<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types;

use Lmc\Cqrs\Types\ValueObject\DecodedValueInterface;

/**
 * @internal
 */
class Utils
{
    public static function getType(mixed $value): string
    {
        if ($value instanceof DecodedValueInterface) {
            return sprintf('DecodedValue<%s>', self::getValueType($value->getValue()));
        }

        return self::getValueType($value);
    }

    private static function getValueType(mixed $value): string
    {
        return is_object($value)
            ? get_class($value)
            : gettype($value);
    }
}
