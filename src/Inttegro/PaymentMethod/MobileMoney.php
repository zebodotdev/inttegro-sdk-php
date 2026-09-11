<?php

namespace Inttegro\PaymentMethod;


/**
 * Mobile Money details associated with payment method.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class MobileMoney extends \Inttegro\DomainValue
{
    /**
     * Masked number in the form `****1234`.
     *
     * Required response field. PHP type: `string`; wire field: `account_number` (`string`).
     *
     * @var string
     */
    public readonly string $accountNumber;

    /**
     * Last4 value for this mobile money.
     *
     * Required response field. PHP type: `string`; wire field: `last4` (`string`).
     *
     * @var string
     */
    public readonly string $last4;

    /**
     * Network value for this mobile money.
     *
     * Required response field. PHP type: `string`; wire field: `network` (`string`).
     *
     * @var string
     */
    public readonly string $network;

    /**
     * Hydrates a MobileMoney from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->accountNumber = \Inttegro\ValueHydrator::string($data['account_number'] ?? null, false);
        $this->last4 = \Inttegro\ValueHydrator::string($data['last4'] ?? null, false);
        $this->network = \Inttegro\ValueHydrator::string($data['network'] ?? null, false);
    }

    /**
     * Creates a MobileMoney from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable MobileMoney value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
