<?php

namespace Inttegro\Chime;


/**
 * Schema.org JSON-LD markup generated at email send time.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class EmailSchemaMarkup extends \Inttegro\DomainValue
{
    /**
     * Classification for the generated markup.
     *
     * Optional response field. PHP type: `string|null`; wire field: `kind` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $kind;

    /**
     * Deliberately extensible JSON object whose keys and values are defined by the selected
     * integration or resource subtype.
     *
     * Optional response field. PHP type: `array<string, mixed>|null`; wire field: `json_ld`
     * (`object`).
     *
     * @var array<string, mixed>|null
     */
    public readonly ?array $jsonLd;

    /**
     * Hydrates an EmailSchemaMarkup from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->kind = \Inttegro\ValueHydrator::string($data['kind'] ?? null, true);
        $this->jsonLd = \Inttegro\ValueHydrator::array($data['json_ld'] ?? null, true);
    }

    /**
     * Creates an EmailSchemaMarkup from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable EmailSchemaMarkup value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
