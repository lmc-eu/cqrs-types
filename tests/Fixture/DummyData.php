<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\Fixture;

class DummyData
{
    public function __construct(private string $value)
    {
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
