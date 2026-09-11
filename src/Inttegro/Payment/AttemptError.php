<?php

namespace Inttegro\Payment;


/**
 * Structured failure details reported for payment.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class AttemptError extends \Inttegro\DomainValue
{
    /**
     * Message value for this attempt error.
     *
     * Required response field. PHP type: `string`; wire field: `message` (`string`).
     *
     * @var string
     */
    public readonly string $message;

    /**
     * Hydrates an AttemptError from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->message = \Inttegro\ValueHydrator::string($data['message'] ?? null, false);
    }

    /**
     * Creates an AttemptError from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable AttemptError value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
