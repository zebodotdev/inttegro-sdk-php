<?php

namespace Inttegro\Payment;

use DateTimeImmutable;

/**
 * Payment Method details associated with payment.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class PaymentMethod extends \Inttegro\DomainValue
{
    /**
     * Unique identifier for this payment method.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Bank Account value for this payment method.
     *
     * Optional response field. PHP type: `\Inttegro\Payment\PaymentMethodBankAccount|null`; wire
     * field: `bank_account` (`object`).
     *
     * @var \Inttegro\Payment\PaymentMethodBankAccount|null
     */
    public readonly ?\Inttegro\Payment\PaymentMethodBankAccount $bankAccount;

    /**
     * Card marker. Nested card credentials are not returned.
     *
     * Optional response field. PHP type: `\Inttegro\PaymentMethod\Card|null`; wire field: `card`
     * (`object`).
     *
     * @var \Inttegro\PaymentMethod\Card|null
     */
    public readonly ?\Inttegro\PaymentMethod\Card $card;

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
     * Identifier of the related customer.
     *
     * Required response field. PHP type: `string`; wire field: `customer_id` (`string`).
     *
     * @var string
     */
    public readonly string $customerId;

    /**
     * Mobile Money value for this payment method.
     *
     * Optional response field. PHP type: `\Inttegro\Payment\PaymentMethodMobileMoney|null`; wire
     * field: `mobile_money` (`object`).
     *
     * @var \Inttegro\Payment\PaymentMethodMobileMoney|null
     */
    public readonly ?\Inttegro\Payment\PaymentMethodMobileMoney $mobileMoney;

    /**
     * Owner value for this payment method.
     *
     * Optional response field. PHP type: `\Inttegro\Payment\PaymentMethodOwner|null`; wire field:
     * `owner` (`object`).
     *
     * @var \Inttegro\Payment\PaymentMethodOwner|null
     */
    public readonly ?\Inttegro\Payment\PaymentMethodOwner $owner;

    /**
     * Discriminator identifying the value's API variant.
     *
     * Required response field. PHP type: `string`; wire field: `type` (`string`).
     *
     * @var string
     */
    public readonly string $type;

    /**
     * Verified value for this payment method.
     *
     * Required response field. PHP type: `bool`; wire field: `verified` (`boolean`).
     *
     * @var bool
     */
    public readonly bool $verified;

    /**
     * Timestamp associated with verified.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `verified_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $verifiedAt;

    /**
     * Hydrates a PaymentMethod from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->bankAccount = \Inttegro\ValueHydrator::object($data['bank_account'] ?? null, [\Inttegro\Payment\PaymentMethodBankAccount::class], true);
        $this->card = \Inttegro\ValueHydrator::object($data['card'] ?? null, [\Inttegro\PaymentMethod\Card::class], true);
        $this->createdAt = \Inttegro\ValueHydrator::dateTime($data['created_at'] ?? null, false);
        $this->customerId = \Inttegro\ValueHydrator::string($data['customer_id'] ?? null, false);
        $this->mobileMoney = \Inttegro\ValueHydrator::object($data['mobile_money'] ?? null, [\Inttegro\Payment\PaymentMethodMobileMoney::class], true);
        $this->owner = \Inttegro\ValueHydrator::object($data['owner'] ?? null, [\Inttegro\Payment\PaymentMethodOwner::class], true);
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
        $this->verified = \Inttegro\ValueHydrator::bool($data['verified'] ?? null, false);
        $this->verifiedAt = \Inttegro\ValueHydrator::dateTime($data['verified_at'] ?? null, true);
    }

    /**
     * Creates a PaymentMethod from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable PaymentMethod value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
