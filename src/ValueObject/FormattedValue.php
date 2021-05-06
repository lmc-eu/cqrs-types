<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\ValueObject;

use Lmc\Cqrs\Types\Utils;

/**
 * @phpstan-template Original
 * @phpstan-template Formatted
 */
class FormattedValue
{
    /**
     * @phpstan-var Original
     * @var mixed
     */
    private $original;
    /**
     * @phpstan-var Formatted
     * @var mixed
     */
    private $formatted;
    private bool $isWide;

    /**
     * @phpstan-param Original $original
     * @phpstan-param Formatted $formatted
     * @param mixed $original
     * @param mixed $formatted
     */
    public function __construct($original, $formatted, bool $isWide = false)
    {
        $this->original = $original;
        $this->formatted = $formatted;
        $this->isWide = $isWide;
    }

    /**
     * @phpstan-return Original
     * @return mixed
     */
    public function getOriginal()
    {
        return $this->original;
    }

    /**
     * @phpstan-return Formatted
     * @return mixed
     */
    public function getFormatted()
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
