<?php

namespace Inttegro\Chime;


/**
 * Email Scanned Link details associated with chime.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class EmailScannedLink extends \Inttegro\DomainValue
{
    /**
     * Raw value for this email scanned link.
     *
     * Optional response field. PHP type: `string|null`; wire field: `raw` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $raw;

    /**
     * Scheme value for this email scanned link.
     *
     * Optional response field. PHP type: `string|null`; wire field: `scheme` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $scheme;

    /**
     * Host value for this email scanned link.
     *
     * Optional response field. PHP type: `string|null`; wire field: `host` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $host;

    /**
     * Current lifecycle state.
     *
     * Optional response field. PHP type: `string|null`; wire field: `status` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $status;

    /**
     * Reason value for this email scanned link.
     *
     * Optional response field. PHP type: `string|null`; wire field: `reason` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $reason;

    /**
     * Hydrates an EmailScannedLink from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->raw = \Inttegro\ValueHydrator::string($data['raw'] ?? null, true);
        $this->scheme = \Inttegro\ValueHydrator::string($data['scheme'] ?? null, true);
        $this->host = \Inttegro\ValueHydrator::string($data['host'] ?? null, true);
        $this->status = \Inttegro\ValueHydrator::string($data['status'] ?? null, true);
        $this->reason = \Inttegro\ValueHydrator::string($data['reason'] ?? null, true);
    }

    /**
     * Creates an EmailScannedLink from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable EmailScannedLink value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
