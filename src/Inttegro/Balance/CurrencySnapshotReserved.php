<?php

namespace Inttegro\Balance;


/**
 * Currency Snapshot Reserved details associated with balance.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class CurrencySnapshotReserved extends \Inttegro\DomainValue
{
    /**
     * Amount in the currency's smallest unit.
     *
     * Required response field. PHP type: `int`; wire field: `amount` (`integer`).
     *
     * @var int
     */
    public readonly int $amount;

    /**
     * Hydrates a CurrencySnapshotReserved from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->amount = \Inttegro\ValueHydrator::int($data['amount'] ?? null, false);
    }

    /**
     * Creates a CurrencySnapshotReserved from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable CurrencySnapshotReserved value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
