<?php

namespace Inttegro\UploadRequest;

use DateTimeImmutable;

/**
 * A public upload request, including its constraints, attempts, review state, and expiration.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class UploadRequest extends \Inttegro\DomainValue
{
    /**
     * Unique identifier for this upload request.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Purpose value for this upload request.
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
     * Identifier of the related file.
     *
     * Optional response field. PHP type: `string|null`; wire field: `file_id` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $fileId;

    /**
     * Public capability URL returned when available. Treat as bearer-secret material.
     *
     * Optional response field. PHP type: `string|null`; wire field: `upload_url` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $uploadUrl;

    /**
     * Constraints value for this upload request.
     *
     * Required response field. PHP type: `\Inttegro\UploadRequest\Constraints`; wire field:
     * `constraints` (`object`).
     *
     * @var \Inttegro\UploadRequest\Constraints
     */
    public readonly \Inttegro\UploadRequest\Constraints $constraints;

    /**
     * Display value for this upload request.
     *
     * Required response field. PHP type: `\Inttegro\UploadRequest\Display`; wire field: `display`
     * (`object`).
     *
     * @var \Inttegro\UploadRequest\Display
     */
    public readonly \Inttegro\UploadRequest\Display $display;

    /**
     * Subject value for this upload request.
     *
     * Required response field. PHP type: `\Inttegro\File\Party`; wire field: `subject` (`object`).
     *
     * @var \Inttegro\File\Party
     */
    public readonly \Inttegro\File\Party $subject;

    /**
     * Recipient value for this upload request.
     *
     * Required response field. PHP type: `\Inttegro\File\Party`; wire field: `recipient`
     * (`object`).
     *
     * @var \Inttegro\File\Party
     */
    public readonly \Inttegro\File\Party $recipient;

    /**
     * Resource value for this upload request.
     *
     * Required response field. PHP type: `\Inttegro\File\Resource`; wire field: `resource`
     * (`object`).
     *
     * @var \Inttegro\File\Resource
     */
    public readonly \Inttegro\File\Resource $resource;

    /**
     * Requester value for this upload request.
     *
     * Required response field. PHP type: `\Inttegro\UploadRequest\Actor`; wire field: `requester`
     * (`object`).
     *
     * @var \Inttegro\UploadRequest\Actor
     */
    public readonly \Inttegro\UploadRequest\Actor $requester;

    /**
     * Attempts value for this upload request.
     *
     * Required response field. PHP type: `\Inttegro\UploadRequest\Attempts`; wire field: `attempts`
     * (`object`).
     *
     * @var \Inttegro\UploadRequest\Attempts
     */
    public readonly \Inttegro\UploadRequest\Attempts $attempts;

    /**
     * Latest Error value for this upload request.
     *
     * Optional response field. PHP type: `\Inttegro\UploadRequest\LatestError|null`; wire field:
     * `latest_error` (`object`).
     *
     * @var \Inttegro\UploadRequest\LatestError|null
     */
    public readonly ?\Inttegro\UploadRequest\LatestError $latestError;

    /**
     * Canceled By value for this upload request.
     *
     * Optional response field. PHP type: `\Inttegro\UploadRequest\Actor|null`; wire field:
     * `canceled_by` (`object`).
     *
     * @var \Inttegro\UploadRequest\Actor|null
     */
    public readonly ?\Inttegro\UploadRequest\Actor $canceledBy;

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
     * Timestamp associated with uploading.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `uploading_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $uploadingAt;

    /**
     * Timestamp associated with fulfilled.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `fulfilled_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $fulfilledAt;

    /**
     * Time at which the value expired.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `expired_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $expiredAt;

    /**
     * Time at which the operation was canceled.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `canceled_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $canceledAt;

    /**
     * Attempt value for this upload request.
     *
     * Optional response field. PHP type: `\Inttegro\UploadRequest\Attempt|null`; wire field:
     * `attempt` (`object`).
     *
     * @var \Inttegro\UploadRequest\Attempt|null
     */
    public readonly ?\Inttegro\UploadRequest\Attempt $attempt;

    /**
     * Hydrates an UploadRequest from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->purpose = \Inttegro\ValueHydrator::string($data['purpose'] ?? null, false);
        $this->status = \Inttegro\ValueHydrator::string($data['status'] ?? null, false);
        $this->active = \Inttegro\ValueHydrator::bool($data['active'] ?? null, false);
        $this->fileId = \Inttegro\ValueHydrator::string($data['file_id'] ?? null, true);
        $this->uploadUrl = \Inttegro\ValueHydrator::string($data['upload_url'] ?? null, true);
        $this->constraints = \Inttegro\ValueHydrator::object($data['constraints'] ?? null, [\Inttegro\UploadRequest\Constraints::class], false);
        $this->display = \Inttegro\ValueHydrator::object($data['display'] ?? null, [\Inttegro\UploadRequest\Display::class], false);
        $this->subject = \Inttegro\ValueHydrator::object($data['subject'] ?? null, [\Inttegro\File\Party::class], false);
        $this->recipient = \Inttegro\ValueHydrator::object($data['recipient'] ?? null, [\Inttegro\File\Party::class], false);
        $this->resource = \Inttegro\ValueHydrator::object($data['resource'] ?? null, [\Inttegro\File\Resource::class], false);
        $this->requester = \Inttegro\ValueHydrator::object($data['requester'] ?? null, [\Inttegro\UploadRequest\Actor::class], false);
        $this->attempts = \Inttegro\ValueHydrator::object($data['attempts'] ?? null, [\Inttegro\UploadRequest\Attempts::class], false);
        $this->latestError = \Inttegro\ValueHydrator::object($data['latest_error'] ?? null, [\Inttegro\UploadRequest\LatestError::class], true);
        $this->canceledBy = \Inttegro\ValueHydrator::object($data['canceled_by'] ?? null, [\Inttegro\UploadRequest\Actor::class], true);
        $this->customData = \Inttegro\ValueHydrator::array($data['custom_data'] ?? null, true);
        $this->metadata = \Inttegro\ValueHydrator::array($data['metadata'] ?? null, true);
        $this->createdAt = \Inttegro\ValueHydrator::dateTime($data['created_at'] ?? null, false);
        $this->updatedAt = \Inttegro\ValueHydrator::dateTime($data['updated_at'] ?? null, false);
        $this->expiresAt = \Inttegro\ValueHydrator::dateTime($data['expires_at'] ?? null, false);
        $this->uploadingAt = \Inttegro\ValueHydrator::dateTime($data['uploading_at'] ?? null, true);
        $this->fulfilledAt = \Inttegro\ValueHydrator::dateTime($data['fulfilled_at'] ?? null, true);
        $this->expiredAt = \Inttegro\ValueHydrator::dateTime($data['expired_at'] ?? null, true);
        $this->canceledAt = \Inttegro\ValueHydrator::dateTime($data['canceled_at'] ?? null, true);
        $this->attempt = \Inttegro\ValueHydrator::object($data['attempt'] ?? null, [\Inttegro\UploadRequest\Attempt::class], true);
    }

    /**
     * Creates an UploadRequest from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable UploadRequest value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
