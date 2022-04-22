<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\ValueObject;

class CacheTime
{
    private function __construct(private int $seconds)
    {
        $this->seconds = max(0, $seconds);
    }

    public static function ofSeconds(int $seconds): self
    {
        return new self($seconds);
    }

    public static function ofMinutes(int $minutes): self
    {
        return new self($minutes * 60);
    }

    public static function ofHours(int $hours): self
    {
        return new self($hours * 60 * 60);
    }

    public static function ofDays(int $days): self
    {
        return new self($days * 60 * 60 * 24);
    }

    public static function noCache(): self
    {
        return new self(0);
    }

    public static function oneMinute(): self
    {
        return self::ofMinutes(1);
    }

    public static function fiveMinutes(): self
    {
        return self::ofMinutes(5);
    }

    public static function tenMinutes(): self
    {
        return self::ofMinutes(10);
    }

    public static function fifteenMinutes(): self
    {
        return self::ofMinutes(15);
    }

    public static function thirtyMinutes(): self
    {
        return self::ofMinutes(30);
    }

    public static function oneHour(): self
    {
        return self::ofHours(1);
    }

    public static function twoHours(): self
    {
        return self::ofHours(2);
    }

    public static function fourHours(): self
    {
        return self::ofHours(4);
    }

    public static function twelveHours(): self
    {
        return self::ofHours(12);
    }

    public static function oneDay(): self
    {
        return self::ofDays(1);
    }

    public static function sevenDays(): self
    {
        return self::ofDays(7);
    }

    public function getSeconds(): int
    {
        return $this->seconds;
    }
}
