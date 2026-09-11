<?php

namespace Inttegro\MessageTemplate;


/**
 * SMS Content details associated with message template.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class SMSContent extends \Inttegro\DomainValue
{
    /**
     * SMS body template.
     *
     * Required response field. PHP type: `string`; wire field: `message_template` (`string`).
     *
     * @var string
     */
    public readonly string $messageTemplate;

    /**
     * Hydrates a SMSContent from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->messageTemplate = \Inttegro\ValueHydrator::string($data['message_template'] ?? null, false);
    }

    /**
     * Creates a SMSContent from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable SMSContent value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
