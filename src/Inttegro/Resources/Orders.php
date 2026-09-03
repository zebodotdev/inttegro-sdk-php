<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;
use Inttegro\Order;
use Inttegro\OrderDocumentDeliveryResult;
use Inttegro\OrderPage;
use Inttegro\Refund;

/**
 * Orders resource for creating orders, processing payments, and managing order lifecycle.
 *
 * Orders are the central transaction object in Inttegro. They represent a purchase with
 * line items, customer information, and payment details. Use this resource to create
 * orders, charge customers, handle confirmations, and process refunds.
 *
 * @see https://studio.inttegro.com/orders for detailed guides
 */
class Orders
{
    private HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Create a new order with line items, customer, and payment details.
     *
     * Creates an order representing a purchase. You can create an order for a new or
     * existing customer, include multiple line items, and optionally execute payment
     * immediately. Orders must have at least one line item and billing details.
     *
     * @param array $payload Order creation parameters
     *   - customer_data: array - New customer information (required if customer_id not provided)
     *   - customer_id: string - Existing customer ID (required if customer_data not provided)
     *   - line_items: array - List of products/services being purchased (required)
     *   - billing_details: array - Billing contact information (required)
     *   - payment_method_id: string - ID of saved payment method to use
     *   - payment_method_data: array - Inline payment method details
     *   - execute_payment: bool - Whether to immediately charge (default: false)
     *   - checkout_settings: array - Checkout flow configuration with redirect_url and cancel_url
     *   - payout_settings: array - Order-specific payout destination configuration
     *   - custom_data: array - Key-value custom data (max 25KB, keys and values must be strings)
     *   - request_meta: array - Request controls such as idempotency_key
     *   - number: string - Optional order number for reference
     *   - statement_descriptor: string - Text on customer's bank statement (max 22 characters)
     *   - statement_descriptor_prefix: string - Static prefix, 2-10 characters, used to build prefix*order_id; mutually exclusive with statement_descriptor
     *   - finalize: bool - Whether to explicitly finalize order (default: false)
     *
     * @return Order The created order
     *
     * @example Create order with new customer and execute payment
     * ```php
     * $order = $client->orders->create([
     *     'request_meta' => [
     *         'idempotency_key' => 'order_2025_001',
     *     ],
     *     'execute_payment' => true,
     *     'customer_data' => [
     *         'name' => 'Akua Asantewaa',
     *         'email_address' => 'akua@example.com',
     *         'phone_number' => '+233541234567'
     *     ],
     *     'payment_method_data' => [
     *         'type' => 'mobile_money',
     *         'mobile_money' => [
     *             'network' => 'mtn',
     *             'account_number' => '0541234567'
     *         ]
     *     ],
     *     'line_items' => [[
     *         'type' => 'product',
     *         'product' => [
     *             'type' => 'digital',
     *             'name' => 'Premium Subscription',
     *             'quantity' => 1,
     *             'price' => ['currency' => 'ghs', 'value' => 5000]
     *         ]
     *     ]],
     *     'billing_details' => [
     *         'name' => 'Akua Asantewaa',
     *         'phone_number' => '+233541234567'
     *     ],
     *     'checkout_settings' => [
     *         'redirect_url' => 'https://example.com/order/complete',
     *         'cancel_url' => 'https://example.com/order/cancelled'
     *     ]
     * ]);
     *
     * echo "Created order: {$order->id}\n";
     * ```
     *
     * @see https://studio.inttegro.com/accept-a-payment for payment flow guide
     * @see https://studio.inttegro.com/order-lifecycle for order states
     */
    public function create(array $payload): Order
    {
        return $this->http->postResource('/orders/create', Order::class, 'order', $payload);
    }

    /** Compatibility route for POST /orders/new. Prefer create() for the canonical /orders/create endpoint. */
    public function createLegacy(array $payload): Order
    {
        return $this->http->postResource('/orders/new', Order::class, 'order', $payload);
    }

