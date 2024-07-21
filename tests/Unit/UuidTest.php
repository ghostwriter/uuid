<?php

declare(strict_types=1);

namespace Tests\Unit;

use Ghostwriter\Uuid\Interface\UuidInterface;
use Ghostwriter\Uuid\Uuid;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Throwable;

use function is_a;

#[CoversClass(Uuid::class)]
final class UuidTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function testImplementsUuidInterface(): void
    {
        self::assertTrue(is_a(Uuid::class, UuidInterface::class, true));
    }

    /**
     * @throws Throwable
     */
    public function testIsValid(): void
    {
        $uuid1 = Uuid::new();
        $uuid = new Uuid($uuid1->toString());

        self::assertSame($uuid1->toString(), $uuid->toString());
    }

    /**
     * @throws Throwable
     */
    public function testNotSame(): void
    {
        $uuid1 = Uuid::new();
        $uuid2 = Uuid::new();

        self::assertNotSame($uuid1, $uuid2);
        self::assertNotSame($uuid1->toString(), $uuid2->toString());
    }
}
