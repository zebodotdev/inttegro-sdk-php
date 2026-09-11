<?php

namespace Inttegro\PaymentMethod;


/**
 * Owner details to patch onto the payment method.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Owner extends \Inttegro\DomainValue
{
    /**
     * Postal address for the payment method owner.
     *
     * Optional response field. PHP type: `\Inttegro\PaymentMethod\OwnerAddress|null`; wire field:
     * `address` (`object`).
     *
     * @var \Inttegro\PaymentMethod\OwnerAddress|null
     */
    public readonly ?\Inttegro\PaymentMethod\OwnerAddress $address;

    /**
     * Full legal name of the account holder.
     *
     * Required response field. PHP type: `string`; wire field: `name` (`string`).
     *
     * @var string
     */
    public readonly string $name;

    /**
     * Hydrates an Owner from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->address = \Inttegro\ValueHydrator::object($data['address'] ?? null, [\Inttegro\PaymentMethod\OwnerAddress::class], true);
        $this->name = \Inttegro\ValueHydrator::string($data['name'] ?? null, false);
    }

    /**
     * Creates an Owner from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Owner value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
