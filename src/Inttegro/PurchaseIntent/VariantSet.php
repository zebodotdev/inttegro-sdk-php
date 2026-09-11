<?php

namespace Inttegro\PurchaseIntent;


/**
 * Variant Set details associated with purchase intent.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class VariantSet extends \Inttegro\DomainValue
{
    /**
     * Whether this value is currently active.
     *
     * Required response field. PHP type: `bool`; wire field: `active` (`boolean`).
     *
     * @var bool
     */
    public readonly bool $active;

    /**
     * Identifier of the related default product.
     *
     * Optional response field. PHP type: `string|null`; wire field: `default_product_id`
     * (`string`).
     *
     * @var string|null
     */
    public readonly ?string $defaultProductId;

    /**
     * Human-readable description.
     *
     * Optional response field. PHP type: `string|null`; wire field: `description` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $description;

    /**
     * Unique identifier for this variant set.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Human-readable name.
     *
     * Required response field. PHP type: `string`; wire field: `name` (`string`).
     *
     * @var string
     */
    public readonly string $name;

    /**
     * Reference value for this variant set.
     *
     * Optional response field. PHP type: `string|null`; wire field: `reference` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $reference;

    /**
     * Variant Axes value for this variant set.
     *
     * Required response field. PHP type: `list<\Inttegro\PurchaseIntent\VariantAxis>`; wire field:
     * `variant_axes` (`array<object>`).
     * When the field is absent, the SDK exposes an empty collection.
     *
     * @var list<\Inttegro\PurchaseIntent\VariantAxis>
     */
    public readonly array $variantAxes;

    /**
     * Variants value for this variant set.
     *
     * Required response field. PHP type: `list<\Inttegro\PurchaseIntent\Variant>`; wire field:
     * `variants` (`array<object>`).
     * When the field is absent, the SDK exposes an empty collection.
     *
     * @var list<\Inttegro\PurchaseIntent\Variant>
     */
    public readonly array $variants;

    /**
     * Hydrates a VariantSet from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->active = \Inttegro\ValueHydrator::bool($data['active'] ?? null, false);
        $this->defaultProductId = \Inttegro\ValueHydrator::string($data['default_product_id'] ?? null, true);
        $this->description = \Inttegro\ValueHydrator::string($data['description'] ?? null, true);
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->name = \Inttegro\ValueHydrator::string($data['name'] ?? null, false);
        $this->reference = \Inttegro\ValueHydrator::string($data['reference'] ?? null, true);
        $this->variantAxes = \Inttegro\ValueHydrator::objects($data['variant_axes'] ?? null, [\Inttegro\PurchaseIntent\VariantAxis::class]);
        $this->variants = \Inttegro\ValueHydrator::objects($data['variants'] ?? null, [\Inttegro\PurchaseIntent\Variant::class]);
    }

    /**
     * Creates a VariantSet from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable VariantSet value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
