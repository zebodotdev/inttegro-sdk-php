<?php

namespace Inttegro\FinancialAccount;


/**
 * Financial Institution Mobile Money Provider details associated with financial account.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class FinancialInstitutionMobileMoneyProvider extends \Inttegro\DomainValue
{
    /**
     * Provider value for this financial institution mobile money provider.
     *
     * Required response field. PHP type: `string`; wire field: `provider` (`string`).
     *
     * @var string
     */
    public readonly string $provider;

    /**
     * Hydrates a FinancialInstitutionMobileMoneyProvider from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->provider = \Inttegro\ValueHydrator::string($data['provider'] ?? null, false);
    }

    /**
     * Creates a FinancialInstitutionMobileMoneyProvider from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable FinancialInstitutionMobileMoneyProvider value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
