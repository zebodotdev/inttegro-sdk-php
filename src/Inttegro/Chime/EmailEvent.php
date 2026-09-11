<?php

namespace Inttegro\Chime;

use DateTimeImmutable;

/**
 * Email Event details associated with chime.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class EmailEvent extends \Inttegro\DomainValue
{
    /**
     * Bounce Sub Type value for this email event.
     *
     * Optional response field. PHP type: `string|null`; wire field: `bounce_sub_type` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $bounceSubType;

    /**
     * Bounce Type value for this email event.
     *
     * Optional response field. PHP type: `string|null`; wire field: `bounce_type` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $bounceType;

    /**
     * Complaint Sub Type value for this email event.
     *
     * Optional response field. PHP type: `string|null`; wire field: `complaint_sub_type`
     * (`string`).
     *
     * @var string|null
     */
    public readonly ?string $complaintSubType;

    /**
     * Unique identifier for this email event.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Timestamp associated with occurred.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `occurred_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $occurredAt;

    /**
     * Provider value for this email event.
     *
     * Required response field. PHP type: `string`; wire field: `provider` (`string`).
     *
     * @var string
     */
    public readonly string $provider;

    /**
     * Identifier of the related provider message.
     *
     * Required response field. PHP type: `string`; wire field: `provider_message_id` (`string`).
     *
     * @var string
     */
    public readonly string $providerMessageId;

    /**
     * Reason value for this email event.
     *
     * Optional response field. PHP type: `string|null`; wire field: `reason` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $reason;

    /**
     * Reason Code value for this email event.
     *
     * Optional response field. PHP type: `string|null`; wire field: `reason_code` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $reasonCode;

    /**
     * Recipient value for this email event.
     *
     * Optional response field. PHP type: `string|null`; wire field: `recipient` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $recipient;

    /**
     * Source value for this email event.
     *
     * Optional response field. PHP type: `string|null`; wire field: `source` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $source;

    /**
     * Suppress Recipient value for this email event.
     *
     * Optional response field. PHP type: `bool|null`; wire field: `suppress_recipient` (`boolean`).
     *
     * @var bool|null
     */
    public readonly ?bool $suppressRecipient;

    /**
     * Temporary value for this email event.
     *
     * Optional response field. PHP type: `bool|null`; wire field: `temporary` (`boolean`).
     *
     * @var bool|null
     */
    public readonly ?bool $temporary;

    /**
     * Discriminator identifying the value's API variant.
     *
     * Required response field. PHP type: `string`; wire field: `type` (`string`).
     *
     * @var string
     */
    public readonly string $type;

    /**
     * Hydrates an EmailEvent from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->bounceSubType = \Inttegro\ValueHydrator::string($data['bounce_sub_type'] ?? null, true);
        $this->bounceType = \Inttegro\ValueHydrator::string($data['bounce_type'] ?? null, true);
        $this->complaintSubType = \Inttegro\ValueHydrator::string($data['complaint_sub_type'] ?? null, true);
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->occurredAt = \Inttegro\ValueHydrator::dateTime($data['occurred_at'] ?? null, false);
        $this->provider = \Inttegro\ValueHydrator::string($data['provider'] ?? null, false);
        $this->providerMessageId = \Inttegro\ValueHydrator::string($data['provider_message_id'] ?? null, false);
        $this->reason = \Inttegro\ValueHydrator::string($data['reason'] ?? null, true);
        $this->reasonCode = \Inttegro\ValueHydrator::string($data['reason_code'] ?? null, true);
        $this->recipient = \Inttegro\ValueHydrator::string($data['recipient'] ?? null, true);
        $this->source = \Inttegro\ValueHydrator::string($data['source'] ?? null, true);
        $this->suppressRecipient = \Inttegro\ValueHydrator::bool($data['suppress_recipient'] ?? null, true);
        $this->temporary = \Inttegro\ValueHydrator::bool($data['temporary'] ?? null, true);
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
    }

    /**
     * Creates an EmailEvent from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable EmailEvent value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
