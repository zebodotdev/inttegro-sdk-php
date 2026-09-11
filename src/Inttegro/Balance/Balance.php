<?php

namespace Inttegro\Balance;


/**
 * The authenticated application's latest balance snapshot, keyed by supported currency.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Balance extends \Inttegro\DomainValue
{
    /**
     * GHS value for this balance.
     *
     * Required response field. PHP type: `\Inttegro\Balance\CurrencySnapshot`; wire field: `ghs`
     * (`object`).
     *
     * @var \Inttegro\Balance\CurrencySnapshot
     */
    public readonly \Inttegro\Balance\CurrencySnapshot $ghs;

    /**
     * Hydrates a Balance from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->ghs = \Inttegro\ValueHydrator::object($data['ghs'] ?? null, [\Inttegro\Balance\CurrencySnapshot::class], false);
    }

    /**
     * Creates a Balance from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Balance value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
