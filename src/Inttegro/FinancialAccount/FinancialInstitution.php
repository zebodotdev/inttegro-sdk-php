<?php

namespace Inttegro\FinancialAccount;


/**
 * Financial Institution details associated with financial account.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class FinancialInstitution extends \Inttegro\DomainValue
{
    /**
     * Bank value for this financial institution.
     *
     * Optional response field. PHP type:
     * `\Inttegro\FinancialAccount\FinancialInstitutionBank|null`; wire field: `bank` (`object`).
     *
     * @var \Inttegro\FinancialAccount\FinancialInstitutionBank|null
     */
    public readonly ?\Inttegro\FinancialAccount\FinancialInstitutionBank $bank;

    /**
     * Country value for this financial institution.
     *
     * Required response field. PHP type: `string`; wire field: `country` (`string`).
     *
     * @var string
     */
    public readonly string $country;

    /**
     * Unique identifier for this financial institution.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Mobile Money Provider value for this financial institution.
     *
     * Optional response field. PHP type:
     * `\Inttegro\FinancialAccount\FinancialInstitutionMobileMoneyProvider|null`; wire field:
     * `mobile_money_provider` (`object`).
     *
     * @var \Inttegro\FinancialAccount\FinancialInstitutionMobileMoneyProvider|null
     */
    public readonly ?\Inttegro\FinancialAccount\FinancialInstitutionMobileMoneyProvider $mobileMoneyProvider;

    /**
     * Human-readable name.
     *
     * Required response field. PHP type: `string`; wire field: `name` (`string`).
     *
     * @var string
     */
    public readonly string $name;

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
     * Hydrates a FinancialInstitution from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->bank = \Inttegro\ValueHydrator::object($data['bank'] ?? null, [\Inttegro\FinancialAccount\FinancialInstitutionBank::class], true);
        $this->country = \Inttegro\ValueHydrator::string($data['country'] ?? null, false);
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->mobileMoneyProvider = \Inttegro\ValueHydrator::object($data['mobile_money_provider'] ?? null, [\Inttegro\FinancialAccount\FinancialInstitutionMobileMoneyProvider::class], true);
        $this->name = \Inttegro\ValueHydrator::string($data['name'] ?? null, false);
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
    }

    /**
     * Creates a FinancialInstitution from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable FinancialInstitution value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
