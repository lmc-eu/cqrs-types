<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\ValueObject;

/**
 * This is a value object for a special type of value, which you want to explicitly mark as Decoded (from ResponseDecoderInterface)
 * - it won't be decoded again by any other decoder
 *
 * @see ResponseDecoderInterface
 * @phpstan-template Value
 */
interface DecodedValueInterface
{
    /**
     * @phpstan-return Value
     */
    public function getValue(): mixed;
}
