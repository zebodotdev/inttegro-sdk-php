<?php

namespace Inttegro\Wallet;


/**
 * Wallet details associated with a payment method or financial account.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Wallet extends \Inttegro\DomainValue
{
    /**
     * Unique identifier for this wallet.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

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
     * Mobile Money value for this wallet.
     *
     * Optional response field. PHP type: `\Inttegro\Wallet\MobileMoney|null`; wire field:
     * `mobile_money` (`object`).
     *
     * @var \Inttegro\Wallet\MobileMoney|null
     */
    public readonly ?\Inttegro\Wallet\MobileMoney $mobileMoney;

    /**
     * Hydrates a Wallet from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
        $this->mobileMoney = \Inttegro\ValueHydrator::object($data['mobile_money'] ?? null, [\Inttegro\Wallet\MobileMoney::class], true);
    }

    /**
     * Creates a Wallet from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Wallet value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
