<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types;

use Lmc\Cqrs\Types\ValueObject\OnErrorInterface;
use Lmc\Cqrs\Types\ValueObject\OnSuccessInterface;

/**
 * @phpstan-template Request
 * @phpstan-template Response
 */
interface SendCommandHandlerInterface
{
    /** @phpstan-param CommandInterface<mixed> $command */
    public function supports(CommandInterface $command): bool;

    /**
     * @phpstan-param CommandInterface<Request> $command
     * @phpstan-return CommandInterface<Request>
     */
    public function prepare(CommandInterface $command): CommandInterface;

    /**
     * @phpstan-param CommandInterface<Request> $command
     * @phpstan-param OnSuccessInterface<Response> $onSuccess
     */
    public function handle(CommandInterface $command, OnSuccessInterface $onSuccess, OnErrorInterface $onError): void;
}
