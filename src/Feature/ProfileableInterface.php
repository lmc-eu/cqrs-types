<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\Feature;

interface ProfileableInterface
{
    public function getProfilerId(): string;

    public function getProfilerData(): ?array;
}
