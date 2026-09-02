<?php

namespace Inttegro;

use Inttegro\ResponseObject;

final class Money
{
    public function __construct(public readonly string $currency, public readonly int $value) {}

    public static function fromArray(array $data): self
    {
        return new self((string)($data['currency'] ?? ''), (int)($data['value'] ?? 0));
    }
}

final class OrderCustomer
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly bool $guest,
        public readonly ?string $emailAddress,
        public readonly ?string $phoneNumber,
        public readonly ?ResponseObject $billingAddress,
        public readonly ?ResponseObject $shippingAddress,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            (string)($data['id'] ?? ''),
            (string)($data['name'] ?? ''),
            (bool)($data['guest'] ?? false),
            isset($data['email_address']) ? (string)$data['email_address'] : null,
            isset($data['phone_number']) ? (string)$data['phone_number'] : null,
            isset($data['billing_address']) && is_array($data['billing_address']) ? new ResponseObject($data['billing_address']) : null,
            isset($data['shipping_address']) && is_array($data['shipping_address']) ? new ResponseObject($data['shipping_address']) : null,
        );
    }
}

final class PaymentNextAction
{
    public function __construct(
        public readonly ?string $type,
        public readonly ?string $confirmationId,
        public readonly ?string $channel,
        public readonly ?string $expiresAt,
        public readonly ?string $url,
        public readonly ResponseObject $data,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            isset($data['type']) ? (string)$data['type'] : null,
            isset($data['confirmation_id']) ? (string)$data['confirmation_id'] : null,
            isset($data['channel']) ? (string)$data['channel'] : null,
            isset($data['expires_at']) ? (string)$data['expires_at'] : null,
            isset($data['url']) ? (string)$data['url'] : null,
            new ResponseObject($data),
        );
    }
}

final class OrderPayment
{
    public function __construct(
        public readonly ?string $id,
        public readonly ?string $status,
        public readonly ?Money $amount,
        public readonly ?PaymentNextAction $nextAction,
        public readonly ?ResponseObject $paymentMethod,
        public readonly ?ResponseObject $latestAttempt,
        public readonly ?ResponseObject $balanceTransaction,
        public readonly ?string $initiatedAt,
        public readonly ?string $executedAt,
        public readonly ?string $paidAt,
        public readonly ?string $failedAt,
    ) {}

    public static function fromArray(array $data): self
    {
        $object = static fn(string $key): ?ResponseObject => isset($data[$key]) && is_array($data[$key])
            ? new ResponseObject($data[$key])
            : null;
        return new self(
            isset($data['id']) ? (string)$data['id'] : null,
            isset($data['status']) ? (string)$data['status'] : null,
            isset($data['amount']) && is_array($data['amount']) ? Money::fromArray($data['amount']) : null,
            isset($data['next_action']) && is_array($data['next_action']) ? PaymentNextAction::fromArray($data['next_action']) : null,
            $object('payment_method'),
            $object('latest_attempt'),
            $object('balance_transaction'),
            isset($data['initiated_at']) ? (string)$data['initiated_at'] : null,
            isset($data['executed_at']) ? (string)$data['executed_at'] : null,
            isset($data['paid_at']) ? (string)$data['paid_at'] : null,
            isset($data['failed_at']) ? (string)$data['failed_at'] : null,
        );
    }
}

final class OrderInvoiceLink
{
    public function __construct(public readonly ?string $url) {}

    public static function fromArray(array $data): self
    {
        return new self(isset($data['url']) ? (string)$data['url'] : null);
    }
}

final class OrderInvoiceFormat
{
    public function __construct(public readonly ?OrderInvoiceLink $web, public readonly ?OrderInvoiceLink $pdf) {}

    public static function fromArray(array $data): self
    {
        return new self(
            isset($data['web']) && is_array($data['web']) ? OrderInvoiceLink::fromArray($data['web']) : null,
            isset($data['pdf']) && is_array($data['pdf']) ? OrderInvoiceLink::fromArray($data['pdf']) : null,
        );
    }
}

final class OrderInvoice
{
    /** @param list<ResponseObject> $deliveries */
    public function __construct(
        public readonly ?string $id,
        public readonly ?string $number,
        public readonly ?OrderInvoiceFormat $format,
        public readonly array $deliveries,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            isset($data['id']) ? (string)$data['id'] : null,
            isset($data['number']) ? (string)$data['number'] : null,
            isset($data['format']) && is_array($data['format']) ? OrderInvoiceFormat::fromArray($data['format']) : null,
            array_map(static fn(array $item): ResponseObject => new ResponseObject($item), $data['deliveries'] ?? []),
        );
    }
}

final class OrderLineItemGroup
{
    /** @param list<ResponseObject> $lineItems */
    public function __construct(public readonly array $lineItems, public readonly ?Money $total) {}

    public static function fromArray(array $data): self
    {
        return new self(
            array_map(static fn(array $item): ResponseObject => new ResponseObject($item), $data['line_items'] ?? []),
            isset($data['total']) && is_array($data['total']) ? Money::fromArray($data['total']) : null,
        );
    }
}

