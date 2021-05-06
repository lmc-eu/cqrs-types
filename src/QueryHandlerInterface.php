<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types;

use Lmc\Cqrs\Types\ValueObject\OnErrorInterface;
use Lmc\Cqrs\Types\ValueObject\OnSuccessInterface;

/**
 * @phpstan-template Request
 * @phpstan-template Response
 */
interface QueryHandlerInterface
{
    /** @phpstan-param QueryInterface<mixed> $query */
    public function supports(QueryInterface $query): bool;

    /**
     * @phpstan-param QueryInterface<Request> $query
     * @phpstan-return QueryInterface<Request>
     */
    public function prepare(QueryInterface $query): QueryInterface;

    /**
     * @phpstan-param QueryInterface<Request> $query
     * @phpstan-param OnSuccessInterface<Response> $onSuccess
     */
    public function handle(QueryInterface $query, OnSuccessInterface $onSuccess, OnErrorInterface $onError): void;
}
