<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types;

use Lmc\Cqrs\Types\Fixture\DecodedDummyData;
use Lmc\Cqrs\Types\Fixture\DecodedSelf;
use Lmc\Cqrs\Types\Fixture\DummyData;
use Lmc\Cqrs\Types\ValueObject\DecodedValue;
use PHPUnit\Framework\TestCase;

class UtilsTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideValues
     *
     * @param mixed $value
     */
    public function shouldGetTypeOfGivenValue($value, string $expected): void
    {
        $type = Utils::getType($value);

        $this->assertSame($expected, $type);
    }

    public function provideValues(): array
    {
        return [
            // value, expectedType
            'null' => [null, 'NULL'],
            'string' => ['string', 'string'],
            'int' => [42, 'integer'],
            'float' => [13.37, 'double'],
            'stdClass' => [new \stdClass(), 'stdClass'],
            'decoded string' => [new DecodedValue('string'), 'DecodedValue<string>'],
            'dummy data' => [new DummyData('dummy'), DummyData::class],
            'dummy data - decoded' => [
                new DecodedValue(new DummyData('dummy')),
                'DecodedValue<' . DummyData::class . '>',
            ],
            'nested dummy data - decoded' => [
                new DecodedValue(new DecodedValue(new DummyData('dummy'))),
                'DecodedValue<' . DecodedValue::class . '>',
            ],
            'decoded dummy data' => [new DecodedDummyData(), 'DecodedValue<string>'],
            'decoded self' => [new DecodedSelf(), 'DecodedValue<' . DecodedSelf::class . '>'],
        ];
    }
}
