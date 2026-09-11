<?php

namespace Inttegro\Shared;


/**
 * Standard error response structure returned by all API endpoints. Provides machine-readable codes,
 * human-readable messages, and actionable guidance for resolution.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Error extends \Inttegro\DomainValue
{
    /**
     * Concise, caller-safe explanation of why the request was rejected or could not finish.
     *
     * Optional response field. PHP type: `string|null`; wire field: `message` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $message;

    /**
     * Machine-readable suggestion for how to resolve the error (e.g.,
     * "retry_with_exponential_backoff", "change_request_parameters").
     *
     * Optional response field. PHP type: `string|null`; wire field: `fix_code` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $fixCode;

    /**
     * Explanation of the relevant rule and next safe action. It never contains raw dependency,
     * storage, or implementation errors.
     *
     * Optional response field. PHP type: `string|null`; wire field: `detail` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $detail;

    /**
     * Stable category describing the reason for failure, such as invalid input, an unmet
     * precondition, or a state conflict.
     *
     * Optional response field. PHP type: `string|null`; wire field: `cause` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $cause;

    /**
     * Broad error category to help clients determine retry strategies (e.g.,
     * "invalid_request_parameter", "transient_error").
     *
     * Required response field. PHP type: `string`; wire field: `type` (`string`).
     *
     * @var string
     */
    public readonly string $type;

    /**
     * Unique machine-readable identifier for this specific error condition. Unlike type and cause
     * which group errors, code pinpoints the exact problem.
     *
     * Required response field. PHP type: `string`; wire field: `code` (`string`).
     *
     * @var string
     */
    public readonly string $code;

    /**
     * Link to error reference documentation with detailed explanation, common causes, and
     * resolution guidance.
     *
     * Required response field. PHP type: `string`; wire field: `url` (`string`).
     *
     * @var string
     */
    public readonly string $url;

    /**
     * Hydrates an Error from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->message = \Inttegro\ValueHydrator::string($data['message'] ?? null, true);
        $this->fixCode = \Inttegro\ValueHydrator::string($data['fix_code'] ?? null, true);
        $this->detail = \Inttegro\ValueHydrator::string($data['detail'] ?? null, true);
        $this->cause = \Inttegro\ValueHydrator::string($data['cause'] ?? null, true);
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
        $this->code = \Inttegro\ValueHydrator::string($data['code'] ?? null, false);
        $this->url = \Inttegro\ValueHydrator::string($data['url'] ?? null, false);
    }

    /**
     * Creates an Error from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Error value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
