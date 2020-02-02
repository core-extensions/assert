<?php

/** @noinspection PhpParamsInspection */
/** @noinspection PhpHierarchyChecksInspection */

declare(strict_types=1);

namespace CoreExtensions\Assert\Tests;

use CoreExtensions\Assert\Assert;
use CoreExtensions\Assert\Exception\AssertionFailedException;
use CoreExtensions\Assert\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class AssertTest extends TestCase
{
    /**
     * @test
     */
    public function keysExists_should_throw_exception(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected value must contains keys x, y, z. Not found keys: z');

        Assert::keysExists(['x' => 1, 'y' => 3], ['x', 'y', 'z']);
    }

    /**
     * @test
     */
    public function keysExists_should_not_throw_exception(): void
    {
        Assert::keysExists(['x' => 1, 'y' => 3, 'z' => 4], ['x', 'y']);
        static::assertTrue(true);
    }

    /**
     * @test
     */
    public function arrayNotEmpty_should_throw_exceptions(): void
    {
        $thrown = 0;

        try {
            Assert::arrayNotEmpty([]);
        } catch (\Throwable $e) {
            ++$thrown;
        }

        try {
            Assert::arrayNotEmpty(null);
        } catch (\Throwable $e) {
            ++$thrown;
        }

        try {
            Assert::arrayNotEmpty(false);
        } catch (\Throwable $e) {
            ++$thrown;
        }

        try {
            Assert::arrayNotEmpty('string');
        } catch (\Throwable $e) {
            ++$thrown;
        }

        try {
            Assert::arrayNotEmpty(1);
        } catch (\Throwable $e) {
            ++$thrown;
        }

        static::assertSame(5, $thrown);
    }

    /**
     * @test
     */
    public function arrayNotEmpty_should_not_throw_exceptions(): void
    {
        Assert::arrayNotEmpty([1]);
        Assert::arrayNotEmpty([0]);
        Assert::arrayNotEmpty(['x' => 0]);
        Assert::arrayNotEmpty([false]);
        Assert::arrayNotEmpty([null]);

        static::assertTrue(true);
    }

    /**
     * @test
     */
    public function nullOrArrayNotEmpty_should_throw_exceptions(): void
    {
        $thrown = 0;

        try {
            Assert::nullOrArrayNotEmpty([]);
        } catch (\Throwable $e) {
            ++$thrown;
        }

        try {
            Assert::nullOrArrayNotEmpty(false);
        } catch (\Throwable $e) {
            ++$thrown;
        }

        try {
            Assert::nullOrArrayNotEmpty('string');
        } catch (\Throwable $e) {
            ++$thrown;
        }

        try {
            Assert::nullOrArrayNotEmpty(1);
        } catch (\Throwable $e) {
            ++$thrown;
        }

        static::assertSame(4, $thrown);
    }

    /**
     * @test
     */
    public function nullOrArrayNotEmpty_should_not_throw_exceptions(): void
    {
        Assert::nullOrArrayNotEmpty(null);
        Assert::nullOrArrayNotEmpty([1]);
        Assert::nullOrArrayNotEmpty([0]);
        Assert::nullOrArrayNotEmpty(['x' => 0]);
        Assert::nullOrArrayNotEmpty([false]);
        Assert::nullOrArrayNotEmpty([null]);

        static::assertTrue(true);
    }

    /**
     * @test
     */
    public function valueBetween_throws_if_value_not_in_range(): void
    {
        $this->expectException(AssertionFailedException::class);

        Assert::valueBetween(-5, 0, 10);
    }

    /**
     * @test
     */
    public function valueBetween_passes_if_value_in_range(): void
    {
        Assert::valueBetween(10, 0, 10);
        Assert::valueBetween(0, 0, 10);

        static::assertTrue(true);
    }

    /**
     * @test
     */
    public function email_exists_and_passes_if_value_is_email(): void
    {
        Assert::email('ivanov@mail.ru');
        static::assertTrue(true);
    }

    /**
     * @test
     */
    public function isInstanceOf_exists_and_passes_if_value_is_email(): void
    {
        Assert::isInstanceOf($this, static::class);
        static::assertTrue(true);
    }
}
