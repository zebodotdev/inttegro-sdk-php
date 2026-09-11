<?php

namespace Inttegro\Order;


/**
 * Shipping Line Item details associated with order.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class ShippingLineItem extends \Inttegro\DomainValue
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
     * Shipping value for this shipping line item.
     *
     * Required response field. PHP type: `\Inttegro\Order\ShippingLineItemShipping`; wire field:
     * `shipping` (`object`).
     *
     * @var \Inttegro\Order\ShippingLineItemShipping
     */
    public readonly \Inttegro\Order\ShippingLineItemShipping $shipping;

    /**
     * Hydrates a ShippingLineItem from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
        $this->shipping = \Inttegro\ValueHydrator::object($data['shipping'] ?? null, [\Inttegro\Order\ShippingLineItemShipping::class], false);
    }

    /**
     * Creates a ShippingLineItem from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable ShippingLineItem value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
