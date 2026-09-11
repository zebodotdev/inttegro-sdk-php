<?php

namespace Inttegro\Chime;


/**
 * Recipient information in response.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Recipient extends \Inttegro\DomainValue
{
    /**
     * Contact type.
     *
     * Required response field. PHP type: `string`; wire field: `type` (`string`).
     *
     * @var string
     */
    public readonly string $type;

    /**
     * Recipient name.
     *
     * Optional response field. PHP type: `string|null`; wire field: `name` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $name;

    /**
     * Phone value for this recipient.
     *
     * Optional response field. PHP type: `\Inttegro\Chime\RecipientPhone|null`; wire field: `phone`
     * (`object`).
     *
     * @var \Inttegro\Chime\RecipientPhone|null
     */
    public readonly ?\Inttegro\Chime\RecipientPhone $phone;

    /**
     * Email value for this recipient.
     *
     * Optional response field. PHP type: `\Inttegro\Chime\RecipientEmail|null`; wire field: `email`
     * (`object`).
     *
     * @var \Inttegro\Chime\RecipientEmail|null
     */
    public readonly ?\Inttegro\Chime\RecipientEmail $email;

    /**
     * Hydrates a Recipient from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
        $this->name = \Inttegro\ValueHydrator::string($data['name'] ?? null, true);
        $this->phone = \Inttegro\ValueHydrator::object($data['phone'] ?? null, [\Inttegro\Chime\RecipientPhone::class], true);
        $this->email = \Inttegro\ValueHydrator::object($data['email'] ?? null, [\Inttegro\Chime\RecipientEmail::class], true);
    }

    /**
     * Creates a Recipient from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Recipient value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
