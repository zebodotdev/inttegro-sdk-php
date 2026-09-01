<?php

namespace Inttegro;

use ArrayAccess;
use JsonSerializable;

class ResponseObject implements ArrayAccess, JsonSerializable
{
    private array $data = [];

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            $this->data[$key] = $this->wrap($value);
        }
    }

    public function __get($name)
    {
        return $this->data[$name] ?? null;
    }

    public function __isset($name): bool
    {
        return isset($this->data[$name]);
    }

    public function offsetExists($offset): bool
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset): mixed
    {
        return $this->data[$offset] ?? null;
    }

    public function offsetSet($offset, $value): void
    {
        $this->data[$offset] = $this->wrap($value);
    }

    public function offsetUnset($offset): void
    {
        unset($this->data[$offset]);
    }

    public function toArray(): array
    {
        return $this->unwrap($this->data);
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    private function wrap($value)
    {
        if (is_array($value)) {
            if ($this->isAssoc($value)) {
                return new self($value);
            }
            return array_map(fn($v) => $this->wrap($v), $value);
        }
        if (is_object($value)) {
            return $value;
        }
        return $value;
    }

    private function unwrap($value)
    {
        if ($value instanceof self) {
            return $value->toArray();
        }
        if (is_array($value)) {
            return array_map(fn($v) => $this->unwrap($v), $value);
        }
        return $value;
    }

    private function isAssoc(array $arr): bool
    {
        if ($arr === []) {
            return false;
        }
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}
