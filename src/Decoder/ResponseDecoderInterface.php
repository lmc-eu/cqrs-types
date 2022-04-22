<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\Decoder;

use Lmc\Cqrs\Types\ValueObject\DecodedValue;

/**
 * @phpstan-template Response
 * @phpstan-template DecodedResponse
 */
interface ResponseDecoderInterface
{
    public function supports(mixed $response, mixed $initiator): bool;

    /**
     * Note: If your decode method returns a DecodedValue - it won't be further decoded by any other decoder.
     * @see DecodedValue
     *
     * @phpstan-param Response $response
     * @phpstan-return DecodedResponse
     */
    public function decode(mixed $response): mixed;
}
