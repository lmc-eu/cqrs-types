<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\Decoder;

/**
 * @phpstan-template Response
 * @phpstan-template DecodedResponse
 * @phpstan-extends ResponseDecoderInterface<Response, DecodedResponse>
 */
interface ImpureResponseDecoderInterface extends ResponseDecoderInterface
{
}
