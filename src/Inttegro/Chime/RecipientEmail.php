<?php

namespace Inttegro\Chime;


/**
 * Recipient Email details associated with chime.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class RecipientEmail extends \Inttegro\DomainValue
{
    /**
     * Address value for this recipient email.
     *
     * Required response field. PHP type: `string`; wire field: `address` (`string`).
     *
     * @var string
     */
    public readonly string $address;

    /**
     * Hydrates a RecipientEmail from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->address = \Inttegro\ValueHydrator::string($data['address'] ?? null, false);
    }

    /**
     * Creates a RecipientEmail from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable RecipientEmail value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
