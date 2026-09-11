<?php

namespace Inttegro\SecretKey;

use DateTimeImmutable;

/**
 * Public authentication outcome associated with the selected key.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class UsageRow extends \Inttegro\DomainValue
{
    /**
     * Identifier of the related secret key.
     *
     * Required response field. PHP type: `string`; wire field: `secret_key_id` (`string`).
     *
     * @var string
     */
    public readonly string $secretKeyId;

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
     * Auth Result value for this usage row.
     *
     * Required response field. PHP type: `string`; wire field: `auth_result` (`string`).
     * Compare against `AuthResult` cases by using their `->value` strings.
     *
     * @var string
     */
    public readonly string $authResult;

    /**
     * Hydrates an UsageRow from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->secretKeyId = \Inttegro\ValueHydrator::string($data['secret_key_id'] ?? null, false);
        $this->occurredAt = \Inttegro\ValueHydrator::dateTime($data['occurred_at'] ?? null, false);
        $this->authResult = \Inttegro\ValueHydrator::string($data['auth_result'] ?? null, false);
    }

    /**
     * Creates an UsageRow from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable UsageRow value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
