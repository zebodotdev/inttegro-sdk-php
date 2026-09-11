<?php

namespace Inttegro\App;

use DateTimeImmutable;

/**
 * An Inttegro application, including its identity, lifecycle timestamps, credentials, and
 * organization relationship.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class App extends \Inttegro\DomainValue
{
    /**
     * Unique identifier for this app.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Human-readable name.
     *
     * Required response field. PHP type: `string`; wire field: `name` (`string`).
     *
     * @var string
     */
    public readonly string $name;

    /**
     * Alias value for this app.
     *
     * Optional response field. PHP type: `string|null`; wire field: `alias` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $alias;

    /**
     * Human-readable description.
     *
     * Optional response field. PHP type: `string|null`; wire field: `description` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $description;

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
     * Time at which the value was last updated.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `updated_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $updatedAt;

    /**
     * Time at which the value was archived.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `archived_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $archivedAt;

    /**
     * Secret Key value for this app.
     *
     * Optional response field. PHP type: `\Inttegro\App\SecretKey|null`; wire field: `secret_key`
     * (`object`).
     *
     * @var \Inttegro\App\SecretKey|null
     */
    public readonly ?\Inttegro\App\SecretKey $secretKey;

    /**
     * Relationship receipt for the created child app.
     *
     * Optional response field. PHP type: `\Inttegro\App\Relationship|null`; wire field:
     * `relationship` (`object`).
     *
     * @var \Inttegro\App\Relationship|null
     */
    public readonly ?\Inttegro\App\Relationship $relationship;

    /**
     * Hydrates an App from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->name = \Inttegro\ValueHydrator::string($data['name'] ?? null, false);
        $this->alias = \Inttegro\ValueHydrator::string($data['alias'] ?? null, true);
        $this->description = \Inttegro\ValueHydrator::string($data['description'] ?? null, true);
        $this->createdAt = \Inttegro\ValueHydrator::dateTime($data['created_at'] ?? null, false);
        $this->updatedAt = \Inttegro\ValueHydrator::dateTime($data['updated_at'] ?? null, true);
        $this->archivedAt = \Inttegro\ValueHydrator::dateTime($data['archived_at'] ?? null, true);
        $this->secretKey = \Inttegro\ValueHydrator::object($data['secret_key'] ?? null, [\Inttegro\App\SecretKey::class], true);
        $this->relationship = \Inttegro\ValueHydrator::object($data['relationship'] ?? null, [\Inttegro\App\Relationship::class], true);
    }

    /**
     * Creates an App from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable App value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
