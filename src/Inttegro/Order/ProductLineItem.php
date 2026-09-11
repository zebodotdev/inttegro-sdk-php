<?php

namespace Inttegro\Order;


/**
 * Product Line Item details associated with order.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class ProductLineItem extends \Inttegro\DomainValue
{
    /**
     * Discriminator identifying the value's API variant.
     *
     * Required response field. PHP type: `string`; wire field: `type` (`string`).
     *
     * @var string
     */
    public readonly string $type;

    /**
     * Product value for this product line item.
     *
     * Required response field. PHP type: `\Inttegro\Order\ProductLineItemProduct`; wire field:
     * `product` (`object`).
     *
     * @var \Inttegro\Order\ProductLineItemProduct
     */
    public readonly \Inttegro\Order\ProductLineItemProduct $product;

    /**
     * Hydrates a ProductLineItem from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
        $this->product = \Inttegro\ValueHydrator::object($data['product'] ?? null, [\Inttegro\Order\ProductLineItemProduct::class], false);
    }

    /**
     * Creates a ProductLineItem from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable ProductLineItem value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
