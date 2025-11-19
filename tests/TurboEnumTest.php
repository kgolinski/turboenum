<?php

use KGolinski\TurboEnum\Enums\TestBackedEnum;
use KGolinski\TurboEnum\Enums\TestEnum;

describe('Turbo Enum Trait', function () {
    it('outputs names correctly', function () {
        $this->expect(TestEnum::names())->toEqual(['one', 'two']);
        $this->expect(TestBackedEnum::names())->toEqual(['one', 'two']);
    });

    it('outputs values correctly', function () {
        $this->expect(fn () => TestEnum::values())->toThrow(new BadMethodCallException('KGolinski\TurboEnum\Enums\TestEnum is not a backed enum'));
        $this->expect(TestBackedEnum::values())->toEqual([1, 2]);
    });

    it('shows if enum has name correctly', function () {
        $this->expect(TestEnum::hasName('one'))->toBeTrue();
        $this->expect(TestEnum::hasName('three'))->toBeFalse();

        $this->expect(TestBackedEnum::hasName('one'))->toBeTrue();
        $this->expect(TestBackedEnum::hasName('three'))->toBeFalse();
    });

    it('shows if enum has value correctly', function () {
        $this->expect(fn () => TestEnum::hasValue('one'))->toThrow(new BadMethodCallException('KGolinski\TurboEnum\Enums\TestEnum is not a backed enum'));
        $this->expect(fn () => TestEnum::hasValue('three'))->toThrow(new BadMethodCallException('KGolinski\TurboEnum\Enums\TestEnum is not a backed enum'));

        $this->expect(TestBackedEnum::hasValue(1))->toBeTrue();
        $this->expect(TestBackedEnum::hasValue(3))->toBeFalse();
    });

    it('is possible to create enum from proper name', function () {
        $this->expect(TestEnum::fromName('one'))->toEqual(TestEnum::one);
        $this->expect(TestBackedEnum::fromName('one'))->toEqual(TestBackedEnum::one);
    });

    it('throws exception when creating enum from invalid name', function () {
        $this->expect(fn () => TestEnum::fromName('three'))->toThrow(new InvalidArgumentException('KGolinski\TurboEnum\Enums\TestEnum has no name: three'));
        $this->expect(fn () => TestBackedEnum::fromName('three'))->toThrow(new InvalidArgumentException('KGolinski\TurboEnum\Enums\TestBackedEnum has no name: three'));
    });

    it('is possible to create enum from proper value', function () {
        $this->expect(fn () => TestEnum::fromValue(1))->toThrow(new BadMethodCallException('KGolinski\TurboEnum\Enums\TestEnum is not a backed enum'));
        $this->expect(TestBackedEnum::fromValue(1))->toEqual(TestBackedEnum::one);
    });

    it('throws exception when creating enum from invalid value', function () {
        $this->expect(fn () => TestEnum::fromValue(3))->toThrow(new BadMethodCallException('KGolinski\TurboEnum\Enums\TestEnum is not a backed enum'));
        $this->expect(fn () => TestBackedEnum::fromValue(3))->toThrow(new InvalidArgumentException('KGolinski\TurboEnum\Enums\TestBackedEnum has no value: 3'));
    });

    it('outputs options correctly', function () {
        $this->expect(TestEnum::options())->toEqual(['one', 'two']);
        $this->expect(TestBackedEnum::options())->toEqual(['one' => 1, 'two' => 2]);
    });

    it('generates random enum', function () {
        $this->expect(TestEnum::random())->toBeInstanceOf(TestEnum::class);
        $this->expect(TestBackedEnum::random())->toBeInstanceOf(TestBackedEnum::class);
    });

    it('generates random enum different than given', function () {
        $this->expect(TestEnum::randomExcept(TestEnum::one))->not->toEqual(TestEnum::one);
        $this->expect(TestBackedEnum::randomExcept(TestBackedEnum::one))->not->toEqual(TestBackedEnum::one);
    });
});
