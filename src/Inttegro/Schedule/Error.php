<?php

namespace Inttegro\Schedule;


/**
 * Error encountered when scheduling a chime for a specific recipient.
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
     * Recipient address that caused the error.
     *
     * Optional response field. PHP type: `string|null`; wire field: `recipient` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $recipient;

    /**
     * Code indicating how to fix this error.
     *
     * Optional response field. PHP type: `string|null`; wire field: `fix_code` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $fixCode;

    /**
     * Error type classification.
     *
     * Optional response field. PHP type: `string|null`; wire field: `type` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $type;

    /**
     * Hydrates an Error from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->recipient = \Inttegro\ValueHydrator::string($data['recipient'] ?? null, true);
        $this->fixCode = \Inttegro\ValueHydrator::string($data['fix_code'] ?? null, true);
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, true);
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
