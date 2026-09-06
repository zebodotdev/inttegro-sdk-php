<?php

namespace Inttegro;

final class SDKReportContext implements \JsonSerializable
{
    public function __construct(
        public readonly string $language,
        public readonly string $version
    ) {
    }

    public function jsonSerialize(): array
    {
        return ['language' => $this->language, 'version' => $this->version];
    }
}

final class HTTPReportContext implements \JsonSerializable
{
    public function __construct(
        public readonly string $method,
        public readonly string $serverAddress,
        public readonly int $durationMs,
        public readonly ?string $route = null,
        public readonly ?int $statusCode = null,
        public readonly ?string $requestId = null
    ) {
    }

    public function jsonSerialize(): array
    {
        return array_filter([
            'method' => $this->method,
            'serverAddress' => $this->serverAddress,
            'durationMs' => $this->durationMs,
            'route' => $this->route,
            'statusCode' => $this->statusCode,
            'requestId' => $this->requestId,
        ], static fn ($value) => $value !== null);
    }
}

final class APIErrorReportContext implements \JsonSerializable
{
    public function __construct(
        public readonly ?string $type = null,
        public readonly ?string $code = null,
        public readonly ?string $fixCode = null
    ) {
    }

    public function jsonSerialize(): array
    {
        return array_filter([
            'type' => $this->type,
            'code' => $this->code,
            'fixCode' => $this->fixCode,
        ], static fn ($value) => $value !== null);
    }
}

final class TraceReportContext implements \JsonSerializable
{
    public function __construct(
        public readonly string $traceId,
        public readonly string $spanId
    ) {
    }

    public function jsonSerialize(): array
    {
        return ['traceId' => $this->traceId, 'spanId' => $this->spanId];
    }
}

/** A privacy-safe description of a failed Inttegro SDK operation. */
final class ErrorReport implements \JsonSerializable
{
    public function __construct(
        public readonly int $schemaVersion,
        public readonly string $eventId,
        public readonly string $occurredAt,
        public readonly string $severity,
        public readonly string $category,
        public readonly string $operation,
        public readonly SDKReportContext $sdk,
        public readonly HTTPReportContext $http,
        public readonly string $exceptionType,
        public readonly string $fingerprint,
        public readonly ?APIErrorReportContext $apiError = null,
        public readonly ?TraceReportContext $trace = null
    ) {
    }

    public function jsonSerialize(): array
    {
        return array_filter([
            'schemaVersion' => $this->schemaVersion,
            'eventId' => $this->eventId,
            'occurredAt' => $this->occurredAt,
            'severity' => $this->severity,
            'category' => $this->category,
            'operation' => $this->operation,
            'sdk' => $this->sdk,
            'http' => $this->http,
            'apiError' => $this->apiError,
            'trace' => $this->trace,
            'exceptionType' => $this->exceptionType,
            'fingerprint' => $this->fingerprint,
        ], static fn ($value) => $value !== null);
    }
}
