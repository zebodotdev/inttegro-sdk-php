<?php

namespace Inttegro\MessageTemplate;


/**
 * Scanned Link details associated with message template.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class ScannedLink extends \Inttegro\DomainValue
{
    /**
     * Host value for this scanned link.
     *
     * Optional response field. PHP type: `string|null`; wire field: `host` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $host;

    /**
     * Raw value for this scanned link.
     *
     * Required response field. PHP type: `string`; wire field: `raw` (`string`).
     *
     * @var string
     */
    public readonly string $raw;

    /**
     * Reason value for this scanned link.
     *
     * Optional response field. PHP type: `string|null`; wire field: `reason` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $reason;

    /**
     * Scheme value for this scanned link.
     *
     * Required response field. PHP type: `string`; wire field: `scheme` (`string`).
     *
     * @var string
     */
    public readonly string $scheme;

    /**
     * Current lifecycle state.
     *
     * Required response field. PHP type: `string`; wire field: `status` (`string`).
     * Compare against `Status` cases by using their `->value` strings.
     *
     * @var string
     */
    public readonly string $status;

    /**
     * Hydrates a ScannedLink from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->host = \Inttegro\ValueHydrator::string($data['host'] ?? null, true);
        $this->raw = \Inttegro\ValueHydrator::string($data['raw'] ?? null, false);
        $this->reason = \Inttegro\ValueHydrator::string($data['reason'] ?? null, true);
        $this->scheme = \Inttegro\ValueHydrator::string($data['scheme'] ?? null, false);
        $this->status = \Inttegro\ValueHydrator::string($data['status'] ?? null, false);
    }

    /**
     * Creates a ScannedLink from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable ScannedLink value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
