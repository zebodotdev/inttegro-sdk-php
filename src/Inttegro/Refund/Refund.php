<?php

namespace Inttegro\Refund;

use DateTimeImmutable;
use Inttegro\Money\Amount;

/**
 * A refund request and its amount, reason, affected line items, lifecycle state, and related
 * balance transaction.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Refund extends \Inttegro\DomainValue
{
    /**
     * Omitted unless the refund was canceled before processing began.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `canceled_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $canceledAt;

    /**
     * Time at which the value was created.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `created_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $createdAt;

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
     * Omitted unless processing failed.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `failed_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $failedAt;

    /**
     * Unique identifier for this refund.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * One or more immutable line-level refund allocations.
     *
     * Required response field. PHP type: `list<\Inttegro\Refund\LineItem>`; wire field:
     * `line_items` (`array<object>`).
     * When the field is absent, the SDK exposes an empty collection.
     *
     * @var list<\Inttegro\Refund\LineItem>
     */
    public readonly array $lineItems;

    /**
     * Identifier of the related order.
     *
     * Required response field. PHP type: `string`; wire field: `order_id` (`string`).
     *
     * @var string
     */
    public readonly string $orderId;

    /**
     * Omitted until processing starts.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `processing_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $processingAt;

    /**
     * Reason value for this refund.
     *
     * Required response field. PHP type: `\Inttegro\GenericValue`; wire field: `reason` (`string`).
     * Compare against `Reason` cases by using their `->value` strings.
     *
     * @var \Inttegro\GenericValue
     */
    public readonly \Inttegro\GenericValue $reason;

    /**
     * Reason Details value for this refund.
     *
     * Optional response field. PHP type: `string|null`; wire field: `reason_details` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $reasonDetails;

    /**
     * Reference value for this refund.
     *
     * Optional response field. PHP type: `string|null`; wire field: `reference` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $reference;

    /**
     * Current lifecycle state.
     *
     * Required response field. PHP type: `string`; wire field: `status` (`string`).
     * Compare against `Status` cases by using their `->value` strings.
     *
     * @var string
     */
    public readonly string $status;

    /**
     * Omitted unless processing succeeded.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `succeeded_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $succeededAt;

    /**
     * Total number of matching values.
     *
     * Required response field. PHP type: `Amount`; wire field: `total` (`object`).
     *
     * @var Amount
     */
    public readonly Amount $total;

    /**
     * Hydrates a Refund from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->canceledAt = \Inttegro\ValueHydrator::dateTime($data['canceled_at'] ?? null, true);
        $this->createdAt = \Inttegro\ValueHydrator::dateTime($data['created_at'] ?? null, false);
        $this->customData = \Inttegro\ValueHydrator::array($data['custom_data'] ?? null, true);
        $this->failedAt = \Inttegro\ValueHydrator::dateTime($data['failed_at'] ?? null, true);
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->lineItems = \Inttegro\ValueHydrator::objects($data['line_items'] ?? null, [\Inttegro\Refund\LineItem::class]);
        $this->orderId = \Inttegro\ValueHydrator::string($data['order_id'] ?? null, false);
        $this->processingAt = \Inttegro\ValueHydrator::dateTime($data['processing_at'] ?? null, true);
        $this->reason = \Inttegro\ValueHydrator::object($data['reason'] ?? null, [\Inttegro\GenericValue::class], false);
        $this->reasonDetails = \Inttegro\ValueHydrator::string($data['reason_details'] ?? null, true);
        $this->reference = \Inttegro\ValueHydrator::string($data['reference'] ?? null, true);
        $this->status = \Inttegro\ValueHydrator::string($data['status'] ?? null, false);
        $this->succeededAt = \Inttegro\ValueHydrator::dateTime($data['succeeded_at'] ?? null, true);
        $this->total = \Inttegro\ValueHydrator::object($data['total'] ?? null, [Amount::class], false);
    }

    /**
     * Creates a Refund from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Refund value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
