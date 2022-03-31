<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\ValueObject;

class CacheKey
{
    public const DEFAULT_ALOGRITHM = 'sha256';
    public const DONT_HASH = 'do-not-hash';

    private string $key;
    private string $algorithm;
    private ?string $hashedKeyCache = null;

    public function __construct(string $key, ?string $algorithm = null)
    {
        $this->key = $key;
        $this->algorithm = $algorithm ?? self::DEFAULT_ALOGRITHM;
    }

    public function getHashedKey(): string
    {
        if ($this->algorithm === self::DONT_HASH) {
            return $this->key;
        }

        if ($this->hashedKeyCache === null) {
            $this->hashedKeyCache = hash($this->algorithm, $this->key);
        }

        return $this->hashedKeyCache;
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
