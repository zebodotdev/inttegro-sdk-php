<?php

namespace Inttegro\Order;


/**
 * Product Line Item Product details associated with order.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class ProductLineItemProduct extends \Inttegro\DomainValue
{
    /**
     * Immutable order-line identifier with the `oli_` prefix.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Source catalog product ID when this line snapshots a catalog product.
     *
     * Optional response field. PHP type: `string|null`; wire field: `product_id` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $productId;

    /**
     * Source catalog price ID when this line snapshots a saved price.
     *
     * Optional response field. PHP type: `string|null`; wire field: `price_id` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $priceId;

    /**
     * Reference value for this product line item product.
     *
     * Optional response field. PHP type: `string|null`; wire field: `reference` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $reference;

    /**
     * Additional explanatory text.
     *
     * Optional response field. PHP type: `string|null`; wire field: `about` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $about;

    /**
     * Merchant-defined string values attached to a resource. SDKs expose this as a semantic
     * collection rather than a raw map.
     *
     * Optional response field. PHP type: `array<string, string>|null`; wire field: `custom_data`
     * (`object`).
     *
     * @var array<string, string>|null
     */
    public readonly ?array $customData;

    /**
     * Tax Code value for this product line item product.
     *
     * Optional response field. PHP type: `string|null`; wire field: `tax_code` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $taxCode;

    /**
     * Human-readable name.
     *
     * Required response field. PHP type: `string`; wire field: `name` (`string`).
     *
     * @var string
     */
    public readonly string $name;

    /**
     * Category value for this product line item product.
     *
     * Optional response field. PHP type: `string|null`; wire field: `category` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $category;

    /**
     * Discriminator identifying the value's API variant.
     *
     * Optional response field. PHP type: `string|null`; wire field: `type` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $type;

    /**
     * An inline price returned by the API.
     *
     * Required response field. PHP type: `\Inttegro\Price\Inline`; wire field: `price` (`object`).
     *
     * @var \Inttegro\Price\Inline
     */
    public readonly \Inttegro\Price\Inline $price;

    /**
     * Quantity value for this product line item product.
     *
     * Required response field. PHP type: `int`; wire field: `quantity` (`integer`).
     *
     * @var int
     */
    public readonly int $quantity;

    /**
     * Hydrates a ProductLineItemProduct from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->productId = \Inttegro\ValueHydrator::string($data['product_id'] ?? null, true);
        $this->priceId = \Inttegro\ValueHydrator::string($data['price_id'] ?? null, true);
        $this->reference = \Inttegro\ValueHydrator::string($data['reference'] ?? null, true);
        $this->about = \Inttegro\ValueHydrator::string($data['about'] ?? null, true);
        $this->customData = \Inttegro\ValueHydrator::array($data['custom_data'] ?? null, true);
        $this->taxCode = \Inttegro\ValueHydrator::string($data['tax_code'] ?? null, true);
        $this->name = \Inttegro\ValueHydrator::string($data['name'] ?? null, false);
        $this->category = \Inttegro\ValueHydrator::string($data['category'] ?? null, true);
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, true);
        $this->price = \Inttegro\ValueHydrator::object($data['price'] ?? null, [\Inttegro\Price\Inline::class], false);
        $this->quantity = \Inttegro\ValueHydrator::int($data['quantity'] ?? null, false);
    }

    /**
     * Creates a ProductLineItemProduct from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable ProductLineItemProduct value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