    /**
     * Retrieve an existing order by its ID.
     *
     * Returns full order details including customer, line items, payment state, and invoice information.
     * Use this to check order status, retrieve payment details, or display order confirmation to customers.
     *
     * @param string $orderId Unique identifier of the order to retrieve (required)
     * @param array $options Additional options (currently unused)
     *
     * @return Order The complete order
     *
     * @example Lookup an order
     * ```php
     * $order = $client->orders->lookup(
     *     'GKj7A8lM5wEGRUvbqpI4bkDFsQvpqVyh5fqePNnb'
     * );
     *
     * echo "Order status: {$order->status}\n";
     * if ($order->payment !== null) {
     *     echo "Payment status: {$order->payment->status}\n";
     * }
     * ```
     *
     * @see https://studio.inttegro.com/orders for API reference
     */
    public function lookup(string $orderId, array $options = []): Order
    {
        return $this->http->postResource(
            '/orders/lookup',
            Order::class,
            'order',
            array_merge(['order_id' => $orderId], $options)
        );
    }

    /** Update mutable fields on an existing order (POST /orders/update). */
    public function update(array $payload): Order
    {
        return $this->http->postResource('/orders/update', Order::class, 'order', $payload);
    }

    /**
     * Initiate payment for an existing order.
     *
     * Supports three payment flows:
     * 1. Saved payment method: Provide only order_id to charge a previously saved payment method
     * 2. New payment method: Include payment_method_data with inline payment details
     * 3. Offline payment: Set paid_out_of_band to true for cash, bank transfer, or check payments
     *
     * When payment requires customer confirmation (e.g., OTP), the returned order includes a nextAction field.
     *
     * @param array $payload Payment parameters
     *   - order_id: string - Unique identifier of the order to pay (required)
     *   - payment_method_data: array - Inline payment method details (mobile money, card, etc.)
     *   - payment_method_id: string - ID of a saved payment method to use
     *   - paid_out_of_band: bool - Set to true if payment received outside Inttegro (default: false)
     *
     * @return Order The updated order and payment state
     *
     * @example Pay with inline mobile money
     * ```php
     * $order = $client->orders->pay([
     *     'order_id' => 'GKj7A8lM5wEGRUvbqpI4bkDFsQvpqVyh5fqePNnb',
     *     'payment_method_data' => [
     *         'type' => 'mobile_money',
     *         'mobile_money' => [
     *             'network' => 'mtn',
     *             'account_number' => '0544998605'
     *         ]
     *     ]
     * ]);
     *
     * if ($order->payment?->nextAction?->type === 'confirm_payment') {
     *     echo "Customer needs to provide OTP sent to their phone\n";
     * }
     * ```
     *
     * @example Pay with saved payment method
     * ```php
     * $order = $client->orders->pay([
     *     'order_id' => 'GKj7A8lM5wEGRUvbqpI4bkDFsQvpqVyh5fqePNnb',
     *     'payment_method_id' => 'pm_xyz123abc456'
     * ]);
     * ```
     *
     * @see https://studio.inttegro.com/accept-a-payment for payment flow guide
     * @see https://studio.inttegro.com/charge-repeat-customers for saved payment methods
     */
    public function pay(array $payload): Order
    {
        return $this->http->postResource('/orders/pay', Order::class, 'order', $payload);
    }

    /**
     * Confirm a pending payment using a verification token (e.g., OTP sent to customer's phone).
     *
     * Call this method when a payment requires customer confirmation and you've collected the verification
     * token from the customer. The token is typically a 6-digit OTP sent via SMS or email.
     *
     * @param array $payload Confirmation parameters
     *   - order_id: string - Unique identifier of the order being paid (required)
     *   - token: string - Verification token provided by customer (required, typically 6 digits)
     *
     * @return Order The updated order
     *
     * @example Confirm payment with OTP
     * ```php
     * $order = $client->orders->confirmPayment([
     *     'order_id' => 'GKj7A8lM5wEGRUvbqpI4bkDFsQvpqVyh5fqePNnb',
     *     'token' => '123456'
     * ]);
     *
     * if ($order->payment?->status === 'succeeded') {
     *     echo "Payment confirmed successfully!\n";
     * }
     * ```
     *
     * @see https://studio.inttegro.com/accept-a-payment for complete payment flow
     */
    public function confirmPayment(array $payload): Order
    {
        return $this->http->postResource('/orders/confirm_payment', Order::class, 'order', $payload);
    }

