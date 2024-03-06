<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\ValueObject;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ProfilerItemTest extends TestCase
{
    #[Test]
    public function shouldProfileResponseAsItIsInThatMoment(): void
    {
        $response = new \stdClass();
        $response->value = 'foo';

        $profilerItem = new ProfilerItem('id', null, 'test', null, $response);

        $response->value = 'fooBar';

        $this->assertSame('foo', $profilerItem->getResponse()->value);
    }

    #[Test]
    public function shouldProfileResponseAsItIsInThatMomentViaSetter(): void
    {
        $response = new \stdClass();
        $response->value = 'foo';

        $profilerItem = new ProfilerItem('id', null, 'test');
        $profilerItem->setResponse($response);

        $response->value = 'fooBar';

        $this->assertSame('foo', $profilerItem->getResponse()->value);
    }
}
