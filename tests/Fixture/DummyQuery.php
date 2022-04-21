<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\Fixture;

use Lmc\Cqrs\Types\QueryInterface;

/**
 * @phpstan-implements QueryInterface<string>
 */
class DummyQuery implements QueryInterface
{
    public function __construct(private string $response)
    {
    }

    public function getRequestType(): string
    {
        return self::class;
    }

    public function createRequest(): string
    {
        return $this->response;
    }

    public function __toString(): string
    {
        return $this->response;
    }
}
