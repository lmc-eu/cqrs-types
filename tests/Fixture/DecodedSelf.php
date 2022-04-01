<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\Fixture;

use Lmc\Cqrs\Types\ValueObject\DecodedValueInterface;

/**
 * @phpstan-implements DecodedValueInterface<DecodedSelf>
 */
class DecodedSelf implements DecodedValueInterface
{
    public function getValue(): self
    {
        return $this;
    }
}
