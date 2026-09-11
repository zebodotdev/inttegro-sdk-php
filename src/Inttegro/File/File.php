<?php

namespace Inttegro\File;

use DateTimeImmutable;

/**
 * Public metadata for a file managed by Inttegro; private storage credentials and object keys are
 * never exposed.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class File extends \Inttegro\DomainValue
{
    /**
     * Unique identifier for this file.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Purpose value for this file.
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
     * Scan Status value for this file.
     *
     * Required response field. PHP type: `string`; wire field: `scan_status` (`string`).
     * Compare against `ScanStatus` cases by using their `->value` strings.
     *
     * @var string
     */
    public readonly string $scanStatus;

    /**
     * Human-readable name.
     *
     * Optional response field. PHP type: `string|null`; wire field: `name` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $name;

    /**
     * Filename value for this file.
     *
     * Optional response field. PHP type: `string|null`; wire field: `filename` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $filename;

    /**
     * Content Type value for this file.
     *
     * Required response field. PHP type: `string`; wire field: `content_type` (`string`).
     *
     * @var string
     */
    public readonly string $contentType;

    /**
     * Original byte size.
     *
     * Required response field. PHP type: `int`; wire field: `size` (`integer`).
     *
     * @var int
     */
    public readonly int $size;

    /**
     * Checksum Sha256 value for this file.
     *
     * Required response field. PHP type: `string`; wire field: `checksum_sha256` (`string`).
     *
     * @var string
     */
    public readonly string $checksumSha256;

    /**
     * Created By value for this file.
     *
     * Required response field. PHP type: `\Inttegro\File\Actor`; wire field: `created_by`
     * (`object`).
     *
     * @var \Inttegro\File\Actor
     */
    public readonly \Inttegro\File\Actor $createdBy;

    /**
     * Source value for this file.
     *
     * Required response field. PHP type: `\Inttegro\File\Source`; wire field: `source` (`object`).
     *
     * @var \Inttegro\File\Source
     */
    public readonly \Inttegro\File\Source $source;

    /**
     * Media value for this file.
     *
     * Optional response field. PHP type: `\Inttegro\File\Media|null`; wire field: `media`
     * (`object`).
     *
     * @var \Inttegro\File\Media|null
     */
    public readonly ?\Inttegro\File\Media $media;

    /**
     * Storage value for this file.
     *
     * Required response field. PHP type: `\Inttegro\File\PublicStorage`; wire field: `storage`
     * (`object`).
     *
     * @var \Inttegro\File\PublicStorage
     */
    public readonly \Inttegro\File\PublicStorage $storage;

    /**
     * Purpose-authorized public delivery metadata for browser-rendered assets. Callers should store
     * file IDs as canonical references and treat these URLs as render URLs.
     *
     * Optional response field. PHP type: `\Inttegro\File\DeliveryDetails|null`; wire field:
     * `delivery` (`object`).
     * Compare against `Delivery` cases by using their `->value` strings.
     *
     * @var \Inttegro\File\DeliveryDetails|null
     */
    public readonly ?\Inttegro\File\DeliveryDetails $delivery;

    /**
     * Latest Error value for this file.
     *
     * Optional response field. PHP type: `\Inttegro\File\LatestError|null`; wire field:
     * `latest_error` (`object`).
     *
     * @var \Inttegro\File\LatestError|null
     */
    public readonly ?\Inttegro\File\LatestError $latestError;

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
     * Time at which the funds become available.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `available_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $availableAt;

    /**
     * Timestamp associated with expires.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `expires_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $expiresAt;

    /**
     * Hydrates a File from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->purpose = \Inttegro\ValueHydrator::string($data['purpose'] ?? null, false);
        $this->status = \Inttegro\ValueHydrator::string($data['status'] ?? null, false);
        $this->scanStatus = \Inttegro\ValueHydrator::string($data['scan_status'] ?? null, false);
        $this->name = \Inttegro\ValueHydrator::string($data['name'] ?? null, true);
        $this->filename = \Inttegro\ValueHydrator::string($data['filename'] ?? null, true);
        $this->contentType = \Inttegro\ValueHydrator::string($data['content_type'] ?? null, false);
        $this->size = \Inttegro\ValueHydrator::int($data['size'] ?? null, false);
        $this->checksumSha256 = \Inttegro\ValueHydrator::string($data['checksum_sha256'] ?? null, false);
        $this->createdBy = \Inttegro\ValueHydrator::object($data['created_by'] ?? null, [\Inttegro\File\Actor::class], false);
        $this->source = \Inttegro\ValueHydrator::object($data['source'] ?? null, [\Inttegro\File\Source::class], false);
        $this->media = \Inttegro\ValueHydrator::object($data['media'] ?? null, [\Inttegro\File\Media::class], true);
        $this->storage = \Inttegro\ValueHydrator::object($data['storage'] ?? null, [\Inttegro\File\PublicStorage::class], false);
        $this->delivery = \Inttegro\ValueHydrator::object($data['delivery'] ?? null, [\Inttegro\File\DeliveryDetails::class], true);
        $this->latestError = \Inttegro\ValueHydrator::object($data['latest_error'] ?? null, [\Inttegro\File\LatestError::class], true);
        $this->customData = \Inttegro\ValueHydrator::array($data['custom_data'] ?? null, true);
        $this->metadata = \Inttegro\ValueHydrator::array($data['metadata'] ?? null, true);
        $this->createdAt = \Inttegro\ValueHydrator::dateTime($data['created_at'] ?? null, false);
        $this->updatedAt = \Inttegro\ValueHydrator::dateTime($data['updated_at'] ?? null, false);
        $this->availableAt = \Inttegro\ValueHydrator::dateTime($data['available_at'] ?? null, true);
        $this->expiresAt = \Inttegro\ValueHydrator::dateTime($data['expires_at'] ?? null, true);
    }

    /**
     * Creates a File from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable File value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
