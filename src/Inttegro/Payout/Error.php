<?php

namespace Inttegro\Payout;

use DateTimeImmutable;

/**
 * Public failure details when execution fails.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Error extends \Inttegro\DomainValue
{
    /**
     * Cause value for this error.
     *
     * Required response field. PHP type: `string`; wire field: `cause` (`string`).
     *
     * @var string
     */
    public readonly string $cause;

    /**
     * Message value for this error.
     *
     * Required response field. PHP type: `string`; wire field: `message` (`string`).
     *
     * @var string
     */
    public readonly string $message;

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
     * Discriminator identifying the value's API variant.
     *
     * Required response field. PHP type: `string`; wire field: `type` (`string`).
     *
     * @var string
     */
    public readonly string $type;

    /**
     * Hydrates an Error from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->cause = \Inttegro\ValueHydrator::string($data['cause'] ?? null, false);
        $this->message = \Inttegro\ValueHydrator::string($data['message'] ?? null, false);
        $this->occurredAt = \Inttegro\ValueHydrator::dateTime($data['occurred_at'] ?? null, false);
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
    }

    /**
     * Creates an Error from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Error value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
