<?php

namespace Inttegro\PurchaseIntent;


/**
 * Quantity bounds the Buy link should enforce. Omit max when the Buy link has no upper quantity
 * bound. When present, max must be greater than or equal to min.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Quantity extends \Inttegro\DomainValue
{
    /**
     * Minimum quantity the customer can buy.
     *
     * Required response field. PHP type: `int`; wire field: `min` (`integer`).
     *
     * @var int
     */
    public readonly int $min;

    /**
     * Optional maximum quantity the customer can buy. It must be greater than or equal to min.
     *
     * Optional response field. PHP type: `int|null`; wire field: `max` (`integer`).
     *
     * @var int|null
     */
    public readonly ?int $max;

    /**
     * Hydrates a Quantity from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->min = \Inttegro\ValueHydrator::int($data['min'] ?? null, false);
        $this->max = \Inttegro\ValueHydrator::int($data['max'] ?? null, true);
    }

    /**
     * Creates a Quantity from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Quantity value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
