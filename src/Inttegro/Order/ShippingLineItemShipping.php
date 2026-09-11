<?php

namespace Inttegro\Order;

use Inttegro\Money\Amount;

/**
 * Shipping Line Item Shipping details associated with order.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class ShippingLineItemShipping extends \Inttegro\DomainValue
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
     * Tax Code value for this shipping line item shipping.
     *
     * Optional response field. PHP type: `string|null`; wire field: `tax_code` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $taxCode;

    /**
     * Label value for this shipping line item shipping.
     *
     * Optional response field. PHP type: `string|null`; wire field: `label` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $label;

    /**
     * Fee value for this shipping line item shipping.
     *
     * Required response field. PHP type: `Amount`; wire field: `fee` (`object`).
     *
     * @var Amount
     */
    public readonly Amount $fee;

    /**
     * Hydrates a ShippingLineItemShipping from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->taxCode = \Inttegro\ValueHydrator::string($data['tax_code'] ?? null, true);
        $this->label = \Inttegro\ValueHydrator::string($data['label'] ?? null, true);
        $this->fee = \Inttegro\ValueHydrator::object($data['fee'] ?? null, [Amount::class], false);
    }

    /**
     * Creates a ShippingLineItemShipping from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable ShippingLineItemShipping value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
