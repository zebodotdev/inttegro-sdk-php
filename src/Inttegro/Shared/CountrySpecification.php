<?php

namespace Inttegro\Shared;


/**
 * Complete specification for a country including supported features and requirements.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class CountrySpecification extends \Inttegro\DomainValue
{
    /**
     * ISO 3166-1 alpha-2 country code.
     *
     * Required response field. PHP type: `string`; wire field: `country_code` (`string`).
     *
     * @var string
     */
    public readonly string $countryCode;

    /**
     * Full country name.
     *
     * Required response field. PHP type: `string`; wire field: `country_name` (`string`).
     *
     * @var string
     */
    public readonly string $countryName;

    /**
     * Supported currencies in this country.
     *
     * Required response field. PHP type: `list<string>`; wire field: `currencies`
     * (`array<string>`).
     *
     * @var list<string>
     */
    public readonly array $currencies;

    /**
     * Supported payment methods in this country.
     *
     * Required response field. PHP type: `list<string>`; wire field: `payment_methods`
     * (`array<string>`).
     *
     * @var list<string>
     */
    public readonly array $paymentMethods;

    /**
     * Available payout schedules for this country.
     *
     * Required response field. PHP type: `list<string>`; wire field: `payout_schedules`
     * (`array<string>`).
     *
     * @var list<string>
     */
    public readonly array $payoutSchedules;

    /**
     * Balance transaction aging specifications available.
     *
     * Required response field. PHP type: `list<string>`; wire field: `bt_aging_specs`
     * (`array<string>`).
     *
     * @var list<string>
     */
    public readonly array $btAgingSpecs;

    /**
     * Legal entity types that can operate in this country.
     *
     * Required response field. PHP type: `list<string>`; wire field: `legal_entity_types`
     * (`array<string>`).
     *
     * @var list<string>
     */
    public readonly array $legalEntityTypes;

    /**
     * Financial account types available in this country.
     *
     * Required response field. PHP type: `list<string>`; wire field: `financial_account_types`
     * (`array<string>`).
     *
     * @var list<string>
     */
    public readonly array $financialAccountTypes;

    /**
     * Identification document types accepted in this country.
     *
     * Required response field. PHP type: `list<string>`; wire field: `id_document_types`
     * (`array<string>`).
     *
     * @var list<string>
     */
    public readonly array $idDocumentTypes;

    /**
     * Bank reference data available for country-specific bank accounts.
     *
     * Optional response field. PHP type: `\Inttegro\Shared\CountryBankDirectory|null`; wire field:
     * `banks` (`object`).
     *
     * @var \Inttegro\Shared\CountryBankDirectory|null
     */
    public readonly ?\Inttegro\Shared\CountryBankDirectory $banks;

    /**
     * Hydrates a CountrySpecification from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->countryCode = \Inttegro\ValueHydrator::string($data['country_code'] ?? null, false);
        $this->countryName = \Inttegro\ValueHydrator::string($data['country_name'] ?? null, false);
        $this->currencies = \Inttegro\ValueHydrator::array($data['currencies'] ?? null, false);
        $this->paymentMethods = \Inttegro\ValueHydrator::array($data['payment_methods'] ?? null, false);
        $this->payoutSchedules = \Inttegro\ValueHydrator::array($data['payout_schedules'] ?? null, false);
        $this->btAgingSpecs = \Inttegro\ValueHydrator::array($data['bt_aging_specs'] ?? null, false);
        $this->legalEntityTypes = \Inttegro\ValueHydrator::array($data['legal_entity_types'] ?? null, false);
        $this->financialAccountTypes = \Inttegro\ValueHydrator::array($data['financial_account_types'] ?? null, false);
        $this->idDocumentTypes = \Inttegro\ValueHydrator::array($data['id_document_types'] ?? null, false);
        $this->banks = \Inttegro\ValueHydrator::object($data['banks'] ?? null, [\Inttegro\Shared\CountryBankDirectory::class], true);
    }

    /**
     * Creates a CountrySpecification from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable CountrySpecification value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
