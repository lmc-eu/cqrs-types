<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\ValueObject;

/**
 * @phpstan-template Response
 */
interface OnSuccessInterface
{
    /**
     * @phpstan-param Response $response
     */
    public function __invoke(mixed $response): void;
}
