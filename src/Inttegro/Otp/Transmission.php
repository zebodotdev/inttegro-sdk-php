<?php

namespace Inttegro\Otp;

use DateTimeImmutable;

/**
 * Transmission details associated with otp.
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
     * Recipient value for this transmission.
     *
     * Required response field. PHP type: `string`; wire field: `recipient` (`string`).
     *
     * @var string
     */
    public readonly string $recipient;

    /**
     * Identifier of the related sender.
     *
     * Required response field. PHP type: `string`; wire field: `sender_id` (`string`).
     *
     * @var string
     */
    public readonly string $senderId;

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
     * Optional response field. PHP type: `string|null`; wire field: `status` (`string`).
     * Compare against `Status` cases by using their `->value` strings.
     *
     * @var string|null
     */
    public readonly ?string $status;

    /**
     * Hydrates a Transmission from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->recipient = \Inttegro\ValueHydrator::string($data['recipient'] ?? null, false);
        $this->senderId = \Inttegro\ValueHydrator::string($data['sender_id'] ?? null, false);
        $this->sentAt = \Inttegro\ValueHydrator::dateTime($data['sent_at'] ?? null, true);
        $this->sentVia = \Inttegro\ValueHydrator::string($data['sent_via'] ?? null, true);
        $this->status = \Inttegro\ValueHydrator::string($data['status'] ?? null, true);
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
