<?php

namespace Inttegro\Refund;

use Inttegro\Money\Amount;

/**
 * Line Item details associated with refund.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class LineItem extends \Inttegro\DomainValue
{
    /**
     * Server-generated refund line-item identifier.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Identifier of the related order line item.
     *
     * Required response field. PHP type: `string`; wire field: `order_line_item_id` (`string`).
     *
     * @var string
     */
    public readonly string $orderLineItemId;

    /**
     * Original Amount Paid value for this line item.
     *
     * Required response field. PHP type: `Amount`; wire field: `original_amount_paid` (`object`).
     *
     * @var Amount
     */
    public readonly Amount $originalAmountPaid;

    /**
     * Reason value for this line item.
     *
     * Optional response field. PHP type: `\Inttegro\GenericValue|null`; wire field: `reason`
     * (`string`).
     * Compare against `Reason` cases by using their `->value` strings.
     *
     * @var \Inttegro\GenericValue|null
     */
    public readonly ?\Inttegro\GenericValue $reason;

    /**
     * Reason Details value for this line item.
     *
     * Optional response field. PHP type: `string|null`; wire field: `reason_details` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $reasonDetails;

    /**
     * Refund Amount value for this line item.
     *
     * Required response field. PHP type: `Amount`; wire field: `refund_amount` (`object`).
     *
     * @var Amount
     */
    public readonly Amount $refundAmount;

    /**
     * Hydrates a LineItem from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->orderLineItemId = \Inttegro\ValueHydrator::string($data['order_line_item_id'] ?? null, false);
        $this->originalAmountPaid = \Inttegro\ValueHydrator::object($data['original_amount_paid'] ?? null, [Amount::class], false);
        $this->reason = \Inttegro\ValueHydrator::object($data['reason'] ?? null, [\Inttegro\GenericValue::class], true);
        $this->reasonDetails = \Inttegro\ValueHydrator::string($data['reason_details'] ?? null, true);
        $this->refundAmount = \Inttegro\ValueHydrator::object($data['refund_amount'] ?? null, [Amount::class], false);
    }

    /**
     * Creates a LineItem from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable LineItem value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
