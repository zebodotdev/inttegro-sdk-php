<?php

namespace Inttegro\Payout;


/**
 * Complete payout settings read model.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class SettingsLookup extends \Inttegro\DomainValue
{
    /**
     * Currency-to-financial-account destination assignments.
     *
     * Required response field. PHP type: `array<string, string>`; wire field: `destinations`
     * (`object`).
     *
     * @var array<string, string>
     */
    public readonly array $destinations;

    /**
     * Present only when foreign exchange is enabled in stored settings.
     *
     * Optional response field. PHP type: `bool|null`; wire field: `fx_enabled` (`boolean`).
     *
     * @var bool|null
     */
    public readonly ?bool $fxEnabled;

    /**
     * Active payout schedule.
     *
     * Optional response field. PHP type: `\Inttegro\Payout\SettingsLookupSchedule|null`; wire
     * field: `schedule` (`object`).
     *
     * @var \Inttegro\Payout\SettingsLookupSchedule|null
     */
    public readonly ?\Inttegro\Payout\SettingsLookupSchedule $schedule;

    /**
     * Hydrates a SettingsLookup from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->destinations = \Inttegro\ValueHydrator::array($data['destinations'] ?? null, false);
        $this->fxEnabled = \Inttegro\ValueHydrator::bool($data['fx_enabled'] ?? null, true);
        $this->schedule = \Inttegro\ValueHydrator::object($data['schedule'] ?? null, [\Inttegro\Payout\SettingsLookupSchedule::class], true);
    }

    /**
     * Creates a SettingsLookup from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable SettingsLookup value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
