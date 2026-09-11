<?php

namespace Inttegro\Chime;


/**
 * Email Mailbox details associated with chime.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class EmailMailbox extends \Inttegro\DomainValue
{
    /**
     * Optional display name.
     *
     * Optional response field. PHP type: `string|null`; wire field: `name` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $name;

    /**
     * Email address.
     *
     * Optional response field. PHP type: `string|null`; wire field: `address` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $address;

    /**
     * Hydrates an EmailMailbox from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->name = \Inttegro\ValueHydrator::string($data['name'] ?? null, true);
        $this->address = \Inttegro\ValueHydrator::string($data['address'] ?? null, true);
    }

    /**
     * Creates an EmailMailbox from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable EmailMailbox value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
