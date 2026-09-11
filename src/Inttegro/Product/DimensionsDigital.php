<?php

namespace Inttegro\Product;


/**
 * Dimensions Digital details associated with product.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class DimensionsDigital extends \Inttegro\DomainValue
{
    /**
     * Bytes value for this dimensions digital.
     *
     * Optional response field. PHP type: `float|null`; wire field: `bytes` (`number`).
     *
     * @var float|null
     */
    public readonly ?float $bytes;

    /**
     * Size Unit value for this dimensions digital.
     *
     * Optional response field. PHP type: `string|null`; wire field: `size_unit` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $sizeUnit;

    /**
     * Size value for this dimensions digital.
     *
     * Optional response field. PHP type: `float|null`; wire field: `size` (`number`).
     *
     * @var float|null
     */
    public readonly ?float $size;

    /**
     * Hydrates a DimensionsDigital from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->bytes = \Inttegro\ValueHydrator::float($data['bytes'] ?? null, true);
        $this->sizeUnit = \Inttegro\ValueHydrator::string($data['size_unit'] ?? null, true);
        $this->size = \Inttegro\ValueHydrator::float($data['size'] ?? null, true);
    }

    /**
     * Creates a DimensionsDigital from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable DimensionsDigital value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
