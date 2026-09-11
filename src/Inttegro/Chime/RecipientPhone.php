<?php

namespace Inttegro\Chime;


/**
 * Recipient Phone details associated with chime.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class RecipientPhone extends \Inttegro\DomainValue
{
    /**
     * Page or business reference number, as defined by the containing value.
     *
     * Required response field. PHP type: `string`; wire field: `number` (`string`).
     *
     * @var string
     */
    public readonly string $number;

    /**
     * Hydrates a RecipientPhone from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->number = \Inttegro\ValueHydrator::string($data['number'] ?? null, false);
    }

    /**
     * Creates a RecipientPhone from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable RecipientPhone value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
