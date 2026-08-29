<?php

namespace Commerce\Resources;

use Commerce\HttpClient;

/**
 * Orders resource for creating orders, processing payments, and managing order lifecycle.
 *
 * Orders are the central transaction object in Commerce. They represent a purchase with
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
     * @return \Commerce\ResponseObject Response containing the created order
     *
     * @example Create order with new customer and execute payment
     * ```php
     * $result = $client->orders->create([
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
     * $order = $result->data['order'];
     * echo "Created order: {$order['id']}\n";
     * ```
     *
     * @see https://studio.inttegro.com/accept-a-payment for payment flow guide
     * @see https://studio.inttegro.com/order-lifecycle for order states
     */
    public function create(array $payload): \Commerce\ResponseObject
    {
        return $this->http->post('/orders/new', $payload);
    }

    /**
     * Alias for create(). Create a new order with line items, customer, and payment details.
     *
     * @param array $payload Order creation parameters (see create() for details)
     * @return \Commerce\ResponseObject Response containing the created order
     *
     * @see create()
     */
    public function new(array $payload): \Commerce\ResponseObject
    {
        return $this->create($payload);
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
     * @return \Commerce\ResponseObject Response containing the complete order object
     *
     * @example Lookup an order
     * ```php
     * $result = $client->orders->lookup(
     *     'GKj7A8lM5wEGRUvbqpI4bkDFsQvpqVyh5fqePNnb'
     * );
     *
     * $order = $result->data['order'];
     * echo "Order status: {$order['status']}\n";
     * if (isset($order['payment'])) {
     *     echo "Payment status: {$order['payment']['status']}\n";
     * }
     * ```
     *
     * @see https://studio.inttegro.com/orders for API reference
     */
    public function lookup(string $orderId, array $options = []): \Commerce\ResponseObject
    {
        return $this->http->post('/orders/lookup', array_merge(['order_id' => $orderId], $options));
    }

    /**
     * Initiate payment for an existing order.
     *
     * Supports three payment flows:
     * 1. Saved payment method: Provide only order_id to charge a previously saved payment method
     * 2. New payment method: Include payment_method_data with inline payment details
     * 3. Offline payment: Set paid_out_of_band to true for cash, bank transfer, or check payments
     *
     * When payment requires customer confirmation (e.g., OTP), the response includes a next_action field.
     *
     * @param array $payload Payment parameters
     *   - order_id: string - Unique identifier of the order to pay (required)
     *   - payment_method_data: array - Inline payment method details (mobile money, card, etc.)
     *   - payment_method_id: string - ID of a saved payment method to use
     *   - paid_out_of_band: bool - Set to true if payment received outside Commerce (default: false)
     *
     * @return \Commerce\ResponseObject Payment response with order and payment state
     *
     * @example Pay with inline mobile money
     * ```php
     * $result = $client->orders->pay([
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
     * $order = $result->data['order'];
     * if (isset($order['payment']['next_action']) && 
     *     $order['payment']['next_action']['type'] === 'confirm_payment') {
     *     echo "Customer needs to provide OTP sent to their phone\n";
     * }
     * ```
     *
     * @example Pay with saved payment method
     * ```php
     * $result = $client->orders->pay([
     *     'order_id' => 'GKj7A8lM5wEGRUvbqpI4bkDFsQvpqVyh5fqePNnb',
     *     'payment_method_id' => 'pm_xyz123abc456'
     * ]);
     * ```
     *
     * @see https://studio.inttegro.com/accept-a-payment for payment flow guide
     * @see https://studio.inttegro.com/charge-repeat-customers for saved payment methods
     */
    public function pay(array $payload): \Commerce\ResponseObject
    {
        return $this->http->post('/orders/pay', $payload);
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
     * @return \Commerce\ResponseObject Updated order with payment status
     *
     * @example Confirm payment with OTP
     * ```php
     * $result = $client->orders->confirmPayment([
     *     'order_id' => 'GKj7A8lM5wEGRUvbqpI4bkDFsQvpqVyh5fqePNnb',
     *     'token' => '123456'
     * ]);
     *
     * $order = $result->data['order'];
     * if ($order['payment']['status'] === 'succeeded') {
     *     echo "Payment confirmed successfully!\n";
     * }
     * ```
     *
     * @see https://studio.inttegro.com/accept-a-payment for complete payment flow
     */
    public function confirmPayment(array $payload): \Commerce\ResponseObject
    {
        return $this->http->post('/orders/confirm_payment', $payload);
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
     * @return \Commerce\ResponseObject Response indicating token was resent
     *
     * @example Resend OTP to customer
     * ```php
     * $result = $client->orders->requestConfirmation(
     *     'GKj7A8lM5wEGRUvbqpI4bkDFsQvpqVyh5fqePNnb'
     * );
     *
     * echo "New OTP sent to customer\n";
     * ```
     *
     * @see https://studio.inttegro.com/accept-a-payment for payment confirmation flow
     */
    public function requestConfirmation(string $orderId, array $requestMeta = []): \Commerce\ResponseObject
    {
        return $this->http->post('/orders/request_confirmation', [
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
     * @return \Commerce\ResponseObject Finalized order object
     *
     * @example Finalize an order
     * ```php
     * $result = $client->orders->finalize(
     *     'GKj7A8lM5wEGRUvbqpI4bkDFsQvpqVyh5fqePNnb'
     * );
     *
     * $order = $result->data['order'];
     * echo "Order finalized at: {$order['sealed_at']}\n";
     * ```
     *
     * @see https://studio.inttegro.com/order-lifecycle for order states
     */
    public function finalize(string $orderId, array $requestMeta = []): \Commerce\ResponseObject
    {
        return $this->http->post('/orders/finalize', [
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
     * @return \Commerce\ResponseObject Order and delivery details
     */
    public function sendInvoice(array $payload): \Commerce\ResponseObject
    {
        return $this->http->post('/orders/send_invoice', $payload);
    }

    /**
     * Send the hosted receipt link for a paid order.
     *
     * @param array $payload Send receipt parameters
     *   - order_id: string - Unique identifier of the paid order whose receipt should be sent (required)
     *
     * @return \Commerce\ResponseObject Order and delivery details
     */
    public function sendReceipt(array $payload): \Commerce\ResponseObject
    {
        return $this->http->post('/orders/send_receipt', $payload);
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
     *   - paid_out_of_band: bool - Set to true if payment received outside Commerce (default: false)
     *
     * @return \Commerce\ResponseObject Completed order object
     *
     * @example Complete order after fulfillment
     * ```php
     * $result = $client->orders->complete([
     *     'order_id' => 'GKj7A8lM5wEGRUvbqpI4bkDFsQvpqVyh5fqePNnb'
     * ]);
     *
     * $order = $result->data['order'];
     * echo "Order completed at: {$order['completed_at']}\n";
     * ```
     *
     * @see https://studio.inttegro.com/order-lifecycle for order states
     */
    public function complete(array $payload): \Commerce\ResponseObject
    {
        return $this->http->post('/orders/complete', $payload);
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
     * @return \Commerce\ResponseObject Cancelled order object
     *
     * @example Cancel an order
     * ```php
     * $result = $client->orders->cancel(
     *     'GKj7A8lM5wEGRUvbqpI4bkDFsQvpqVyh5fqePNnb'
     * );
     *
     * $order = $result->data['order'];
     * echo "Order {$order['id']} has been cancelled\n";
     * ```
     *
     * @see https://studio.inttegro.com/order-lifecycle for order states
     */
    public function cancel(string $orderId, array $requestMeta = []): \Commerce\ResponseObject
    {
        return $this->http->post('/orders/cancel', [
            'order_id' => $orderId,
            'request_meta' => $requestMeta ?: $this->stableOrderRequestMeta('cancel', $orderId),
        ]);
    }

    /**
     * Refund a paid order, returning funds to the customer.
     *
     * Refunds the payment associated with an order, sending funds back to the customer's original payment
     * method. The order must have been successfully paid before it can be refunded.
     *
     * @param string $orderId Unique identifier of the order to refund (required)
     *
     * @return \Commerce\ResponseObject Refunded order object with updated payment status
     *
     * @example Refund an order
     * ```php
     * $result = $client->orders->refund(
     *     'GKj7A8lM5wEGRUvbqpI4bkDFsQvpqVyh5fqePNnb'
     * );
     *
     * $order = $result->data['order'];
     * echo "Order refunded. Refund ID: {$order['payment']['refund']['id']}\n";
     * ```
     *
     * @see https://studio.inttegro.com/retry-a-payment for payment retry guide
     */
    public function refund(string $orderId): \Commerce\ResponseObject
    {
        return $this->http->post('/orders/refund', ['order_id' => $orderId]);
    }

    /**
     * Retrieve a paginated list of orders.
     *
     * Returns orders in reverse chronological order (most recent first). Use the has_more field
     * and page parameter to navigate through results. Supports filtering by status and time range.
     *
     * @param array $payload Pagination and filter parameters (optional)
     *   - page: int - Page number to retrieve (minimum 1, default: 1)
     *   - per_page: int - Number of results per page (minimum 1, maximum 100, default: 10)
     *   - status: string - Filter by order status (e.g., 'paid', 'requires_payment', 'completed')
     *   - created_after: string - Filter orders created after this timestamp (ISO 8601)
     *   - created_before: string - Filter orders created before this timestamp (ISO 8601)
     *
     * @return \Commerce\ResponseObject Paginated list of orders with pagination details
     *
     * @example Get first page of orders
     * ```php
     * $result = $client->orders->page([
     *     'per_page' => 25,
     *     'page' => 1
     * ]);
     *
     * echo "Retrieved " . count($result->data['orders']) . " orders\n";
     * echo "Has more: " . ($result->data['has_more'] ? 'yes' : 'no') . "\n";
     *
     * // Get next page if available
     * if ($result->data['has_more']) {
     *     $nextPage = $client->orders->page(['per_page' => 25, 'page' => 2]);
     * }
     * ```
     *
     * @see https://studio.inttegro.com/pagination for pagination guide
     * @see https://studio.inttegro.com/orders for API reference
     */
    public function page(array $payload = []): \Commerce\ResponseObject
    {
        return $this->http->post('/orders/page', $payload);
    }

    private function stableOrderRequestMeta(string $action, string $orderId): array
    {
        return ['idempotency_key' => sprintf('orders_%s_%s', $action, $orderId)];
    }
}
