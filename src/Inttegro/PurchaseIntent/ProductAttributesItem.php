<?php

namespace Inttegro\PurchaseIntent;


/**
 * Product Attributes Item details associated with purchase intent.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class ProductAttributesItem extends \Inttegro\DomainValue
{
    /**
     * Human-readable name.
     *
     * Required response field. PHP type: `string`; wire field: `name` (`string`).
     *
     * @var string
     */
    public readonly string $name;

    /**
     * Amount expressed in integer minor units, never a floating-point major-unit value.
     *
     * Required response field. PHP type: `string`; wire field: `value` (`string`).
     *
     * @var string
     */
    public readonly string $value;

    /**
     * Hydrates a ProductAttributesItem from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->name = \Inttegro\ValueHydrator::string($data['name'] ?? null, false);
        $this->value = \Inttegro\ValueHydrator::string($data['value'] ?? null, false);
    }

    /**
     * Creates a ProductAttributesItem from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable ProductAttributesItem value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
