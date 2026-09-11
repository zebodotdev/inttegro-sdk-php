<?php

namespace Inttegro\FileLink;


/**
 * Delivery details associated with file link.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Delivery extends \Inttegro\DomainValue
{
    /**
     * Mode value for this delivery.
     *
     * Optional response field. PHP type: `string|null`; wire field: `mode` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $mode;

    /**
     * Filename value for this delivery.
     *
     * Optional response field. PHP type: `string|null`; wire field: `filename` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $filename;

    /**
     * Content Type value for this delivery.
     *
     * Optional response field. PHP type: `string|null`; wire field: `content_type` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $contentType;

    /**
     * Disposition value for this delivery.
     *
     * Optional response field. PHP type: `string|null`; wire field: `disposition` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $disposition;

    /**
     * Hydrates a Delivery from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->mode = \Inttegro\ValueHydrator::string($data['mode'] ?? null, true);
        $this->filename = \Inttegro\ValueHydrator::string($data['filename'] ?? null, true);
        $this->contentType = \Inttegro\ValueHydrator::string($data['content_type'] ?? null, true);
        $this->disposition = \Inttegro\ValueHydrator::string($data['disposition'] ?? null, true);
    }

    /**
     * Creates a Delivery from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Delivery value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
