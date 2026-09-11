<?php

namespace Inttegro\Payout;


/**
 * Settings Mutation Schedule Spec details associated with payout.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class SettingsMutationScheduleSpec extends \Inttegro\DomainValue
{
    /**
     * Abide value for this settings mutation schedule spec.
     *
     * Required response field. PHP type: `string`; wire field: `abide` (`string`).
     *
     * @var string
     */
    public readonly string $abide;

    /**
     * Unique identifier for this settings mutation schedule spec.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Label value for this settings mutation schedule spec.
     *
     * Required response field. PHP type: `string`; wire field: `label` (`string`).
     *
     * @var string
     */
    public readonly string $label;

    /**
     * T Plus value for this settings mutation schedule spec.
     *
     * Required response field. PHP type: `string`; wire field: `t_plus` (`string`).
     *
     * @var string
     */
    public readonly string $tPlus;

    /**
     * Hydrates a SettingsMutationScheduleSpec from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->abide = \Inttegro\ValueHydrator::string($data['abide'] ?? null, false);
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->label = \Inttegro\ValueHydrator::string($data['label'] ?? null, false);
        $this->tPlus = \Inttegro\ValueHydrator::string($data['t_plus'] ?? null, false);
    }

    /**
     * Creates a SettingsMutationScheduleSpec from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable SettingsMutationScheduleSpec value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
