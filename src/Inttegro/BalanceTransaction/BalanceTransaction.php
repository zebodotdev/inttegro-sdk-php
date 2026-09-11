<?php

namespace Inttegro\BalanceTransaction;

use DateTimeImmutable;

/**
 * A ledger entry that explains when and why money moved through an Inttegro balance.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class BalanceTransaction extends \Inttegro\DomainValue
{
    /**
     * Monetary amount in integer minor units and its currency.
     *
     * Required response field. PHP type: `\Inttegro\BalanceTransaction\Amount`; wire field:
     * `amount` (`object`).
     *
     * @var \Inttegro\BalanceTransaction\Amount
     */
    public readonly \Inttegro\BalanceTransaction\Amount $amount;

    /**
     * Time at which the funds become available.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `available_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $availableAt;

    /**
     * Time at which the funds were claimed.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `claimed_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $claimedAt;

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
     * Unique identifier for this balance transaction.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Identifier of the related order.
     *
     * Required response field. PHP type: `string`; wire field: `order_id` (`string`).
     *
     * @var string
     */
    public readonly string $orderId;

    /**
     * Time at which payment completed.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `paid_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $paidAt;

    /**
     * Present when `type` is `payment`; omitted when `type` is `refund`.
     *
     * Optional response field. PHP type: `string|null`; wire field: `payment_id` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $paymentId;

    /**
     * Identifier of the related payout.
     *
     * Optional response field. PHP type: `string|null`; wire field: `payout_id` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $payoutId;

    /**
     * Payout Configuration value for this balance transaction.
     *
     * Optional response field. PHP type: `\Inttegro\Payment\PayoutConfiguration|null`; wire field:
     * `payout_configuration` (`object`).
     *
     * @var \Inttegro\Payment\PayoutConfiguration|null
     */
    public readonly ?\Inttegro\Payment\PayoutConfiguration $payoutConfiguration;

    /**
     * Present when `type` is `refund`; omitted when `type` is `payment`.
     *
     * Optional response field. PHP type: `string|null`; wire field: `refund_id` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $refundId;

    /**
     * Semantic source or cause of the transaction, not its direction.
     *
     * Required response field. PHP type: `string`; wire field: `type` (`string`).
     * Compare against `Type` cases by using their `->value` strings.
     *
     * @var string
     */
    public readonly string $type;

    /**
     * Hydrates a BalanceTransaction from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->amount = \Inttegro\ValueHydrator::object($data['amount'] ?? null, [\Inttegro\BalanceTransaction\Amount::class], false);
        $this->availableAt = \Inttegro\ValueHydrator::dateTime($data['available_at'] ?? null, true);
        $this->claimedAt = \Inttegro\ValueHydrator::dateTime($data['claimed_at'] ?? null, true);
        $this->createdAt = \Inttegro\ValueHydrator::dateTime($data['created_at'] ?? null, false);
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->orderId = \Inttegro\ValueHydrator::string($data['order_id'] ?? null, false);
        $this->paidAt = \Inttegro\ValueHydrator::dateTime($data['paid_at'] ?? null, true);
        $this->paymentId = \Inttegro\ValueHydrator::string($data['payment_id'] ?? null, true);
        $this->payoutId = \Inttegro\ValueHydrator::string($data['payout_id'] ?? null, true);
        $this->payoutConfiguration = \Inttegro\ValueHydrator::object($data['payout_configuration'] ?? null, [\Inttegro\Payment\PayoutConfiguration::class], true);
        $this->refundId = \Inttegro\ValueHydrator::string($data['refund_id'] ?? null, true);
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
    }

    /**
     * Creates a BalanceTransaction from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable BalanceTransaction value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
