<?php

namespace Inttegro\FinancialAccount;

use DateTimeImmutable;

/**
 * Pull Configuration Mandate details associated with financial account.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class PullConfigurationMandate extends \Inttegro\DomainValue
{
    /**
     * Time at which the value was created.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `created_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $createdAt;

    /**
     * Unique identifier for this pull configuration mandate.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Ip Address value for this pull configuration mandate.
     *
     * Required response field. PHP type: `string`; wire field: `ip_address` (`string`).
     *
     * @var string
     */
    public readonly string $ipAddress;

    /**
     * User Agent value for this pull configuration mandate.
     *
     * Required response field. PHP type: `string`; wire field: `user_agent` (`string`).
     *
     * @var string
     */
    public readonly string $userAgent;

    /**
     * Hydrates a PullConfigurationMandate from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->createdAt = \Inttegro\ValueHydrator::dateTime($data['created_at'] ?? null, false);
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->ipAddress = \Inttegro\ValueHydrator::string($data['ip_address'] ?? null, false);
        $this->userAgent = \Inttegro\ValueHydrator::string($data['user_agent'] ?? null, false);
    }

    /**
     * Creates a PullConfigurationMandate from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable PullConfigurationMandate value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
