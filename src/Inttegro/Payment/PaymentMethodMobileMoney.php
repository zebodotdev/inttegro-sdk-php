<?php

namespace Inttegro\Payment;


/**
 * Payment Method Mobile Money details associated with payment.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class PaymentMethodMobileMoney extends \Inttegro\DomainValue
{
    /**
     * Network value for this payment method mobile money.
     *
     * Required response field. PHP type: `string`; wire field: `network` (`string`).
     *
     * @var string
     */
    public readonly string $network;

    /**
     * Masked number in the form `****1234`.
     *
     * Required response field. PHP type: `string`; wire field: `account_number` (`string`).
     *
     * @var string
     */
    public readonly string $accountNumber;

    /**
     * Last4 value for this payment method mobile money.
     *
     * Required response field. PHP type: `string`; wire field: `last4` (`string`).
     *
     * @var string
     */
    public readonly string $last4;

    /**
     * Hydrates a PaymentMethodMobileMoney from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->network = \Inttegro\ValueHydrator::string($data['network'] ?? null, false);
        $this->accountNumber = \Inttegro\ValueHydrator::string($data['account_number'] ?? null, false);
        $this->last4 = \Inttegro\ValueHydrator::string($data['last4'] ?? null, false);
    }

    /**
     * Creates a PaymentMethodMobileMoney from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable PaymentMethodMobileMoney value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
