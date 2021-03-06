<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\Exception;

use Lmc\Cqrs\Types\QueryHandlerInterface;
use Lmc\Cqrs\Types\QueryInterface;
use Lmc\Cqrs\Types\ValueObject\PrioritizedItem;

class NoQueryHandlerUsedException extends \InvalidArgumentException implements CqrsExceptionInterface
{
    /**
     * @phpstan-param QueryInterface<mixed> $query
     * @phpstan-param PrioritizedItem<QueryHandlerInterface<mixed, mixed>>[] $currentHandlers
     */
    public function __construct(
        string $message,
        private QueryInterface $query,
        private array $currentHandlers,
        int $code = 0,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @phpstan-param QueryInterface<mixed> $query
     * @phpstan-param PrioritizedItem<QueryHandlerInterface<mixed, mixed>>[] $currentHandlers
     */
    public static function create(
        QueryInterface $query,
        array $currentHandlers,
        int $code = 0,
        ?\Throwable $previous = null,
    ): self {
        return new self('There is no handler for a given Query.', $query, $currentHandlers, $code, $previous);
    }

    /** @phpstan-return QueryInterface<mixed> */
    public function getQuery(): QueryInterface
    {
        return $this->query;
    }

    /**
     * @phpstan-return PrioritizedItem<QueryHandlerInterface<mixed, mixed>>[]
     * @return PrioritizedItem[]
     */
    public function getCurrentHandlers(): array
    {
        return $this->currentHandlers;
    }
}
