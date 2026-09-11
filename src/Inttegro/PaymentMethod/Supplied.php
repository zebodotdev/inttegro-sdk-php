<?php

namespace Inttegro\PaymentMethod;

use DateTimeImmutable;

/**
 * Public provenance for how the payment method was supplied.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Supplied extends \Inttegro\DomainValue
{
    /**
     * Identifier of the related attempt.
     *
     * Optional response field. PHP type: `string|null`; wire field: `attempt_id` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $attemptId;

    /**
     * By value for this supplied.
     *
     * Required response field. PHP type: `string`; wire field: `by` (`string`).
     *
     * @var string
     */
    public readonly string $by;

    /**
     * Channel value for this supplied.
     *
     * Optional response field. PHP type: `string|null`; wire field: `channel` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $channel;

    /**
     * Identifier of the related resource.
     *
     * Optional response field. PHP type: `string|null`; wire field: `resource_id` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $resourceId;

    /**
     * Resource Type value for this supplied.
     *
     * Optional response field. PHP type: `string|null`; wire field: `resource_type` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $resourceType;

    /**
     * Timestamp associated with supplied.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `supplied_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $suppliedAt;

    /**
     * Hydrates a Supplied from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->attemptId = \Inttegro\ValueHydrator::string($data['attempt_id'] ?? null, true);
        $this->by = \Inttegro\ValueHydrator::string($data['by'] ?? null, false);
        $this->channel = \Inttegro\ValueHydrator::string($data['channel'] ?? null, true);
        $this->resourceId = \Inttegro\ValueHydrator::string($data['resource_id'] ?? null, true);
        $this->resourceType = \Inttegro\ValueHydrator::string($data['resource_type'] ?? null, true);
        $this->suppliedAt = \Inttegro\ValueHydrator::dateTime($data['supplied_at'] ?? null, false);
    }

    /**
     * Creates a Supplied from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Supplied value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
