<?php

declare(strict_types=1);

namespace Tests\Unit\Exception;

use Ghostwriter\Uuid\Exception\InvalidUuidStringException;
use Ghostwriter\Uuid\Interface\UuidExceptionInterface;
use Ghostwriter\Uuid\Uuid;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversClassesThatImplementInterface;
use Tests\Unit\AbstractTestCase;
use Throwable;

#[CoversClass(InvalidUuidStringException::class)]
#[CoversClass(Uuid::class)]
#[CoversClassesThatImplementInterface(UuidExceptionInterface::class)]
final class InvalidUuidStringExceptionTest extends AbstractTestCase
{
    /** @throws Throwable */
    public function testThrowsInvalidUuidStringException(): void
    {
        try {
            new Uuid('invalid-uuid-string');
        } catch (InvalidUuidStringException $exception) {
            self::assertInstanceOf(UuidExceptionInterface::class, $exception);
            self::assertSame('invalid-uuid-string', $exception->getMessage());
        }
    }
}
