<?php

namespace Inttegro\Payment;


/**
 * Payout configuration for this balance transaction.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class PayoutConfiguration extends \Inttegro\DomainValue
{
    /**
     * Compatibility flag. Cross-currency payout execution is not currently available.
     *
     * Required response field. PHP type: `bool`; wire field: `enable_fx` (`boolean`).
     *
     * @var bool
     */
    public readonly bool $enableFx;

    /**
     * Where the funds will be paid out.
     *
     * Required response field. PHP type: `\Inttegro\Payment\PayoutConfigurationDestination`; wire
     * field: `destination` (`object`).
     *
     * @var \Inttegro\Payment\PayoutConfigurationDestination
     */
    public readonly \Inttegro\Payment\PayoutConfigurationDestination $destination;

    /**
     * Hydrates a PayoutConfiguration from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->enableFx = \Inttegro\ValueHydrator::bool($data['enable_fx'] ?? null, false);
        $this->destination = \Inttegro\ValueHydrator::object($data['destination'] ?? null, [\Inttegro\Payment\PayoutConfigurationDestination::class], false);
    }

    /**
     * Creates a PayoutConfiguration from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable PayoutConfiguration value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
