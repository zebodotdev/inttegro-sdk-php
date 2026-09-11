<?php

namespace Inttegro\Payment;

use DateTimeImmutable;

/**
 * Details for authorization action.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class NextActionAuthorize extends \Inttegro\DomainValue
{
    /**
     * Beneficiary requiring authorization.
     *
     * Required response field. PHP type: `string`; wire field: `beneficiary` (`string`).
     *
     * @var string
     */
    public readonly string $beneficiary;

    /**
     * Authorization scheme.
     *
     * Required response field. PHP type: `string`; wire field: `scheme` (`string`).
     *
     * @var string
     */
    public readonly string $scheme;

    /**
     * When the authorization request expires.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `expires_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $expiresAt;

    /**
     * Hydrates a NextActionAuthorize from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->beneficiary = \Inttegro\ValueHydrator::string($data['beneficiary'] ?? null, false);
        $this->scheme = \Inttegro\ValueHydrator::string($data['scheme'] ?? null, false);
        $this->expiresAt = \Inttegro\ValueHydrator::dateTime($data['expires_at'] ?? null, false);
    }

    /**
     * Creates a NextActionAuthorize from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable NextActionAuthorize value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
