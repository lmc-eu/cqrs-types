<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\Formatter;

use Lmc\Cqrs\Types\ValueObject\FormattedValue;
use Lmc\Cqrs\Types\ValueObject\ProfilerItem;
use PHPUnit\Framework\TestCase;

class JsonProfilerFormatterTest extends TestCase
{
    /**
     * @dataProvider provideProfilerItem
     *
     * @test
     */
    public function shouldFormatProfilerItem(ProfilerItem $item, ProfilerItem $expected): void
    {
        $formatter = new JsonProfilerFormatter();

        $formatted = $formatter->formatItem($item);

        $this->assertEquals($expected, $formatted);
    }

    public function provideProfilerItem(): array
    {
        return [
            'without any json' => [
                new ProfilerItem('id', null, 'test'),
                new ProfilerItem('id', null, 'test'),
            ],
            'with empty json array in response' => [
                new ProfilerItem('id', null, 'test', '', '[]'),
                new ProfilerItem('id', null, 'test', '', new FormattedValue('[]', [])),
            ],
            'with empty json object in response' => [
                new ProfilerItem('id', null, 'test', '', '{}'),
                new ProfilerItem('id', null, 'test', '', new FormattedValue('{}', [])),
            ],
            'with json in response' => [
                new ProfilerItem(
                    'id',
                    null,
                    'test',
                    '',
                    '{"data": { "id": 42 }}'
                ),
                new ProfilerItem(
                    'id',
                    null,
                    'test',
                    '',
                    new FormattedValue('{"data": { "id": 42 }}', ['data' => ['id' => 42]])
                ),
            ],
            'with empty json array in formatted response' => [
                new ProfilerItem(
                    'id',
                    null,
                    'test',
                    '',
                    new FormattedValue('StreamInterface', '[]')
                ),
                new ProfilerItem(
                    'id',
                    null,
                    'test',
                    '',
                    new FormattedValue('StreamInterface', [])
                ),
            ],
            'with empty json object in formatted response' => [
                new ProfilerItem(
                    'id',
                    null,
                    'test',
                    '',
                    new FormattedValue('StreamInterface', '{}')
                ),
                new ProfilerItem(
                    'id',
                    null,
                    'test',
                    '',
                    new FormattedValue('StreamInterface', [])
                ),
            ],
            'with json in formatted response' => [
                new ProfilerItem(
                    'id',
                    null,
                    'test',
                    '',
                    '{"data": { "id": 42 }}'
                ),
                new ProfilerItem(
                    'id',
                    null,
                    'test',
                    '',
                    new FormattedValue('{"data": { "id": 42 }}', ['data' => ['id' => 42]])
                ),
            ],
            'with empty json array in additional data' => [
                new ProfilerItem('id', ['body' => '[]'], 'test'),
                new ProfilerItem('id', ['body' => new FormattedValue('[]', [])], 'test'),
            ],
            'with empty json object in additional data' => [
                new ProfilerItem('id', ['body' => '{}'], 'test'),
                new ProfilerItem('id', ['body' => new FormattedValue('{}', [])], 'test'),
            ],
            'with json in additional data' => [
                new ProfilerItem('id', ['body' => '{"data": { "id": 42 }}'], 'test'),
                new ProfilerItem(
                    'id',
                    ['body' => new FormattedValue('{"data": { "id": 42 }}', ['data' => ['id' => 42]])],
                    'test'
                ),
            ],
            'with empty json array in formatted additional data' => [
                new ProfilerItem('id', ['body' => new FormattedValue('StreamInterface', '[]')], 'test'),
                new ProfilerItem('id', ['body' => new FormattedValue('StreamInterface', [])], 'test'),
            ],
            'with empty json object in formatted additional data' => [
                new ProfilerItem('id', ['body' => new FormattedValue('StreamInterface', '{}')], 'test'),
                new ProfilerItem('id', ['body' => new FormattedValue('StreamInterface', [])], 'test'),
            ],
            'with json in additional formatted data' => [
                new ProfilerItem(
                    'id',
                    ['body' => new FormattedValue('StreamInterface', '{"data": { "id": 42 }}')],
                    'test'
                ),
                new ProfilerItem(
                    'id',
                    ['body' => new FormattedValue('StreamInterface', ['data' => ['id' => 42]])],
                    'test'
                ),
            ],
        ];
    }
}
