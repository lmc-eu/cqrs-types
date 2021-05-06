<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\ValueObject;

use PHPUnit\Framework\TestCase;

class CacheTimeTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideCacheTime
     */
    public function shouldCreateCacheTime(callable $createCacheTime, int $expectedSeconds): void
    {
        $cacheTime = $createCacheTime();

        $this->assertSame($expectedSeconds, $cacheTime->getSeconds());
    }

    public function provideCacheTime(): array
    {
        return [
            'no-cache' => [fn () => CacheTime::noCache(), 0],
            'ofSeconds' => [fn () => CacheTime::ofSeconds(42), 42],
            'ofMinutes' => [fn () => CacheTime::ofMinutes(42), 42 * 60],
            'ofHours' => [fn () => CacheTime::ofHours(42), 42 * 60 * 60],
            'ofDays' => [fn () => CacheTime::ofDays(42), 42 * 60 * 60 * 24],

            'oneMinute' => [fn () => CacheTime::oneMinute(), 60],
            'fiveMinutes' => [fn () => CacheTime::fiveMinutes(), 300],
            'tenMinutes' => [fn () => CacheTime::tenMinutes(), 600],
            'fifteenMinutes' => [fn () => CacheTime::fifteenMinutes(), 900],
            'thirtyMinutes' => [fn () => CacheTime::thirtyMinutes(), 1800],

            'oneHour' => [fn () => CacheTime::oneHour(), 3600],
            'twoHours' => [fn () => CacheTime::twoHours(), 7200],
            'fourHours' => [fn () => CacheTime::fourHours(), 14400],
            'twelveHours' => [fn () => CacheTime::twelveHours(), 43200],

            'oneDay' => [fn () => CacheTime::oneDay(), 86400],
            'sevenDays' => [fn () => CacheTime::sevenDays(), 604800],
        ];
    }
}
