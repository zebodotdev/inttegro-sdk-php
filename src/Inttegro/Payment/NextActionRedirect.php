<?php

namespace Inttegro\Payment;

use DateTimeImmutable;

/**
 * Details for redirect action.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class NextActionRedirect extends \Inttegro\DomainValue
{
    /**
     * URL to redirect the customer to.
     *
     * Required response field. PHP type: `string`; wire field: `redirect_url` (`string`).
     *
     * @var string
     */
    public readonly string $redirectUrl;

    /**
     * When the redirect URL expires.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `valid_until` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $validUntil;

    /**
     * Latest redirect visit details.
     *
     * Optional response field. PHP type: `\Inttegro\Payment\NextActionRedirectLatestVisit|null`;
     * wire field: `latest_visit` (`object`).
     *
     * @var \Inttegro\Payment\NextActionRedirectLatestVisit|null
     */
    public readonly ?\Inttegro\Payment\NextActionRedirectLatestVisit $latestVisit;

    /**
     * Hydrates a NextActionRedirect from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->redirectUrl = \Inttegro\ValueHydrator::string($data['redirect_url'] ?? null, false);
        $this->validUntil = \Inttegro\ValueHydrator::dateTime($data['valid_until'] ?? null, false);
        $this->latestVisit = \Inttegro\ValueHydrator::object($data['latest_visit'] ?? null, [\Inttegro\Payment\NextActionRedirectLatestVisit::class], true);
    }

    /**
     * Creates a NextActionRedirect from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable NextActionRedirect value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
