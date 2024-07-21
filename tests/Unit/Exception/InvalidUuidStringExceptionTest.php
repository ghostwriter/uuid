<?php

declare(strict_types=1);

namespace Tests\Unit\Exception;

use Ghostwriter\Uuid\Exception\InvalidUuidStringException;
use Ghostwriter\Uuid\Interface\UuidExceptionInterface;
use Ghostwriter\Uuid\Uuid;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

use function is_a;

#[UsesClass(Uuid::class)]
#[CoversClass(InvalidUuidStringException::class)]
final class InvalidUuidStringExceptionTest extends TestCase
{
    public function testImplementsUuidExceptionInterface(): void
    {
        self::assertTrue(is_a(InvalidUuidStringException::class, UuidExceptionInterface::class, true));
    }

    public function testThrowsInvalidUuidStringException(): void
    {
        $this->expectException(InvalidUuidStringException::class);
        $this->expectExceptionMessage('invalid-uuid-string');

        new Uuid('invalid-uuid-string');
    }
}
