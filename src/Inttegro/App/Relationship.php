<?php

namespace Inttegro\App;

use DateTimeImmutable;

/**
 * Relationship receipt for the created child app.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Relationship extends \Inttegro\DomainValue
{
    /**
     * Unique identifier for this relationship.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Kind value for this relationship.
     *
     * Required response field. PHP type: `string`; wire field: `kind` (`string`).
     *
     * @var string
     */
    public readonly string $kind;

    /**
     * Policy Version value for this relationship.
     *
     * Required response field. PHP type: `string`; wire field: `policy_version` (`string`).
     *
     * @var string
     */
    public readonly string $policyVersion;

    /**
     * Current lifecycle state.
     *
     * Required response field. PHP type: `string`; wire field: `status` (`string`).
     *
     * @var string
     */
    public readonly string $status;

    /**
     * Identifier of the related actor app.
     *
     * Required response field. PHP type: `string`; wire field: `actor_app_id` (`string`).
     *
     * @var string
     */
    public readonly string $actorAppId;

    /**
     * Identifier of the related creator app.
     *
     * Required response field. PHP type: `string`; wire field: `creator_app_id` (`string`).
     *
     * @var string
     */
    public readonly string $creatorAppId;

    /**
     * Identifier of the related placement parent app.
     *
     * Required response field. PHP type: `string`; wire field: `placement_parent_app_id`
     * (`string`).
     *
     * @var string
     */
    public readonly string $placementParentAppId;

    /**
     * Identifier of the related subject app.
     *
     * Required response field. PHP type: `string`; wire field: `subject_app_id` (`string`).
     *
     * @var string
     */
    public readonly string $subjectAppId;

    /**
     * Identifier of the related child app.
     *
     * Required response field. PHP type: `string`; wire field: `child_app_id` (`string`).
     *
     * @var string
     */
    public readonly string $childAppId;

    /**
     * Child Standing value for this relationship.
     *
     * Required response field. PHP type: `string`; wire field: `child_standing` (`string`).
     *
     * @var string
     */
    public readonly string $childStanding;

    /**
     * Relationship Policy value for this relationship.
     *
     * Required response field. PHP type: `\Inttegro\App\RelationshipPolicy`; wire field:
     * `relationship_policy` (`object`).
     *
     * @var \Inttegro\App\RelationshipPolicy
     */
    public readonly \Inttegro\App\RelationshipPolicy $relationshipPolicy;

    /**
     * Retained Creator Authority Exists value for this relationship.
     *
     * Required response field. PHP type: `bool`; wire field: `retained_creator_authority_exists`
     * (`boolean`).
     *
     * @var bool
     */
    public readonly bool $retainedCreatorAuthorityExists;

    /**
     * Time at which the value was created.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `created_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $createdAt;

    /**
     * Hydrates a Relationship from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->kind = \Inttegro\ValueHydrator::string($data['kind'] ?? null, false);
        $this->policyVersion = \Inttegro\ValueHydrator::string($data['policy_version'] ?? null, false);
        $this->status = \Inttegro\ValueHydrator::string($data['status'] ?? null, false);
        $this->actorAppId = \Inttegro\ValueHydrator::string($data['actor_app_id'] ?? null, false);
        $this->creatorAppId = \Inttegro\ValueHydrator::string($data['creator_app_id'] ?? null, false);
        $this->placementParentAppId = \Inttegro\ValueHydrator::string($data['placement_parent_app_id'] ?? null, false);
        $this->subjectAppId = \Inttegro\ValueHydrator::string($data['subject_app_id'] ?? null, false);
        $this->childAppId = \Inttegro\ValueHydrator::string($data['child_app_id'] ?? null, false);
        $this->childStanding = \Inttegro\ValueHydrator::string($data['child_standing'] ?? null, false);
        $this->relationshipPolicy = \Inttegro\ValueHydrator::object($data['relationship_policy'] ?? null, [\Inttegro\App\RelationshipPolicy::class], false);
        $this->retainedCreatorAuthorityExists = \Inttegro\ValueHydrator::bool($data['retained_creator_authority_exists'] ?? null, false);
        $this->createdAt = \Inttegro\ValueHydrator::dateTime($data['created_at'] ?? null, false);
    }

    /**
     * Creates a Relationship from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Relationship value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
