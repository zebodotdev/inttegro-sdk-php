<?php

namespace Inttegro\Payment;

use DateTimeImmutable;

/**
 * Latest confirmation attempt.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class NextActionConfirmPaymentAttempt extends \Inttegro\DomainValue
{
    /**
     * Attempt status.
     *
     * Required response field. PHP type: `string`; wire field: `status` (`string`).
     * Compare against `Status` cases by using their `->value` strings.
     *
     * @var string
     */
    public readonly string $status;

    /**
     * Whether the confirmation has succeeded.
     *
     * Required response field. PHP type: `bool`; wire field: `confirmed` (`boolean`).
     *
     * @var bool
     */
    public readonly bool $confirmed;

    /**
     * Reason for the current attempt state.
     *
     * Required response field. PHP type: `string`; wire field: `reason` (`string`).
     *
     * @var string
     */
    public readonly string $reason;

    /**
     * When the attempt was executed.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `executed_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $executedAt;

    /**
     * When the attempt was created.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `created_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $createdAt;

    /**
     * Hydrates a NextActionConfirmPaymentAttempt from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->status = \Inttegro\ValueHydrator::string($data['status'] ?? null, false);
        $this->confirmed = \Inttegro\ValueHydrator::bool($data['confirmed'] ?? null, false);
        $this->reason = \Inttegro\ValueHydrator::string($data['reason'] ?? null, false);
        $this->executedAt = \Inttegro\ValueHydrator::dateTime($data['executed_at'] ?? null, true);
        $this->createdAt = \Inttegro\ValueHydrator::dateTime($data['created_at'] ?? null, false);
    }

    /**
     * Creates a NextActionConfirmPaymentAttempt from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable NextActionConfirmPaymentAttempt value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
