<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\Decoder;

use PHPUnit\Framework\TestCase;

class CallbackResponseDecoderTest extends TestCase
{
    /**
     * @test
     */
    public function shouldSupportsByGivenCallback(): void
    {
        $decoder = new CallbackResponseDecoder(
            'is_string',
            fn (string $response) => sprintf('decoded:%s', $response),
        );

        $this->assertTrue($decoder->supports('response'));
        $this->assertFalse($decoder->supports(42));
    }

    /**
     * @test
     */
    public function shouldDecodeByGivenCallback(): void
    {
        $decoder = new CallbackResponseDecoder(
            'is_string',
            fn (string $response) => sprintf('decoded:%s', $response),
        );

        $result = $decoder->decode('response');

        $this->assertSame('decoded:response', $result);
    }
}
