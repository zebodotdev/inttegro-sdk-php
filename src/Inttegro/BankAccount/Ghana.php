<?php

namespace Inttegro\BankAccount;


/**
 * Ghana details associated with bank account.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Ghana extends \Inttegro\DomainValue
{
    /**
     * Branch value for this ghana.
     *
     * Optional response field. PHP type: `string|null`; wire field: `branch` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $branch;

    /**
     * Holder value for this ghana.
     *
     * Required response field. PHP type: `\Inttegro\BankAccount\Owner`; wire field: `holder`
     * (`object`).
     *
     * @var \Inttegro\BankAccount\Owner
     */
    public readonly \Inttegro\BankAccount\Owner $holder;

    /**
     * Human-readable name.
     *
     * Optional response field. PHP type: `string|null`; wire field: `name` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $name;

    /**
     * Page or business reference number, as defined by the containing value.
     *
     * Required response field. PHP type: `string`; wire field: `number` (`string`).
     *
     * @var string
     */
    public readonly string $number;

    /**
     * Sort Code value for this ghana.
     *
     * Optional response field. PHP type: `string|null`; wire field: `sort_code` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $sortCode;

    /**
     * Swift Code value for this ghana.
     *
     * Optional response field. PHP type: `string|null`; wire field: `swift_code` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $swiftCode;

    /**
     * Hydrates a Ghana from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->branch = \Inttegro\ValueHydrator::string($data['branch'] ?? null, true);
        $this->holder = \Inttegro\ValueHydrator::object($data['holder'] ?? null, [\Inttegro\BankAccount\Owner::class], false);
        $this->name = \Inttegro\ValueHydrator::string($data['name'] ?? null, true);
        $this->number = \Inttegro\ValueHydrator::string($data['number'] ?? null, false);
        $this->sortCode = \Inttegro\ValueHydrator::string($data['sort_code'] ?? null, true);
        $this->swiftCode = \Inttegro\ValueHydrator::string($data['swift_code'] ?? null, true);
    }

    /**
     * Creates a Ghana from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Ghana value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
