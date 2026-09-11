<?php

namespace Inttegro\Payout;

use DateTimeImmutable;
use Inttegro\Money\Amount;

/**
 * A transfer scheduled from an Inttegro balance to a destination financial account.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Payout extends \Inttegro\DomainValue
{
    /**
     * Monetary amount in integer minor units and its currency.
     *
     * Optional response field. PHP type: `Amount|null`; wire field: `amount` (`object`).
     *
     * @var Amount|null
     */
    public readonly ?Amount $amount;

    /**
     * Balance transaction IDs linked to this payout.
     *
     * Optional response field. PHP type: `list<string>|null`; wire field: `balance_transactions`
     * (`array<string>`).
     *
     * @var list<string>|null
     */
    public readonly ?array $balanceTransactions;

    /**
     * When the payout was canceled.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `canceled_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $canceledAt;

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
     * Financial account receiving the funds.
     *
     * Required response field. PHP type: `string`; wire field: `destination_id` (`string`).
     *
     * @var string
     */
    public readonly string $destinationId;

    /**
     * Public failure details when execution fails.
     *
     * Optional response field. PHP type: `\Inttegro\Payout\Error|null`; wire field: `error`
     * (`object`).
     *
     * @var \Inttegro\Payout\Error|null
     */
    public readonly ?\Inttegro\Payout\Error $error;

    /**
     * Earliest moment payout execution may begin.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `execute_after`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $executeAfter;

    /**
     * Actor that executed the payout.
     *
     * Optional response field. PHP type: `string|null`; wire field: `executed_by` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $executedBy;

    /**
     * Expected completion time.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `expected_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $expectedAt;

    /**
     * When the payout entered its unsuccessful terminal state.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `failed_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $failedAt;

    /**
     * Unique payout identifier.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * When the payout was created.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `initiated_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $initiatedAt;

    /**
     * Actor that initiated the payout.
     *
     * Optional response field. PHP type: `string|null`; wire field: `initiated_by` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $initiatedBy;

    /**
     * Max Amount value for this payout.
     *
     * Required response field. PHP type: `Amount`; wire field: `max_amount` (`object`).
     *
     * @var Amount
     */
    public readonly Amount $maxAmount;

    /**
     * Merchant reference carried on the payout.
     *
     * Optional response field. PHP type: `string|null`; wire field: `reference` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $reference;

    /**
     * Schedule associated with the payout.
     *
     * Optional response field. PHP type: `string|null`; wire field: `schedule_id` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $scheduleId;

    /**
     * When the payout was scheduled.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `scheduled_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $scheduledAt;

    /**
     * Actor that scheduled the payout.
     *
     * Optional response field. PHP type: `string|null`; wire field: `scheduled_by` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $scheduledBy;

    /**
     * When the transfer was sent.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `sent_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $sentAt;

    /**
     * Source identifier associated with the payout.
     *
     * Optional response field. PHP type: `string|null`; wire field: `source_id` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $sourceId;

    /**
     * Current payout lifecycle state.
     *
     * Required response field. PHP type: `string`; wire field: `status` (`string`).
     * Compare against `Status` cases by using their `->value` strings.
     *
     * @var string
     */
    public readonly string $status;

    /**
     * When the payout succeeded.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `succeeded_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $succeededAt;

    /**
     * Hydrates a Payout from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->amount = \Inttegro\ValueHydrator::object($data['amount'] ?? null, [Amount::class], true);
        $this->balanceTransactions = \Inttegro\ValueHydrator::array($data['balance_transactions'] ?? null, true);
        $this->canceledAt = \Inttegro\ValueHydrator::dateTime($data['canceled_at'] ?? null, true);
        $this->customData = \Inttegro\ValueHydrator::array($data['custom_data'] ?? null, true);
        $this->destinationId = \Inttegro\ValueHydrator::string($data['destination_id'] ?? null, false);
        $this->error = \Inttegro\ValueHydrator::object($data['error'] ?? null, [\Inttegro\Payout\Error::class], true);
        $this->executeAfter = \Inttegro\ValueHydrator::dateTime($data['execute_after'] ?? null, false);
        $this->executedBy = \Inttegro\ValueHydrator::string($data['executed_by'] ?? null, true);
        $this->expectedAt = \Inttegro\ValueHydrator::dateTime($data['expected_at'] ?? null, true);
        $this->failedAt = \Inttegro\ValueHydrator::dateTime($data['failed_at'] ?? null, true);
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->initiatedAt = \Inttegro\ValueHydrator::dateTime($data['initiated_at'] ?? null, false);
        $this->initiatedBy = \Inttegro\ValueHydrator::string($data['initiated_by'] ?? null, true);
        $this->maxAmount = \Inttegro\ValueHydrator::object($data['max_amount'] ?? null, [Amount::class], false);
        $this->reference = \Inttegro\ValueHydrator::string($data['reference'] ?? null, true);
        $this->scheduleId = \Inttegro\ValueHydrator::string($data['schedule_id'] ?? null, true);
        $this->scheduledAt = \Inttegro\ValueHydrator::dateTime($data['scheduled_at'] ?? null, true);
        $this->scheduledBy = \Inttegro\ValueHydrator::string($data['scheduled_by'] ?? null, true);
        $this->sentAt = \Inttegro\ValueHydrator::dateTime($data['sent_at'] ?? null, true);
        $this->sourceId = \Inttegro\ValueHydrator::string($data['source_id'] ?? null, true);
        $this->status = \Inttegro\ValueHydrator::string($data['status'] ?? null, false);
        $this->succeededAt = \Inttegro\ValueHydrator::dateTime($data['succeeded_at'] ?? null, true);
    }

    /**
     * Creates a Payout from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Payout value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
