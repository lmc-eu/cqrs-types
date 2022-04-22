<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\Decoder;

use PHPUnit\Framework\TestCase;

class JsonResponseDecoderTest extends TestCase
{
    /**
     * @dataProvider provideStringInput
     *
     * @test
     */
    public function shouldDecodeGivenString(?string $input, bool $supports, string|array|null $expected): void
    {
        $decoder = new JsonResponseDecoder();

        $this->assertSame($supports, $decoder->supports($input, null));
        $this->assertSame($expected, $decoder->decode($input));
    }

    public function provideStringInput(): array
    {
        return [
            'null' => [null, false, null],
            'empty' => ['', false, ''],
            'not a json' => ['not a json', false, 'not a json'],
            'empty array' => ['[]', true, []],
            'empty object' => ['{}', true, []],
            'json' => ['{"key": "value"}', true, ['key' => 'value']],
            'invalid json' => ['{key: "invalid"}', false, '{key: "invalid"}'],
        ];
    }
}
