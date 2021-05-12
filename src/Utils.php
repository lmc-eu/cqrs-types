<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types;

/**
 * @internal
 */
class Utils
{
    /** @param mixed $value */
    public static function getType($value): string
    {
        return is_object($value)
            ? get_class($value)
            : gettype($value);
    }
}
