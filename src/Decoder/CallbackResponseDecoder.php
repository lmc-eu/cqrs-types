<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\Decoder;

/**
 * @phpstan-template Response
 * @phpstan-template DecodedResponse
 * @phpstan-implements ResponseDecoderInterface<Response, DecodedResponse>
 */
class CallbackResponseDecoder implements ResponseDecoderInterface
{
    /**
     * @phpstan-var callable(mixed): bool
     * @var callable
     */
    private $supports;
    /**
     * @phpstan-var callable(Response): DecodedResponse
     * @var callable
     */
    private $decode;

    /**
     * @phpstan-param callable(mixed): bool $supports
     * @phpstan-param callable(Response): DecodedResponse $decode
     */
    public function __construct(callable $supports, callable $decode)
    {
        $this->supports = $supports;
        $this->decode = $decode;
    }

    /**
     * @param mixed $response
     */
    public function supports($response): bool
    {
        return call_user_func($this->supports, $response);
    }

    /**
     * @phpstan-param Response $response
     * @phpstan-return DecodedResponse
     * @param mixed $response
     * @return mixed
     */
    public function decode($response)
    {
        return call_user_func($this->decode, $response);
    }
}
