<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\ValueObject;

/**
 * @phpstan-template Response
 */
interface OnSuccessInterface
{
    /**
     * @phpstan-param Response $response
     * @param mixed $response
     */
    public function __invoke($response): void;
}
