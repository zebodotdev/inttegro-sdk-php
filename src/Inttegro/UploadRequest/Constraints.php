<?php

namespace Inttegro\UploadRequest;


/**
 * Constraints details associated with upload request.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Constraints extends \Inttegro\DomainValue
{
    /**
     * Min Size value for this constraints.
     *
     * Optional response field. PHP type: `int|null`; wire field: `min_size` (`integer`).
     *
     * @var int|null
     */
    public readonly ?int $minSize;

    /**
     * Max Size value for this constraints.
     *
     * Optional response field. PHP type: `int|null`; wire field: `max_size` (`integer`).
     *
     * @var int|null
     */
    public readonly ?int $maxSize;

    /**
     * Exact Size value for this constraints.
     *
     * Optional response field. PHP type: `int|null`; wire field: `exact_size` (`integer`).
     *
     * @var int|null
     */
    public readonly ?int $exactSize;

    /**
     * Content Types value for this constraints.
     *
     * Optional response field. PHP type: `list<string>|null`; wire field: `content_types`
     * (`array<string>`).
     *
     * @var list<string>|null
     */
    public readonly ?array $contentTypes;

    /**
     * Extensions value for this constraints.
     *
     * Optional response field. PHP type: `list<string>|null`; wire field: `extensions`
     * (`array<string>`).
     *
     * @var list<string>|null
     */
    public readonly ?array $extensions;

    /**
     * Filename value for this constraints.
     *
     * Optional response field. PHP type: `string|null`; wire field: `filename` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $filename;

    /**
     * Hydrates a Constraints from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->minSize = \Inttegro\ValueHydrator::int($data['min_size'] ?? null, true);
        $this->maxSize = \Inttegro\ValueHydrator::int($data['max_size'] ?? null, true);
        $this->exactSize = \Inttegro\ValueHydrator::int($data['exact_size'] ?? null, true);
        $this->contentTypes = \Inttegro\ValueHydrator::array($data['content_types'] ?? null, true);
        $this->extensions = \Inttegro\ValueHydrator::array($data['extensions'] ?? null, true);
        $this->filename = \Inttegro\ValueHydrator::string($data['filename'] ?? null, true);
    }

    /**
     * Creates a Constraints from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Constraints value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