    /**
     * Request a new confirmation token to be sent to the customer (e.g., resend OTP).
     *
     * Use this when the customer didn't receive the original OTP or the token expired. A fresh verification
     * token will be sent via SMS or email to the customer's registered contact information.
     *
     * @param string $orderId Unique identifier of the order requiring confirmation (required)
     * @param array $requestMeta Request controls such as idempotency_key (optional)
     *
     * @return Order The updated order
     *
     * @example Resend OTP to customer
     * ```php
     * $order = $client->orders->requestConfirmation(
     *     'GKj7A8lM5wEGRUvbqpI4bkDFsQvpqVyh5fqePNnb'
     * );
     *
     * echo "New OTP sent to customer\n";
     * ```
     *
     * @see https://studio.inttegro.com/accept-a-payment for payment confirmation flow
     */
    public function requestConfirmation(string $orderId, array $requestMeta = []): Order
    {
        return $this->http->postResource('/orders/request_confirmation', Order::class, 'order', [
            'order_id' => $orderId,
            'request_meta' => $requestMeta ?: $this->stableOrderRequestMeta('request_confirmation', $orderId),
        ]);
    }

    /**
     * Finalize an order to make it immutable and ready for payment or fulfillment.
     *
     * Finalizing (sealing) an order locks its line items and totals, making it ready for payment execution
     * or order completion. Most orders are finalized automatically, but you can explicitly finalize if needed.
     *
     * @param string $orderId Unique identifier of the order to finalize (required)
     * @param array $requestMeta Request controls such as idempotency_key (optional)
     *
     * @return Order The finalized order
     *
     * @example Finalize an order
     * ```php
     * $order = $client->orders->finalize(
     *     'GKj7A8lM5wEGRUvbqpI4bkDFsQvpqVyh5fqePNnb'
     * );
     *
     * echo "Order finalized at: {$order->sealedAt}\n";
     * ```
     *
     * @see https://studio.inttegro.com/order-lifecycle for order states
     */
    public function finalize(string $orderId, array $requestMeta = []): Order
    {
        return $this->http->postResource('/orders/finalize', Order::class, 'order', [
            'order_id' => $orderId,
            'request_meta' => $requestMeta ?: $this->stableOrderRequestMeta('finalize', $orderId),
        ]);
    }

    /**
     * Send the hosted invoice link for an existing order.
     *
     * @param array $payload Send invoice parameters
     *   - order_id: string - Unique identifier of the order whose invoice should be sent (required)
     *
     * @return OrderDocumentDeliveryResult Order and delivery details
     */
    public function sendInvoice(array $payload): OrderDocumentDeliveryResult
    {
        return $this->http->postValue('/orders/send_invoice', OrderDocumentDeliveryResult::class, $payload);
    }

    /**
     * Send the hosted receipt link for a paid order.
     *
     * @param array $payload Send receipt parameters
     *   - order_id: string - Unique identifier of the paid order whose receipt should be sent (required)
     *
     * @return OrderDocumentDeliveryResult Order and delivery details
     */
    public function sendReceipt(array $payload): OrderDocumentDeliveryResult
    {
        return $this->http->postValue('/orders/send_receipt', OrderDocumentDeliveryResult::class, $payload);
    }

