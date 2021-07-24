<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\ValueObject;

use PHPUnit\Framework\TestCase;

class OnErrorCallbackTest extends TestCase
{
    /**
     * @test
     */
    public function shouldUseGivenCallback(): void
    {
        $actualError = null;

        $callback = new OnErrorCallback(function (\Throwable $error) use (&$actualError): void {
            $actualError = $error->getMessage();
        });

        $callback(new \Exception('Actual error'));

        $this->assertSame('Actual error', $actualError);
    }

    /**
     * @test
     */
    public function shouldThrowGivenError(): void
    {
        $callback = OnErrorCallback::throwOnError();

        $this->expectExceptionMessage('Should be thrown.');

        $callback(new \Exception('Should be thrown.'));
    }

    /**
     * @test
     */
    public function shouldIgnoreError(): void
    {
        $callback = OnErrorCallback::ignoreError();

        $callback(new \Exception('Should not be thrown.'));

        $this->expectNotToPerformAssertions();
    }
}
