<?php

namespace Inttegro\Product;


/**
 * Dimensions Custom details associated with product.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class DimensionsCustom extends \Inttegro\DomainValue
{
    /**
     * Size Unit value for this dimensions custom.
     *
     * Optional response field. PHP type: `string|null`; wire field: `size_unit` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $sizeUnit;

    /**
     * Size value for this dimensions custom.
     *
     * Optional response field. PHP type: `float|null`; wire field: `size` (`number`).
     *
     * @var float|null
     */
    public readonly ?float $size;

    /**
     * Named string measurements or descriptors for a product dimension.
     *
     * Optional response field. PHP type: `array<string, string>|null`; wire field: `details`
     * (`object`).
     *
     * @var array<string, string>|null
     */
    public readonly ?array $details;

    /**
     * Hydrates a DimensionsCustom from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->sizeUnit = \Inttegro\ValueHydrator::string($data['size_unit'] ?? null, true);
        $this->size = \Inttegro\ValueHydrator::float($data['size'] ?? null, true);
        $this->details = \Inttegro\ValueHydrator::array($data['details'] ?? null, true);
    }

    /**
     * Creates a DimensionsCustom from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable DimensionsCustom value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
