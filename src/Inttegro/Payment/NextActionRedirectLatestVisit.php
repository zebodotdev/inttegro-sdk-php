<?php

namespace Inttegro\Payment;

use DateTimeImmutable;

/**
 * Latest redirect visit details.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class NextActionRedirectLatestVisit extends \Inttegro\DomainValue
{
    /**
     * User Agent value for this next action redirect latest visit.
     *
     * Required response field. PHP type: `string`; wire field: `user_agent` (`string`).
     *
     * @var string
     */
    public readonly string $userAgent;

    /**
     * Ip Address value for this next action redirect latest visit.
     *
     * Required response field. PHP type: `string`; wire field: `ip_address` (`string`).
     *
     * @var string
     */
    public readonly string $ipAddress;

    /**
     * At value for this next action redirect latest visit.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `at` (`ISO-8601 string
     * with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $at;

    /**
     * Hydrates a NextActionRedirectLatestVisit from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->userAgent = \Inttegro\ValueHydrator::string($data['user_agent'] ?? null, false);
        $this->ipAddress = \Inttegro\ValueHydrator::string($data['ip_address'] ?? null, false);
        $this->at = \Inttegro\ValueHydrator::dateTime($data['at'] ?? null, false);
    }

    /**
     * Creates a NextActionRedirectLatestVisit from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable NextActionRedirectLatestVisit value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
