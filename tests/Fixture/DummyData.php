<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\Fixture;

class DummyData
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
