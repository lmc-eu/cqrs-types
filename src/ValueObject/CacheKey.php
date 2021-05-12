<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\ValueObject;

class CacheKey
{
    public const DEFAULT_ALOGRITHM = 'sha256';
    public const DONT_HASH = 'do-not-hash';

    private string $key;
    private string $algorithm;

    public function __construct(string $key, ?string $algorithm = null)
    {
        $this->key = $key;
        $this->algorithm = $algorithm ?? self::DEFAULT_ALOGRITHM;
    }

    public function getHashedKey(): string
    {
        return $this->algorithm === self::DONT_HASH
            ? $this->key
            : hash($this->algorithm, $this->key);
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getAlgorithm(): string
    {
        return $this->algorithm;
    }

    public function __toString(): string
    {
        return $this->getHashedKey();
    }
}
