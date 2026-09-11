<?php

namespace Inttegro\UploadRequest;


/**
 * Review Reason details associated with upload request.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class ReviewReason extends \Inttegro\DomainValue
{
    /**
     * Code value for this review reason.
     *
     * Required response field. PHP type: `string`; wire field: `code` (`string`).
     *
     * @var string
     */
    public readonly string $code;

    /**
     * Message value for this review reason.
     *
     * Required response field. PHP type: `string`; wire field: `message` (`string`).
     *
     * @var string
     */
    public readonly string $message;

    /**
     * Param value for this review reason.
     *
     * Optional response field. PHP type: `string|null`; wire field: `param` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $param;

    /**
     * Hydrates a ReviewReason from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->code = \Inttegro\ValueHydrator::string($data['code'] ?? null, false);
        $this->message = \Inttegro\ValueHydrator::string($data['message'] ?? null, false);
        $this->param = \Inttegro\ValueHydrator::string($data['param'] ?? null, true);
    }

    /**
     * Creates a ReviewReason from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable ReviewReason value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
