<?php

namespace Inttegro\PurchaseIntent;

use Inttegro\Money\Amount;

/**
 * Original Price details associated with purchase intent.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class OriginalPrice extends \Inttegro\DomainValue
{
    /**
     * Whether the resolved comparison price is active.
     *
     * Required response field. PHP type: `bool`; wire field: `active` (`boolean`).
     *
     * @var bool
     */
    public readonly bool $active;

    /**
     * Catalog price ID when the comparison price is not inline.
     *
     * Optional response field. PHP type: `string|null`; wire field: `id` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $id;

    /**
     * Catalog price label when available.
     *
     * Optional response field. PHP type: `string|null`; wire field: `label` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $label;

    /**
     * Nominal value for this original price.
     *
     * Required response field. PHP type: `Amount`; wire field: `nominal` (`object`).
     *
     * @var Amount
     */
    public readonly Amount $nominal;

    /**
     * Hydrates an OriginalPrice from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->active = \Inttegro\ValueHydrator::bool($data['active'] ?? null, false);
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, true);
        $this->label = \Inttegro\ValueHydrator::string($data['label'] ?? null, true);
        $this->nominal = \Inttegro\ValueHydrator::object($data['nominal'] ?? null, [Amount::class], false);
    }

    /**
     * Creates an OriginalPrice from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable OriginalPrice value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
