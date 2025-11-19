<?php

// Distilled from: https://github.com/archtechx/enums

namespace KGolinski\TurboEnum\Traits;

use BackedEnum;

trait TurboEnum
{
    public static function names(): array
    {
        return array_map(fn ($c) => $c->name, static::cases());
    }

    public static function values(): ?array
    {
        $cases = static::cases();
        // @phpstan-ignore instanceof.alwaysTrue
        if (! ($cases[0] instanceof BackedEnum)) {
            throw new \BadMethodCallException(static::class.' is not a backed enum');
        }

        return array_map(fn ($c) => $c->value, $cases);
    }

    public static function hasName(string $name): bool
    {
        $names = static::names();

        return in_array($name, $names, true);
    }

    public static function hasValue(mixed $value): bool
    {
        $values = static::values();

        return $values ? in_array($value, $values, true) : false;
    }

    public static function fromName(string $name): self
    {
        if (! self::hasName($name)) {
            throw new \InvalidArgumentException(static::class." has no name: $name");
        }

        return constant("self::$name");
    }

    public static function fromValue(mixed $value): self
    {
        settype($value, gettype(static::values()[0]));
        if (! self::hasValue($value)) {
            throw new \InvalidArgumentException(static::class." has no value: $value");
        }

        return self::from($value);
    }

    public static function options(): array
    {
        $cases = static::cases();

        // @phpstan-ignore instanceof.alwaysTrue
        return $cases[0] instanceof BackedEnum ? array_column($cases, 'value', 'name') : array_column($cases, 'name');
    }

    public static function random(): self
    {
        $cases = static::cases();

        return $cases[array_rand($cases)];
    }

    public static function randomExcept(self ...$exceptions): self
    {
        $cases = static::cases();
        // @phpstan-ignore instanceof.alwaysTrue (trait is used by both backed and non-backed enums)
        $exceptions = $cases[0] instanceof BackedEnum
            ? array_map(fn ($e) => $e->value, $exceptions)
            : array_map(fn ($e) => $e->name, $exceptions);
        // @phpstan-ignore instanceof.alwaysTrue (trait is used by both backed and non-backed enums)
        $filteredCases = $cases[0] instanceof BackedEnum
            ? array_filter($cases, fn ($case) => ! in_array($case->value, $exceptions))
            : array_filter($cases, fn ($case) => ! in_array($case->name, $exceptions));

        return $filteredCases[array_rand($filteredCases)];
    }
}
