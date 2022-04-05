<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\Fixture;

use Lmc\Cqrs\Types\ValueObject\DecodedValueInterface;

/**
 * @phpstan-implements DecodedValueInterface<string>
 */
class DecodedDummyData implements DecodedValueInterface
{
    public function getValue(): string
    {
        return 'decoded';
    }
}
