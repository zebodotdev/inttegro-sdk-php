<?php

namespace Inttegro\Payment;


/**
 * Owner identity associated with payment.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class PaymentMethodOwner extends \Inttegro\DomainValue
{
    /**
     * Payment method owner's name.
     *
     * Required response field. PHP type: `string`; wire field: `name` (`string`).
     *
     * @var string
     */
    public readonly string $name;

    /**
     * Address value for this payment method owner.
     *
     * Optional response field. PHP type: `\Inttegro\Order\Address|null`; wire field: `address`
     * (`object`).
     *
     * @var \Inttegro\Order\Address|null
     */
    public readonly ?\Inttegro\Order\Address $address;

    /**
     * Hydrates a PaymentMethodOwner from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->name = \Inttegro\ValueHydrator::string($data['name'] ?? null, false);
        $this->address = \Inttegro\ValueHydrator::object($data['address'] ?? null, [\Inttegro\Order\Address::class], true);
    }

    /**
     * Creates a PaymentMethodOwner from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable PaymentMethodOwner value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
