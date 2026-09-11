<?php

namespace Inttegro\FileLink;

use DateTimeImmutable;

/**
 * Access details associated with file link.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Access extends \Inttegro\DomainValue
{
    /**
     * Max Accesses value for this access.
     *
     * Optional response field. PHP type: `int|null`; wire field: `max_accesses` (`integer`).
     *
     * @var int|null
     */
    public readonly ?int $maxAccesses;

    /**
     * Access Count value for this access.
     *
     * Optional response field. PHP type: `int|null`; wire field: `access_count` (`integer`).
     *
     * @var int|null
     */
    public readonly ?int $accessCount;

    /**
     * Timestamp associated with last accessed.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `last_accessed_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $lastAccessedAt;

    /**
     * Allow Download value for this access.
     *
     * Optional response field. PHP type: `bool|null`; wire field: `allow_download` (`boolean`).
     *
     * @var bool|null
     */
    public readonly ?bool $allowDownload;

    /**
     * Allowed Origins value for this access.
     *
     * Optional response field. PHP type: `list<string>|null`; wire field: `allowed_origins`
     * (`array<string>`).
     *
     * @var list<string>|null
     */
    public readonly ?array $allowedOrigins;

    /**
     * Hydrates an Access from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->maxAccesses = \Inttegro\ValueHydrator::int($data['max_accesses'] ?? null, true);
        $this->accessCount = \Inttegro\ValueHydrator::int($data['access_count'] ?? null, true);
        $this->lastAccessedAt = \Inttegro\ValueHydrator::dateTime($data['last_accessed_at'] ?? null, true);
        $this->allowDownload = \Inttegro\ValueHydrator::bool($data['allow_download'] ?? null, true);
        $this->allowedOrigins = \Inttegro\ValueHydrator::array($data['allowed_origins'] ?? null, true);
    }

    /**
     * Creates an Access from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Access value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
