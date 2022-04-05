<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types;

use Lmc\Cqrs\Types\ValueObject\DecodedValueInterface;

/**
 * @internal
 */
class Utils
{
    /** @param mixed $value */
    public static function getType($value): string
    {
        if ($value instanceof DecodedValueInterface) {
            return sprintf('DecodedValue<%s>', self::getValueType($value->getValue()));
        }

        return self::getValueType($value);
    }

    /** @param mixed $value */
    private static function getValueType($value): string
    {
        return is_object($value)
            ? get_class($value)
            : gettype($value);
    }
}
