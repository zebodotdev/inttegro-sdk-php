<?php

namespace Inttegro\SecretKey;


/**
 * Usage details associated with secret key.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Usage extends \Inttegro\DomainValue
{
    /**
     * Public secret key metadata. The bearer token is never returned by read or mutation endpoints.
     *
     * Required response field. PHP type: `\Inttegro\SecretKey\SecretKey`; wire field: `key`
     * (`object`).
     *
     * @var \Inttegro\SecretKey\SecretKey
     */
    public readonly \Inttegro\SecretKey\SecretKey $key;

    /**
     * Usage value for this usage.
     *
     * Required response field. PHP type: `\Inttegro\SecretKey\UsagePage`; wire field: `usage`
     * (`object`).
     *
     * @var \Inttegro\SecretKey\UsagePage
     */
    public readonly \Inttegro\SecretKey\UsagePage $usage;

    /**
     * Hydrates an Usage from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->key = \Inttegro\ValueHydrator::object($data['key'] ?? null, [\Inttegro\SecretKey\SecretKey::class], false);
        $this->usage = \Inttegro\ValueHydrator::object($data['usage'] ?? null, [\Inttegro\SecretKey\UsagePage::class], false);
    }

    /**
     * Creates an Usage from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Usage value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
