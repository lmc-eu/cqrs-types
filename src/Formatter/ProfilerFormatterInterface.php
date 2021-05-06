<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\Formatter;

use Lmc\Cqrs\Types\ValueObject\ProfilerItem;

interface ProfilerFormatterInterface
{
    public function formatItem(ProfilerItem $item): ProfilerItem;
}
