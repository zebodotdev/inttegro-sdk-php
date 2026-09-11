<?php

namespace Inttegro\MessageTemplate;


/**
 * Preview details associated with message template.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Preview extends \Inttegro\DomainValue
{
    /**
     * Message Template value for this preview.
     *
     * Required response field. PHP type: `\Inttegro\MessageTemplate\MessageTemplate`; wire field:
     * `message_template` (`object`).
     *
     * @var \Inttegro\MessageTemplate\MessageTemplate
     */
    public readonly \Inttegro\MessageTemplate\MessageTemplate $messageTemplate;

    /**
     * Rendered value for this preview.
     *
     * Required response field. PHP type: `\Inttegro\MessageTemplate\Rendered`; wire field:
     * `rendered` (`object`).
     *
     * @var \Inttegro\MessageTemplate\Rendered
     */
    public readonly \Inttegro\MessageTemplate\Rendered $rendered;

    /**
     * Hydrates a Preview from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->messageTemplate = \Inttegro\ValueHydrator::object($data['message_template'] ?? null, [\Inttegro\MessageTemplate\MessageTemplate::class], false);
        $this->rendered = \Inttegro\ValueHydrator::object($data['rendered'] ?? null, [\Inttegro\MessageTemplate\Rendered::class], false);
    }

    /**
     * Creates a Preview from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Preview value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
