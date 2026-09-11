<?php

namespace Inttegro\App;


/**
 * Optional direct-placement relationship policy. Omitted values default to parent management and
 * child credentials.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class RelationshipPolicy extends \Inttegro\DomainValue
{
    /**
     * Initial standing assigned to the child in this relationship.
     *
     * Required response field. PHP type: `string`; wire field: `child_standing` (`string`).
     *
     * @var string
     */
    public readonly string $childStanding;

    /**
     * Who can manage the child app and its resources through this relationship.
     *
     * Required response field. PHP type: `string`; wire field: `management` (`string`).
     *
     * @var string
     */
    public readonly string $management;

    /**
     * Who can create, rotate, or disable the child app's API keys after creation. Defaults to
     * child. In V1, apps/create still returns the initial child key to the caller.
     *
     * Required response field. PHP type: `string`; wire field: `credentials` (`string`).
     *
     * @var string
     */
    public readonly string $credentials;

    /**
     * Hydrates a RelationshipPolicy from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->childStanding = \Inttegro\ValueHydrator::string($data['child_standing'] ?? null, false);
        $this->management = \Inttegro\ValueHydrator::string($data['management'] ?? null, false);
        $this->credentials = \Inttegro\ValueHydrator::string($data['credentials'] ?? null, false);
    }

    /**
     * Creates a RelationshipPolicy from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable RelationshipPolicy value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
