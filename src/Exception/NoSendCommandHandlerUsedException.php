<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\Exception;

use Lmc\Cqrs\Types\CommandInterface;
use Lmc\Cqrs\Types\SendCommandHandlerInterface;
use Lmc\Cqrs\Types\ValueObject\PrioritizedItem;

class NoSendCommandHandlerUsedException extends \InvalidArgumentException implements CqrsExceptionInterface
{
    /** @phpstan-var CommandInterface<mixed> */
    private CommandInterface $command;
    /** @phpstan-var PrioritizedItem<SendCommandHandlerInterface<mixed, mixed>>[] */
    private array $currentHandlers;

    /**
     * @phpstan-param CommandInterface<mixed> $command
     * @phpstan-param PrioritizedItem<SendCommandHandlerInterface<mixed, mixed>>[] $currentHandlers
     */
    public function __construct(
        string $message,
        CommandInterface $command,
        array $currentHandlers,
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->command = $command;
        $this->currentHandlers = $currentHandlers;
    }

    /**
     * @phpstan-param CommandInterface<mixed> $command
     * @phpstan-param PrioritizedItem<SendCommandHandlerInterface<mixed, mixed>>[] $currentHandlers
     */
    public static function create(
        CommandInterface $command,
        array $currentHandlers,
        int $code = 0,
        ?\Throwable $previous = null
    ): self {
        return new self('There is no handler for a given Command.', $command, $currentHandlers, $code, $previous);
    }

    /** @phpstan-return CommandInterface<mixed> */
    public function getCommand(): CommandInterface
    {
        return $this->command;
    }

    /**
     * @phpstan-return PrioritizedItem<SendCommandHandlerInterface<mixed, mixed>>[]
     * @return PrioritizedItem[]
     */
    public function getCurrentHandlers(): array
    {
        return $this->currentHandlers;
    }
}
