<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types;

use Lmc\Cqrs\Types\Exception\CqrsExceptionInterface;
use Lmc\Cqrs\Types\Exception\UnsupportedRequestException;
use Lmc\Cqrs\Types\Fixture\DummyCommand;
use Lmc\Cqrs\Types\Fixture\DummySendCommandHandler;
use Lmc\Cqrs\Types\ValueObject\OnErrorCallback;
use Lmc\Cqrs\Types\ValueObject\OnSuccessCallback;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class SendCommandTest extends TestCase
{
    private DummySendCommandHandler $dummySendCommandHandler;

    protected function setUp(): void
    {
        $this->dummySendCommandHandler = new DummySendCommandHandler();
    }

    #[Test]
    public function shouldPrepareCommandByReturningItback(): void
    {
        $data = 'dummy-data';
        $command = new DummyCommand($data);

        $this->assertSame($command, $this->dummySendCommandHandler->prepare($command));
    }

    #[Test]
    public function shouldSendDummyCommandDirectly(): void
    {
        $data = 'dummy-data';
        $command = new DummyCommand($data);

        $this->assertTrue($this->dummySendCommandHandler->supports($command));

        $this->dummySendCommandHandler->handle(
            $command,
            new OnSuccessCallback(fn (string $response) => $this->assertSame($data, $response)),
            new OnErrorCallback(fn (\Throwable $error) => $this->fail($error->getMessage())),
        );
    }

    #[Test]
    public function shouldNotSupportOtherThanDummyCommand(): void
    {
        $notADummyCommand = new class() implements CommandInterface {
            public function getRequestType(): string
            {
                return 'not-a-dummy';
            }

            public function createRequest(): mixed
            {
                throw new \Exception(sprintf('Method %s is not implemented yet.', __METHOD__));
            }

            public function __toString(): string
            {
                throw new \Exception(sprintf('Method %s is not implemented yet.', __METHOD__));
            }
        };

        $this->assertFalse($this->dummySendCommandHandler->supports($notADummyCommand));

        $this->dummySendCommandHandler->handle(
            $notADummyCommand,
            new OnSuccessCallback(fn ($response) => $this->fail('Command should not be handled.')),
            new OnErrorCallback(function (\Throwable $error): void {
                $this->assertInstanceOf(UnsupportedRequestException::class, $error);
                $this->assertInstanceOf(CqrsExceptionInterface::class, $error);

                $this->assertSame('Unsupported request given to handle.', $error->getMessage());

                if ($error instanceof UnsupportedRequestException) {
                    $this->assertSame(DummyCommand::class, $error->getExpectedRequest());
                    $this->assertSame('not-a-dummy', $error->getGivenRequest());
                }
            }),
        );
    }
}
