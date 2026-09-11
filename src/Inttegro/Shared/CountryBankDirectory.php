<?php

namespace Inttegro\Shared;


/**
 * Bank reference data available for country-specific bank accounts.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class CountryBankDirectory extends \Inttegro\DomainValue
{
    /**
     * Country-specific bank account subtype used by financial account APIs.
     *
     * Required response field. PHP type: `string`; wire field: `bank_account_type` (`string`).
     *
     * @var string
     */
    public readonly string $bankAccountType;

    /**
     * Identifier scheme used for bank branch codes.
     *
     * Required response field. PHP type: `string`; wire field: `code_scheme` (`string`).
     *
     * @var string
     */
    public readonly string $codeScheme;

    /**
     * Banking institutions available in this country.
     *
     * Required response field. PHP type: `list<\Inttegro\Shared\CountryBank>`; wire field: `items`
     * (`array<object>`).
     * When the field is absent, the SDK exposes an empty collection.
     *
     * @var list<\Inttegro\Shared\CountryBank>
     */
    public readonly array $items;

    /**
     * Hydrates a CountryBankDirectory from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->bankAccountType = \Inttegro\ValueHydrator::string($data['bank_account_type'] ?? null, false);
        $this->codeScheme = \Inttegro\ValueHydrator::string($data['code_scheme'] ?? null, false);
        $this->items = \Inttegro\ValueHydrator::objects($data['items'] ?? null, [\Inttegro\Shared\CountryBank::class]);
    }

    /**
     * Creates a CountryBankDirectory from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable CountryBankDirectory value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
