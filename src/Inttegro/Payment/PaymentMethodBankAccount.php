<?php

namespace Inttegro\Payment;


/**
 * Payment Method Bank Account details associated with payment.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class PaymentMethodBankAccount extends \Inttegro\DomainValue
{
    /**
     * Discriminator identifying the value's API variant.
     *
     * Required response field. PHP type: `string`; wire field: `type` (`string`).
     *
     * @var string
     */
    public readonly string $type;

    /**
     * Ghana Bank Account value for this payment method bank account.
     *
     * Optional response field. PHP type: `\Inttegro\Payment\PaymentMethodGhanaBankAccount|null`;
     * wire field: `ghana_bank_account` (`object`).
     *
     * @var \Inttegro\Payment\PaymentMethodGhanaBankAccount|null
     */
    public readonly ?\Inttegro\Payment\PaymentMethodGhanaBankAccount $ghanaBankAccount;

    /**
     * Hydrates a PaymentMethodBankAccount from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
        $this->ghanaBankAccount = \Inttegro\ValueHydrator::object($data['ghana_bank_account'] ?? null, [\Inttegro\Payment\PaymentMethodGhanaBankAccount::class], true);
    }

    /**
     * Creates a PaymentMethodBankAccount from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable PaymentMethodBankAccount value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
