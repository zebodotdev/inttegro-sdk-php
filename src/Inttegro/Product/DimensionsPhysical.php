<?php

namespace Inttegro\Product;


/**
 * Dimensions Physical details associated with product.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class DimensionsPhysical extends \Inttegro\DomainValue
{
    /**
     * Weight Unit value for this dimensions physical.
     *
     * Optional response field. PHP type: `string|null`; wire field: `weight_unit` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $weightUnit;

    /**
     * Weight value for this dimensions physical.
     *
     * Optional response field. PHP type: `float|null`; wire field: `weight` (`number`).
     *
     * @var float|null
     */
    public readonly ?float $weight;

    /**
     * Legacy alias for weight in requests.
     *
     * Optional response field. PHP type: `float|null`; wire field: `size` (`number`).
     *
     * @var float|null
     */
    public readonly ?float $size;

    /**
     * Volume Unit value for this dimensions physical.
     *
     * Optional response field. PHP type: `string|null`; wire field: `volume_unit` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $volumeUnit;

    /**
     * Volume value for this dimensions physical.
     *
     * Optional response field. PHP type: `float|null`; wire field: `volume` (`number`).
     *
     * @var float|null
     */
    public readonly ?float $volume;

    /**
     * Length value for this dimensions physical.
     *
     * Optional response field. PHP type: `float|null`; wire field: `length` (`number`).
     *
     * @var float|null
     */
    public readonly ?float $length;

    /**
     * Height value for this dimensions physical.
     *
     * Optional response field. PHP type: `float|null`; wire field: `height` (`number`).
     *
     * @var float|null
     */
    public readonly ?float $height;

    /**
     * Width value for this dimensions physical.
     *
     * Optional response field. PHP type: `float|null`; wire field: `width` (`number`).
     *
     * @var float|null
     */
    public readonly ?float $width;

    /**
     * Hydrates a DimensionsPhysical from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->weightUnit = \Inttegro\ValueHydrator::string($data['weight_unit'] ?? null, true);
        $this->weight = \Inttegro\ValueHydrator::float($data['weight'] ?? null, true);
        $this->size = \Inttegro\ValueHydrator::float($data['size'] ?? null, true);
        $this->volumeUnit = \Inttegro\ValueHydrator::string($data['volume_unit'] ?? null, true);
        $this->volume = \Inttegro\ValueHydrator::float($data['volume'] ?? null, true);
        $this->length = \Inttegro\ValueHydrator::float($data['length'] ?? null, true);
        $this->height = \Inttegro\ValueHydrator::float($data['height'] ?? null, true);
        $this->width = \Inttegro\ValueHydrator::float($data['width'] ?? null, true);
    }

    /**
     * Creates a DimensionsPhysical from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable DimensionsPhysical value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
