<?php

namespace Inttegro\File;


/**
 * Public Storage details associated with file.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class PublicStorage extends \Inttegro\DomainValue
{
    /**
     * Encoding of the stored representation.
     *
     * Required response field. PHP type: `string`; wire field: `encoding` (`string`).
     *
     * @var string
     */
    public readonly string $encoding;

    /**
     * Stored byte size after any lossless encoding.
     *
     * Required response field. PHP type: `int`; wire field: `stored_size` (`integer`).
     *
     * @var int
     */
    public readonly int $storedSize;

    /**
     * Hydrates a PublicStorage from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->encoding = \Inttegro\ValueHydrator::string($data['encoding'] ?? null, false);
        $this->storedSize = \Inttegro\ValueHydrator::int($data['stored_size'] ?? null, false);
    }

    /**
     * Creates a PublicStorage from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable PublicStorage value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
