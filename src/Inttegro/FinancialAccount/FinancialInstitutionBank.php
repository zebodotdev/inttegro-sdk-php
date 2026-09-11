<?php

namespace Inttegro\FinancialAccount;


/**
 * Financial Institution Bank details associated with financial account.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class FinancialInstitutionBank extends \Inttegro\DomainValue
{
    /**
     * Bank Account Type value for this financial institution bank.
     *
     * Required response field. PHP type: `string`; wire field: `bank_account_type` (`string`).
     *
     * @var string
     */
    public readonly string $bankAccountType;

    /**
     * Branch value for this financial institution bank.
     *
     * Optional response field. PHP type:
     * `\Inttegro\FinancialAccount\FinancialInstitutionBankBranch|null`; wire field: `branch`
     * (`object`).
     *
     * @var \Inttegro\FinancialAccount\FinancialInstitutionBankBranch|null
     */
    public readonly ?\Inttegro\FinancialAccount\FinancialInstitutionBankBranch $branch;

    /**
     * Code Scheme value for this financial institution bank.
     *
     * Required response field. PHP type: `string`; wire field: `code_scheme` (`string`).
     *
     * @var string
     */
    public readonly string $codeScheme;

    /**
     * Sort Code Prefix value for this financial institution bank.
     *
     * Optional response field. PHP type: `string|null`; wire field: `sort_code_prefix` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $sortCodePrefix;

    /**
     * Swift Code value for this financial institution bank.
     *
     * Optional response field. PHP type: `string|null`; wire field: `swift_code` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $swiftCode;

    /**
     * Hydrates a FinancialInstitutionBank from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->bankAccountType = \Inttegro\ValueHydrator::string($data['bank_account_type'] ?? null, false);
        $this->branch = \Inttegro\ValueHydrator::object($data['branch'] ?? null, [\Inttegro\FinancialAccount\FinancialInstitutionBankBranch::class], true);
        $this->codeScheme = \Inttegro\ValueHydrator::string($data['code_scheme'] ?? null, false);
        $this->sortCodePrefix = \Inttegro\ValueHydrator::string($data['sort_code_prefix'] ?? null, true);
        $this->swiftCode = \Inttegro\ValueHydrator::string($data['swift_code'] ?? null, true);
    }

    /**
     * Creates a FinancialInstitutionBank from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable FinancialInstitutionBank value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
