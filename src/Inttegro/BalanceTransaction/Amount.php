<?php

namespace Inttegro\BalanceTransaction;


/**
 * Amount details associated with balance transaction.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Amount extends \Inttegro\DomainValue
{
    /**
     * Currency code as stored on the transaction.
     *
     * Required response field. PHP type: `string`; wire field: `currency` (`string`).
     *
     * @var string
     */
    public readonly string $currency;

    /**
     * Unsigned amount in the currency's smallest unit.
     *
     * Required response field. PHP type: `int`; wire field: `value` (`integer`).
     * Interpret the integer in the smallest unit of `currency`; do not treat it as a floating-point
     * major-unit amount.
     *
     * @var int
     */
    public readonly int $value;

    /**
     * Hydrates an Amount from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->currency = \Inttegro\ValueHydrator::string($data['currency'] ?? null, false);
        $this->value = \Inttegro\ValueHydrator::int($data['value'] ?? null, false);
    }

    /**
     * Creates an Amount from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Amount value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
