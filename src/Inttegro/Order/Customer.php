<?php

namespace Inttegro\Order;


/**
 * Customer details associated with order.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Customer extends \Inttegro\DomainValue
{
    /**
     * Unique identifier for this customer.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Guest value for this customer.
     *
     * Required response field. PHP type: `bool`; wire field: `guest` (`boolean`).
     *
     * @var bool
     */
    public readonly bool $guest;

    /**
     * Human-readable name.
     *
     * Required response field. PHP type: `string`; wire field: `name` (`string`).
     *
     * @var string
     */
    public readonly string $name;

    /**
     * Email Address value for this customer.
     *
     * Optional response field. PHP type: `string|null`; wire field: `email_address` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $emailAddress;

    /**
     * Phone Number value for this customer.
     *
     * Optional response field. PHP type: `string|null`; wire field: `phone_number` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $phoneNumber;

    /**
     * Billing Address value for this customer.
     *
     * Optional response field. PHP type: `\Inttegro\Order\Address|null`; wire field:
     * `billing_address` (`object`).
     *
     * @var \Inttegro\Order\Address|null
     */
    public readonly ?\Inttegro\Order\Address $billingAddress;

    /**
     * Shipping Address value for this customer.
     *
     * Optional response field. PHP type: `\Inttegro\Order\Address|null`; wire field:
     * `shipping_address` (`object`).
     *
     * @var \Inttegro\Order\Address|null
     */
    public readonly ?\Inttegro\Order\Address $shippingAddress;

    /**
     * Hydrates a Customer from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->guest = \Inttegro\ValueHydrator::bool($data['guest'] ?? null, false);
        $this->name = \Inttegro\ValueHydrator::string($data['name'] ?? null, false);
        $this->emailAddress = \Inttegro\ValueHydrator::string($data['email_address'] ?? null, true);
        $this->phoneNumber = \Inttegro\ValueHydrator::string($data['phone_number'] ?? null, true);
        $this->billingAddress = \Inttegro\ValueHydrator::object($data['billing_address'] ?? null, [\Inttegro\Order\Address::class], true);
        $this->shippingAddress = \Inttegro\ValueHydrator::object($data['shipping_address'] ?? null, [\Inttegro\Order\Address::class], true);
    }

    /**
     * Creates a Customer from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Customer value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
