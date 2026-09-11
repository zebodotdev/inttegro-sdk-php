<?php

namespace Inttegro\Shared;


/**
 * Upload Fulfillment details associated with shared.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class UploadFulfillment extends \Inttegro\DomainValue
{
    /**
     * Upload Request value for this upload fulfillment.
     *
     * Required response field. PHP type: `\Inttegro\UploadRequest\UploadRequest`; wire field:
     * `upload_request` (`object`).
     *
     * @var \Inttegro\UploadRequest\UploadRequest
     */
    public readonly \Inttegro\UploadRequest\UploadRequest $uploadRequest;

    /**
     * File value for this upload fulfillment.
     *
     * Required response field. PHP type: `\Inttegro\File\UploadReceipt`; wire field: `file`
     * (`object`).
     *
     * @var \Inttegro\File\UploadReceipt
     */
    public readonly \Inttegro\File\UploadReceipt $file;

    /**
     * Hydrates an UploadFulfillment from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->uploadRequest = \Inttegro\ValueHydrator::object($data['upload_request'] ?? null, [\Inttegro\UploadRequest\UploadRequest::class], false);
        $this->file = \Inttegro\ValueHydrator::object($data['file'] ?? null, [\Inttegro\File\UploadReceipt::class], false);
    }

    /**
     * Creates an UploadFulfillment from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable UploadFulfillment value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
