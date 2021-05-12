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
interface CommandSenderInterface
{
    /** @phpstan-param SendCommandHandlerInterface<mixed, mixed> $handler */
    public function addHandler(SendCommandHandlerInterface $handler, int $priority): void;

    /**
     * @phpstan-return PrioritizedItem<SendCommandHandlerInterface<mixed, mixed>>[]
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
     * @phpstan-param CommandInterface<Request> $command
     * @phpstan-param OnSuccessInterface<DecodedResponse> $onSuccess
     */
    public function send(CommandInterface $command, OnSuccessInterface $onSuccess, OnErrorInterface $onError): void;

    /**
     * @phpstan-param CommandInterface<Request> $command
     * @phpstan-return DecodedResponse
     * @throws \Throwable
     * @return mixed
     */
    public function sendAndReturn(CommandInterface $command);
}
