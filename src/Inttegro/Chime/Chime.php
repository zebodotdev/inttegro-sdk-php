<?php

namespace Inttegro\Chime;

use DateTimeImmutable;

/**
 * A notification message and its recipient, transport, content, and delivery history.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Chime extends \Inttegro\DomainValue
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
     * Merchant-defined string values attached to a resource. SDKs expose this as a semantic
     * collection rather than a raw map.
     *
     * Optional response field. PHP type: `array<string, string>|null`; wire field: `custom_data`
     * (`object`).
     *
     * @var array<string, string>|null
     */
    public readonly ?array $customData;

    /**
     * Identifier of the related customer.
     *
     * Optional response field. PHP type: `string|null`; wire field: `customer_id` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $customerId;

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
     * Rendered SMS content. Empty for email Chimes.
     *
     * Required response field. PHP type: `string`; wire field: `full_message` (`string`).
     *
     * @var string
     */
    public readonly string $fullMessage;

    /**
     * Unique identifier for this chime.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Idempotency Key value for this chime.
     *
     * Optional response field. PHP type: `string|null`; wire field: `idempotency_key` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $idempotencyKey;

    /**
     * Purpose value for this chime.
     *
     * Optional response field. PHP type: `string|null`; wire field: `purpose` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $purpose;

    /**
     * Recipient information in response.
     *
     * Required response field. PHP type: `\Inttegro\Chime\Recipient`; wire field: `recipient`
     * (`object`).
     *
     * @var \Inttegro\Chime\Recipient
     */
    public readonly \Inttegro\Chime\Recipient $recipient;

    /**
     * Identifier of the related sender.
     *
     * Required response field. PHP type: `string`; wire field: `sender_id` (`string`).
     *
     * @var string
     */
    public readonly string $senderId;

    /**
     * Transmission value for this chime.
     *
     * Optional response field. PHP type: `\Inttegro\Chime\Transmission|null`; wire field:
     * `transmission` (`object`).
     *
     * @var \Inttegro\Chime\Transmission|null
     */
    public readonly ?\Inttegro\Chime\Transmission $transmission;

    /**
     * Hydrates a Chime from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->createdAt = \Inttegro\ValueHydrator::dateTime($data['created_at'] ?? null, false);
        $this->customData = \Inttegro\ValueHydrator::array($data['custom_data'] ?? null, true);
        $this->customerId = \Inttegro\ValueHydrator::string($data['customer_id'] ?? null, true);
        $this->email = \Inttegro\ValueHydrator::object($data['email'] ?? null, [\Inttegro\Chime\EmailMessage::class], true);
        $this->fullMessage = \Inttegro\ValueHydrator::string($data['full_message'] ?? null, false);
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->idempotencyKey = \Inttegro\ValueHydrator::string($data['idempotency_key'] ?? null, true);
        $this->purpose = \Inttegro\ValueHydrator::string($data['purpose'] ?? null, true);
        $this->recipient = \Inttegro\ValueHydrator::object($data['recipient'] ?? null, [\Inttegro\Chime\Recipient::class], false);
        $this->senderId = \Inttegro\ValueHydrator::string($data['sender_id'] ?? null, false);
        $this->transmission = \Inttegro\ValueHydrator::object($data['transmission'] ?? null, [\Inttegro\Chime\Transmission::class], true);
    }

    /**
     * Creates a Chime from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Chime value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
