<?php

namespace Inttegro\Broadcast;

use DateTimeImmutable;

/**
 * Cancel Detail details associated with broadcast.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class CancelDetail extends \Inttegro\DomainValue
{
    /**
     * Chime Ids value for this cancel detail.
     *
     * Optional response field. PHP type: `list<string>|null`; wire field: `chime_ids`
     * (`array<string>`).
     *
     * @var list<string>|null
     */
    public readonly ?array $chimeIds;

    /**
     * Content value for this cancel detail.
     *
     * Required response field. PHP type: `string`; wire field: `content` (`string`).
     *
     * @var string
     */
    public readonly string $content;

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
     * Customer Ids value for this cancel detail.
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
     * Errors value for this cancel detail.
     *
     * Optional response field. PHP type: `list<\Inttegro\Broadcast\Error>|null`; wire field:
     * `errors` (`array<object>`).
     * When the field is absent, the SDK exposes an empty collection.
     *
     * @var list<\Inttegro\Broadcast\Error>|null
     */
    public readonly ?array $errors;

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
     * Unique identifier for this cancel detail.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Idempotency Key value for this cancel detail.
     *
     * Optional response field. PHP type: `string|null`; wire field: `idempotency_key` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $idempotencyKey;

    /**
     * Purpose value for this cancel detail.
     *
     * Optional response field. PHP type: `string|null`; wire field: `purpose` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $purpose;

    /**
     * Recipients value for this cancel detail.
     *
     * Required response field. PHP type: `list<string>`; wire field: `recipients`
     * (`array<string>`).
     *
     * @var list<string>
     */
    public readonly array $recipients;

    /**
     * Send After value for this cancel detail.
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
     * Time at which the operation was canceled.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `canceled_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $canceledAt;

    /**
     * Hydrates a CancelDetail from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->chimeIds = \Inttegro\ValueHydrator::array($data['chime_ids'] ?? null, true);
        $this->content = \Inttegro\ValueHydrator::string($data['content'] ?? null, false);
        $this->createdAt = \Inttegro\ValueHydrator::dateTime($data['created_at'] ?? null, false);
        $this->customerIds = \Inttegro\ValueHydrator::array($data['customer_ids'] ?? null, true);
        $this->email = \Inttegro\ValueHydrator::object($data['email'] ?? null, [\Inttegro\Chime\EmailMessage::class], true);
        $this->errors = \Inttegro\ValueHydrator::objects($data['errors'] ?? null, [\Inttegro\Broadcast\Error::class]);
        $this->executedAt = \Inttegro\ValueHydrator::dateTime($data['executed_at'] ?? null, true);
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->idempotencyKey = \Inttegro\ValueHydrator::string($data['idempotency_key'] ?? null, true);
        $this->purpose = \Inttegro\ValueHydrator::string($data['purpose'] ?? null, true);
        $this->recipients = \Inttegro\ValueHydrator::array($data['recipients'] ?? null, false);
        $this->sendAfter = \Inttegro\ValueHydrator::dateTime($data['send_after'] ?? null, false);
        $this->senderId = \Inttegro\ValueHydrator::string($data['sender_id'] ?? null, false);
        $this->canceledAt = \Inttegro\ValueHydrator::dateTime($data['canceled_at'] ?? null, true);
    }

    /**
     * Creates a CancelDetail from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable CancelDetail value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
