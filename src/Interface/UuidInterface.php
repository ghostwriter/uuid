<?php

declare(strict_types=1);

namespace Ghostwriter\Uuid\Interface;

interface UuidInterface
{
    public function compare(self $uuid): int;

    public function toString(): string;
}
