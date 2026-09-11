<?php

namespace Inttegro\Order;

use Inttegro\Money\Amount;

/**
 * Group of line items in the order.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class LineItemGroup extends \Inttegro\DomainValue
{
    /**
     * Items included in the order. Product line items may use inline product data, `product_id`
     * with explicit `price`, or `product_id` with `price_id`.
     *
     * Required response field. PHP type:
     * `list<\Inttegro\Order\ProductLineItem|\Inttegro\Order\FeeLineItem|\Inttegro\Order\ShippingLineItem|\Inttegro\Order\DiscountLineItem>`;
     * wire field: `line_items` (`array<object>`).
     * When the field is absent, the SDK exposes an empty collection.
     *
     * @var list<\Inttegro\Order\ProductLineItem|\Inttegro\Order\FeeLineItem|\Inttegro\Order\ShippingLineItem|\Inttegro\Order\DiscountLineItem>
     */
    public readonly array $lineItems;

    /**
     * Total number of matching values.
     *
     * Required response field. PHP type: `Amount`; wire field: `total` (`object`).
     *
     * @var Amount
     */
    public readonly Amount $total;

    /**
     * Hydrates a LineItemGroup from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->lineItems = \Inttegro\ValueHydrator::objects($data['line_items'] ?? null, [\Inttegro\Order\ProductLineItem::class, \Inttegro\Order\FeeLineItem::class, \Inttegro\Order\ShippingLineItem::class, \Inttegro\Order\DiscountLineItem::class]);
        $this->total = \Inttegro\ValueHydrator::object($data['total'] ?? null, [Amount::class], false);
    }

    /**
     * Creates a LineItemGroup from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable LineItemGroup value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
