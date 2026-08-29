<?php

namespace Commerce\Resources;

use Commerce\HttpClient;

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
     * @return \Commerce\ResponseObject Created OTP session
     *
     * @example Initialize OTP session
     * ```php
     * $result = $client->otp->initiate([
     *     'recipient' => '+233541234567',
     *     'sender' => 'Acme',
     *     'service_name' => 'Acme Bank',
     *     'request_meta' => ['idempotency_key' => 'otp_login_1700000000'],
     *     'purpose' => 'payment_confirmation'
     * ]);
     *
     * $txn = $result->data['transaction'];
     * echo "OTP sent. Transaction ID: {$txn['id']}\n";
     * echo "Expires at: {$txn['expires_at']}\n";
     * ```
     *
     * @see https://studio.inttegro.com/otp for OTP implementation guide
     */
    public function initiate(array $payload): \Commerce\ResponseObject
    {
        return $this->http->post('/otp/initiate', $payload);
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
     * @return \Commerce\ResponseObject Verification result
     *
     * @example Verify OTP code
     * ```php
     * $result = $client->otp->verify([
     *     'transaction_id' => 'ot_abc123',
     *     'recipient' => '+233541234567',
     *     'token' => '123456'
     * ]);
     *
     * $txn = $result->data['transaction'];
     * if ($txn['status'] === 'verified') {
     *     echo "OTP verified successfully!\n";
     * } else {
     *     echo "Invalid code. Status: {$txn['status']}\n";
     * }
     * ```
     *
     * @see https://studio.inttegro.com/otp for verification flow
     */
    public function verify(array $payload): \Commerce\ResponseObject
    {
        return $this->http->post('/otp/verify', $payload);
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
     * @return \Commerce\ResponseObject OTP session details
     *
     * @example Lookup OTP session
     * ```php
     * $result = $client->otp->lookup([
     *     'transaction_id' => 'ot_abc123'
     * ]);
     *
     * $txn = $result->data['transaction'];
     * echo "Status: {$txn['status']}\n";
     * echo "Expires: {$txn['expires_at']}\n";
     * ```
     *
     * @see https://studio.inttegro.com/otp for OTP overview
     */
    public function lookup(array $payload): \Commerce\ResponseObject
    {
        return $this->http->post('/otp/lookup', $payload);
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
     * @return \Commerce\ResponseObject Cancelled session
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
    public function cancel(array $payload): \Commerce\ResponseObject
    {
        return $this->http->post('/otp/cancel', $payload);
    }
}
