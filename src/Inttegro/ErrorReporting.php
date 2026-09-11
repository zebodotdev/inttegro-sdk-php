<?php

namespace Inttegro;

/** SDK identity included in a privacy-safe terminal failure report. */
final class SDKReportContext implements \JsonSerializable
{
    /** @param string $language SDK implementation language. @param string $version SDK version. */
    public function __construct(
        /** SDK implementation language. */
        public readonly string $language,
        /** Installed SDK semantic version. */
        public readonly string $version
    ) {
    }

    /** @return array{language: string, version: string} JSON-safe SDK identity. */
    public function jsonSerialize(): array
    {
        return ['language' => $this->language, 'version' => $this->version];
    }
}

/** Privacy-safe HTTP metadata for a failed SDK operation. */
final class HTTPReportContext implements \JsonSerializable
{
    /**
     * @param string $method Static HTTP method.
     * @param string $serverAddress API server address without credentials or resource identifiers.
     * @param int $durationMs Total operation duration in milliseconds.
     * @param string|null $route Static route template, when available.
     * @param int|null $statusCode HTTP response status, when a response arrived.
     * @param string|null $requestId Server request identifier, when available.
     */
    public function __construct(
        /** Static HTTP method. */
        public readonly string $method,
        /** API server address without credentials, query strings, or resource identifiers. */
        public readonly string $serverAddress,
        /** Total operation duration in milliseconds. */
        public readonly int $durationMs,
        /** Static route template, when available. */
        public readonly ?string $route = null,
        /** HTTP status code when the server returned a response. */
        public readonly ?int $statusCode = null,
        /** Server request identifier used for correlation. */
        public readonly ?string $requestId = null
    ) {
    }

    /** @return array<string, int|string> JSON-safe HTTP failure metadata with null fields omitted. */
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

/** Non-sensitive machine-readable fields from an Inttegro API error. */
final class APIErrorReportContext implements \JsonSerializable
{
    /**
     * @param string|null $type Broad API error category.
     * @param string|null $code Machine-readable API error code.
     * @param string|null $fixCode Machine-readable remediation code.
     */
    public function __construct(
        /** Broad API error category. */
        public readonly ?string $type = null,
        /** Machine-readable API error code. */
        public readonly ?string $code = null,
        /** Machine-readable remediation code. */
        public readonly ?string $fixCode = null
    ) {
    }

    /** @return array<string, string> JSON-safe API error fields with null values omitted. */
    public function jsonSerialize(): array
    {
        return array_filter([
            'type' => $this->type,
            'code' => $this->code,
            'fixCode' => $this->fixCode,
        ], static fn ($value) => $value !== null);
    }
}

/** OpenTelemetry identifiers used to correlate a failure with an application-owned trace. */
final class TraceReportContext implements \JsonSerializable
{
    /** @param string $traceId OpenTelemetry trace ID. @param string $spanId OpenTelemetry span ID. */
    public function __construct(
        /** OpenTelemetry trace ID. */
        public readonly string $traceId,
        /** OpenTelemetry span ID. */
        public readonly string $spanId
    ) {
    }

    /** @return array{traceId: string, spanId: string} JSON-safe trace correlation fields. */
    public function jsonSerialize(): array
    {
        return ['traceId' => $this->traceId, 'spanId' => $this->spanId];
    }
}

/**
 * Privacy-safe description of one terminally failed Inttegro SDK operation.
 *
 * Reports intentionally exclude credentials, headers, bodies, resource IDs, dynamic URLs,
 * exception messages, and stack traces. Applications receive a report only when they explicitly
 * configure an error reporter on `Client`.
 */
final class ErrorReport implements \JsonSerializable
{
    /**
     * Creates an immutable failure report from fields already filtered by the SDK.
     *
     * @param int $schemaVersion Report schema version.
     * @param string $eventId Unique event identifier.
     * @param string $occurredAt Offset-bearing event timestamp.
     * @param string $severity Failure severity.
     * @param string $category Stable failure category.
     * @param string $operation Logical SDK operation.
     * @param SDKReportContext $sdk SDK identity.
     * @param HTTPReportContext $http Privacy-safe HTTP metadata.
     * @param string $exceptionType Exception class name without its message or stack trace.
     * @param string $fingerprint Stable grouping fingerprint.
     * @param APIErrorReportContext|null $apiError Safe API error fields.
     * @param TraceReportContext|null $trace Application-owned trace identifiers.
     */
    public function __construct(
        /** Report schema version. */
        public readonly int $schemaVersion,
        /** Unique identifier for this report event. */
        public readonly string $eventId,
        /** Offset-bearing timestamp at which the failure report was created. */
        public readonly string $occurredAt,
        /** Failure severity. */
        public readonly string $severity,
        /** Stable failure category. */
        public readonly string $category,
        /** Logical SDK operation, such as `orders.create`. */
        public readonly string $operation,
        /** SDK language and version. */
        public readonly SDKReportContext $sdk,
        /** Privacy-safe HTTP operation metadata. */
        public readonly HTTPReportContext $http,
        /** Exception class name without its message or stack trace. */
        public readonly string $exceptionType,
        /** Stable value used to group equivalent failures. */
        public readonly string $fingerprint,
        /** Safe machine-readable API error fields, when applicable. */
        public readonly ?APIErrorReportContext $apiError = null,
        /** Application-owned trace identifiers, when tracing was active. */
        public readonly ?TraceReportContext $trace = null
    ) {
    }

    /** @return array<string, mixed> Complete JSON-safe report with null contexts omitted. */
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
