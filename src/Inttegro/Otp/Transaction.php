<?php

namespace Inttegro\Otp;

use DateTimeImmutable;

/**
 * An OTP transaction returned by initiation, verification, and lookup operations.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Transaction extends \Inttegro\DomainValue
{
    /**
     * Omitted unless the transaction was canceled.
     *
     * Optional response field. PHP type: `string|null`; wire field: `cancel_reason` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $cancelReason;

    /**
     * Omitted unless the transaction was canceled.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `canceled_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $canceledAt;

    /**
     * Timestamp associated with expires.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `expires_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $expiresAt;

    /**
     * Message text with the `{token}` placeholder preserved; no generated token is returned.
     *
     * Required response field. PHP type: `string`; wire field: `full_message` (`string`).
     *
     * @var string
     */
    public readonly string $fullMessage;

    /**
     * Unique identifier with ot_ prefix.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Time at which processing began.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `initiated_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $initiatedAt;

    /**
     * Current lifecycle state.
     *
     * Required response field. PHP type: `string`; wire field: `status` (`string`).
     * Compare against `Status` cases by using their `->value` strings.
     *
     * @var string
     */
    public readonly string $status;

    /**
     * Transmission value for this transaction.
     *
     * Optional response field. PHP type: `\Inttegro\Otp\Transmission|null`; wire field:
     * `transmission` (`object`).
     *
     * @var \Inttegro\Otp\Transmission|null
     */
    public readonly ?\Inttegro\Otp\Transmission $transmission;

    /**
     * Hydrates a Transaction from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->cancelReason = \Inttegro\ValueHydrator::string($data['cancel_reason'] ?? null, true);
        $this->canceledAt = \Inttegro\ValueHydrator::dateTime($data['canceled_at'] ?? null, true);
        $this->expiresAt = \Inttegro\ValueHydrator::dateTime($data['expires_at'] ?? null, false);
        $this->fullMessage = \Inttegro\ValueHydrator::string($data['full_message'] ?? null, false);
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->initiatedAt = \Inttegro\ValueHydrator::dateTime($data['initiated_at'] ?? null, false);
        $this->status = \Inttegro\ValueHydrator::string($data['status'] ?? null, false);
        $this->transmission = \Inttegro\ValueHydrator::object($data['transmission'] ?? null, [\Inttegro\Otp\Transmission::class], true);
    }

    /**
     * Creates a Transaction from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Transaction value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