    /**
     * Mark an order as completed, indicating fulfillment is done.
     *
     * Call this after you've shipped physical goods or delivered digital products to the customer.
     * Completing an order transitions it to its final state and can optionally mark payment as received
     * offline (out-of-band) if paid_out_of_band is set to true.
     *
     * @param array $payload Completion parameters
     *   - order_id: string - Unique identifier of the order to complete (required)
     *   - paid_out_of_band: bool - Set to true if payment received outside Inttegro (default: false)
     *
     * @return Order The completed order
     *
     * @example Complete order after fulfillment
     * ```php
     * $order = $client->orders->complete([
     *     'order_id' => 'GKj7A8lM5wEGRUvbqpI4bkDFsQvpqVyh5fqePNnb'
     * ]);
     *
     * echo "Order completed at: {$order->completedAt}\n";
     * ```
     *
     * @see https://studio.inttegro.com/order-lifecycle for order states
     */
    public function complete(array $payload): Order
    {
        return $this->http->postResource('/orders/complete', Order::class, 'order', $payload);
    }

    /**
     * Cancel an order, stopping payment execution and preventing further processing.
     *
     * Canceling an order is irreversible and should be done when the customer requests cancellation or
     * the order cannot be fulfilled. If payment was already captured, you'll need to refund it separately.
     *
     * @param string $orderId Unique identifier of the order to cancel (required)
     * @param array $requestMeta Request controls such as idempotency_key (optional)
     *
     * @return Order The cancelled order
     *
     * @example Cancel an order
     * ```php
     * $order = $client->orders->cancel(
     *     'GKj7A8lM5wEGRUvbqpI4bkDFsQvpqVyh5fqePNnb'
     * );
     *
     * echo "Order {$order->id} has been cancelled\n";
     * ```
     *
     * @see https://studio.inttegro.com/order-lifecycle for order states
     */
    public function cancel(string $orderId, array $requestMeta = []): Order
    {
        return $this->http->postResource('/orders/cancel', Order::class, 'order', [
            'order_id' => $orderId,
            'request_meta' => $requestMeta ?: $this->stableOrderRequestMeta('cancel', $orderId),
        ]);
    }

    /**
     * Create a refund through the `/orders/refund` compatibility alias.
     *
     * This accepts the same line-item payload as `$client->refunds->create()` and returns
     * the created Refund directly. New integrations should use the canonical method.
     *
     * @param array $payload Create-refund payload containing order_id, reason, and line_items
     * @param string|null $idempotencyKey Optional key for safely retrying the request
     *
     * @return Refund The created refund
     *
     * @example Refund an order
     * ```php
     * $refund = $client->orders->refund([
     *     'order_id' => 'or_0123456789abcdefghijklmnopqrstuvwxyzABCD',
     *     'reason' => 'requested_by_customer',
     *     'line_items' => [[
     *         'order_line_item_id' => 'oli_abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMN',
     *         'refund_amount' => ['currency' => 'ghs', 'value' => 2500],
     *     ]],
     * ]);
     *
     * echo "Refund created: {$refund->id}\n";
     * ```
     */
    public function refund(array $payload, ?string $idempotencyKey = null): Refund
    {
        return $this->http->postResource('/orders/refund', Refund::class, 'refund',
            $payload,
            $idempotencyKey ? ['Idempotency-Key' => $idempotencyKey] : []
        );
    }

    /**
     * Retrieve a paginated list of orders.
     *
     * Returns orders in reverse chronological order (most recent first).
     *
     * @param array $payload Pagination and filter parameters (optional)
     *   - page_number: int - Zero-based page index to retrieve (0-10)
     *   - page_size: int - Number of orders per page (1-256)
     *   - customer_id: string - Optional customer whose orders should be returned
     *
     * @return OrderPage Paginated orders and pagination details
     *
     * @example Get first page of orders
     * ```php
     * $page = $client->orders->page([
     *     'page_size' => 25,
     *     'page_number' => 0
     * ]);
     *
     * echo "Retrieved " . count($page->orders) . " orders\n";
     * echo "Page number: {$page->number}\n";
     * ```
     *
     * @see https://studio.inttegro.com/pagination for pagination guide
     * @see https://studio.inttegro.com/orders for API reference
     */
    public function page(array $payload = []): OrderPage
    {
        return $this->http->postResource('/orders/page', OrderPage::class, 'page', $payload);
    }

    private function stableOrderRequestMeta(string $action, string $orderId): array
    {
        return ['idempotency_key' => sprintf('orders_%s_%s', $action, $orderId)];
    }
}
