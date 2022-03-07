<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\ValueObject;

use Lmc\Cqrs\Types\Decoder\ResponseDecoderInterface;

/**
 * This is a value object for a special type of value, which you want to explicitly mark as Decoded (from ResponseDecoderInterface)
 * - it won't be decoded again by any other decoder
 *
 * @see ResponseDecoderInterface
 * @phpstan-template Value
 * @phpstan-implements DecodedValueInterface<Value>
 */
class DecodedValue implements DecodedValueInterface
{
    /**
     * @phpstan-param Value $value
     */
    public function __construct(private mixed $value)
    {
    }

    /**
     * @phpstan-return Value
     */
    public function getValue(): mixed
    {
        return $this->value;
    }
}
