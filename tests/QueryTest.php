<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types;

use Lmc\Cqrs\Types\Exception\CqrsExceptionInterface;
use Lmc\Cqrs\Types\Exception\UnsupportedRequestException;
use Lmc\Cqrs\Types\Fixture\DummyQuery;
use Lmc\Cqrs\Types\Fixture\DummyQueryHandler;
use Lmc\Cqrs\Types\ValueObject\OnErrorCallback;
use Lmc\Cqrs\Types\ValueObject\OnSuccessCallback;
use PHPUnit\Framework\TestCase;

class QueryTest extends TestCase
{
    private DummyQueryHandler $dummyQueryHandler;

    protected function setUp(): void
    {
        $this->dummyQueryHandler = new DummyQueryHandler();
    }

    /**
     * @test
     */
    public function shouldPrepareQueryByReturningItback(): void
    {
        $data = 'dummy-data';
        $query = new DummyQuery($data);

        $this->assertSame($query, $this->dummyQueryHandler->prepare($query));
    }

    /** @test */
    public function shouldHandleDummyQueryDirectly(): void
    {
        $data = 'dummy-data';
        $query = new DummyQuery($data);

        $this->assertTrue($this->dummyQueryHandler->supports($query));

        $this->dummyQueryHandler->handle(
            $query,
            new OnSuccessCallback(fn (string $response) => $this->assertSame($data, $response)),
            new OnErrorCallback(fn (\Throwable $error) => $this->fail($error->getMessage()))
        );
    }

    /** @test */
    public function shouldNotSupportOtherThanDummyQuery(): void
    {
        $notADummyQuery = new class() implements QueryInterface {
            public function getRequestType(): string
            {
                return 'not-a-dummy';
            }

            public function createRequest(): void
            {
                throw new \Exception(sprintf('Method %s is not implemented yet.', __METHOD__));
            }

            public function __toString(): string
            {
                throw new \Exception(sprintf('Method %s is not implemented yet.', __METHOD__));
            }
        };

        $this->assertFalse($this->dummyQueryHandler->supports($notADummyQuery));

        $this->dummyQueryHandler->handle(
            $notADummyQuery,
            new OnSuccessCallback(fn ($response) => $this->fail('Query should not be handled.')),
            new OnErrorCallback(function (\Throwable $error): void {
                $this->assertInstanceOf(UnsupportedRequestException::class, $error);
                $this->assertInstanceOf(CqrsExceptionInterface::class, $error);

                $this->assertSame('Unsupported request given to handle.', $error->getMessage());

                if ($error instanceof UnsupportedRequestException) {
                    $this->assertSame(DummyQuery::class, $error->getExpectedRequest());
                    $this->assertSame('not-a-dummy', $error->getGivenRequest());
                }
            })
        );
    }
}
