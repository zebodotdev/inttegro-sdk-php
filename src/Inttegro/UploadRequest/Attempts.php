<?php

namespace Inttegro\UploadRequest;

use DateTimeImmutable;

/**
 * Attempts details associated with upload request.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Attempts extends \Inttegro\DomainValue
{
    /**
     * Max Attempts value for this attempts.
     *
     * Optional response field. PHP type: `int|null`; wire field: `max_attempts` (`integer`).
     *
     * @var int|null
     */
    public readonly ?int $maxAttempts;

    /**
     * Attempt Count value for this attempts.
     *
     * Required response field. PHP type: `int`; wire field: `attempt_count` (`integer`).
     *
     * @var int
     */
    public readonly int $attemptCount;

    /**
     * Failed Attempt Count value for this attempts.
     *
     * Required response field. PHP type: `int`; wire field: `failed_attempt_count` (`integer`).
     *
     * @var int
     */
    public readonly int $failedAttemptCount;

    /**
     * Timestamp associated with last attempted.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `last_attempted_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $lastAttemptedAt;

    /**
     * Hydrates an Attempts from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->maxAttempts = \Inttegro\ValueHydrator::int($data['max_attempts'] ?? null, true);
        $this->attemptCount = \Inttegro\ValueHydrator::int($data['attempt_count'] ?? null, false);
        $this->failedAttemptCount = \Inttegro\ValueHydrator::int($data['failed_attempt_count'] ?? null, false);
        $this->lastAttemptedAt = \Inttegro\ValueHydrator::dateTime($data['last_attempted_at'] ?? null, true);
    }

    /**
     * Creates an Attempts from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Attempts value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
