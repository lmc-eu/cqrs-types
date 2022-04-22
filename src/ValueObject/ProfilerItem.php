<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\ValueObject;

class ProfilerItem
{
    public const TYPE_QUERY = 'query';
    public const TYPE_COMMAND = 'command';
    public const TYPE_OTHER = 'other';

    private array $additionalData;
    private string $itemType;

    /**
     * @phpstan-param \Throwable|FormattedValue<mixed, mixed>|null $error
     */
    public function __construct(
        private string $profilerId,
        ?array $additionalData,
        string $itemType,
        private ?string $type = null,
        private mixed $response = null,
        private \Throwable|FormattedValue|null $error = null,
        private ?CacheKey $cacheKey = null,
        private ?bool $isLoadedFromCache = null,
        private ?bool $isStoredInCache = null,
        private ?int $storedInCacheFor = null,
        private ?int $duration = null,
        private ?string $handledBy = null,
        private array $decodedBy = [],
    ) {
        $this->additionalData = $additionalData ?? [];
        $this->itemType = $this->matchItemType($itemType);

        $this->setResponse($response);
        $this->setError($error);
    }

    private function matchItemType(string $type): string
    {
        return match (mb_strtolower(trim($type))) {
            self::TYPE_QUERY => self::TYPE_QUERY,
            self::TYPE_COMMAND => self::TYPE_COMMAND,
            default => self::TYPE_OTHER,
        };
    }

    public function getProfilerId(): string
    {
        return $this->profilerId;
    }

    /** @phpstan-param mixed|FormattedValue<mixed, mixed> $additionalData */
    public function setAdditionalData(string $key, mixed $additionalData): void
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

    /** @phpstan-return mixed|FormattedValue<mixed, mixed> */
    public function getResponse(): mixed
    {
        return $this->response;
    }

    /** @phpstan-param mixed|FormattedValue<mixed, mixed> $response */
    public function setResponse(mixed $response): void
    {
        $this->response = $this->copy($response);
    }

    private function copy(mixed $value): mixed
    {
        return is_object($value)
            ? clone $value
            : $value;
    }

    /** @phpstan-return \Throwable|FormattedValue<mixed, mixed>|null */
    public function getError(): \Throwable|FormattedValue|null
    {
        return $this->error;
    }

    /** @phpstan-param \Throwable|FormattedValue<mixed, mixed>|null $error */
    public function setError(\Throwable|FormattedValue|null $error): void
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
