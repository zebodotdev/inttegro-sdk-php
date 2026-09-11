<?php

namespace Inttegro;

/**
 * Decoded SDK value plus response-only HTTP metadata.
 */
class Response
{
    /** @var mixed Decoded domain data. */
    public readonly mixed $data;
    /** @var int HTTP status code. */
    public readonly int $status;
    /** @var array<string, string> Response headers only, keyed by normalized header name. */
    public readonly array $headers;
    /** @var array<string, mixed>|null API response_meta value, when present. */
    public readonly ?array $meta;
    /** @var string|null Convenience accessor for X-Request-Id. */
    public readonly ?string $requestId;
    /** @var string|null Convenience accessor for Retry-After. */
    public readonly ?string $retryAfter;

    /**
     * @param mixed $data
     * @param array<string, string> $headers
     * @param array<string, mixed>|null $meta
     */
    public function __construct(mixed $data, int $status, array $headers, ?array $meta = null)
    {
        $this->data = $data;
        $this->status = $status;
        $this->headers = $headers;
        $this->meta = $meta;
        $this->requestId = self::header($headers, 'x-request-id');
        $this->retryAfter = self::header($headers, 'retry-after');
    }

    public function withData(mixed $data): self
    {
        return new self($data, $this->status, $this->headers, $this->meta);
    }

    /** @param array<string, string> $headers */
    private static function header(array $headers, string $name): ?string
    {
        foreach ($headers as $key => $value) {
            if (strtolower((string)$key) === strtolower($name) && trim((string)$value) !== '') {
                return $value;
            }
        }
        return null;
    }
}
