<?php

namespace Inttegro\PaymentMethod;


/**
 * Bank Account details associated with payment method.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class BankAccount extends \Inttegro\DomainValue
{
    /**
     * Ghana Bank Account value for this bank account.
     *
     * Optional response field. PHP type:
     * `\Inttegro\PaymentMethod\BankAccountGhanaBankAccount|null`; wire field: `ghana_bank_account`
     * (`object`).
     *
     * @var \Inttegro\PaymentMethod\BankAccountGhanaBankAccount|null
     */
    public readonly ?\Inttegro\PaymentMethod\BankAccountGhanaBankAccount $ghanaBankAccount;

    /**
     * Discriminator identifying the value's API variant.
     *
     * Required response field. PHP type: `string`; wire field: `type` (`string`).
     * Compare against `Type` cases by using their `->value` strings.
     *
     * @var string
     */
    public readonly string $type;

    /**
     * Hydrates a BankAccount from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->ghanaBankAccount = \Inttegro\ValueHydrator::object($data['ghana_bank_account'] ?? null, [\Inttegro\PaymentMethod\BankAccountGhanaBankAccount::class], true);
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
    }

    /**
     * Creates a BankAccount from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable BankAccount value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
