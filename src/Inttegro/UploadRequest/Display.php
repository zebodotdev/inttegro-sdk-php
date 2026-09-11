<?php

namespace Inttegro\UploadRequest;


/**
 * Display details associated with upload request.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Display extends \Inttegro\DomainValue
{
    /**
     * Title value for this display.
     *
     * Optional response field. PHP type: `string|null`; wire field: `title` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $title;

    /**
     * Human-readable description.
     *
     * Optional response field. PHP type: `string|null`; wire field: `description` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $description;

    /**
     * Help Text value for this display.
     *
     * Optional response field. PHP type: `string|null`; wire field: `help_text` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $helpText;

    /**
     * Hydrates a Display from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->title = \Inttegro\ValueHydrator::string($data['title'] ?? null, true);
        $this->description = \Inttegro\ValueHydrator::string($data['description'] ?? null, true);
        $this->helpText = \Inttegro\ValueHydrator::string($data['help_text'] ?? null, true);
    }

    /**
     * Creates a Display from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Display value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
