<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\ValueObject;

/**
 * @phpstan-template Item
 */
class PrioritizedItem
{
    public const PRIORITY_HIGHEST = 100;
    public const PRIORITY_HIGH = 80;
    public const PRIORITY_MEDIUM = 50;
    public const PRIORITY_LOW = 10;
    public const PRIORITY_LOWEST = 1;

    /**
     * @phpstan-param self<mixed> $a
     * @phpstan-param self<mixed> $b
     */
    public static function compare(self $a, self $b): int
    {
        return $b->getPriority() <=> $a->getPriority();
    }

    /**
     * @phpstan-param Item $item
     */
    public function __construct(private mixed $item, private int $priority)
    {
    }

    /**
     * @phpstan-return Item
     */
    public function getItem(): mixed
    {
        return $this->item;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }
}
