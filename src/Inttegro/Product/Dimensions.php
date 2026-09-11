<?php

namespace Inttegro\Product;


/**
 * At most one of `physical`, `digital`, or `custom`.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Dimensions extends \Inttegro\DomainValue
{
    /**
     * Physical value for this dimensions.
     *
     * Optional response field. PHP type: `\Inttegro\Product\DimensionsPhysical|null`; wire field:
     * `physical` (`object`).
     *
     * @var \Inttegro\Product\DimensionsPhysical|null
     */
    public readonly ?\Inttegro\Product\DimensionsPhysical $physical;

    /**
     * Digital value for this dimensions.
     *
     * Optional response field. PHP type: `\Inttegro\Product\DimensionsDigital|null`; wire field:
     * `digital` (`object`).
     *
     * @var \Inttegro\Product\DimensionsDigital|null
     */
    public readonly ?\Inttegro\Product\DimensionsDigital $digital;

    /**
     * Custom value for this dimensions.
     *
     * Optional response field. PHP type: `\Inttegro\Product\DimensionsCustom|null`; wire field:
     * `custom` (`object`).
     *
     * @var \Inttegro\Product\DimensionsCustom|null
     */
    public readonly ?\Inttegro\Product\DimensionsCustom $custom;

    /**
     * Hydrates a Dimensions from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->physical = \Inttegro\ValueHydrator::object($data['physical'] ?? null, [\Inttegro\Product\DimensionsPhysical::class], true);
        $this->digital = \Inttegro\ValueHydrator::object($data['digital'] ?? null, [\Inttegro\Product\DimensionsDigital::class], true);
        $this->custom = \Inttegro\ValueHydrator::object($data['custom'] ?? null, [\Inttegro\Product\DimensionsCustom::class], true);
    }

    /**
     * Creates a Dimensions from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Dimensions value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
