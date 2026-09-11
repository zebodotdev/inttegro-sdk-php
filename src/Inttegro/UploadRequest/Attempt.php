<?php

namespace Inttegro\UploadRequest;

use DateTimeImmutable;

/**
 * Attempt details associated with upload request.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Attempt extends \Inttegro\DomainValue
{
    /**
     * Timestamp associated with attempted.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `attempted_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $attemptedAt;

    /**
     * Content Type value for this attempt.
     *
     * Optional response field. PHP type: `string|null`; wire field: `content_type` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $contentType;

    /**
     * Declared Size value for this attempt.
     *
     * Optional response field. PHP type: `int|null`; wire field: `declared_size` (`integer`).
     *
     * @var int|null
     */
    public readonly ?int $declaredSize;

    /**
     * Error value for this attempt.
     *
     * Optional response field. PHP type: `\Inttegro\UploadRequest\LatestError|null`; wire field:
     * `error` (`object`).
     *
     * @var \Inttegro\UploadRequest\LatestError|null
     */
    public readonly ?\Inttegro\UploadRequest\LatestError $error;

    /**
     * Time at which the operation failed.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `failed_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $failedAt;

    /**
     * Identifier of the related file.
     *
     * Optional response field. PHP type: `string|null`; wire field: `file_id` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $fileId;

    /**
     * Filename value for this attempt.
     *
     * Optional response field. PHP type: `string|null`; wire field: `filename` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $filename;

    /**
     * Unique identifier for this attempt.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Ordinal value for this attempt.
     *
     * Required response field. PHP type: `int`; wire field: `ordinal` (`integer`).
     *
     * @var int
     */
    public readonly int $ordinal;

    /**
     * Review value for this attempt.
     *
     * Optional response field. PHP type: `\Inttegro\UploadRequest\Review|null`; wire field:
     * `review` (`object`).
     *
     * @var \Inttegro\UploadRequest\Review|null
     */
    public readonly ?\Inttegro\UploadRequest\Review $review;

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
     * Timestamp associated with succeeded.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `succeeded_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $succeededAt;

    /**
     * Identifier of the related upload request.
     *
     * Required response field. PHP type: `string`; wire field: `upload_request_id` (`string`).
     *
     * @var string
     */
    public readonly string $uploadRequestId;

    /**
     * Hydrates an Attempt from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->attemptedAt = \Inttegro\ValueHydrator::dateTime($data['attempted_at'] ?? null, false);
        $this->contentType = \Inttegro\ValueHydrator::string($data['content_type'] ?? null, true);
        $this->declaredSize = \Inttegro\ValueHydrator::int($data['declared_size'] ?? null, true);
        $this->error = \Inttegro\ValueHydrator::object($data['error'] ?? null, [\Inttegro\UploadRequest\LatestError::class], true);
        $this->failedAt = \Inttegro\ValueHydrator::dateTime($data['failed_at'] ?? null, true);
        $this->fileId = \Inttegro\ValueHydrator::string($data['file_id'] ?? null, true);
        $this->filename = \Inttegro\ValueHydrator::string($data['filename'] ?? null, true);
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->ordinal = \Inttegro\ValueHydrator::int($data['ordinal'] ?? null, false);
        $this->review = \Inttegro\ValueHydrator::object($data['review'] ?? null, [\Inttegro\UploadRequest\Review::class], true);
        $this->status = \Inttegro\ValueHydrator::string($data['status'] ?? null, false);
        $this->succeededAt = \Inttegro\ValueHydrator::dateTime($data['succeeded_at'] ?? null, true);
        $this->uploadRequestId = \Inttegro\ValueHydrator::string($data['upload_request_id'] ?? null, false);
    }

    /**
     * Creates an Attempt from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Attempt value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
