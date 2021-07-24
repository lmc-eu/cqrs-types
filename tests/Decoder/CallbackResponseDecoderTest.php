<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\Decoder;

use PHPUnit\Framework\TestCase;

class CallbackResponseDecoderTest extends TestCase
{
    /**
     * @test
     */
    public function shouldSupportsResponseByGivenCallback(): void
    {
        $decoder = new CallbackResponseDecoder(
            fn (string $response, $initiator) => $response === 'response',
            fn (string $response) => sprintf('decoded:%s', $response),
        );

        $this->assertTrue($decoder->supports('response', null));
        $this->assertFalse($decoder->supports(42, null));
    }

    /**
     * @test
     */
    public function shouldSupportsInitiatorByGivenCallback(): void
    {
        $decoder = new CallbackResponseDecoder(
            fn (string $response, ?string $initiator) => $initiator === 'initiator',
            fn (string $response) => sprintf('decoded:%s', $response),
        );

        $this->assertTrue($decoder->supports('response', 'initiator'));
        $this->assertFalse($decoder->supports('response', null));
    }

    /**
     * @test
     */
    public function shouldDecodeByGivenCallback(): void
    {
        $decoder = new CallbackResponseDecoder(
            fn (string $response, $initiator) => is_string($response),
            fn (string $response) => sprintf('decoded:%s', $response),
        );

        $result = $decoder->decode('response');

        $this->assertSame('decoded:response', $result);
    }
}
