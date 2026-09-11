<?php

namespace Inttegro\Payment;

use DateTimeImmutable;
use Inttegro\Money\Amount;

/**
 * A payment intent tied to an order, including its amount, execution state, required action, and
 * settlement details.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Payment extends \Inttegro\DomainValue
{
    /**
     * Payment intent ID.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Payment state.
     *
     * Required response field. PHP type: `string`; wire field: `status` (`string`).
     * Compare against `Status` cases by using their `->value` strings.
     *
     * @var string
     */
    public readonly string $status;

    /**
     * Optional statement descriptor shown on the customer's bank statement.
     *
     * Required response field. PHP type: `string`; wire field: `statement_descriptor` (`string`).
     *
     * @var string
     */
    public readonly string $statementDescriptor;

    /**
     * Monetary amount in integer minor units and its currency.
     *
     * Required response field. PHP type: `Amount`; wire field: `amount` (`object`).
     *
     * @var Amount
     */
    public readonly Amount $amount;

    /**
     * Merchant balance entry caused by a payment or refund. `type` describes the semantic source,
     * not direction. A payment transaction contains `payment_id`; a refund transaction contains
     * `refund_id`. Exactly one matching reference is present.
     *
     * Optional response field. PHP type: `\Inttegro\BalanceTransaction\BalanceTransaction|null`;
     * wire field: `balance_transaction` (`object`).
     *
     * @var \Inttegro\BalanceTransaction\BalanceTransaction|null
     */
    public readonly ?\Inttegro\BalanceTransaction\BalanceTransaction $balanceTransaction;

    /**
     * Payment Method value for this payment.
     *
     * Optional response field. PHP type: `\Inttegro\Payment\PaymentMethod|null`; wire field:
     * `payment_method` (`object`).
     *
     * @var \Inttegro\Payment\PaymentMethod|null
     */
    public readonly ?\Inttegro\Payment\PaymentMethod $paymentMethod;

    /**
     * Billing Details value for this payment.
     *
     * Optional response field. PHP type: `\Inttegro\Payment\BillingDetails|null`; wire field:
     * `billing_details` (`object`).
     *
     * @var \Inttegro\Payment\BillingDetails|null
     */
    public readonly ?\Inttegro\Payment\BillingDetails $billingDetails;

    /**
     * Customer value for this payment.
     *
     * Optional response field. PHP type: `\Inttegro\Order\Customer|null`; wire field: `customer`
     * (`object`).
     *
     * @var \Inttegro\Order\Customer|null
     */
    public readonly ?\Inttegro\Order\Customer $customer;

    /**
     * Most recent payment attempt details.
     *
     * Optional response field. PHP type: `\Inttegro\Payment\Attempt|null`; wire field:
     * `latest_attempt` (`object`).
     *
     * @var \Inttegro\Payment\Attempt|null
     */
    public readonly ?\Inttegro\Payment\Attempt $latestAttempt;

    /**
     * Next action required to complete a payment.
     *
     * Optional response field. PHP type: `\Inttegro\Payment\NextAction|null`; wire field:
     * `next_action` (`object`).
     *
     * @var \Inttegro\Payment\NextAction|null
     */
    public readonly ?\Inttegro\Payment\NextAction $nextAction;

    /**
     * Latest Error value for this payment.
     *
     * Optional response field. PHP type: `\Inttegro\Payment\Error|null`; wire field: `latest_error`
     * (`object`).
     *
     * @var \Inttegro\Payment\Error|null
     */
    public readonly ?\Inttegro\Payment\Error $latestError;

    /**
     * When we kicked off the payment intent.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `initiated_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $initiatedAt;

    /**
     * When payment execution started.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `executed_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $executedAt;

    /**
     * When payment completed successfully.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `paid_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $paidAt;

    /**
     * When payment was canceled.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `canceled_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $canceledAt;

    /**
     * When payment becomes overdue.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `due_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $dueAt;

    /**
     * When payment expired.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `expired_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $expiredAt;

    /**
     * When payment failed.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `failed_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $failedAt;

    /**
     * Whether payment was recorded as received outside Inttegro.
     *
     * Optional response field. PHP type: `bool|null`; wire field: `paid_offline` (`boolean`).
     *
     * @var bool|null
     */
    public readonly ?bool $paidOffline;

    /**
     * Payment Method Types value for this payment.
     *
     * Optional response field. PHP type: `list<string>|null`; wire field: `payment_method_types`
     * (`array<string>`).
     *
     * @var list<string>|null
     */
    public readonly ?array $paymentMethodTypes;

    /**
     * Payout configuration for this payment.
     *
     * Optional response field. PHP type: `\Inttegro\Payment\PayoutConfiguration|null`; wire field:
     * `payout_configuration` (`object`).
     *
     * @var \Inttegro\Payment\PayoutConfiguration|null
     */
    public readonly ?\Inttegro\Payment\PayoutConfiguration $payoutConfiguration;

    /**
     * Hydrates a Payment from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->status = \Inttegro\ValueHydrator::string($data['status'] ?? null, false);
        $this->statementDescriptor = \Inttegro\ValueHydrator::string($data['statement_descriptor'] ?? null, false);
        $this->amount = \Inttegro\ValueHydrator::object($data['amount'] ?? null, [Amount::class], false);
        $this->balanceTransaction = \Inttegro\ValueHydrator::object($data['balance_transaction'] ?? null, [\Inttegro\BalanceTransaction\BalanceTransaction::class], true);
        $this->paymentMethod = \Inttegro\ValueHydrator::object($data['payment_method'] ?? null, [\Inttegro\Payment\PaymentMethod::class], true);
        $this->billingDetails = \Inttegro\ValueHydrator::object($data['billing_details'] ?? null, [\Inttegro\Payment\BillingDetails::class], true);
        $this->customer = \Inttegro\ValueHydrator::object($data['customer'] ?? null, [\Inttegro\Order\Customer::class], true);
        $this->latestAttempt = \Inttegro\ValueHydrator::object($data['latest_attempt'] ?? null, [\Inttegro\Payment\Attempt::class], true);
        $this->nextAction = \Inttegro\ValueHydrator::object($data['next_action'] ?? null, [\Inttegro\Payment\NextAction::class], true);
        $this->latestError = \Inttegro\ValueHydrator::object($data['latest_error'] ?? null, [\Inttegro\Payment\Error::class], true);
        $this->initiatedAt = \Inttegro\ValueHydrator::dateTime($data['initiated_at'] ?? null, false);
        $this->executedAt = \Inttegro\ValueHydrator::dateTime($data['executed_at'] ?? null, true);
        $this->paidAt = \Inttegro\ValueHydrator::dateTime($data['paid_at'] ?? null, true);
        $this->canceledAt = \Inttegro\ValueHydrator::dateTime($data['canceled_at'] ?? null, true);
        $this->dueAt = \Inttegro\ValueHydrator::dateTime($data['due_at'] ?? null, true);
        $this->expiredAt = \Inttegro\ValueHydrator::dateTime($data['expired_at'] ?? null, true);
        $this->failedAt = \Inttegro\ValueHydrator::dateTime($data['failed_at'] ?? null, true);
        $this->paidOffline = \Inttegro\ValueHydrator::bool($data['paid_offline'] ?? null, true);
        $this->paymentMethodTypes = \Inttegro\ValueHydrator::array($data['payment_method_types'] ?? null, true);
        $this->payoutConfiguration = \Inttegro\ValueHydrator::object($data['payout_configuration'] ?? null, [\Inttegro\Payment\PayoutConfiguration::class], true);
    }

    /**
     * Creates a Payment from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Payment value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }

    /**
     * Reports whether the resource's payment has completed successfully.
     */
    public function isPaid(): bool
    {
        return $this->status === \Inttegro\Payment\Status::Paid->value;
    }

    /**
     * Reports whether the payment requires additional customer or merchant action.
     */
    public function requiresAction(): bool
    {
        return $this->status === \Inttegro\Payment\Status::RequiresAction->value;
    }

    /**
     * Reports whether the resource has reached a terminal lifecycle state.
     */
    public function isTerminal(): bool
    {
        return in_array($this->status, [
            \Inttegro\Payment\Status::Paid->value,
            \Inttegro\Payment\Status::Canceled->value,
            \Inttegro\Payment\Status::Expired->value,
            \Inttegro\Payment\Status::Failed->value,
        ], true);
    }

    /**
     * Returns the next required payment action, or null when no action is required.
     */
    public function requiredAction(): ?\Inttegro\Payment\NextAction
    {
        return $this->requiresAction() ? $this->nextAction : null;
    }
}
