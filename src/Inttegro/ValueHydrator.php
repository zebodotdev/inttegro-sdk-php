<?php

namespace Inttegro;

use DateTimeImmutable;
use DateTimeInterface;

/** @internal */
final class ValueHydrator
{
    /** @return ($nullable is true ? string|null : string) */
    public static function string(mixed $value, bool $nullable): ?string
    {
        return $value === null && $nullable ? null : (string) ($value ?? '');
    }

    /** @return ($nullable is true ? DateTimeImmutable|null : DateTimeImmutable) */
    public static function dateTime(mixed $value, bool $nullable): ?DateTimeImmutable
    {
        if ($value === null && $nullable) {
            return null;
        }
        if ($value instanceof DateTimeImmutable) {
            return $value;
        }
        if ($value instanceof DateTimeInterface) {
            return DateTimeImmutable::createFromInterface($value);
        }
        if (!is_string($value) || $value === '' || preg_match('/(?:Z|[+-]\d{2}:\d{2})$/', $value) !== 1) {
            throw new \UnexpectedValueException('Expected an ISO-8601 timestamp with a UTC offset.');
        }
        try {
            return new DateTimeImmutable($value);
        } catch (\Exception $error) {
            throw new \UnexpectedValueException('Invalid ISO-8601 timestamp.', previous: $error);
        }
    }

    /** @return ($nullable is true ? int|null : int) */
    public static function int(mixed $value, bool $nullable): ?int
    {
        return $value === null && $nullable ? null : (int) ($value ?? 0);
    }

    /** @return ($nullable is true ? float|null : float) */
    public static function float(mixed $value, bool $nullable): ?float
    {
        return $value === null && $nullable ? null : (float) ($value ?? 0.0);
    }

    /** @return ($nullable is true ? bool|null : bool) */
    public static function bool(mixed $value, bool $nullable): ?bool
    {
        return $value === null && $nullable ? null : (bool) ($value ?? false);
    }

    /** @return ($nullable is true ? array<mixed>|null : array<mixed>) */
    public static function array(mixed $value, bool $nullable): ?array
    {
        return $value === null && $nullable ? null : (is_array($value) ? $value : []);
    }

    /**
     * @template T of DomainValue
     * @param non-empty-list<class-string<T>> $classes
     * @return ($nullable is true ? T|null : T)
     */
    public static function object(mixed $value, array $classes, bool $nullable): ?DomainValue
    {
        if ($value === null && $nullable) {
            return null;
        }
        $data = is_array($value) ? $value : [];
        $class = self::classFor($data, $classes);
        return $class::fromArray($data);
    }

    /**
     * @template T of DomainValue
     * @param non-empty-list<class-string<T>> $classes
     * @return list<T>
     */
    public static function objects(mixed $value, array $classes): array
    {
        if (!is_array($value)) {
            return [];
        }
        return array_map(
            static fn(mixed $item): DomainValue => self::object(is_array($item) ? $item : [], $classes, false),
            array_values($value),
        );
    }

    /**
     * @template T of DomainValue
     * @param non-empty-list<class-string<T>> $classes
     * @return array<string, T>
     */
    public static function objectMap(mixed $value, array $classes): array
    {
        if (!is_array($value)) {
            return [];
        }
        return array_map(
            static fn(mixed $item): DomainValue => self::object(is_array($item) ? $item : [], $classes, false),
            $value,
        );
    }

    /**
     * @param array<string, mixed> $data
     * @param list<class-string<DomainValue>> $classes
     * @return class-string<DomainValue>
     */
    private static function classFor(array $data, array $classes): string
    {
        $kind = strtolower((string) ($data['type'] ?? ''));
        if ($kind !== '') {
            foreach ($classes as $class) {
                $short = strtolower((new \ReflectionClass($class))->getShortName());
                if (str_contains($short, str_replace('_', '', $kind))) {
                    return $class;
                }
            }
        }
        return $classes[0] ?? GenericValue::class;
    }
}
