<?php

namespace Inttegro\Order;

use DateTimeImmutable;

/**
 * A complete commerce order containing line items, customer details, payment state, documents, and
 * fulfillment information.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Order extends \Inttegro\DomainValue
{
    /**
     * When the order was canceled. Omitted otherwise.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `canceled_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $canceledAt;

    /**
     * Checkout and payment flow configuration for this order.
     *
     * Optional response field. PHP type: `\Inttegro\Order\CheckoutSettings|null`; wire field:
     * `checkout_settings` (`object`).
     *
     * @var \Inttegro\Order\CheckoutSettings|null
     */
    public readonly ?\Inttegro\Order\CheckoutSettings $checkoutSettings;

    /**
     * When the order was completed. Omitted otherwise.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `completed_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $completedAt;

    /**
     * Attribution for the public resource that created this order, when available.
     *
     * Optional response field. PHP type: `\Inttegro\Order\CreatedFrom|null`; wire field:
     * `created_from` (`object`).
     *
     * @var \Inttegro\Order\CreatedFrom|null
     */
    public readonly ?\Inttegro\Order\CreatedFrom $createdFrom;

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
     * Customer value for this order.
     *
     * Required response field. PHP type: `\Inttegro\Order\Customer`; wire field: `customer`
     * (`object`).
     *
     * @var \Inttegro\Order\Customer
     */
    public readonly \Inttegro\Order\Customer $customer;

    /**
     * When the order expires. Omitted when no expiry is set.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `expires_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $expiresAt;

    /**
     * Unique identifier for this order.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * When order processing began.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `initiated_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $initiatedAt;

    /**
     * Invoice value for this order.
     *
     * Optional response field. PHP type: `\Inttegro\Order\Invoice|null`; wire field: `invoice`
     * (`object`).
     *
     * @var \Inttegro\Order\Invoice|null
     */
    public readonly ?\Inttegro\Order\Invoice $invoice;

    /**
     * Human-readable order number.
     *
     * Optional response field. PHP type: `string|null`; wire field: `number` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $number;

    /**
     * Merchant-provided receipt number, when set.
     *
     * Optional response field. PHP type: `string|null`; wire field: `receipt_number` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $receiptNumber;

    /**
     * All refunds issued for this order, newest first. Omitted when no refunds exist.
     *
     * Optional response field. PHP type: `list<\Inttegro\Refund\Refund>|null`; wire field:
     * `refunds` (`array<object>`).
     * When the field is absent, the SDK exposes an empty collection.
     *
     * @var list<\Inttegro\Refund\Refund>|null
     */
    public readonly ?array $refunds;

    /**
     * Order-level invoice rendering data. Pages uses this data when rendering invoice web and
     * download views.
     *
     * Optional response field. PHP type: `\Inttegro\Order\InvoiceSettings|null`; wire field:
     * `invoice_settings` (`object`).
     *
     * @var \Inttegro\Order\InvoiceSettings|null
     */
    public readonly ?\Inttegro\Order\InvoiceSettings $invoiceSettings;

    /**
     * Current lifecycle state of the order.
     *
     * Required response field. PHP type: `string`; wire field: `status` (`string`).
     * Compare against `Status` cases by using their `->value` strings.
     *
     * @var string
     */
    public readonly string $status;

    /**
     * When the order was finalized and became immutable—ready for payment or fulfillment.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `sealed_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $sealedAt;

    /**
     * Cart contents and totals.
     *
     * Optional response field. PHP type: `\Inttegro\Order\LineItemGroup|null`; wire field:
     * `line_item_group` (`object`).
     *
     * @var \Inttegro\Order\LineItemGroup|null
     */
    public readonly ?\Inttegro\Order\LineItemGroup $lineItemGroup;

    /**
     * Payment intent tied to this order.
     *
     * Optional response field. PHP type: `\Inttegro\Payment\Payment|null`; wire field: `payment`
     * (`object`).
     *
     * @var \Inttegro\Payment\Payment|null
     */
    public readonly ?\Inttegro\Payment\Payment $payment;

    /**
     * When the order became paid.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `paid_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $paidAt;

    /**
     * When the order payment becomes overdue.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `payment_due_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $paymentDueAt;

    /**
     * External order reference when present.
     *
     * Optional response field. PHP type: `string|null`; wire field: `reference` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $reference;

    /**
     * Hydrates an Order from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->canceledAt = \Inttegro\ValueHydrator::dateTime($data['canceled_at'] ?? null, true);
        $this->checkoutSettings = \Inttegro\ValueHydrator::object($data['checkout_settings'] ?? null, [\Inttegro\Order\CheckoutSettings::class], true);
        $this->completedAt = \Inttegro\ValueHydrator::dateTime($data['completed_at'] ?? null, true);
        $this->createdFrom = \Inttegro\ValueHydrator::object($data['created_from'] ?? null, [\Inttegro\Order\CreatedFrom::class], true);
        $this->customData = \Inttegro\ValueHydrator::array($data['custom_data'] ?? null, true);
        $this->customer = \Inttegro\ValueHydrator::object($data['customer'] ?? null, [\Inttegro\Order\Customer::class], false);
        $this->expiresAt = \Inttegro\ValueHydrator::dateTime($data['expires_at'] ?? null, true);
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->initiatedAt = \Inttegro\ValueHydrator::dateTime($data['initiated_at'] ?? null, false);
        $this->invoice = \Inttegro\ValueHydrator::object($data['invoice'] ?? null, [\Inttegro\Order\Invoice::class], true);
        $this->number = \Inttegro\ValueHydrator::string($data['number'] ?? null, true);
        $this->receiptNumber = \Inttegro\ValueHydrator::string($data['receipt_number'] ?? null, true);
        $this->refunds = \Inttegro\ValueHydrator::objects($data['refunds'] ?? null, [\Inttegro\Refund\Refund::class]);
        $this->invoiceSettings = \Inttegro\ValueHydrator::object($data['invoice_settings'] ?? null, [\Inttegro\Order\InvoiceSettings::class], true);
        $this->status = \Inttegro\ValueHydrator::string($data['status'] ?? null, false);
        $this->sealedAt = \Inttegro\ValueHydrator::dateTime($data['sealed_at'] ?? null, true);
        $this->lineItemGroup = \Inttegro\ValueHydrator::object($data['line_item_group'] ?? null, [\Inttegro\Order\LineItemGroup::class], true);
        $this->payment = \Inttegro\ValueHydrator::object($data['payment'] ?? null, [\Inttegro\Payment\Payment::class], true);
        $this->paidAt = \Inttegro\ValueHydrator::dateTime($data['paid_at'] ?? null, true);
        $this->paymentDueAt = \Inttegro\ValueHydrator::dateTime($data['payment_due_at'] ?? null, true);
        $this->reference = \Inttegro\ValueHydrator::string($data['reference'] ?? null, true);
    }

    /**
     * Creates an Order from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Order value.
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
        return $this->status === \Inttegro\Order\Status::Paid->value || $this->paidAt !== null;
    }

    /**
     * Reports whether the order still requires payment.
     */
    public function requiresPayment(): bool
    {
        return $this->status === \Inttegro\Order\Status::RequiresPayment->value;
    }

    /**
     * Reports whether the resource has reached a terminal lifecycle state.
     */
    public function isTerminal(): bool
    {
        return in_array($this->status, [
            \Inttegro\Order\Status::Paid->value,
            \Inttegro\Order\Status::Completed->value,
            \Inttegro\Order\Status::Canceled->value,
            \Inttegro\Order\Status::Expired->value,
        ], true);
    }

    /**
     * Returns the payment action that must be completed, or null when the order does not require one.
     */
    public function requiredPaymentAction(): ?\Inttegro\Payment\NextAction
    {
        return $this->payment?->requiredAction();
    }
}
