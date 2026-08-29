<?php

namespace Commerce\Resources;

use Commerce\HttpClient;

/**
 * Chimes resource for sending notifications via SMS and email.
 *
 * Chimes deliver transactional messages to customers instantly. Use chimes for order
 * confirmations, payment receipts, shipping updates, or custom notifications triggered
 * by your application logic.
 *
 * @see https://studio.inttegro.com/chimes for detailed guides
 */
class Chimes
{
    private HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Send an immediate notification to a recipient via SMS or email.
     *
     * Delivers a message using the specified transport method (sms or email). Messages are
     * sent synchronously, and delivery status is returned in the response. Use chimes for
     * time-sensitive notifications like OTPs, order confirmations, or payment receipts.
     *
     * @param array $payload Chime parameters
     *   - recipient: string - Phone number (E.164 format) or email address (required)
     *   - message: string - Message content to send (required)
     *   - transport: string - Delivery method: 'sms' or 'email' (optional, auto-detected from recipient)
     *   - sender: string - Sender name/number for SMS or from-address for email (optional)
     *
     * @return \Commerce\ResponseObject Sent chime with delivery status
     *
     * @example Send SMS notification
     * ```php
     * $result = $client->chimes->send([
     *     'recipient' => '+233541234567',
     *     'message' => 'Your order #12345 has shipped!',
     *     'transport' => 'sms'
     * ]);
     *
     * $chime = $result->data['chime'];
     * echo "Chime sent: {$chime['id']}\n";
     * echo "Status: {$chime['status']}\n";
     * ```
     *
     * @example Send email notification
     * ```php
     * $result = $client->chimes->send([
     *     'recipient' => 'customer@example.com',
     *     'message' => 'Payment received for order #12345',
     *     'transport' => 'email'
     * ]);
     * ```
     *
     * @see https://studio.inttegro.com/send-customer-notification for notification guide
     */
    public function send(array $payload): \Commerce\ResponseObject
    {
        return $this->http->post('/chimes/send', $payload);
    }

    /**
     * Retrieve details of a previously sent chime.
     *
     * Returns full chime information including recipient, message content, transport method,
     * delivery status, and transmission timestamps. Use this to verify delivery or debug
     * notification issues.
     *
     * @param string $chimeId Unique identifier of the chime to retrieve (required)
     *
     * @return \Commerce\ResponseObject Complete chime object with delivery details
     *
     * @example Lookup a chime
     * ```php
     * $result = $client->chimes->lookup(
     *     'chm_abc123xyz789'
     * );
     *
     * $chime = $result->data['chime'];
     * echo "Recipient: {$chime['recipient']}\n";
     * echo "Status: {$chime['status']}\n";
     * echo "Sent at: {$chime['sent_at']}\n";
     * ```
     *
     * @see https://studio.inttegro.com/chimes for chime overview
     */
    public function lookup(string $chimeId): \Commerce\ResponseObject
    {
        return $this->http->post('/chimes/lookup', ['chime_id' => $chimeId]);
    }

    /**
     * Schedule a notification to be sent at a future time.
     *
     * Creates a chime that will be sent automatically at the specified timestamp. Use scheduled
     * chimes for appointment reminders, subscription renewal notices, or time-delayed notifications.
     *
     * @param array $payload Scheduled chime parameters
     *   - recipients: array - List of recipient phone numbers or emails (required)
     *   - full_message: string - Message content to send (required)
     *   - send_after: string - ISO 8601 timestamp when chime should be sent (required)
     *   - sender_id: string - Sender identifier (optional)
     *   - purpose: string - Purpose of this scheduled chime (optional)
     *
     * @return \Commerce\ResponseObject Scheduled chime object with send time
     *
     * @example Schedule SMS for tomorrow
     * ```php
     * $result = $client->chimes->schedule([
     *     'recipients' => ['+233541234567', 'user@example.com'],
     *     'full_message' => 'Your subscription renews tomorrow',
     *     'send_after' => '2025-12-21T09:00:00Z',
     *     'sender_id' => 'YourBrand'
     * ]);
     *
     * $schedule = $result->data['scheduled_chime'];
     * echo "Chime scheduled: {$schedule['id']}\n";
     * echo "Will send at: {$schedule['send_after']}\n";
     * ```
     *
     * @see https://studio.inttegro.com/send-scheduled-notifications for scheduling guide
     */
    public function schedule(array $payload): \Commerce\ResponseObject
    {
        return $this->http->post('/chimes/schedule', $payload);
    }

    /**
     * Broadcast a chime to multiple recipients.
     *
     * Queues a broadcast with a shared message template. Use broadcasts for marketing announcements
     * or bulk notifications.
     *
     * @param array $payload Broadcast parameters
     *   - recipients: array - List of recipient phone numbers or emails (required)
     *   - message_template: string - Message template to send (required)
     *   - service_name: string - Service initiating the broadcast (required)
     *   - sender: string - Sender identifier (optional)
     *   - purpose: string - Purpose of this broadcast (optional)
     *   - preferred_gateway: string - Preferred delivery gateway (optional)
     *   - request_meta: array - Request controls such as idempotency_key (optional)
     *
     * @return \Commerce\ResponseObject Broadcast summary
     */
    public function broadcast(array $payload): \Commerce\ResponseObject
    {
        return $this->http->post('/chimes/broadcast', $payload);
    }
}
