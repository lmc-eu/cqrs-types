<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\ValueObject;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class CacheKeyTest extends TestCase
{
    #[Test]
    public function shouldHashCacheKeyWithDefaultAlgorithm(): void
    {
        $key = new CacheKey('key');

        $this->assertSame('key', $key->getKey());
        $this->assertSame('sha256', $key->getAlgorithm());
        $this->assertSame(hash('sha256', 'key'), $key->getHashedKey());
        $this->assertSame(hash('sha256', 'key'), (string) $key);
    }

    #[Test]
    public function shouldNotHashCacheKey(): void
    {
        $key = new CacheKey('key', CacheKey::DONT_HASH);

        $this->assertSame('key', $key->getKey());
        $this->assertSame('do-not-hash', $key->getAlgorithm());
        $this->assertSame('key', $key->getHashedKey());
        $this->assertSame('key', (string) $key);
    }

    #[Test]
    public function shouldHashCacheKeyByCustomAlgorithm(): void
    {
        $key = new CacheKey('key', 'md5');

        $this->assertSame('key', $key->getKey());
        $this->assertSame('md5', $key->getAlgorithm());
        $this->assertSame(md5('key'), $key->getHashedKey());
        $this->assertSame(md5('key'), (string) $key);
    }
}
