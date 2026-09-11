<?php

namespace Inttegro\MessageTemplate;


/**
 * Mailbox details associated with message template.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Mailbox extends \Inttegro\DomainValue
{
    /**
     * Literal or templated mailbox address, such as `{{recipient_email}}`.
     *
     * Required response field. PHP type: `string`; wire field: `address` (`string`).
     *
     * @var string
     */
    public readonly string $address;

    /**
     * Human-readable name.
     *
     * Optional response field. PHP type: `string|null`; wire field: `name` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $name;

    /**
     * Hydrates a Mailbox from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->address = \Inttegro\ValueHydrator::string($data['address'] ?? null, false);
        $this->name = \Inttegro\ValueHydrator::string($data['name'] ?? null, true);
    }

    /**
     * Creates a Mailbox from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Mailbox value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
