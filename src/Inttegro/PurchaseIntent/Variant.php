<?php

namespace Inttegro\PurchaseIntent;


/**
 * Variant details associated with purchase intent.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Variant extends \Inttegro\DomainValue
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
     * Position value for this variant.
     *
     * Optional response field. PHP type: `int|null`; wire field: `position` (`integer`).
     *
     * @var int|null
     */
    public readonly ?int $position;

    /**
     * Price value for this variant.
     *
     * Optional response field. PHP type: `\Inttegro\PurchaseIntent\Price|null`; wire field: `price`
     * (`object`).
     *
     * @var \Inttegro\PurchaseIntent\Price|null
     */
    public readonly ?\Inttegro\PurchaseIntent\Price $price;

    /**
     * Product value for this variant.
     *
     * Optional response field. PHP type: `\Inttegro\PurchaseIntent\Product|null`; wire field:
     * `product` (`object`).
     *
     * @var \Inttegro\PurchaseIntent\Product|null
     */
    public readonly ?\Inttegro\PurchaseIntent\Product $product;

    /**
     * Identifier of the related product.
     *
     * Required response field. PHP type: `string`; wire field: `product_id` (`string`).
     *
     * @var string
     */
    public readonly string $productId;

    /**
     * Product variant attribute selections keyed by attribute name.
     *
     * Required response field. PHP type: `array<string, string>`; wire field: `variant_values`
     * (`object`).
     *
     * @var array<string, string>
     */
    public readonly array $variantValues;

    /**
     * Hydrates a Variant from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->active = \Inttegro\ValueHydrator::bool($data['active'] ?? null, false);
        $this->position = \Inttegro\ValueHydrator::int($data['position'] ?? null, true);
        $this->price = \Inttegro\ValueHydrator::object($data['price'] ?? null, [\Inttegro\PurchaseIntent\Price::class], true);
        $this->product = \Inttegro\ValueHydrator::object($data['product'] ?? null, [\Inttegro\PurchaseIntent\Product::class], true);
        $this->productId = \Inttegro\ValueHydrator::string($data['product_id'] ?? null, false);
        $this->variantValues = \Inttegro\ValueHydrator::array($data['variant_values'] ?? null, false);
    }

    /**
     * Creates a Variant from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Variant value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
