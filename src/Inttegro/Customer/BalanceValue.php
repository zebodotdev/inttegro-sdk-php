<?php

namespace Inttegro\Customer;

use DateTimeImmutable;
use Inttegro\Money\Amount;

/**
 * Balance Value details associated with customer.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class BalanceValue extends \Inttegro\DomainValue
{
    /**
     * As Of value for this balance value.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `as_of` (`ISO-8601 string
     * with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $asOf;

    /**
     * Available value for this balance value.
     *
     * Required response field. PHP type: `Amount`; wire field: `available` (`object`).
     *
     * @var Amount
     */
    public readonly Amount $available;

    /**
     * Hydrates a BalanceValue from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->asOf = \Inttegro\ValueHydrator::dateTime($data['as_of'] ?? null, false);
        $this->available = \Inttegro\ValueHydrator::object($data['available'] ?? null, [Amount::class], false);
    }

    /**
     * Creates a BalanceValue from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable BalanceValue value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
