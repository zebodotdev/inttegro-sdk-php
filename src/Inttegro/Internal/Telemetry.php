<?php

namespace Inttegro\Internal;

use Inttegro\APIError;
use Inttegro\NetworkError;
use Inttegro\TimeoutError;
use Inttegro\Version;

use OpenTelemetry\API\Globals;
use OpenTelemetry\API\Trace\SpanInterface;
use OpenTelemetry\API\Trace\SpanKind;
use OpenTelemetry\API\Trace\StatusCode;
use OpenTelemetry\API\Trace\TracerInterface;
use OpenTelemetry\API\Trace\TracerProviderInterface;
use OpenTelemetry\Context\Propagation\TextMapPropagatorInterface;

/** Emits redacted SDK spans through the application's OpenTelemetry provider. */
final class Telemetry
{
    private const SAFE_RESOURCES = [
        'apps', 'balance_transactions', 'balances', 'broadcasts', 'checkout', 'chimes', 'customers',
        'file_links', 'file_references', 'files', 'financial_accounts', 'keys', 'message_templates', 'orders',
        'otp', 'payment_methods', 'payouts', 'ping', 'prices', 'products', 'purchase_intents', 'refunds',
        'schedules', 'sessions', 'spec', 'upload_requests',
    ];
    private const SAFE_ACTIONS = [
        'activate', 'add_price', 'archive', 'broadcast', 'cancel', 'complete', 'confirm_payment',
        'confirm_verification', 'connect', 'contents', 'countries', 'create', 'deactivate', 'delete', 'destroy',
        'disable', 'disable_fx', 'disable_pull', 'disable_push', 'disactivate', 'disconnect', 'enable', 'enable_fx',
        'enable_pull', 'enable_push', 'finalize', 'generate', 'initiate', 'lookup', 'new', 'open', 'page', 'pay',
        'publish', 'reconcile', 'reconnect', 'refund', 'render_preview', 'request_confirmation', 'review',
        'revoke', 'schedule', 'send', 'send_invoice', 'send_receipt', 'set_default_unit_price',
        'set_destinations', 'settings', 'tokenize', 'unarchive', 'unpublish', 'update', 'upload', 'usage', 'verify',
    ];
    private TracerInterface $tracer;
    private TextMapPropagatorInterface $propagator;

    public function __construct(
        private bool $enabled = true,
        ?TracerProviderInterface $tracerProvider = null,
        ?TextMapPropagatorInterface $propagator = null
    ) {
        $this->tracer = ($tracerProvider ?? Globals::tracerProvider())->getTracer('inttegro', Version::VERSION);
        $this->propagator = $propagator ?? Globals::propagator();
    }

    /**
     * @template T
     * @param callable(?SpanInterface): T $callback
     * @return T
     */
    public function trace(
        string $pathOrUrl,
        string $method,
        string $baseUrl,
        callable $callback,
        ?string $operationOverride = null
    ): mixed {
        if (!$this->enabled) {
            return $callback(null);
        }

        [$operation, $route, $serverAddress] = $this->requestDetails($pathOrUrl, $baseUrl, $operationOverride);
        $attributes = [
            'inttegro.operation.name' => $operation,
            'inttegro.sdk.language' => 'php',
            'inttegro.sdk.version' => Version::VERSION,
            'http.request.method' => strtoupper($method),
            'server.address' => $serverAddress,
        ];
        if ($route !== null) {
            $attributes['url.template'] = $route;
        }

        $span = $this->tracer->spanBuilder('inttegro.' . $operation)
            ->setSpanKind(SpanKind::KIND_CLIENT)
            ->setAttributes($attributes)
            ->startSpan();
        $scope = $span->activate();
        try {
            return $callback($span);
        } catch (\Throwable $error) {
            $errorType = $this->classifyError($error);
            $span->setAttribute('error.type', $errorType);
            $span->setStatus(StatusCode::STATUS_ERROR);
            $span->addEvent('inttegro.request.failed', ['error.type' => $errorType]);
            throw $error;
        } finally {
            $scope->detach();
            $span->end();
        }
    }

    /** @param list<string> $headers @return list<string> */
    public function prepare(?SpanInterface $span, array $headers): array
    {
        if ($this->enabled) {
            $carrier = [];
            $this->propagator->inject($carrier);
            foreach ($carrier as $key => $value) {
                if (!$this->hasHeader($headers, (string)$key)) {
                    $headers[] = $key . ': ' . $value;
                }
            }
        }
        if ($span !== null) {
            $span->addEvent('inttegro.request.prepared');
            $span->addEvent('inttegro.http.attempt.started', ['http.request.resend_count' => 0]);
        }
        return $headers;
    }

    /** @param array{status: int, headers?: array<string, string>} $response */
    public function response(?SpanInterface $span, array $response): void
    {
        if ($span === null) {
            return;
        }
        $status = $response['status'];
        $span->setAttribute('http.response.status_code', $status);
        $requestId = $response['headers']['x-request-id'] ?? null;
        if (is_string($requestId) && $requestId !== '') {
            $span->setAttribute('inttegro.request.id', $requestId);
        }
        $span->addEvent('inttegro.response.received', [
            'http.response.status_code' => $status,
            'http.request.resend_count' => 0,
        ]);
    }

    public function decoded(?SpanInterface $span): void
    {
        $span?->addEvent('inttegro.response.decoded');
    }

    /** @return array{string, ?string, string} */
    private function requestDetails(string $pathOrUrl, string $baseUrl, ?string $override): array
    {
        $url = str_starts_with($pathOrUrl, 'http://') || str_starts_with($pathOrUrl, 'https://')
            ? $pathOrUrl
            : rtrim($baseUrl, '/') . '/' . ltrim($pathOrUrl, '/');
        $parsed = parse_url($url);
        $isStaticApiRoute = !str_starts_with($pathOrUrl, 'http://') && !str_starts_with($pathOrUrl, 'https://');
        $segments = $isStaticApiRoute
            ? array_values(array_filter(explode('/', trim($parsed['path'] ?? '', '/'))))
            : [];
        $resource = $segments[0] ?? null;
        $action = $segments[1] ?? null;
        $knownRoute = count($segments) > 0 && count($segments) <= 2
            && in_array($resource, self::SAFE_RESOURCES, true)
            && ($action === null || in_array($action, self::SAFE_ACTIONS, true));
        $route = $knownRoute ? ($parsed['path'] ?? '/') : null;
        $derivedOperation = $knownRoute
            ? $resource . '.' . ($action ?? ($resource === 'balances' ? 'lookup' : 'request'))
            : 'http.request';
        return [$override ?? $derivedOperation, $route, $parsed['host'] ?? 'unknown'];
    }

    /** @param list<string> $headers */
    private function hasHeader(array $headers, string $name): bool
    {
        foreach ($headers as $header) {
            [$candidate] = explode(':', $header, 2);
            if (strcasecmp(trim($candidate), $name) === 0) {
                return true;
            }
        }
        return false;
    }

    private function classifyError(\Throwable $error): string
    {
        if ($error instanceof TimeoutError) {
            return 'timeout';
        }
        if ($error instanceof NetworkError) {
            return 'network_error';
        }
        if ($error instanceof APIError) {
            return 'http_' . $error->status;
        }
        if ($error instanceof \JsonException) {
            return 'decode_error';
        }
        return 'unknown_error';
    }
}
