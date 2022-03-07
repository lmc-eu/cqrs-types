<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types;

/**
 * @phpstan-template Request
 */
interface QueryInterface extends \Stringable
{
    public function getRequestType(): string;

    /**
     * @phpstan-return Request
     * @return mixed of <Request> which must be handled by a specific Handler<Request>
     */
    public function createRequest(): mixed;

    public function __toString(): string;
}
