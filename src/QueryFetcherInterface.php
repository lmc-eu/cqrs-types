<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types;

use Lmc\Cqrs\Types\Decoder\ResponseDecoderInterface;
use Lmc\Cqrs\Types\ValueObject\OnErrorInterface;
use Lmc\Cqrs\Types\ValueObject\OnSuccessInterface;
use Lmc\Cqrs\Types\ValueObject\PrioritizedItem;

/**
 * @phpstan-template Request
 * @phpstan-template DecodedResponse
 */
interface QueryFetcherInterface
{
    /** @phpstan-param QueryHandlerInterface<mixed, mixed> $handler */
    public function addHandler(QueryHandlerInterface $handler, int $priority): void;

    /**
     * @phpstan-return PrioritizedItem<QueryHandlerInterface<mixed, mixed>>[]
     * @return PrioritizedItem[]
     */
    public function getHandlers(): array;

    /** @phpstan-param ResponseDecoderInterface<mixed, mixed> $decoder */
    public function addDecoder(ResponseDecoderInterface $decoder, int $priority): void;

    /**
     * @phpstan-return PrioritizedItem<ResponseDecoderInterface<mixed, mixed>>[]
     * @return PrioritizedItem[]
     */
    public function getDecoders(): array;

    /**
     * @phpstan-param QueryInterface<Request> $query
     * @phpstan-param OnSuccessInterface<DecodedResponse> $onSuccess
     */
    public function fetch(QueryInterface $query, OnSuccessInterface $onSuccess, OnErrorInterface $onError): void;

    /**
     * @phpstan-param QueryInterface<Request> $query
     * @phpstan-param OnSuccessInterface<DecodedResponse> $onSuccess
     */
    public function fetchFresh(QueryInterface $query, OnSuccessInterface $onSuccess, OnErrorInterface $onError): void;

    /**
     * @phpstan-param QueryInterface<Request> $query
     * @phpstan-return DecodedResponse
     * @throws \Throwable
     * @return mixed
     */
    public function fetchAndReturn(QueryInterface $query);

    /**
     * @phpstan-param QueryInterface<Request> $query
     * @phpstan-return DecodedResponse
     * @throws \Throwable
     * @return mixed
     */
    public function fetchFreshAndReturn(QueryInterface $query);

    public function enableCache(): void;

    public function disableCache(): void;

    public function isCacheEnabled(): bool;

    /** @phpstan-param QueryInterface<Request> $query */
    public function invalidateQueryCache(QueryInterface $query): bool;

    public function invalidateCacheItem(string $cacheKeyHash): bool;
}
