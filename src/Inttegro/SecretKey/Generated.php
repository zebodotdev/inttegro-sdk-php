<?php

namespace Inttegro\SecretKey;

use DateTimeImmutable;

/**
 * Newly generated secret key. The token is returned once and cannot be retrieved later.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Generated extends \Inttegro\DomainValue
{
    /**
     * Secret key identifier.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Optional human-readable label for the secret key.
     *
     * Optional response field. PHP type: `string|null`; wire field: `label` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $label;

    /**
     * Token Type value for this generated.
     *
     * Required response field. PHP type: `string`; wire field: `token_type` (`string`).
     * Compare against `TokenType` cases by using their `->value` strings.
     *
     * @var string
     */
    public readonly string $tokenType;

    /**
     * Timestamp associated with issued.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `issued_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $issuedAt;

    /**
     * One-time bearer token for the generated key.
     *
     * Required response field. PHP type: `string`; wire field: `token` (`string`).
     *
     * @var string
     */
    public readonly string $token;

    /**
     * Hydrates a Generated from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->label = \Inttegro\ValueHydrator::string($data['label'] ?? null, true);
        $this->tokenType = \Inttegro\ValueHydrator::string($data['token_type'] ?? null, false);
        $this->issuedAt = \Inttegro\ValueHydrator::dateTime($data['issued_at'] ?? null, false);
        $this->token = \Inttegro\ValueHydrator::string($data['token'] ?? null, false);
    }

    /**
     * Creates a Generated from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Generated value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
