<?php

namespace Inttegro\FinancialAccount;


/**
 * A bank branch in a country bank directory.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class FinancialInstitutionBankBranch extends \Inttegro\DomainValue
{
    /**
     * Stable branch identifier.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Branch display name.
     *
     * Required response field. PHP type: `string`; wire field: `name` (`string`).
     *
     * @var string
     */
    public readonly string $name;

    /**
     * Ghana bank branch sort code.
     *
     * Required response field. PHP type: `string`; wire field: `sort_code` (`string`).
     *
     * @var string
     */
    public readonly string $sortCode;

    /**
     * Hydrates a FinancialInstitutionBankBranch from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->name = \Inttegro\ValueHydrator::string($data['name'] ?? null, false);
        $this->sortCode = \Inttegro\ValueHydrator::string($data['sort_code'] ?? null, false);
    }

    /**
     * Creates a FinancialInstitutionBankBranch from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable FinancialInstitutionBankBranch value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
