<?php

namespace Inttegro\SecretKey;

use DateTimeImmutable;

/**
 * Metadata for an application secret key; the secret token itself is returned only when a key is
 * generated.
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
     * Application-scoped secret key identifier.
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
     * Token Type value for this secret key.
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
     * Omitted until the label is changed.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `updated_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $updatedAt;

    /**
     * Omitted for keys without a fixed expiry.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `expires_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $expiresAt;

    /**
     * Current lifecycle state.
     *
     * Required response field. PHP type: `string`; wire field: `status` (`string`).
     * Compare against `Status` cases by using their `->value` strings.
     *
     * @var string
     */
    public readonly string $status;

    /**
     * Whether this value is currently active.
     *
     * Required response field. PHP type: `bool`; wire field: `active` (`boolean`).
     *
     * @var bool
     */
    public readonly bool $active;

    /**
     * Omitted until the key is revoked.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `revoked_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $revokedAt;

    /**
     * Most recent recorded authentication when available; otherwise omitted.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `last_used_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $lastUsedAt;

    /**
     * Number of recorded authentications when available; omitted when zero.
     *
     * Optional response field. PHP type: `int|null`; wire field: `usage_count` (`integer`).
     *
     * @var int|null
     */
    public readonly ?int $usageCount;

    /**
     * Hydrates a SecretKey from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->label = \Inttegro\ValueHydrator::string($data['label'] ?? null, true);
        $this->tokenType = \Inttegro\ValueHydrator::string($data['token_type'] ?? null, false);
        $this->issuedAt = \Inttegro\ValueHydrator::dateTime($data['issued_at'] ?? null, false);
        $this->updatedAt = \Inttegro\ValueHydrator::dateTime($data['updated_at'] ?? null, true);
        $this->expiresAt = \Inttegro\ValueHydrator::dateTime($data['expires_at'] ?? null, true);
        $this->status = \Inttegro\ValueHydrator::string($data['status'] ?? null, false);
        $this->active = \Inttegro\ValueHydrator::bool($data['active'] ?? null, false);
        $this->revokedAt = \Inttegro\ValueHydrator::dateTime($data['revoked_at'] ?? null, true);
        $this->lastUsedAt = \Inttegro\ValueHydrator::dateTime($data['last_used_at'] ?? null, true);
        $this->usageCount = \Inttegro\ValueHydrator::int($data['usage_count'] ?? null, true);
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
