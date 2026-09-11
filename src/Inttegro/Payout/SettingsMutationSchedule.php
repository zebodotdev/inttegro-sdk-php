<?php

namespace Inttegro\Payout;


/**
 * Updated payout schedule.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class SettingsMutationSchedule extends \Inttegro\DomainValue
{
    /**
     * Human-readable description.
     *
     * Required response field. PHP type: `string`; wire field: `description` (`string`).
     *
     * @var string
     */
    public readonly string $description;

    /**
     * Unique identifier for this settings mutation schedule.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Interval value for this settings mutation schedule.
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
     * Spec value for this settings mutation schedule.
     *
     * Required response field. PHP type: `\Inttegro\Payout\SettingsMutationScheduleSpec`; wire
     * field: `spec` (`object`).
     *
     * @var \Inttegro\Payout\SettingsMutationScheduleSpec
     */
    public readonly \Inttegro\Payout\SettingsMutationScheduleSpec $spec;

    /**
     * Discriminator identifying the value's API variant.
     *
     * Required response field. PHP type: `string`; wire field: `type` (`string`).
     *
     * @var string
     */
    public readonly string $type;

    /**
     * Hydrates a SettingsMutationSchedule from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->description = \Inttegro\ValueHydrator::string($data['description'] ?? null, false);
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->interval = \Inttegro\ValueHydrator::string($data['interval'] ?? null, false);
        $this->name = \Inttegro\ValueHydrator::string($data['name'] ?? null, false);
        $this->scheduleOn = \Inttegro\ValueHydrator::string($data['schedule_on'] ?? null, false);
        $this->spec = \Inttegro\ValueHydrator::object($data['spec'] ?? null, [\Inttegro\Payout\SettingsMutationScheduleSpec::class], false);
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
    }

    /**
     * Creates a SettingsMutationSchedule from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable SettingsMutationSchedule value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
