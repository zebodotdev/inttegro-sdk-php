<?php

namespace Inttegro\FileLink;

use DateTimeImmutable;

/**
 * A public file-link record and its access, delivery, and revocation state.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class FileLink extends \Inttegro\DomainValue
{
    /**
     * Unique identifier for this file link.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Kind value for this file link.
     *
     * Required response field. PHP type: `string`; wire field: `kind` (`string`).
     * Compare against `Kind` cases by using their `->value` strings.
     *
     * @var string
     */
    public readonly string $kind;

    /**
     * Identifier of the related file.
     *
     * Required response field. PHP type: `string`; wire field: `file_id` (`string`).
     *
     * @var string
     */
    public readonly string $fileId;

    /**
     * Purpose value for this file link.
     *
     * Required response field. PHP type: `string`; wire field: `purpose` (`string`).
     *
     * @var string
     */
    public readonly string $purpose;

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
     * Delivery value for this file link.
     *
     * Required response field. PHP type: `\Inttegro\FileLink\Delivery`; wire field: `delivery`
     * (`object`).
     *
     * @var \Inttegro\FileLink\Delivery
     */
    public readonly \Inttegro\FileLink\Delivery $delivery;

    /**
     * Access value for this file link.
     *
     * Required response field. PHP type: `\Inttegro\FileLink\Access`; wire field: `access`
     * (`object`).
     *
     * @var \Inttegro\FileLink\Access
     */
    public readonly \Inttegro\FileLink\Access $access;

    /**
     * Created By value for this file link.
     *
     * Required response field. PHP type: `\Inttegro\FileLink\Actor`; wire field: `created_by`
     * (`object`).
     *
     * @var \Inttegro\FileLink\Actor
     */
    public readonly \Inttegro\FileLink\Actor $createdBy;

    /**
     * Revoked By value for this file link.
     *
     * Optional response field. PHP type: `\Inttegro\FileLink\Actor|null`; wire field: `revoked_by`
     * (`object`).
     *
     * @var \Inttegro\FileLink\Actor|null
     */
    public readonly ?\Inttegro\FileLink\Actor $revokedBy;

    /**
     * Merchant-defined string values attached to a resource. SDKs expose this as a semantic
     * collection rather than a raw map.
     *
     * Optional response field. PHP type: `array<string, string>|null`; wire field: `custom_data`
     * (`object`).
     *
     * @var array<string, string>|null
     */
    public readonly ?array $customData;

    /**
     * System-managed string metadata attached to a file resource.
     *
     * Optional response field. PHP type: `array<string, string>|null`; wire field: `metadata`
     * (`object`).
     *
     * @var array<string, string>|null
     */
    public readonly ?array $metadata;

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
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `updated_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $updatedAt;

    /**
     * Timestamp associated with expires.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `expires_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $expiresAt;

    /**
     * Timestamp associated with revoked.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `revoked_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $revokedAt;

    /**
     * Hydrates a FileLink from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->kind = \Inttegro\ValueHydrator::string($data['kind'] ?? null, false);
        $this->fileId = \Inttegro\ValueHydrator::string($data['file_id'] ?? null, false);
        $this->purpose = \Inttegro\ValueHydrator::string($data['purpose'] ?? null, false);
        $this->status = \Inttegro\ValueHydrator::string($data['status'] ?? null, false);
        $this->active = \Inttegro\ValueHydrator::bool($data['active'] ?? null, false);
        $this->delivery = \Inttegro\ValueHydrator::object($data['delivery'] ?? null, [\Inttegro\FileLink\Delivery::class], false);
        $this->access = \Inttegro\ValueHydrator::object($data['access'] ?? null, [\Inttegro\FileLink\Access::class], false);
        $this->createdBy = \Inttegro\ValueHydrator::object($data['created_by'] ?? null, [\Inttegro\FileLink\Actor::class], false);
        $this->revokedBy = \Inttegro\ValueHydrator::object($data['revoked_by'] ?? null, [\Inttegro\FileLink\Actor::class], true);
        $this->customData = \Inttegro\ValueHydrator::array($data['custom_data'] ?? null, true);
        $this->metadata = \Inttegro\ValueHydrator::array($data['metadata'] ?? null, true);
        $this->createdAt = \Inttegro\ValueHydrator::dateTime($data['created_at'] ?? null, false);
        $this->updatedAt = \Inttegro\ValueHydrator::dateTime($data['updated_at'] ?? null, false);
        $this->expiresAt = \Inttegro\ValueHydrator::dateTime($data['expires_at'] ?? null, false);
        $this->revokedAt = \Inttegro\ValueHydrator::dateTime($data['revoked_at'] ?? null, true);
    }

    /**
     * Creates a FileLink from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable FileLink value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
