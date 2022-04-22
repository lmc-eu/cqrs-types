<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\Decoder;

/**
 * @phpstan-implements ResponseDecoderInterface<string, string|array>
 */
class JsonResponseDecoder implements ResponseDecoderInterface
{
    public function supports(mixed $response, mixed $initiator): bool
    {
        return is_string($response) && is_array(json_decode($response, true));
    }

    public function decode(mixed $response): mixed
    {
        return is_string($response) && is_array($decoded = json_decode($response, true))
            ? $decoded
            : $response;
    }
}
