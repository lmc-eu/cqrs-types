<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\ValueObject;

class ProfilerItem
{
    public const TYPE_QUERY = 'query';
    public const TYPE_COMMAND = 'command';
    public const TYPE_OTHER = 'other';

    private string $profilerId;
    private array $additionalData;
    private string $itemType;

    private ?string $type;
    /** @var mixed */
    private $response;
    /** @var \Throwable|FormattedValue<mixed, mixed>|null */
    private $error;
    private ?CacheKey $cacheKey;
    private ?bool $isLoadedFromCache;
    private ?bool $isStoredInCache;
    private ?int $storedInCacheFor;
    private ?int $duration;
    private ?string $handledBy;
    private array $decodedBy;

    /**
     * @param mixed $response
     * @param \Throwable|FormattedValue<mixed, mixed>|null $error
     */
    public function __construct(
        string $profilerId,
        ?array $additionalData,
        string $itemType,
        ?string $type = null,
        $response = null,
        $error = null,
        ?CacheKey $cacheKey = null,
        ?bool $isLoadedFromCache = null,
        ?bool $isStoredInCache = null,
        ?int $storedInCacheFor = null,
        ?int $duration = null,
        ?string $handledBy = null,
        array $decodedBy = []
    ) {
        $this->profilerId = $profilerId;
        $this->additionalData = $additionalData ?? [];
        $this->itemType = $this->matchItemType($itemType);

        $this->type = $type;
        $this->response = $response;
        $this->error = $error;
        $this->cacheKey = $cacheKey;
        $this->isLoadedFromCache = $isLoadedFromCache;
        $this->isStoredInCache = $isStoredInCache;
        $this->storedInCacheFor = $storedInCacheFor;
        $this->duration = $duration;
        $this->handledBy = $handledBy;
        $this->decodedBy = $decodedBy;
    }

    private function matchItemType(string $type): string
    {
        switch (mb_strtolower(trim($type))) {
            case self::TYPE_QUERY:
                return self::TYPE_QUERY;
            case self::TYPE_COMMAND:
                return self::TYPE_COMMAND;
            default:
                return self::TYPE_OTHER;
        }
    }

    public function getProfilerId(): string
    {
        return $this->profilerId;
    }

    /** @param mixed|FormattedValue<mixed, mixed> $additionalData */
    public function setAdditionalData(string $key, $additionalData): void
    {
        $this->additionalData[$key] = $additionalData;
    }

    public function getAdditionalData(): array
    {
        return $this->additionalData;
    }

    public function getItemType(): string
    {
        return $this->itemType;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /** @return mixed|FormattedValue<mixed, mixed> */
    public function getResponse()
    {
        return $this->response;
    }

    /** @param mixed|FormattedValue<mixed, mixed> $response */
    public function setResponse($response): void
    {
        $this->response = $response;
    }

    /** @return \Throwable|FormattedValue<mixed, mixed>|null */
    public function getError()
    {
        return $this->error;
    }

    /** @param \Throwable|FormattedValue<mixed, mixed>|null $error */
    public function setError($error): void
    {
        $this->error = $error;
    }

    public function getCacheKey(): ?CacheKey
    {
        return $this->cacheKey;
    }

    public function setCacheKey(?CacheKey $cacheKey): void
    {
        $this->cacheKey = $cacheKey;
    }

    public function isStoredInCache(): ?bool
    {
        return $this->isStoredInCache;
    }

    public function getStoredInCacheFor(): ?int
    {
        return $this->storedInCacheFor;
    }

    public function setIsStoredInCache(?bool $isStoredInCache, ?int $lifetime): void
    {
        $this->isStoredInCache = $isStoredInCache;
        $this->storedInCacheFor = $lifetime;
    }

    public function isLoadedFromCache(): ?bool
    {
        return $this->isLoadedFromCache;
    }

    public function setIsLoadedFromCache(?bool $isLoadedFromCache): void
    {
        $this->isLoadedFromCache = $isLoadedFromCache;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): void
    {
        $this->duration = $duration;
    }

    public function getHandledBy(): ?string
    {
        return $this->handledBy;
    }

    public function setHandledBy(?string $handledBy): void
    {
        $this->handledBy = $handledBy;
    }

    public function getDecodedBy(): array
    {
        return $this->decodedBy;
    }

    public function setDecodedBy(array $decodedBy): void
    {
        $this->decodedBy = $decodedBy;
    }
}
