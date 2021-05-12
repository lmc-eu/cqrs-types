<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\Base;

use Lmc\Cqrs\Types\Exception\UnsupportedRequestException;
use Lmc\Cqrs\Types\QueryHandlerInterface;
use Lmc\Cqrs\Types\QueryInterface;
use Lmc\Cqrs\Types\ValueObject\OnErrorInterface;

/**
 * @phpstan-template Request
 * @phpstan-template Response
 * @phpstan-implements QueryHandlerInterface<Request, Response>
 */
abstract class AbstractQueryHandler implements QueryHandlerInterface
{
    /**
     * @phpstan-param QueryInterface<Request> $query
     * @phpstan-return QueryInterface<Request>
     */
    public function prepare(QueryInterface $query): QueryInterface
    {
        return $query;
    }

    /**
     * @phpstan-param QueryInterface<Request> $query
     */
    protected function assertIsSupported(string $expected, QueryInterface $query, OnErrorInterface $onError): bool
    {
        if (!$this->supports($query)) {
            $onError(UnsupportedRequestException::create($expected, $query->getRequestType()));

            return false;
        }

        return true;
    }
}
