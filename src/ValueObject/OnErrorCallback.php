<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\ValueObject;

class OnErrorCallback implements OnErrorInterface
{
    /**
     * @phpstan-var callable(\Throwable): void
     * @var callable
     */
    private $callback;

    public static function throwOnError(): self
    {
        return new self(function (\Throwable $error): void {
            throw $error;
        });
    }

    public static function ignoreError(): self
    {
        return new self(function (\Throwable $error): void {});
    }

    /**
     * @phpstan-param callable(\Throwable): void $callback
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function __invoke(\Throwable $error): void
    {
        call_user_func($this->callback, $error);
    }
}
