<?php

namespace Inttegro\Order;


/**
 * Fee Line Item details associated with order.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class FeeLineItem extends \Inttegro\DomainValue
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
     * Fee value for this fee line item.
     *
     * Required response field. PHP type: `\Inttegro\Order\FeeLineItemFee`; wire field: `fee`
     * (`object`).
     *
     * @var \Inttegro\Order\FeeLineItemFee
     */
    public readonly \Inttegro\Order\FeeLineItemFee $fee;

    /**
     * Hydrates a FeeLineItem from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
        $this->fee = \Inttegro\ValueHydrator::object($data['fee'] ?? null, [\Inttegro\Order\FeeLineItemFee::class], false);
    }

    /**
     * Creates a FeeLineItem from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable FeeLineItem value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
