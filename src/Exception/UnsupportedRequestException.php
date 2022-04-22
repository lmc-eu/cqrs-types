<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\Exception;

class UnsupportedRequestException extends \InvalidArgumentException implements CqrsExceptionInterface
{
    public function __construct(
        string $message,
        private string $expectedRequest,
        private string $givenRequest,
        int $code = 0,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }

    public static function create(
        string $expectedRequest,
        string $givenRequest,
        int $code = 0,
        ?\Throwable $previous = null,
    ): self {
        return new self('Unsupported request given to handle.', $expectedRequest, $givenRequest, $code, $previous);
    }

    public function getExpectedRequest(): string
    {
        return $this->expectedRequest;
    }

    public function getGivenRequest(): string
    {
        return $this->givenRequest;
    }
}
