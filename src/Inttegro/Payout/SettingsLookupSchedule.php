<?php

namespace Inttegro\Payout;


/**
 * Active payout schedule.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class SettingsLookupSchedule extends \Inttegro\DomainValue
{
    /**
     * Aging Spec value for this settings lookup schedule.
     *
     * Required response field. PHP type: `\Inttegro\Payout\SettingsLookupScheduleAgingSpec`; wire
     * field: `aging_spec` (`object`).
     *
     * @var \Inttegro\Payout\SettingsLookupScheduleAgingSpec
     */
    public readonly \Inttegro\Payout\SettingsLookupScheduleAgingSpec $agingSpec;

    /**
     * Human-readable description.
     *
     * Required response field. PHP type: `string`; wire field: `description` (`string`).
     *
     * @var string
     */
    public readonly string $description;

    /**
     * Interval value for this settings lookup schedule.
     *
     * Required response field. PHP type: `string`; wire field: `interval` (`string`).
     *
     * @var string
     */
    public readonly string $interval;

    /**
     * Human-readable name.
     *
     * Required response field. PHP type: `string`; wire field: `name` (`string`).
     *
     * @var string
     */
    public readonly string $name;

    /**
     * Timestamp associated with schedule.
     *
     * Required response field. PHP type: `string`; wire field: `schedule_on` (`string`).
     *
     * @var string
     */
    public readonly string $scheduleOn;

    /**
     * Discriminator identifying the value's API variant.
     *
     * Required response field. PHP type: `string`; wire field: `type` (`string`).
     *
     * @var string
     */
    public readonly string $type;

    /**
     * Hydrates a SettingsLookupSchedule from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->agingSpec = \Inttegro\ValueHydrator::object($data['aging_spec'] ?? null, [\Inttegro\Payout\SettingsLookupScheduleAgingSpec::class], false);
        $this->description = \Inttegro\ValueHydrator::string($data['description'] ?? null, false);
        $this->interval = \Inttegro\ValueHydrator::string($data['interval'] ?? null, false);
        $this->name = \Inttegro\ValueHydrator::string($data['name'] ?? null, false);
        $this->scheduleOn = \Inttegro\ValueHydrator::string($data['schedule_on'] ?? null, false);
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
    }

    /**
     * Creates a SettingsLookupSchedule from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable SettingsLookupSchedule value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
