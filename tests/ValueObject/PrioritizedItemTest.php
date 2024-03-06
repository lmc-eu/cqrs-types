<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\ValueObject;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class PrioritizedItemTest extends TestCase
{
    #[Test]
    public function shouldSortPrioritizedItemsByPriority(): void
    {
        $items = [
            new PrioritizedItem('f: -1', -1),
            new PrioritizedItem('a: 3', 3),
            new PrioritizedItem('b: 10', 10),
            new PrioritizedItem('c: 5', 5),
            new PrioritizedItem('d: 2', 2),
            new PrioritizedItem('e: 5', 5),
        ];

        uasort($items, [PrioritizedItem::class, 'compare']);

        $values =
            array_values(
                array_map(
                    fn (PrioritizedItem $item) => $item->getItem(),
                    $items,
                ),
            );

        $this->assertSame(
            [
                'b: 10',
                'c: 5',
                'e: 5',
                'a: 3',
                'd: 2',
                'f: -1',
            ],
            $values,
        );
    }
}
