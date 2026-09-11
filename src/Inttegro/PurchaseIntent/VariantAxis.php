<?php

namespace Inttegro\PurchaseIntent;


/**
 * Variant Axis details associated with purchase intent.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class VariantAxis extends \Inttegro\DomainValue
{
    /**
     * Key value for this variant axis.
     *
     * Required response field. PHP type: `string`; wire field: `key` (`string`).
     *
     * @var string
     */
    public readonly string $key;

    /**
     * Label value for this variant axis.
     *
     * Required response field. PHP type: `string`; wire field: `label` (`string`).
     *
     * @var string
     */
    public readonly string $label;

    /**
     * Position value for this variant axis.
     *
     * Required response field. PHP type: `int`; wire field: `position` (`integer`).
     *
     * @var int
     */
    public readonly int $position;

    /**
     * Hydrates a VariantAxis from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->key = \Inttegro\ValueHydrator::string($data['key'] ?? null, false);
        $this->label = \Inttegro\ValueHydrator::string($data['label'] ?? null, false);
        $this->position = \Inttegro\ValueHydrator::int($data['position'] ?? null, false);
    }

    /**
     * Creates a VariantAxis from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable VariantAxis value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
