<?php

namespace Inttegro;

/**
 * Immutable value used only where the API contract intentionally permits arbitrary object data.
 *
 * Unlike closed-schema resource classes, this value preserves original keys and values exactly.
 * Use `toArray()` when forwarding the object and property access when reading a known key. The SDK
 * does not guess types or rename fields inside open-ended JSON data.
 */
final class GenericValue extends DomainValue
{
    /**
     * Stores an open-ended API object without transforming its keys.
     *
     * @param array<string, mixed> $data Arbitrary JSON-compatible object data.
     */
    public function __construct(private readonly array $data) {}

    /**
     * Creates an open-ended value from decoded API data.
     *
     * @param array<string, mixed> $data Arbitrary JSON-compatible object data.
     * @return static A value that preserves the supplied keys and values.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }

    /**
     * Returns the unmodified open-ended API object.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * Reads an arbitrary object key, returning null when it is absent.
     *
     * @param string $name Original API object key.
     */
    public function __get(string $name): mixed
    {
        return $this->data[$name] ?? null;
    }

    /**
     * Reports whether an arbitrary object key exists with a non-null value.
     *
     * @param string $name Original API object key.
     */
    public function __isset(string $name): bool
    {
        return isset($this->data[$name]);
    }
}
