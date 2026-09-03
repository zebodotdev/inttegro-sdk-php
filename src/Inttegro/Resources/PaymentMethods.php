<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;

/**
 * Payment methods resource for saving and verifying customer payment instruments.
 *
 * Payment methods store customer payment details for future use. Tokenize mobile money
 * wallets, verify ownership, and charge saved methods without re-collecting details.
 * Essential for subscription billing and returning customer checkout flows.
 *
 * @see https://studio.inttegro.com/payment-methods for detailed guides
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
     * @return \Inttegro\PaymentMethod Tokenized payment method
     *
     * @example Tokenize mobile money wallet
     * ```php
     * $result = $client->paymentMethods->tokenize([
     *     'customer_id' => 'cu_abc123',
     *     'payment_method_data' => [
     *         'type' => 'mobile_money',
     *         'mobile_money' => [
     *             'network' => 'mtn',
     *             'account_number' => '0541234567'
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
     * @see https://studio.inttegro.com/charge-repeat-customers for saved payment method guide
     */
    public function tokenize(array $payload): \Inttegro\PaymentMethod
    {
        return $this->http->postResource('/payment_methods/tokenize', \Inttegro\PaymentMethod::class, 'payment_method', $payload);
    }

    /**
     * Initiate verification of a saved payment method.
     *
     * Sends an OTP to the payment method (e.g., SMS to mobile money number) to verify customer
     * ownership. After verification, the payment method can be charged without requiring customer
     * confirmation on each transaction.
     *
     * @param string $paymentMethodId Unique identifier of the payment method to verify (required)
     * @param array $requestMeta Request controls such as idempotency_key (optional)
     *
     * @return \Inttegro\PaymentMethodVerificationSession Payment method with verification status
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
     * @see https://studio.inttegro.com/charge-repeat-customers for verification flow
     */
    public function verify(string $paymentMethodId, array $requestMeta = []): \Inttegro\PaymentMethodVerificationSession
    {
        return $this->http->postResource('/payment_methods/verify', \Inttegro\PaymentMethodVerificationSession::class, 'verification', [
            'payment_method_id' => $paymentMethodId,
            'request_meta' => $requestMeta ?: $this->stablePaymentMethodRequestMeta('verify', $paymentMethodId),
        ]);
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
     * @return \Inttegro\PaymentMethod Verified payment method
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
     * @see https://studio.inttegro.com/charge-repeat-customers for verification guide
     */
    public function confirmVerification(array $payload): \Inttegro\PaymentMethod
    {
        return $this->http->postResource('/payment_methods/confirm_verification', \Inttegro\PaymentMethod::class, 'payment_method', $payload);
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
     * @return \Inttegro\PaymentMethod Complete payment method object
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
     * @see https://studio.inttegro.com/payment-methods for payment method overview
     */
    public function lookup(string $paymentMethodId): \Inttegro\PaymentMethod
    {
        return $this->http->postResource('/payment_methods/lookup', \Inttegro\PaymentMethod::class, 'payment_method', ['payment_method_id' => $paymentMethodId]);
    }

    /** Retrieve a paginated list of payment methods. */
    public function page(array $payload = []): \Inttegro\PaymentMethodPage
    {
        return $this->http->postResource('/payment_methods/page', \Inttegro\PaymentMethodPage::class, 'page', $payload);
    }

    /** Update mutable payment method metadata and state. */
    public function update(array $payload): \Inttegro\PaymentMethod
    {
        return $this->http->postResource('/payment_methods/update', \Inttegro\PaymentMethod::class, 'payment_method', $payload);
    }

    public function activate(string $paymentMethodId): \Inttegro\PaymentMethod
    {
        return $this->http->postResource('/payment_methods/activate', \Inttegro\PaymentMethod::class, 'payment_method', ['payment_method_id' => $paymentMethodId]);
    }

    public function disactivate(string $paymentMethodId): \Inttegro\PaymentMethod
    {
        return $this->http->postResource('/payment_methods/disactivate', \Inttegro\PaymentMethod::class, 'payment_method', ['payment_method_id' => $paymentMethodId]);
    }

    public function deactivate(string $paymentMethodId): \Inttegro\PaymentMethod
    {
        return $this->disactivate($paymentMethodId);
    }

    public function archive(string $paymentMethodId): \Inttegro\PaymentMethod
    {
        return $this->http->postResource('/payment_methods/archive', \Inttegro\PaymentMethod::class, 'payment_method', ['payment_method_id' => $paymentMethodId]);
    }

    public function unarchive(string $paymentMethodId): \Inttegro\PaymentMethod
    {
        return $this->http->postResource('/payment_methods/unarchive', \Inttegro\PaymentMethod::class, 'payment_method', ['payment_method_id' => $paymentMethodId]);
    }

    /**
     * Remove a saved payment method, preventing future charges.
     *
     * Deletes the payment method from customer's saved instruments. Use this when customers
     * remove payment methods from their account or when payment details become invalid.
     * Deletion is permanent and cannot be undone.
     *
     * @param string $paymentMethodId Unique identifier of the payment method to delete (required)
     * @param array $requestMeta Request controls such as idempotency_key (optional)
     *
     * @return \Inttegro\PaymentMethodDeletion Confirmation of deletion
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
     * @see https://studio.inttegro.com/payment-methods for payment method management
     */
    public function delete(string $paymentMethodId, array $requestMeta = []): \Inttegro\PaymentMethodDeletion
    {
        return $this->http->postValue('/payment_methods/delete', \Inttegro\PaymentMethodDeletion::class, [
            'payment_method_id' => $paymentMethodId,
            'request_meta' => $requestMeta ?: $this->stablePaymentMethodRequestMeta('delete', $paymentMethodId),
        ]);
    }

    /**
     * Retrieve payment method configuration and capabilities.
     *
     * Returns the current payment method settings for your application, including supported
     * payment types, verification requirements, and other configuration details.
     *
     * @return \Inttegro\PaymentMethodSettings Payment method settings
     *
     * @example Get payment method settings
     * ```php
     * $result = $client->paymentMethods->settings();
     *
     * $settings = $result->data['settings'];
     * // View supported payment types and configuration
     * ```
     *
     * @see https://studio.inttegro.com/payment-methods for payment method overview
     */
    public function settings(): \Inttegro\PaymentMethodSettings
    {
        return $this->http->postResource('/payment_methods/settings', \Inttegro\PaymentMethodSettings::class, 'settings', []);
    }

    private function stablePaymentMethodRequestMeta(string $action, string $paymentMethodId): array
    {
        return ['idempotency_key' => sprintf('payment_methods_%s_%s', $action, $paymentMethodId)];
    }
}