final class Refund
{
    /** @param list<ResponseObject> $lineItems */
    public function __construct(
        public readonly string $id,
        public readonly ?string $orderId,
        public readonly ?string $status,
        public readonly ?Money $total,
        public readonly array $lineItems,
        public readonly ?string $reason,
        public readonly ?string $reasonDetails,
        public readonly ?string $reference,
        public readonly ?array $customData,
        public readonly ?string $createdAt,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            (string)($data['id'] ?? ''),
            isset($data['order_id']) ? (string)$data['order_id'] : null,
            isset($data['status']) ? (string)$data['status'] : null,
            isset($data['total']) && is_array($data['total']) ? Money::fromArray($data['total']) : null,
            array_map(static fn(array $item): ResponseObject => new ResponseObject($item), $data['line_items'] ?? []),
            isset($data['reason']) ? (string)$data['reason'] : null,
            isset($data['reason_details']) ? (string)$data['reason_details'] : null,
            isset($data['reference']) ? (string)$data['reference'] : null,
            isset($data['custom_data']) && is_array($data['custom_data']) ? $data['custom_data'] : null,
            isset($data['created_at']) ? (string)$data['created_at'] : null,
        );
    }
}

final class Order
{
    /** @param list<Refund> $refunds */
    public function __construct(
        public readonly string $id,
        public readonly string $status,
        public readonly ?string $number,
        public readonly ?string $receiptNumber,
        public readonly ?OrderCustomer $customer,
        public readonly ?OrderLineItemGroup $lineItemGroup,
        public readonly ?OrderPayment $payment,
        public readonly ?OrderInvoice $invoice,
        public readonly ?ResponseObject $checkoutSettings,
        public readonly ?ResponseObject $shipping,
        public readonly ?array $customData,
        public readonly array $refunds,
        public readonly ?string $initiatedAt,
        public readonly ?string $sealedAt,
        public readonly ?string $completedAt,
        public readonly ?string $expiresAt,
        public readonly ?string $paidAt,
        public readonly ?string $canceledAt,
        public readonly ResponseObject $data,
    ) {}

    public static function fromArray(array $data): self
    {
        $object = static fn(string $key): ?ResponseObject => isset($data[$key]) && is_array($data[$key])
            ? new ResponseObject($data[$key])
            : null;
        return new self(
            (string)($data['id'] ?? ''),
            (string)($data['status'] ?? 'unknown'),
            isset($data['number']) ? (string)$data['number'] : null,
            isset($data['receipt_number']) ? (string)$data['receipt_number'] : null,
            isset($data['customer']) && is_array($data['customer']) ? OrderCustomer::fromArray($data['customer']) : null,
            isset($data['line_item_group']) && is_array($data['line_item_group']) ? OrderLineItemGroup::fromArray($data['line_item_group']) : null,
            isset($data['payment']) && is_array($data['payment']) ? OrderPayment::fromArray($data['payment']) : null,
            isset($data['invoice']) && is_array($data['invoice']) ? OrderInvoice::fromArray($data['invoice']) : null,
            $object('checkout_settings'),
            $object('shipping'),
            isset($data['custom_data']) && is_array($data['custom_data']) ? $data['custom_data'] : null,
            array_map(static fn(array $item): Refund => Refund::fromArray($item), $data['refunds'] ?? []),
            isset($data['initiated_at']) ? (string)$data['initiated_at'] : null,
            isset($data['sealed_at']) ? (string)$data['sealed_at'] : null,
            isset($data['completed_at']) ? (string)$data['completed_at'] : null,
            isset($data['expires_at']) ? (string)$data['expires_at'] : null,
            isset($data['paid_at']) ? (string)$data['paid_at'] : null,
            isset($data['canceled_at']) ? (string)$data['canceled_at'] : null,
            new ResponseObject($data),
        );
    }
}

final class OrderPage
{
    /** @param list<Order> $orders */
    public function __construct(public readonly ?int $number, public readonly ?int $size, public readonly array $orders) {}

    public static function fromArray(array $data): self
    {
        return new self(
            isset($data['number']) ? (int)$data['number'] : null,
            isset($data['size']) ? (int)$data['size'] : null,
            array_map(static fn(array $item): Order => Order::fromArray($item), $data['orders'] ?? []),
        );
    }
}

final class OrderDocumentDeliveryAttempt
{
    public function __construct(
        public readonly ?string $channel,
        public readonly ?string $chimeId,
        public readonly ?string $error,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            isset($data['channel']) ? (string)$data['channel'] : null,
            isset($data['chime_id']) ? (string)$data['chime_id'] : null,
            isset($data['error']) ? (string)$data['error'] : null,
        );
    }
}

final class OrderDocumentDelivery
{
    /**
     * @param list<string> $sentChannels
     * @param list<string> $failedChannels
     * @param list<OrderDocumentDeliveryAttempt> $deliveries
     * @param list<OrderDocumentDeliveryAttempt> $failures
     */
    public function __construct(
        public readonly ?string $documentKind,
        public readonly ?string $documentUrl,
        public readonly array $sentChannels,
        public readonly array $failedChannels,
        public readonly array $deliveries,
        public readonly array $failures,
    ) {}

    public static function fromArray(array $data): self
    {
        $attempts = static fn(string $key): array => array_map(
            static fn(array $item): OrderDocumentDeliveryAttempt => OrderDocumentDeliveryAttempt::fromArray($item),
            $data[$key] ?? [],
        );
        return new self(
            isset($data['document_kind']) ? (string)$data['document_kind'] : null,
            isset($data['document_url']) ? (string)$data['document_url'] : null,
            array_values($data['sent_channels'] ?? []),
            array_values($data['failed_channels'] ?? []),
            $attempts('deliveries'),
            $attempts('failures'),
        );
    }
}

final class OrderDocumentDeliveryResult
{
    public function __construct(public readonly Order $order, public readonly OrderDocumentDelivery $delivery) {}

    public static function fromArray(array $data): self
    {
        return new self(
            Order::fromArray(is_array($data['order'] ?? null) ? $data['order'] : []),
            OrderDocumentDelivery::fromArray(is_array($data['delivery'] ?? null) ? $data['delivery'] : []),
        );
    }
}
