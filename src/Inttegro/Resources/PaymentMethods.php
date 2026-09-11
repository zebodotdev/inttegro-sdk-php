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

    /**
     * Creates the payment methods resource client.
     *
     * @param HttpClient $http Shared authenticated HTTP transport used by this resource client.
     */
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
     * @param array<string, mixed> $payload Tokenization parameters
     *   - customer_id: string - Customer who will own this payment method (required)
     *   - payment_method_data: array - Payment details to tokenize (required)
     *   - verify_immediately: bool - Send verification OTP right after tokenization (default: false)
     *
     * @return \Inttegro\PaymentMethod\PaymentMethod Tokenized payment method
     *
     * @example Tokenize mobile money wallet
     * ```php
     * $paymentMethod = $client->paymentMethods->tokenize([
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
     * echo "Payment method saved: {$paymentMethod->id}\n";
     * echo "Verification status: {$paymentMethod->verification?->status}\n";
     * ```
     *
     * @see https://studio.inttegro.com/charge-repeat-customers for saved payment method guide
     */
    public function tokenize(array $payload): \Inttegro\PaymentMethod\PaymentMethod
    {
        return $this->http->postResource('/payment_methods/tokenize', \Inttegro\PaymentMethod\PaymentMethod::class, 'payment_method', $payload);
    }

    /**
     * Initiate verification of a saved payment method.
     *
     * Sends an OTP to the payment method (e.g., SMS to mobile money number) to verify customer
     * ownership. After verification, the payment method can be charged without requiring customer
     * confirmation on each transaction.
     *
     * @param string $paymentMethodId Unique identifier of the payment method to verify (required)
     * @param array<string, mixed> $requestMeta Request controls such as idempotency_key (optional)
     *
     * @return \Inttegro\PaymentMethod\VerificationSession Payment method with verification status
     *
     * @example Start payment method verification
     * ```php
     * $verification = $client->paymentMethods->verify(
     *     'pm_xyz789abc'
     * );
     *
     * if ($verification->status === 'pending') {
     *     echo "OTP sent. Collect code from customer.\n";
     * }
     * ```
     *
     * @see https://studio.inttegro.com/charge-repeat-customers for verification flow
     */
    public function verify(string $paymentMethodId, array $requestMeta = []): \Inttegro\PaymentMethod\VerificationSession
    {
        return $this->http->postResource('/payment_methods/verify', \Inttegro\PaymentMethod\VerificationSession::class, 'verification', [
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
     * @param array<string, mixed> $payload Verification parameters
     *   - payment_method_id: string - Payment method being verified (required)
     *   - token: string - OTP code provided by customer (required, typically 6 digits)
     *
     * @return \Inttegro\PaymentMethod\PaymentMethod Verified payment method
     *
     * @example Confirm verification with OTP
     * ```php
     * $paymentMethod = $client->paymentMethods->confirmVerification([
     *     'payment_method_id' => 'pm_xyz789abc',
     *     'token' => '123456'
     * ]);
     *
     * if ($paymentMethod->verification?->status === 'verified') {
     *     echo "Payment method verified! Can now charge without OTP.\n";
     * }
     * ```
     *
     * @see https://studio.inttegro.com/charge-repeat-customers for verification guide
     */
    public function confirmVerification(array $payload): \Inttegro\PaymentMethod\PaymentMethod
    {
        return $this->http->postResource('/payment_methods/confirm_verification', \Inttegro\PaymentMethod\PaymentMethod::class, 'payment_method', $payload);
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
     * @return \Inttegro\PaymentMethod\PaymentMethod Complete payment method object
     *
     * @example Lookup a payment method
     * ```php
     * $paymentMethod = $client->paymentMethods->lookup(
     *     'pm_xyz789abc'
     * );
     *
     * echo "Type: {$paymentMethod->type}\n";
     * echo "Customer: {$paymentMethod->customerId}\n";
     * echo "Verified: " . ($paymentMethod->verification?->status === 'verified' ? 'yes' : 'no') . "\n";
     * ```
     *
     * @see https://studio.inttegro.com/payment-methods for payment method overview
     */
    public function lookup(string $paymentMethodId): \Inttegro\PaymentMethod\PaymentMethod
    {
        return $this->http->postResource('/payment_methods/lookup', \Inttegro\PaymentMethod\PaymentMethod::class, 'payment_method', ['payment_method_id' => $paymentMethodId]);
    }

    /**
     * Retrieve a paginated list of payment methods.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @return \Inttegro\PaymentMethod\Page A typed page of matching payment methods.
     */
    public function page(array $payload = []): \Inttegro\PaymentMethod\Page
    {
        return $this->http->postResource('/payment_methods/page', \Inttegro\PaymentMethod\Page::class, 'page', $payload);
    }

    /**
     * Update mutable payment method metadata and state.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @return \Inttegro\PaymentMethod\PaymentMethod The updated payment method.
     */
    public function update(array $payload): \Inttegro\PaymentMethod\PaymentMethod
    {
        return $this->http->postResource('/payment_methods/update', \Inttegro\PaymentMethod\PaymentMethod::class, 'payment_method', $payload);
    }

    /**
     * Activates the payment method.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param string $paymentMethodId Unique identifier of the payment method.
     * @return \Inttegro\PaymentMethod\PaymentMethod The activated payment method.
     */
    public function activate(string $paymentMethodId): \Inttegro\PaymentMethod\PaymentMethod
    {
        return $this->http->postResource('/payment_methods/activate', \Inttegro\PaymentMethod\PaymentMethod::class, 'payment_method', ['payment_method_id' => $paymentMethodId]);
    }

    /**
     * Deactivates the payment method.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param string $paymentMethodId Unique identifier of the payment method.
     * @return \Inttegro\PaymentMethod\PaymentMethod The resulting payment method.
     */
    public function disactivate(string $paymentMethodId): \Inttegro\PaymentMethod\PaymentMethod
    {
        return $this->http->postResource('/payment_methods/disactivate', \Inttegro\PaymentMethod\PaymentMethod::class, 'payment_method', ['payment_method_id' => $paymentMethodId]);
    }

    /**
     * Deactivates the payment method.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param string $paymentMethodId Unique identifier of the payment method.
     * @return \Inttegro\PaymentMethod\PaymentMethod The deactivated payment method.
     */
    public function deactivate(string $paymentMethodId): \Inttegro\PaymentMethod\PaymentMethod
    {
        return $this->disactivate($paymentMethodId);
    }

    /**
     * Archives the payment method.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param string $paymentMethodId Unique identifier of the payment method.
     * @return \Inttegro\PaymentMethod\PaymentMethod The archived payment method.
     */
    public function archive(string $paymentMethodId): \Inttegro\PaymentMethod\PaymentMethod
    {
        return $this->http->postResource('/payment_methods/archive', \Inttegro\PaymentMethod\PaymentMethod::class, 'payment_method', ['payment_method_id' => $paymentMethodId]);
    }

    /**
     * Restores the archived payment method.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param string $paymentMethodId Unique identifier of the payment method.
     * @return \Inttegro\PaymentMethod\PaymentMethod The resulting payment method.
     */
    public function unarchive(string $paymentMethodId): \Inttegro\PaymentMethod\PaymentMethod
    {
        return $this->http->postResource('/payment_methods/unarchive', \Inttegro\PaymentMethod\PaymentMethod::class, 'payment_method', ['payment_method_id' => $paymentMethodId]);
    }

    /**
     * Remove a saved payment method, preventing future charges.
     *
     * Deletes the payment method from customer's saved instruments. Use this when customers
     * remove payment methods from their account or when payment details become invalid.
     * Deletion is permanent and cannot be undone.
     *
     * @param string $paymentMethodId Unique identifier of the payment method to delete (required)
     * @param array<string, mixed> $requestMeta Request controls such as idempotency_key (optional)
     *
     * @return \Inttegro\PaymentMethod\Deletion Confirmation of deletion
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
    public function delete(string $paymentMethodId, array $requestMeta = []): \Inttegro\PaymentMethod\Deletion
    {
        return $this->http->postValue('/payment_methods/delete', \Inttegro\PaymentMethod\Deletion::class, [
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
     * @return \Inttegro\PaymentMethod\Settings Payment method settings
     *
     * @example Get payment method settings
     * ```php
     * $settings = $client->paymentMethods->settings();
     * // View supported payment types and configuration
     * ```
     *
     * @see https://studio.inttegro.com/payment-methods for payment method overview
     */
    public function settings(): \Inttegro\PaymentMethod\Settings
    {
        return $this->http->postResource('/payment_methods/settings', \Inttegro\PaymentMethod\Settings::class, 'settings', []);
    }

    private function stablePaymentMethodRequestMeta(string $action, string $paymentMethodId): array
    {
        return ['idempotency_key' => sprintf('payment_methods_%s_%s', $action, $paymentMethodId)];
    }
}
