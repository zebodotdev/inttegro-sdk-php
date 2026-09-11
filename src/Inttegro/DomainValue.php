<?php

namespace Inttegro;

use ArrayAccess;
use BackedEnum;
use DateTimeInterface;
use JsonSerializable;
use LogicException;

/**
 * Immutable base for every closed-schema value returned or accepted by the Inttegro SDK.
 *
 * Concrete values expose typed, readonly `camelCase` PHP properties while this base provides the
 * API's `snake_case` wire view through `ArrayAccess`, `toArray()`, and JSON serialization. Nested
 * domain values are exported recursively, backed enums become their string values, and
 * `DateTimeInterface` values become offset-bearing RFC 3339 strings.
 *
 * Array access is read-only. Assigning or unsetting a field throws `LogicException`.
 */
abstract class DomainValue implements ArrayAccess, JsonSerializable
{
    /**
     * Creates a typed value from a decoded API object.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable domain value.
     */
    abstract public static function fromArray(array $data): static;

    /**
     * Converts typed properties back to the API's wire representation.
     *
     * Property names become `snake_case`. Nested values, arrays, backed enums, and timestamps are
     * normalized recursively so the result is safe to pass to `json_encode()`.
     *
     * @return array<string, mixed> The recursively normalized API object.
     */
    public function toArray(): array
    {
        $result = [];
        foreach (get_object_vars($this) as $name => $value) {
            $result[self::snake($name)] = self::export($value);
        }
        return $result;
    }

    /**
     * Returns the same API wire object as `toArray()` for `json_encode()`.
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    /**
     * Reports whether a non-null property exists for a PHP or API field name.
     *
     * Both `paymentId` and `payment_id` address the same typed property.
     *
     * @param mixed $offset PHP `camelCase` or wire `snake_case` field name.
     */
    public function offsetExists(mixed $offset): bool
    {
        return is_string($offset) && isset($this->{self::camel($offset)});
    }

    /**
     * Reads a typed property through PHP `ArrayAccess`.
     *
     * @param mixed $offset PHP `camelCase` or wire `snake_case` field name.
     * @return mixed The PHP-native property value.
     */
    public function offsetGet(mixed $offset): mixed
    {
        return is_string($offset) ? $this->{self::camel($offset)} : null;
    }

    /**
     * Rejects mutation because domain values are immutable.
     *
     * @param mixed $offset Ignored field name.
     * @param mixed $value Ignored replacement value.
     * @throws LogicException Always.
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new LogicException('Inttegro domain values are immutable.');
    }

    /**
     * Rejects unsetting because domain values are immutable.
     *
     * @param mixed $offset Ignored field name.
     * @throws LogicException Always.
     */
    public function offsetUnset(mixed $offset): void
    {
        throw new LogicException('Inttegro domain values are immutable.');
    }

    private static function snake(string $value): string
    {
        return strtolower((string) preg_replace('/(?<!^)[A-Z]/', '_$0', $value));
    }

    private static function camel(string $value): string
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $value))));
    }

    private static function export(mixed $value): mixed
    {
        if ($value instanceof self) {
            return $value->toArray();
        }
        if ($value instanceof DateTimeInterface) {
            return $value->format(DATE_RFC3339_EXTENDED);
        }
        if ($value instanceof BackedEnum) {
            return $value->value;
        }
        if (is_array($value)) {
            return array_map([self::class, 'export'], $value);
        }
        return $value;
    }
}
