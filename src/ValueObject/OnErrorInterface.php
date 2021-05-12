<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\ValueObject;

interface OnErrorInterface
{
    public function __invoke(\Throwable $error): void;
}
