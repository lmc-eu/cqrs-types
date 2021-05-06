<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\Feature;

use Lmc\Cqrs\Types\ValueObject\CacheKey;
use Lmc\Cqrs\Types\ValueObject\CacheTime;

interface CacheableInterface
{
    public function getCacheKey(): CacheKey;

    public function getCacheTime(): CacheTime;
}
