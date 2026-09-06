<?php

namespace Inttegro\Internal;

use Inttegro\APIError;
use Inttegro\NetworkError;
use Inttegro\TimeoutError;
use Inttegro\Version;
use Inttegro\APIErrorReportContext;
use Inttegro\ErrorReport;
use Inttegro\HTTPReportContext;
use Inttegro\InttegroError;
use Inttegro\SDKReportContext;
use Inttegro\TraceReportContext;

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
    /** @var null|\Closure(ErrorReport): void */
    private ?\Closure $errorReporter;

    public function __construct(
        private bool $enabled = true,
        ?TracerProviderInterface $tracerProvider = null,
        ?TextMapPropagatorInterface $propagator = null,
        ?callable $errorReporter = null,
        private string $errorReportingPolicy = 'unexpected'
    ) {
        if (!in_array($this->errorReportingPolicy, ['unexpected', 'all'], true)) {
            throw new \InvalidArgumentException('errorReportingPolicy must be unexpected or all');
        }
        $this->errorReporter = $errorReporter === null ? null : \Closure::fromCallable($errorReporter);
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
        if (!$this->enabled && $this->errorReporter === null) {
            return $callback(null);
        }

        [$operation, $route, $serverAddress] = $this->requestDetails($pathOrUrl, $baseUrl, $operationOverride);
        $startedAt = $this->errorReporter === null ? null : hrtime(true);
        if (!$this->enabled) {
            try {
                return $callback(null);
            } catch (\Throwable $error) {
                $this->reportFailure($error, $operation, $route, $serverAddress, $method, $startedAt, null);
                throw $error;
            }
        }
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
            $this->reportFailure($error, $operation, $route, $serverAddress, $method, $startedAt, $span);
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

    private function reportFailure(
        \Throwable $error,
        string $operation,
        ?string $route,
        string $serverAddress,
        string $method,
        ?int $startedAt,
        ?SpanInterface $span
    ): void {
        $reporter = $this->errorReporter;
        if ($reporter === null) {
            return;
        }
        try {
            $category = $this->classifyError($error);
            if ($category === 'canceled') {
                return;
            }
            if ($this->errorReportingPolicy === 'unexpected' && $error instanceof APIError) {
                if ($error->status < 500 && $error->type !== 'unknown_error') {
                    return;
                }
            }

            $apiError = $error instanceof APIError ? $error : null;
            $apiContext = $apiError !== null && ($apiError->type || $apiError->code || $apiError->fixCode)
                ? new APIErrorReportContext($apiError->type, $apiError->code, $apiError->fixCode)
                : null;
            $traceContext = null;
            if ($span !== null && $span->getContext()->isValid()) {
                $traceContext = new TraceReportContext(
                    $span->getContext()->getTraceId(),
                    $span->getContext()->getSpanId()
                );
            }
            $statusCode = $apiError?->status;
            $durationMs = $startedAt === null ? 0 : max(0, (int)round((hrtime(true) - $startedAt) / 1_000_000));
            $report = new ErrorReport(
                schemaVersion: 1,
                eventId: $this->eventId(),
                occurredAt: (new \DateTimeImmutable('now', new \DateTimeZone('UTC')))->format('Y-m-d\\TH:i:s.u\\Z'),
                severity: 'error',
                category: $category,
                operation: $operation,
                sdk: new SDKReportContext('php', Version::VERSION),
                http: new HTTPReportContext(
                    strtoupper($method),
                    $serverAddress,
                    $durationMs,
                    $route,
                    $statusCode,
                    $apiError?->requestId
                ),
                apiError: $apiContext,
                trace: $traceContext,
                exceptionType: (new \ReflectionClass($error))->getShortName(),
                fingerprint: implode(':', [
                    'inttegro',
                    'php',
                    $operation,
                    $category,
                    $statusCode ?? 'none',
                ])
            );
            if ($error instanceof InttegroError) {
                $error->report = $report;
            }
            $reporter($report);
        } catch (\Throwable) {
            // Report preparation and delivery must never replace the original failure.
        }
    }

    private function eventId(): string
    {
        $bytes = random_bytes(16);
        $bytes[6] = chr((ord($bytes[6]) & 0x0f) | 0x40);
        $bytes[8] = chr((ord($bytes[8]) & 0x3f) | 0x80);
        $hex = bin2hex($bytes);
        return sprintf('%s-%s-%s-%s-%s',
            substr($hex, 0, 8),
            substr($hex, 8, 4),
            substr($hex, 12, 4),
            substr($hex, 16, 4),
            substr($hex, 20)
        );
    }
}
