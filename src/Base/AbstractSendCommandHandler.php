<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\Base;

use Lmc\Cqrs\Types\CommandInterface;
use Lmc\Cqrs\Types\Exception\UnsupportedRequestException;
use Lmc\Cqrs\Types\SendCommandHandlerInterface;
use Lmc\Cqrs\Types\ValueObject\OnErrorInterface;

/**
 * @phpstan-template Request
 * @phpstan-template Response
 * @phpstan-implements SendCommandHandlerInterface<Request, Response>
 */
abstract class AbstractSendCommandHandler implements SendCommandHandlerInterface
{
    /**
     * @phpstan-param CommandInterface<Request> $command
     * @phpstan-return CommandInterface<Request>
     */
    public function prepare(CommandInterface $command): CommandInterface
    {
        return $command;
    }

    /**
     * @phpstan-param CommandInterface<Request> $command
     */
    protected function assertIsSupported(string $expected, CommandInterface $command, OnErrorInterface $onError): bool
    {
        if (!$this->supports($command)) {
            $onError(UnsupportedRequestException::create($expected, $command->getRequestType()));

            return false;
        }

        return true;
    }
}
