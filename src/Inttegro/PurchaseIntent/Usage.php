<?php

namespace Inttegro\PurchaseIntent;


/**
 * Exactly one of multi_use or single_use is returned as true. Order is present after a single-use
 * intent is consumed.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Usage extends \Inttegro\DomainValue
{
    /**
     * Multi Use value for this usage.
     *
     * Optional response field. PHP type: `bool|null`; wire field: `multi_use` (`boolean`).
     *
     * @var bool|null
     */
    public readonly ?bool $multiUse;

    /**
     * Order value for this usage.
     *
     * Optional response field. PHP type: `\Inttegro\PurchaseIntent\UsageOrder|null`; wire field:
     * `order` (`object`).
     *
     * @var \Inttegro\PurchaseIntent\UsageOrder|null
     */
    public readonly ?\Inttegro\PurchaseIntent\UsageOrder $order;

    /**
     * Single Use value for this usage.
     *
     * Optional response field. PHP type: `bool|null`; wire field: `single_use` (`boolean`).
     *
     * @var bool|null
     */
    public readonly ?bool $singleUse;

    /**
     * Hydrates an Usage from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->multiUse = \Inttegro\ValueHydrator::bool($data['multi_use'] ?? null, true);
        $this->order = \Inttegro\ValueHydrator::object($data['order'] ?? null, [\Inttegro\PurchaseIntent\UsageOrder::class], true);
        $this->singleUse = \Inttegro\ValueHydrator::bool($data['single_use'] ?? null, true);
    }

    /**
     * Creates an Usage from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Usage value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
