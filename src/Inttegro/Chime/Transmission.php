<?php

namespace Inttegro\Chime;

use DateTimeImmutable;

/**
 * Transmission details associated with chime.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Transmission extends \Inttegro\DomainValue
{
    /**
     * Address value for this transmission.
     *
     * Required response field. PHP type: `string`; wire field: `address` (`string`).
     *
     * @var string
     */
    public readonly string $address;

    /**
     * Time at which the value was created.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `created_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $createdAt;

    /**
     * Timestamp associated with delivered.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `delivered_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $deliveredAt;

    /**
     * Email Events value for this transmission.
     *
     * Optional response field. PHP type: `list<\Inttegro\Chime\EmailEvent>|null`; wire field:
     * `email_events` (`array<object>`).
     * When the field is absent, the SDK exposes an empty collection.
     *
     * @var list<\Inttegro\Chime\EmailEvent>|null
     */
    public readonly ?array $emailEvents;

    /**
     * Email Failure Code value for this transmission.
     *
     * Optional response field. PHP type: `string|null`; wire field: `email_failure_code`
     * (`string`).
     *
     * @var string|null
     */
    public readonly ?string $emailFailureCode;

    /**
     * Email Failure Reason value for this transmission.
     *
     * Optional response field. PHP type: `string|null`; wire field: `email_failure_reason`
     * (`string`).
     *
     * @var string|null
     */
    public readonly ?string $emailFailureReason;

    /**
     * Email Status value for this transmission.
     *
     * Optional response field. PHP type: `string|null`; wire field: `email_status` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $emailStatus;

    /**
     * Error value for this transmission.
     *
     * Optional response field. PHP type: `string|null`; wire field: `error` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $error;

    /**
     * Time at which the operation failed.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `failed_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $failedAt;

    /**
     * Gateway value for this transmission.
     *
     * Required response field. PHP type: `string`; wire field: `gateway` (`string`).
     *
     * @var string
     */
    public readonly string $gateway;

    /**
     * Identifier of the related gateway message.
     *
     * Optional response field. PHP type: `string|null`; wire field: `gateway_message_id`
     * (`string`).
     *
     * @var string|null
     */
    public readonly ?string $gatewayMessageId;

    /**
     * Unique identifier for this transmission.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Timestamp associated with initialized.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `initialized_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $initializedAt;

    /**
     * Timestamp associated with last email event.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field:
     * `last_email_event_at` (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $lastEmailEventAt;

    /**
     * Mechanism value for this transmission.
     *
     * Required response field. PHP type: `string`; wire field: `mechanism` (`string`).
     *
     * @var string
     */
    public readonly string $mechanism;

    /**
     * Timestamp associated with sent.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `sent_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $sentAt;

    /**
     * Sent Via value for this transmission.
     *
     * Optional response field. PHP type: `string|null`; wire field: `sent_via` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $sentVia;

    /**
     * Current lifecycle state.
     *
     * Required response field. PHP type: `string`; wire field: `status` (`string`).
     *
     * @var string
     */
    public readonly string $status;

    /**
     * Timestamp associated with suppressed.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `suppressed_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $suppressedAt;

    /**
     * Suppression Reason value for this transmission.
     *
     * Optional response field. PHP type: `string|null`; wire field: `suppression_reason`
     * (`string`).
     *
     * @var string|null
     */
    public readonly ?string $suppressionReason;

    /**
     * Hydrates a Transmission from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->address = \Inttegro\ValueHydrator::string($data['address'] ?? null, false);
        $this->createdAt = \Inttegro\ValueHydrator::dateTime($data['created_at'] ?? null, false);
        $this->deliveredAt = \Inttegro\ValueHydrator::dateTime($data['delivered_at'] ?? null, true);
        $this->emailEvents = \Inttegro\ValueHydrator::objects($data['email_events'] ?? null, [\Inttegro\Chime\EmailEvent::class]);
        $this->emailFailureCode = \Inttegro\ValueHydrator::string($data['email_failure_code'] ?? null, true);
        $this->emailFailureReason = \Inttegro\ValueHydrator::string($data['email_failure_reason'] ?? null, true);
        $this->emailStatus = \Inttegro\ValueHydrator::string($data['email_status'] ?? null, true);
        $this->error = \Inttegro\ValueHydrator::string($data['error'] ?? null, true);
        $this->failedAt = \Inttegro\ValueHydrator::dateTime($data['failed_at'] ?? null, true);
        $this->gateway = \Inttegro\ValueHydrator::string($data['gateway'] ?? null, false);
        $this->gatewayMessageId = \Inttegro\ValueHydrator::string($data['gateway_message_id'] ?? null, true);
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->initializedAt = \Inttegro\ValueHydrator::dateTime($data['initialized_at'] ?? null, false);
        $this->lastEmailEventAt = \Inttegro\ValueHydrator::dateTime($data['last_email_event_at'] ?? null, true);
        $this->mechanism = \Inttegro\ValueHydrator::string($data['mechanism'] ?? null, false);
        $this->sentAt = \Inttegro\ValueHydrator::dateTime($data['sent_at'] ?? null, true);
        $this->sentVia = \Inttegro\ValueHydrator::string($data['sent_via'] ?? null, true);
        $this->status = \Inttegro\ValueHydrator::string($data['status'] ?? null, false);
        $this->suppressedAt = \Inttegro\ValueHydrator::dateTime($data['suppressed_at'] ?? null, true);
        $this->suppressionReason = \Inttegro\ValueHydrator::string($data['suppression_reason'] ?? null, true);
    }

    /**
     * Creates a Transmission from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Transmission value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
