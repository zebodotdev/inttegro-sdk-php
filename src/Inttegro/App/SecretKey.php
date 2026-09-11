<?php

namespace Inttegro\App;

use DateTimeImmutable;

/**
 * Secret Key details associated with app.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class SecretKey extends \Inttegro\DomainValue
{
    /**
     * Unique identifier for this secret key.
     *
     * Optional response field. PHP type: `string|null`; wire field: `id` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $id;

    /**
     * Token Type value for this secret key.
     *
     * Optional response field. PHP type: `string|null`; wire field: `token_type` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $tokenType;

    /**
     * Timestamp associated with issued.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `issued_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $issuedAt;

    /**
     * Token value for this secret key.
     *
     * Optional response field. PHP type: `string|null`; wire field: `token` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $token;

    /**
     * Hydrates a SecretKey from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, true);
        $this->tokenType = \Inttegro\ValueHydrator::string($data['token_type'] ?? null, true);
        $this->issuedAt = \Inttegro\ValueHydrator::dateTime($data['issued_at'] ?? null, true);
        $this->token = \Inttegro\ValueHydrator::string($data['token'] ?? null, true);
    }

    /**
     * Creates a SecretKey from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable SecretKey value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
