<?php

namespace Inttegro\Payment;


/**
 * Payment Method Ghana Bank Account details associated with payment.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class PaymentMethodGhanaBankAccount extends \Inttegro\DomainValue
{
    /**
     * Account Number value for this payment method ghana bank account.
     *
     * Required response field. PHP type: `string`; wire field: `account_number` (`string`).
     *
     * @var string
     */
    public readonly string $accountNumber;

    /**
     * Branch value for this payment method ghana bank account.
     *
     * Optional response field. PHP type: `string|null`; wire field: `branch` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $branch;

    /**
     * Human-readable name.
     *
     * Optional response field. PHP type: `string|null`; wire field: `name` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $name;

    /**
     * Sort Code value for this payment method ghana bank account.
     *
     * Optional response field. PHP type: `string|null`; wire field: `sort_code` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $sortCode;

    /**
     * Swift Code value for this payment method ghana bank account.
     *
     * Optional response field. PHP type: `string|null`; wire field: `swift_code` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $swiftCode;

    /**
     * Hydrates a PaymentMethodGhanaBankAccount from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->accountNumber = \Inttegro\ValueHydrator::string($data['account_number'] ?? null, false);
        $this->branch = \Inttegro\ValueHydrator::string($data['branch'] ?? null, true);
        $this->name = \Inttegro\ValueHydrator::string($data['name'] ?? null, true);
        $this->sortCode = \Inttegro\ValueHydrator::string($data['sort_code'] ?? null, true);
        $this->swiftCode = \Inttegro\ValueHydrator::string($data['swift_code'] ?? null, true);
    }

    /**
     * Creates a PaymentMethodGhanaBankAccount from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable PaymentMethodGhanaBankAccount value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
