<?php

namespace Inttegro\Payment;


/**
 * Where the funds will be paid out.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class PayoutConfigurationDestination extends \Inttegro\DomainValue
{
    /**
     * ID of the financial account receiving the payout.
     *
     * Required response field. PHP type: `string`; wire field: `financial_account_id` (`string`).
     *
     * @var string
     */
    public readonly string $financialAccountId;

    /**
     * Hydrates a PayoutConfigurationDestination from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->financialAccountId = \Inttegro\ValueHydrator::string($data['financial_account_id'] ?? null, false);
    }

    /**
     * Creates a PayoutConfigurationDestination from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable PayoutConfigurationDestination value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
