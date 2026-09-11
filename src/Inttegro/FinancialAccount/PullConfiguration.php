<?php

namespace Inttegro\FinancialAccount;

use DateTimeImmutable;

/**
 * Pull Configuration details associated with financial account.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class PullConfiguration extends \Inttegro\DomainValue
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
     * Mandate value for this pull configuration.
     *
     * Required response field. PHP type: `\Inttegro\FinancialAccount\PullConfigurationMandate`;
     * wire field: `mandate` (`object`).
     *
     * @var \Inttegro\FinancialAccount\PullConfigurationMandate
     */
    public readonly \Inttegro\FinancialAccount\PullConfigurationMandate $mandate;

    /**
     * Hydrates a PullConfiguration from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->enabledAt = \Inttegro\ValueHydrator::dateTime($data['enabled_at'] ?? null, false);
        $this->mandate = \Inttegro\ValueHydrator::object($data['mandate'] ?? null, [\Inttegro\FinancialAccount\PullConfigurationMandate::class], false);
    }

    /**
     * Creates a PullConfiguration from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable PullConfiguration value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
