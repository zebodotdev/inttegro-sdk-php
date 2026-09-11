<?php

namespace Inttegro\Order;


/**
 * Discount Line Item details associated with order.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class DiscountLineItem extends \Inttegro\DomainValue
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
     * Discount value for this discount line item.
     *
     * Required response field. PHP type: `\Inttegro\Order\DiscountLineItemDiscount`; wire field:
     * `discount` (`object`).
     *
     * @var \Inttegro\Order\DiscountLineItemDiscount
     */
    public readonly \Inttegro\Order\DiscountLineItemDiscount $discount;

    /**
     * Hydrates a DiscountLineItem from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
        $this->discount = \Inttegro\ValueHydrator::object($data['discount'] ?? null, [\Inttegro\Order\DiscountLineItemDiscount::class], false);
    }

    /**
     * Creates a DiscountLineItem from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable DiscountLineItem value.
     */
    public static function fromArray(array $data): static { return new static($data); }
}
