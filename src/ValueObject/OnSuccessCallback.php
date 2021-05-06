<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\ValueObject;

/**
 * @phpstan-template Response
 * @phpstan-implements OnSuccessInterface<Response>
 */
class OnSuccessCallback implements OnSuccessInterface
{
    /**
     * @phpstan-var callable(Response): void
     * @var callable
     */
    private $callback;

    /**
     * @phpstan-param callable(Response): void $callback
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @phpstan-param Response $response
     * @param mixed $response
     */
    public function __invoke($response): void
    {
        call_user_func($this->callback, $response);
    }
}
