<?php

namespace Inttegro\Customer;

use DateTimeImmutable;

/**
 * A customer record containing contact, balance, address, and lifecycle information.
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
     * Available customer balances keyed by lowercase currency code.
     *
     * Required response field. PHP type: `array<string, \Inttegro\Customer\BalanceValue>`; wire
     * field: `balance` (`object`).
     * When the field is absent, the SDK exposes an empty collection.
     *
     * @var array<string, \Inttegro\Customer\BalanceValue>
     */
    public readonly array $balance;

    /**
     * Billing Address value for this customer.
     *
     * Optional response field. PHP type: `\Inttegro\Customer\Address|null`; wire field:
     * `billing_address` (`object`).
     *
     * @var \Inttegro\Customer\Address|null
     */
    public readonly ?\Inttegro\Customer\Address $billingAddress;

    /**
     * Time at which the value was created.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `created_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $createdAt;

    /**
     * Merchant-defined string values attached to a resource. SDKs expose this as a semantic
     * collection rather than a raw map.
     *
     * Optional response field. PHP type: `array<string, string>|null`; wire field: `custom_data`
     * (`object`).
     *
     * @var array<string, string>|null
     */
    public readonly ?array $customData;

    /**
     * Email Address value for this customer.
     *
     * Optional response field. PHP type: `string|null`; wire field: `email_address` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $emailAddress;

    /**
     * Guest value for this customer.
     *
     * Required response field. PHP type: `bool`; wire field: `guest` (`boolean`).
     *
     * @var bool
     */
    public readonly bool $guest;

    /**
     * Unique identifier for this customer.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Human-readable name.
     *
     * Required response field. PHP type: `string`; wire field: `name` (`string`).
     *
     * @var string
     */
    public readonly string $name;

    /**
     * Phone Number value for this customer.
     *
     * Optional response field. PHP type: `string|null`; wire field: `phone_number` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $phoneNumber;

    /**
     * Reference value for this customer.
     *
     * Optional response field. PHP type: `string|null`; wire field: `reference` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $reference;

    /**
     * Shipping Address value for this customer.
     *
     * Optional response field. PHP type: `\Inttegro\Customer\Address|null`; wire field:
     * `shipping_address` (`object`).
     *
     * @var \Inttegro\Customer\Address|null
     */
    public readonly ?\Inttegro\Customer\Address $shippingAddress;

    /**
     * Suffix value for this customer.
     *
     * Optional response field. PHP type: `string|null`; wire field: `suffix` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $suffix;

    /**
     * Title value for this customer.
     *
     * Optional response field. PHP type: `string|null`; wire field: `title` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $title;

    /**
     * Time at which the value was last updated.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `updated_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $updatedAt;

    /**
     * Hydrates a Customer from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->balance = \Inttegro\ValueHydrator::objectMap($data['balance'] ?? null, [\Inttegro\Customer\BalanceValue::class]);
        $this->billingAddress = \Inttegro\ValueHydrator::object($data['billing_address'] ?? null, [\Inttegro\Customer\Address::class], true);
        $this->createdAt = \Inttegro\ValueHydrator::dateTime($data['created_at'] ?? null, false);
        $this->customData = \Inttegro\ValueHydrator::array($data['custom_data'] ?? null, true);
        $this->emailAddress = \Inttegro\ValueHydrator::string($data['email_address'] ?? null, true);
        $this->guest = \Inttegro\ValueHydrator::bool($data['guest'] ?? null, false);
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->name = \Inttegro\ValueHydrator::string($data['name'] ?? null, false);
        $this->phoneNumber = \Inttegro\ValueHydrator::string($data['phone_number'] ?? null, true);
        $this->reference = \Inttegro\ValueHydrator::string($data['reference'] ?? null, true);
        $this->shippingAddress = \Inttegro\ValueHydrator::object($data['shipping_address'] ?? null, [\Inttegro\Customer\Address::class], true);
        $this->suffix = \Inttegro\ValueHydrator::string($data['suffix'] ?? null, true);
        $this->title = \Inttegro\ValueHydrator::string($data['title'] ?? null, true);
        $this->updatedAt = \Inttegro\ValueHydrator::dateTime($data['updated_at'] ?? null, true);
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
