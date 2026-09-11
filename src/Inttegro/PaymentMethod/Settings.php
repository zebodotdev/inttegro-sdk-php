<?php

namespace Inttegro\PaymentMethod;


/**
 * Payment method acceptance configuration for an application.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Settings extends \Inttegro\DomainValue
{
    /**
     * Settings for a specific payment method type.
     *
     * Optional response field. PHP type: `\Inttegro\PaymentMethod\TypeSetting|null`; wire field:
     * `mobile_money` (`object`).
     *
     * @var \Inttegro\PaymentMethod\TypeSetting|null
     */
    public readonly ?\Inttegro\PaymentMethod\TypeSetting $mobileMoney;

    /**
     * Settings for a specific payment method type.
     *
     * Optional response field. PHP type: `\Inttegro\PaymentMethod\TypeSetting|null`; wire field:
     * `bank_account` (`object`).
     *
     * @var \Inttegro\PaymentMethod\TypeSetting|null
     */
    public readonly ?\Inttegro\PaymentMethod\TypeSetting $bankAccount;

    /**
     * Settings for a specific payment method type.
     *
     * Optional response field. PHP type: `\Inttegro\PaymentMethod\TypeSetting|null`; wire field:
     * `card` (`object`).
     *
     * @var \Inttegro\PaymentMethod\TypeSetting|null
     */
    public readonly ?\Inttegro\PaymentMethod\TypeSetting $card;

    /**
     * Settings for a specific payment method type.
     *
     * Optional response field. PHP type: `\Inttegro\PaymentMethod\TypeSetting|null`; wire field:
     * `motito` (`object`).
     *
     * @var \Inttegro\PaymentMethod\TypeSetting|null
     */
    public readonly ?\Inttegro\PaymentMethod\TypeSetting $motito;

    /**
     * Hydrates a Settings from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->mobileMoney = \Inttegro\ValueHydrator::object($data['mobile_money'] ?? null, [\Inttegro\PaymentMethod\TypeSetting::class], true);
        $this->bankAccount = \Inttegro\ValueHydrator::object($data['bank_account'] ?? null, [\Inttegro\PaymentMethod\TypeSetting::class], true);
        $this->card = \Inttegro\ValueHydrator::object($data['card'] ?? null, [\Inttegro\PaymentMethod\TypeSetting::class], true);
        $this->motito = \Inttegro\ValueHydrator::object($data['motito'] ?? null, [\Inttegro\PaymentMethod\TypeSetting::class], true);
    }

    /**
     * Creates a Settings from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Settings value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
