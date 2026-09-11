<?php

namespace Inttegro\File;

use DateTimeImmutable;

/**
 * Upload Receipt details associated with file.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class UploadReceipt extends \Inttegro\DomainValue
{
    /**
     * Content Type value for this upload receipt.
     *
     * Required response field. PHP type: `string`; wire field: `content_type` (`string`).
     *
     * @var string
     */
    public readonly string $contentType;

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
     * Filename value for this upload receipt.
     *
     * Optional response field. PHP type: `string|null`; wire field: `filename` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $filename;

    /**
     * Unique identifier for this upload receipt.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Human-readable name.
     *
     * Optional response field. PHP type: `string|null`; wire field: `name` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $name;

    /**
     * Size value for this upload receipt.
     *
     * Required response field. PHP type: `int`; wire field: `size` (`integer`).
     *
     * @var int
     */
    public readonly int $size;

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
     * Hydrates an UploadReceipt from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->contentType = \Inttegro\ValueHydrator::string($data['content_type'] ?? null, false);
        $this->createdAt = \Inttegro\ValueHydrator::dateTime($data['created_at'] ?? null, false);
        $this->filename = \Inttegro\ValueHydrator::string($data['filename'] ?? null, true);
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->name = \Inttegro\ValueHydrator::string($data['name'] ?? null, true);
        $this->size = \Inttegro\ValueHydrator::int($data['size'] ?? null, false);
        $this->status = \Inttegro\ValueHydrator::string($data['status'] ?? null, false);
    }

    /**
     * Creates an UploadReceipt from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable UploadReceipt value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
