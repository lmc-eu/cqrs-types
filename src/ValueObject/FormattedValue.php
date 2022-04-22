<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\ValueObject;

use Lmc\Cqrs\Types\Utils;

/**
 * @phpstan-template Original
 * @phpstan-template Formatted
 */
class FormattedValue implements \Stringable
{
    /**
     * @phpstan-param Original $original
     * @phpstan-param Formatted $formatted
     */
    public function __construct(private mixed $original, private mixed $formatted, private bool $isWide = false)
    {
    }

    /**
     * @phpstan-return Original
     */
    public function getOriginal(): mixed
    {
        return $this->original;
    }

    /**
     * @phpstan-return Formatted
     */
    public function getFormatted(): mixed
    {
        return $this->formatted;
    }

    public function isWide(): bool
    {
        return $this->isWide;
    }

    public function __toString(): string
    {
        if (is_string($this->formatted)) {
            return $this->formatted;
        }

        if (is_string($this->original)) {
            return $this->original;
        }

        return sprintf(
            'FormattedValue<%s, %s>',
            Utils::getType($this->original),
            Utils::getType($this->formatted),
        );
    }
}
