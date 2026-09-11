<?php

namespace Inttegro\Otp;

use DateTimeImmutable;

/**
 * Details of a verification attempt.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class VerificationAttempt extends \Inttegro\DomainValue
{
    /**
     * Timestamp associated with attempted.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `attempted_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $attemptedAt;

    /**
     * Unique identifier for this verification attempt.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Token submitted for this verification attempt.
     *
     * Required response field. PHP type: `string`; wire field: `presented_token` (`string`).
     *
     * @var string
     */
    public readonly string $presentedToken;

    /**
     * Recipient value for this verification attempt.
     *
     * Required response field. PHP type: `string`; wire field: `recipient` (`string`).
     *
     * @var string
     */
    public readonly string $recipient;

    /**
     * Result value for this verification attempt.
     *
     * Required response field. PHP type: `\Inttegro\Otp\VerificationAttemptResult`; wire field:
     * `result` (`object`).
     *
     * @var \Inttegro\Otp\VerificationAttemptResult
     */
    public readonly \Inttegro\Otp\VerificationAttemptResult $result;

    /**
     * Hydrates a VerificationAttempt from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->attemptedAt = \Inttegro\ValueHydrator::dateTime($data['attempted_at'] ?? null, false);
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->presentedToken = \Inttegro\ValueHydrator::string($data['presented_token'] ?? null, false);
        $this->recipient = \Inttegro\ValueHydrator::string($data['recipient'] ?? null, false);
        $this->result = \Inttegro\ValueHydrator::object($data['result'] ?? null, [\Inttegro\Otp\VerificationAttemptResult::class], false);
    }

    /**
     * Creates a VerificationAttempt from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable VerificationAttempt value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
