<?php

namespace Commerce\Resources;

use Commerce\HttpClient;

/**
 * Payment methods resource for saving and verifying customer payment instruments.
 *
 * Payment methods store customer payment details for future use. Tokenize mobile money
 * wallets, verify ownership, and charge saved methods without re-collecting details.
 * Essential for subscription billing and returning customer checkout flows.
 *
 * @see https://commerce.zebo.dev/payment-methods for detailed guides
 */
class PaymentMethods
{
    private HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Save a payment method for future use without charging it.
     *
     * Tokenizes payment details and associates them with a customer. The payment method can be
     * charged later without re-collecting details. Currently supports mobile money wallets.
     * Optionally trigger verification immediately after tokenization.
     *
     * @param array $payload Tokenization parameters
     *   - customer_id: string - Customer who will own this payment method (required)
     *   - payment_method_data: array - Payment details to tokenize (required)
     *   - verify_immediately: bool - Send verification OTP right after tokenization (default: false)
     *
     * @return \Commerce\ResponseObject Tokenized payment method
     *
     * @example Tokenize mobile money wallet
     * ```php
     * $result = $client->paymentMethods->tokenize([
     *     'customer_id' => 'cu_abc123',
     *     'payment_method_data' => [
     *         'type' => 'mobile_money',
     *         'mobile_money' => [
     *             'issuer' => 'mtn',
     *             'number' => '0541234567'
     *         ]
     *     ],
     *     'verify_immediately' => true
     * ]);
     *
     * $pm = $result->data['payment_method'];
     * echo "Payment method saved: {$pm['id']}\n";
     * echo "Verification status: {$pm['verification']['status']}\n";
     * ```
     *
     * @see https://commerce.zebo.dev/charge-repeat-customers for saved payment method guide
     */
    public function tokenize(array $payload): \Commerce\ResponseObject
    {
        return $this->http->post('/payment_methods/tokenize', $payload);
    }

    /**
     * Initiate verification of a saved payment method.
     *
     * Sends an OTP to the payment method (e.g., SMS to mobile money number) to verify customer
     * ownership. After verification, the payment method can be charged without requiring customer
     * confirmation on each transaction.
     *
     * @param string $paymentMethodId Unique identifier of the payment method to verify (required)
     *
     * @return \Commerce\ResponseObject Payment method with verification status
     *
     * @example Start payment method verification
     * ```php
     * $result = $client->paymentMethods->verify(
     *     'pm_xyz789abc'
     * );
     *
     * $pm = $result->data['payment_method'];
     * if ($pm['verification']['status'] === 'pending') {
     *     echo "OTP sent. Collect code from customer.\n";
     * }
     * ```
     *
     * @see https://commerce.zebo.dev/charge-repeat-customers for verification flow
     */
    public function verify(string $paymentMethodId): \Commerce\ResponseObject
    {
        return $this->http->post('/payment_methods/verify', ['payment_method_id' => $paymentMethodId]);
    }

    /**
     * Complete payment method verification using customer-provided OTP.
     *
     * Submits the verification code to confirm payment method ownership. Once verified,
     * the payment method can be charged without customer confirmation (frictionless charging).
     *
     * @param array $payload Verification parameters
     *   - payment_method_id: string - Payment method being verified (required)
     *   - token: string - OTP code provided by customer (required, typically 6 digits)
     *
     * @return \Commerce\ResponseObject Verified payment method
     *
     * @example Confirm verification with OTP
     * ```php
     * $result = $client->paymentMethods->confirmVerification([
     *     'payment_method_id' => 'pm_xyz789abc',
     *     'token' => '123456'
     * ]);
     *
     * $pm = $result->data['payment_method'];
     * if ($pm['verification']['status'] === 'verified') {
     *     echo "Payment method verified! Can now charge without OTP.\n";
     * }
     * ```
     *
     * @see https://commerce.zebo.dev/charge-repeat-customers for verification guide
     */
    public function confirmVerification(array $payload): \Commerce\ResponseObject
    {
        return $this->http->post('/payment_methods/confirm_verification', $payload);
    }

    /**
     * Retrieve details of a saved payment method.
     *
     * Returns full payment method information including type, masked details (e.g., last 4 digits),
     * verification status, and associated customer. Use this to display saved payment methods to
     * customers or check verification state before charging.
     *
     * @param string $paymentMethodId Unique identifier of the payment method to retrieve (required)
     *
     * @return \Commerce\ResponseObject Complete payment method object
     *
     * @example Lookup a payment method
     * ```php
     * $result = $client->paymentMethods->lookup(
     *     'pm_xyz789abc'
     * );
     *
     * $pm = $result->data['payment_method'];
     * echo "Type: {$pm['type']}\n";
     * echo "Customer: {$pm['customer_id']}\n";
     * echo "Verified: " . ($pm['verification']['status'] === 'verified' ? 'yes' : 'no') . "\n";
     * ```
     *
     * @see https://commerce.zebo.dev/payment-methods for payment method overview
     */
    public function lookup(string $paymentMethodId): \Commerce\ResponseObject
    {
        return $this->http->post('/payment_methods/lookup', ['payment_method_id' => $paymentMethodId]);
    }

    /**
     * Remove a saved payment method, preventing future charges.
     *
     * Deletes the payment method from customer's saved instruments. Use this when customers
     * remove payment methods from their account or when payment details become invalid.
     * Deletion is permanent and cannot be undone.
     *
     * @param string $paymentMethodId Unique identifier of the payment method to delete (required)
     *
     * @return \Commerce\ResponseObject Confirmation of deletion
     *
     * @example Delete a payment method
     * ```php
     * $result = $client->paymentMethods->delete(
     *     'pm_xyz789abc'
     * );
     *
     * echo "Payment method removed\n";
     * ```
     *
     * @see https://commerce.zebo.dev/payment-methods for payment method management
     */
    public function delete(string $paymentMethodId): \Commerce\ResponseObject
    {
        return $this->http->post('/payment_methods/delete', ['payment_method_id' => $paymentMethodId]);
    }

    /**
     * Retrieve payment method configuration and capabilities.
     *
     * Returns the current payment method settings for your application, including supported
     * payment types, verification requirements, and other configuration details.
     *
     * @return \Commerce\ResponseObject Payment method settings
     *
     * @example Get payment method settings
     * ```php
     * $result = $client->paymentMethods->settings();
     *
     * $settings = $result->data['settings'];
     * // View supported payment types and configuration
     * ```
     *
     * @see https://commerce.zebo.dev/payment-methods for payment method overview
     */
    public function settings(): \Commerce\ResponseObject
    {
        return $this->http->post('/payment_methods/settings', []);
    }
}
