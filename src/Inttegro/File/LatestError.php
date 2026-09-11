<?php

namespace Inttegro\File;

use DateTimeImmutable;

/**
 * Structured failure details reported for file.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class LatestError extends \Inttegro\DomainValue
{
    /**
     * Code value for this latest error.
     *
     * Optional response field. PHP type: `string|null`; wire field: `code` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $code;

    /**
     * Message value for this latest error.
     *
     * Optional response field. PHP type: `string|null`; wire field: `message` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $message;

    /**
     * Retryable value for this latest error.
     *
     * Optional response field. PHP type: `bool|null`; wire field: `retryable` (`boolean`).
     *
     * @var bool|null
     */
    public readonly ?bool $retryable;

    /**
     * At value for this latest error.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $at;

    /**
     * Hydrates a LatestError from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->code = \Inttegro\ValueHydrator::string($data['code'] ?? null, true);
        $this->message = \Inttegro\ValueHydrator::string($data['message'] ?? null, true);
        $this->retryable = \Inttegro\ValueHydrator::bool($data['retryable'] ?? null, true);
        $this->at = \Inttegro\ValueHydrator::dateTime($data['at'] ?? null, true);
    }

    /**
     * Creates a LatestError from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable LatestError value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
