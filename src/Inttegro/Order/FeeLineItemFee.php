<?php

namespace Inttegro\Order;

use Inttegro\Money\Amount;

/**
 * Fee Line Item Fee details associated with order.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class FeeLineItemFee extends \Inttegro\DomainValue
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
     * Human-readable description.
     *
     * Optional response field. PHP type: `string|null`; wire field: `description` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $description;

    /**
     * Tax Code value for this fee line item fee.
     *
     * Optional response field. PHP type: `string|null`; wire field: `tax_code` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $taxCode;

    /**
     * Monetary amount in integer minor units and its currency.
     *
     * Required response field. PHP type: `Amount`; wire field: `amount` (`object`).
     *
     * @var Amount
     */
    public readonly Amount $amount;

    /**
     * Label value for this fee line item fee.
     *
     * Required response field. PHP type: `string`; wire field: `label` (`string`).
     *
     * @var string
     */
    public readonly string $label;

    /**
     * Hydrates a FeeLineItemFee from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->description = \Inttegro\ValueHydrator::string($data['description'] ?? null, true);
        $this->taxCode = \Inttegro\ValueHydrator::string($data['tax_code'] ?? null, true);
        $this->amount = \Inttegro\ValueHydrator::object($data['amount'] ?? null, [Amount::class], false);
        $this->label = \Inttegro\ValueHydrator::string($data['label'] ?? null, false);
    }

    /**
     * Creates a FeeLineItemFee from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable FeeLineItemFee value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
