<?php

declare(strict_types=1);

namespace CoreExtensions\Assert;

use CoreExtensions\Assert\Exception\InvalidArgumentException;
use Webmozart\Assert\Assert as BaseAssert;

/**
 * @method static void nullOrPhoneNumber(string $value, string $message = '')
 * @method static void nullOrEmail(string $value, string $message = '')
 * @method static void nullOrArrayNotEmpty(array $value, string $message = '')
 */
final class Assert extends BaseAssert
{
    /**
     * @param $value
     *
     * @throws \InvalidArgumentException
     */
    public static function phoneNumber($value, string $message = ''): void
    {
        // todo реализовать точную проверку по маске
        static::minLength(
            $value,
            3,
            \sprintf(
                $message
                    ?: 'Expected a phone number not empty and consists of at least 3 characters.'
            )
        );
    }

    /**
     * @param float|int $value
     * @param float|int $min   Min value inclusive
     * @param float|int $max   Max value inclusive
     *
     * @throws \InvalidArgumentException
     */
    public static function valueBetween($value, $min, $max, string $message = ''): void
    {
        self::numeric($value);
        self::numeric($min);
        self::numeric($max);

        if ($value < $min || $value > $max) {
            static::reportInvalidArgument(
                \sprintf(
                    $message ?: 'Expected value between %d and %d. Got: %d',
                    $min,
                    $max,
                    $value
                )
            );
        }
    }

    /**
     * Checks that $value contains all $keys.
     *
     * @param array $value
     * @param array $keys
     */
    public static function keysExists($value, $keys, string $message = ''): void
    {
        self::isArray($value);
        self::isArray($keys);
        self::notEmpty($keys);

        $valueKeys = \array_keys($value);
        $diff = \array_diff($keys, $valueKeys);

        if ($diff) {
            static::reportInvalidArgument(
                \sprintf(
                    $message ?: 'Expected value must contains keys %s. Not found keys: %s',
                    \implode(', ', $keys),
                    \implode(', ', $diff)
                )
            );
        }
    }

    public static function arrayNotEmpty($value, string $message = ''): void
    {
        static::isArray($value, $message);
        static::notEmpty($value, $message);
    }

    public static function notOneOf($value, array $values, string $message = ''): void
    {
        if (\in_array($value, $values, true)) {
            static::reportInvalidArgument(
                \sprintf(
                    $message ?: 'Expected value not one of: %2$s. Got: %s',
                    static::valueToString($value),
                    \implode(', ', \array_map(['static', 'valueToString'], $values))
                )
            );
        }
    }

    protected static function reportInvalidArgument($message): void
    {
        throw new InvalidArgumentException($message);
    }
}
