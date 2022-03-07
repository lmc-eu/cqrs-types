<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\ValueObject;

use PHPUnit\Framework\TestCase;

class FormattedValueTest extends TestCase
{
    /**
     * @dataProvider provideValues
     *
     * @test
     */
    public function shouldCastFormattedValueToString(mixed $original, mixed $formatted, string $expected): void
    {
        $formattedValue = new FormattedValue($original, $formatted);

        $this->assertSame($expected, (string) $formattedValue);
    }

    public function provideValues(): array
    {
        return [
            'formatted value is string' => ['original', 'formatted:value', 'formatted:value'],
            'formatted value is not string' => ['original', ['formatted' => 'value'], 'original'],
            'neither original nor formatted value is string' => [['original'], ['formatted'], 'FormattedValue<array, array>'],
        ];
    }
}
