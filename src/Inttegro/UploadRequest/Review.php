<?php

namespace Inttegro\UploadRequest;

use DateTimeImmutable;

/**
 * Review details associated with upload request.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Review extends \Inttegro\DomainValue
{
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
     * Decision value for this review.
     *
     * Required response field. PHP type: `string`; wire field: `decision` (`string`).
     *
     * @var string
     */
    public readonly string $decision;

    /**
     * Identifier of the related file.
     *
     * Optional response field. PHP type: `string|null`; wire field: `file_id` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $fileId;

    /**
     * Public Message value for this review.
     *
     * Optional response field. PHP type: `string|null`; wire field: `public_message` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $publicMessage;

    /**
     * Reasons value for this review.
     *
     * Optional response field. PHP type: `list<\Inttegro\UploadRequest\ReviewReason>|null`; wire
     * field: `reasons` (`array<object>`).
     * When the field is absent, the SDK exposes an empty collection.
     *
     * @var list<\Inttegro\UploadRequest\ReviewReason>|null
     */
    public readonly ?array $reasons;

    /**
     * Timestamp associated with reviewed.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `reviewed_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $reviewedAt;

    /**
     * Discriminator identifying the value's API variant.
     *
     * Required response field. PHP type: `string`; wire field: `type` (`string`).
     *
     * @var string
     */
    public readonly string $type;

    /**
     * Hydrates a Review from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->createdAt = \Inttegro\ValueHydrator::dateTime($data['created_at'] ?? null, false);
        $this->decision = \Inttegro\ValueHydrator::string($data['decision'] ?? null, false);
        $this->fileId = \Inttegro\ValueHydrator::string($data['file_id'] ?? null, true);
        $this->publicMessage = \Inttegro\ValueHydrator::string($data['public_message'] ?? null, true);
        $this->reasons = \Inttegro\ValueHydrator::objects($data['reasons'] ?? null, [\Inttegro\UploadRequest\ReviewReason::class]);
        $this->reviewedAt = \Inttegro\ValueHydrator::dateTime($data['reviewed_at'] ?? null, false);
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
    }

    /**
     * Creates a Review from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Review value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
