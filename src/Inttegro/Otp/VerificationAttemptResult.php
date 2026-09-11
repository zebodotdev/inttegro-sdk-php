<?php

namespace Inttegro\Otp;


/**
 * Verification Attempt Result details associated with otp.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class VerificationAttemptResult extends \Inttegro\DomainValue
{
    /**
     * Omitted when no detail is available.
     *
     * Optional response field. PHP type: `string|null`; wire field: `detail` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $detail;

    /**
     * Verdict value for this verification attempt result.
     *
     * Required response field. PHP type: `string`; wire field: `verdict` (`string`).
     *
     * @var string
     */
    public readonly string $verdict;

    /**
     * Hydrates a VerificationAttemptResult from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->detail = \Inttegro\ValueHydrator::string($data['detail'] ?? null, true);
        $this->verdict = \Inttegro\ValueHydrator::string($data['verdict'] ?? null, false);
    }

    /**
     * Creates a VerificationAttemptResult from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable VerificationAttemptResult value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
