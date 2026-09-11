<?php

namespace Inttegro\Schedule;

use DateTimeImmutable;

/**
 * Creation Detail details associated with schedule.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class CreationDetail extends \Inttegro\DomainValue
{
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
     * Customer Ids value for this creation detail.
     *
     * Optional response field. PHP type: `list<string>|null`; wire field: `customer_ids`
     * (`array<string>`).
     *
     * @var list<string>|null
     */
    public readonly ?array $customerIds;

    /**
     * Email content, safety scan result, and system-generated schema markup for email chimes.
     *
     * Optional response field. PHP type: `\Inttegro\Chime\EmailMessage|null`; wire field: `email`
     * (`object`).
     *
     * @var \Inttegro\Chime\EmailMessage|null
     */
    public readonly ?\Inttegro\Chime\EmailMessage $email;

    /**
     * Time at which execution began.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `executed_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $executedAt;

    /**
     * Full Message value for this creation detail.
     *
     * Required response field. PHP type: `string`; wire field: `full_message` (`string`).
     *
     * @var string
     */
    public readonly string $fullMessage;

    /**
     * Unique identifier for this creation detail.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Idempotency Key value for this creation detail.
     *
     * Optional response field. PHP type: `string|null`; wire field: `idempotency_key` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $idempotencyKey;

    /**
     * Purpose value for this creation detail.
     *
     * Optional response field. PHP type: `string|null`; wire field: `purpose` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $purpose;

    /**
     * Recipients value for this creation detail.
     *
     * Optional response field. PHP type: `list<string>|null`; wire field: `recipients`
     * (`array<string>`).
     *
     * @var list<string>|null
     */
    public readonly ?array $recipients;

    /**
     * Send After value for this creation detail.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `send_after` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $sendAfter;

    /**
     * Identifier of the related sender.
     *
     * Required response field. PHP type: `string`; wire field: `sender_id` (`string`).
     *
     * @var string
     */
    public readonly string $senderId;

    /**
     * Hydrates a CreationDetail from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->createdAt = \Inttegro\ValueHydrator::dateTime($data['created_at'] ?? null, false);
        $this->customerIds = \Inttegro\ValueHydrator::array($data['customer_ids'] ?? null, true);
        $this->email = \Inttegro\ValueHydrator::object($data['email'] ?? null, [\Inttegro\Chime\EmailMessage::class], true);
        $this->executedAt = \Inttegro\ValueHydrator::dateTime($data['executed_at'] ?? null, true);
        $this->fullMessage = \Inttegro\ValueHydrator::string($data['full_message'] ?? null, false);
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->idempotencyKey = \Inttegro\ValueHydrator::string($data['idempotency_key'] ?? null, true);
        $this->purpose = \Inttegro\ValueHydrator::string($data['purpose'] ?? null, true);
        $this->recipients = \Inttegro\ValueHydrator::array($data['recipients'] ?? null, true);
        $this->sendAfter = \Inttegro\ValueHydrator::dateTime($data['send_after'] ?? null, false);
        $this->senderId = \Inttegro\ValueHydrator::string($data['sender_id'] ?? null, false);
    }

    /**
     * Creates a CreationDetail from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable CreationDetail value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
