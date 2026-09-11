<?php

namespace Inttegro\File;


/**
 * Party details associated with file.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Party extends \Inttegro\DomainValue
{
    /**
     * Discriminator identifying the value's API variant.
     *
     * Optional response field. PHP type: `string|null`; wire field: `type` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $type;

    /**
     * Unique identifier for this party.
     *
     * Optional response field. PHP type: `string|null`; wire field: `id` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $id;

    /**
     * Human-readable name.
     *
     * Optional response field. PHP type: `string|null`; wire field: `name` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $name;

    /**
     * Email value for this party.
     *
     * Optional response field. PHP type: `string|null`; wire field: `email` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $email;

    /**
     * Hydrates a Party from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, true);
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, true);
        $this->name = \Inttegro\ValueHydrator::string($data['name'] ?? null, true);
        $this->email = \Inttegro\ValueHydrator::string($data['email'] ?? null, true);
    }

    /**
     * Creates a Party from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Party value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
