<?php

namespace Inttegro\PaymentMethod;

use DateTimeImmutable;

/**
 * A tokenized payment instrument tied to a customer, with typed instrument and verification
 * details.
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
     * Whether this payment method is active and reusable in new payment flows.
     *
     * Required response field. PHP type: `bool`; wire field: `active` (`boolean`).
     *
     * @var bool
     */
    public readonly bool $active;

    /**
     * Timestamp when the payment method was archived. Omitted while unarchived.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `archived_at`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $archivedAt;

    /**
     * Bank account details (present when type is bank_account).
     *
     * Optional response field. PHP type: `\Inttegro\PaymentMethod\BankAccount|null`; wire field:
     * `bank_account` (`object`).
     *
     * @var \Inttegro\PaymentMethod\BankAccount|null
     */
    public readonly ?\Inttegro\PaymentMethod\BankAccount $bankAccount;

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
     * When this payment method was tokenized.
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
     * Customer who owns this payment method.
     *
     * Required response field. PHP type: `string`; wire field: `customer_id` (`string`).
     *
     * @var string
     */
    public readonly string $customerId;

    /**
     * Whether the method is limited to its originating flow and cannot be reused.
     *
     * Optional response field. PHP type: `bool|null`; wire field: `ephemeral` (`boolean`).
     *
     * @var bool|null
     */
    public readonly ?bool $ephemeral;

    /**
     * When this payment method expires. Omitted when no expiry is available.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `expires_on`
     * (`ISO-8601 string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $expiresOn;

    /**
     * Unique identifier for this payment method.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Masked mobile-money wallet details (present when type is mobile_money).
     *
     * Optional response field. PHP type: `\Inttegro\PaymentMethod\MobileMoney|null`; wire field:
     * `mobile_money` (`object`).
     *
     * @var \Inttegro\PaymentMethod\MobileMoney|null
     */
    public readonly ?\Inttegro\PaymentMethod\MobileMoney $mobileMoney;

    /**
     * Owner identity captured during tokenization when provided.
     *
     * Optional response field. PHP type: `\Inttegro\PaymentMethod\Owner|null`; wire field: `owner`
     * (`object`).
     *
     * @var \Inttegro\PaymentMethod\Owner|null
     */
    public readonly ?\Inttegro\PaymentMethod\Owner $owner;

    /**
     * Payment rail type.
     *
     * Required response field. PHP type: `string`; wire field: `type` (`string`).
     * Compare against `Type` cases by using their `->value` strings.
     *
     * @var string
     */
    public readonly string $type;

    /**
     * Public provenance for how the payment method was supplied.
     *
     * Optional response field. PHP type: `\Inttegro\PaymentMethod\Supplied|null`; wire field:
     * `supplied` (`object`).
     *
     * @var \Inttegro\PaymentMethod\Supplied|null
     */
    public readonly ?\Inttegro\PaymentMethod\Supplied $supplied;

    /**
     * Most recent verification record when the payment method has entered a verification flow.
     *
     * Optional response field. PHP type: `\Inttegro\PaymentMethod\Verification|null`; wire field:
     * `verification` (`object`).
     *
     * @var \Inttegro\PaymentMethod\Verification|null
     */
    public readonly ?\Inttegro\PaymentMethod\Verification $verification;

    /**
     * When ownership verification was completed.
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
        $this->active = \Inttegro\ValueHydrator::bool($data['active'] ?? null, false);
        $this->archivedAt = \Inttegro\ValueHydrator::dateTime($data['archived_at'] ?? null, true);
        $this->bankAccount = \Inttegro\ValueHydrator::object($data['bank_account'] ?? null, [\Inttegro\PaymentMethod\BankAccount::class], true);
        $this->card = \Inttegro\ValueHydrator::object($data['card'] ?? null, [\Inttegro\PaymentMethod\Card::class], true);
        $this->createdAt = \Inttegro\ValueHydrator::dateTime($data['created_at'] ?? null, false);
        $this->customData = \Inttegro\ValueHydrator::array($data['custom_data'] ?? null, true);
        $this->customerId = \Inttegro\ValueHydrator::string($data['customer_id'] ?? null, false);
        $this->ephemeral = \Inttegro\ValueHydrator::bool($data['ephemeral'] ?? null, true);
        $this->expiresOn = \Inttegro\ValueHydrator::dateTime($data['expires_on'] ?? null, true);
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->mobileMoney = \Inttegro\ValueHydrator::object($data['mobile_money'] ?? null, [\Inttegro\PaymentMethod\MobileMoney::class], true);
        $this->owner = \Inttegro\ValueHydrator::object($data['owner'] ?? null, [\Inttegro\PaymentMethod\Owner::class], true);
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
        $this->supplied = \Inttegro\ValueHydrator::object($data['supplied'] ?? null, [\Inttegro\PaymentMethod\Supplied::class], true);
        $this->verification = \Inttegro\ValueHydrator::object($data['verification'] ?? null, [\Inttegro\PaymentMethod\Verification::class], true);
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

    /**
     * Reports whether the resource has been archived.
     */
    public function isArchived(): bool
    {
        return $this->archivedAt !== null;
    }

    /**
     * Reports whether verification has completed.
     */
    public function isVerified(): bool
    {
        return $this->verifiedAt !== null;
    }

    /**
     * Reports whether the payment method is active, non-ephemeral, and not archived.
     */
    public function isReusable(): bool
    {
        return $this->active && !$this->isArchived() && $this->ephemeral !== true;
    }
}
