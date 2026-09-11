<?php

namespace Inttegro\FileLink;


/**
 * Creation details associated with file link.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Creation extends \Inttegro\DomainValue
{
    /**
     * Public file link metadata. Token hashes and provider URLs are not exposed.
     *
     * Required response field. PHP type: `\Inttegro\FileLink\FileLink`; wire field: `file_link`
     * (`object`).
     *
     * @var \Inttegro\FileLink\FileLink
     */
    public readonly \Inttegro\FileLink\FileLink $fileLink;

    /**
     * Public capability URL. Treat as bearer-secret material.
     *
     * Required response field. PHP type: `string`; wire field: `url` (`string`).
     *
     * @var string
     */
    public readonly string $url;

    /**
     * Hydrates a Creation from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->fileLink = \Inttegro\ValueHydrator::object($data['file_link'] ?? null, [\Inttegro\FileLink\FileLink::class], false);
        $this->url = \Inttegro\ValueHydrator::string($data['url'] ?? null, false);
    }

    /**
     * Creates a Creation from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Creation value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
