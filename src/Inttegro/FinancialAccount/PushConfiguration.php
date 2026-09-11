<?php

namespace Inttegro\FinancialAccount;

use DateTimeImmutable;

/**
 * Push Configuration details associated with financial account.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class PushConfiguration extends \Inttegro\DomainValue
{
    /**
     * Timestamp associated with enabled.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `enabled_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $enabledAt;

    /**
     * Hydrates a PushConfiguration from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->enabledAt = \Inttegro\ValueHydrator::dateTime($data['enabled_at'] ?? null, false);
    }

    /**
     * Creates a PushConfiguration from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable PushConfiguration value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
