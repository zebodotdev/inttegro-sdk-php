<?php

namespace Inttegro\PaymentMethod;

use DateTimeImmutable;

/**
 * Most recent verification record when the payment method has entered a verification flow.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Verification extends \Inttegro\DomainValue
{
    /**
     * When verification was completed.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `completed_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $completedAt;

    /**
     * When verification was initiated.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `initiated_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $initiatedAt;

    /**
     * Verification mechanism used.
     *
     * Optional response field. PHP type: `string|null`; wire field: `mechanism` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $mechanism;

    /**
     * ID of the verification request.
     *
     * Required response field. PHP type: `string`; wire field: `request_id` (`string`).
     *
     * @var string
     */
    public readonly string $requestId;

    /**
     * Verification type.
     *
     * Required response field. PHP type: `string`; wire field: `type` (`string`).
     * Compare against `Type` cases by using their `->value` strings.
     *
     * @var string
     */
    public readonly string $type;

    /**
     * Hydrates a Verification from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->completedAt = \Inttegro\ValueHydrator::dateTime($data['completed_at'] ?? null, true);
        $this->initiatedAt = \Inttegro\ValueHydrator::dateTime($data['initiated_at'] ?? null, false);
        $this->mechanism = \Inttegro\ValueHydrator::string($data['mechanism'] ?? null, true);
        $this->requestId = \Inttegro\ValueHydrator::string($data['request_id'] ?? null, false);
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
    }

    /**
     * Creates a Verification from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Verification value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
