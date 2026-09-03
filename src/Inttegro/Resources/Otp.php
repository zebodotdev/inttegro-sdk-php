<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;

/**
 * OTP resource for managing one-time password sessions.
 *
 * OTPs provide secure verification for sensitive operations. Initialize sessions, send
 * codes via SMS or email, verify customer-provided codes, and manage OTP lifecycle.
 * Used for payment confirmations, account verification, and authentication flows.
 *
 * @see https://studio.inttegro.com/otp for OTP integration guide
 */
class Otp
{
    private HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Create a new OTP session and deliver the code to the recipient.
     *
     * Initializes an OTP session and sends a verification code via SMS or email. The code
     * is typically 6 digits and expires after a configured time period. Use OTPs for
     * payment confirmations, sensitive account changes, or multi-factor authentication.
     *
     * @param array $payload OTP initiation parameters
     *   - recipient: string - Phone number in international format (required)
     *   - sender: string - Sender identifier (required)
     *   - service_name: string - Service name in message (required)
     *   - request_meta: array - Request controls such as idempotency_key (optional)
     *   - purpose: string - Description of why OTP is needed (optional)
     *   - Additional transaction configuration parameters
     *
     * @return \Inttegro\OTPTransaction Created OTP session
     *
     * @example Initialize OTP session
     * ```php
     * $transaction = $client->otp->initiate([
     *     'recipient' => '+233541234567',
     *     'sender' => 'Acme',
     *     'service_name' => 'Acme Bank',
     *     'request_meta' => ['idempotency_key' => 'otp_login_1700000000'],
     *     'purpose' => 'payment_confirmation'
     * ]);
     *
     * echo "OTP sent. Transaction ID: {$transaction->id}\n";
     * echo "Expires at: {$transaction->expiresAt}\n";
     * ```
     *
     * @see https://studio.inttegro.com/otp for OTP implementation guide
     */
    public function initiate(array $payload): \Inttegro\OTPTransaction
    {
        return $this->http->postResource('/otp/initiate', \Inttegro\OTPTransaction::class, 'transaction', $payload);
    }

    /**
     * Verify a customer-provided OTP code against an active session.
     *
     * Validates the OTP code entered by the customer. If the code matches and hasn't expired,
     * verification succeeds and the session is marked complete. Failed verification attempts
     * are tracked, and excessive failures may lock the session.
     *
     * @param array $payload Verification parameters
     *   - transaction_id: string - OTP transaction identifier (required)
     *   - recipient: string - Recipient phone number (required)
     *   - token: string - Customer-provided OTP code (required, typically 6 digits)
     *
     * @return \Inttegro\OTPVerification Verification result
     *
     * @example Verify OTP code
     * ```php
     * $verification = $client->otp->verify([
     *     'transaction_id' => 'ot_abc123',
     *     'recipient' => '+233541234567',
     *     'token' => '123456'
     * ]);
     *
     * if ($verification->transaction->status === 'verified') {
     *     echo "OTP verified successfully!\n";
     * } else {
     *     echo "Invalid code. Status: {$verification->transaction->status}\n";
     * }
     * ```
     *
     * @see https://studio.inttegro.com/otp for verification flow
     */
    public function verify(array $payload): \Inttegro\OTPVerification
    {
        return $this->http->postValue('/otp/verify', \Inttegro\OTPVerification::class, $payload);
    }

    /**
     * Retrieve details of an OTP session.
     *
     * Returns session information including status, expiration time, verification attempts,
     * and recipient details. Use this to check session state or display remaining attempts
     * to customers.
     *
     * @param array $payload Lookup parameters
     *   - transaction_id: string - OTP transaction identifier to retrieve (required)
     *
     * @return \Inttegro\OTPTransaction OTP session details
     *
     * @example Lookup OTP session
     * ```php
     * $transaction = $client->otp->lookup([
     *     'transaction_id' => 'ot_abc123'
     * ]);
     *
     * echo "Status: {$transaction->status}\n";
     * echo "Expires: {$transaction->expiresAt}\n";
     * ```
     *
     * @see https://studio.inttegro.com/otp for OTP overview
     */
    public function lookup(array $payload): \Inttegro\OTPTransaction
    {
        return $this->http->postResource('/otp/lookup', \Inttegro\OTPTransaction::class, 'transaction', $payload);
    }

    /**
     * Cancel an active OTP session, preventing further verification attempts.
     *
     * Invalidates an OTP session immediately. Use this when the customer abandons the
     * verification flow or when the operation requiring OTP is cancelled. Cancelled
     * sessions cannot be resumed or verified.
     *
     * @param array $payload Cancellation parameters
     *   - transaction_id: string - OTP transaction to cancel (required)
     *   - reason: string - Reason for cancellation (required)
     *
     * @return \Inttegro\OTPTransaction Cancelled session
     *
     * @example Cancel OTP session
     * ```php
     * $result = $client->otp->cancel([
     *     'transaction_id' => 'ot_abc123',
     *     'reason' => 'user_requested_new_code'
     * ]);
     *
     * echo "OTP session cancelled\n";
     * ```
     *
     * @see https://studio.inttegro.com/otp for session management
     */
    public function cancel(array $payload): \Inttegro\OTPTransaction
    {
        return $this->http->postResource('/otp/cancel', \Inttegro\OTPTransaction::class, 'transaction', $payload);
    }
}
