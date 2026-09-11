<?php

namespace Inttegro\MessageTemplate;


/**
 * Rendered SMS details associated with message template.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class RenderedSMS extends \Inttegro\DomainValue
{
    /**
     * Full Message value for this rendered sms.
     *
     * Required response field. PHP type: `string`; wire field: `full_message` (`string`).
     *
     * @var string
     */
    public readonly string $fullMessage;

    /**
     * Hydrates a RenderedSMS from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->fullMessage = \Inttegro\ValueHydrator::string($data['full_message'] ?? null, false);
    }

    /**
     * Creates a RenderedSMS from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable RenderedSMS value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
