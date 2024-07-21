<?php

declare(strict_types=1);

namespace Tests\Unit;

use DateTimeImmutable;
use Ghostwriter\Uuid\Interface\UuidInterface;
use Ghostwriter\Uuid\Uuid;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Throwable;

use function is_a;
use function usort;

#[CoversClass(Uuid::class)]
final class UuidTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function testCompare(): void
    {
        $uuid1 = Uuid::new(new DateTimeImmutable('-1 year'));
        $uuid2 = Uuid::new(new DateTimeImmutable('-1 month'));
        $uuid3 = Uuid::new(new DateTimeImmutable('-1 week'));
        $uuid4 = Uuid::new(new DateTimeImmutable('-1 day'));

        self::assertSame(0, $uuid1->compare($uuid1));
        self::assertSame(-1, $uuid1->compare($uuid2));
        self::assertSame(-1, $uuid1->compare($uuid3));
        self::assertSame(-1, $uuid1->compare($uuid4));

        self::assertSame(1, $uuid2->compare($uuid1));
        self::assertSame(0, $uuid2->compare($uuid2));
        self::assertSame(-1, $uuid2->compare($uuid3));
        self::assertSame(-1, $uuid2->compare($uuid4));

        self::assertSame(1, $uuid3->compare($uuid1));
        self::assertSame(1, $uuid3->compare($uuid2));
        self::assertSame(0, $uuid3->compare($uuid3));
        self::assertSame(-1, $uuid3->compare($uuid4));

        self::assertSame(1, $uuid4->compare($uuid1));
        self::assertSame(1, $uuid4->compare($uuid2));
        self::assertSame(1, $uuid4->compare($uuid3));
        self::assertSame(0, $uuid4->compare($uuid4));

        /** @var array{0:UuidInterface,1:UuidInterface,2:UuidInterface,3:UuidInterface} $uuids */
        $uuids = [$uuid3, $uuid1, $uuid4, $uuid2];

        usort($uuids, static fn (UuidInterface $left, UuidInterface $right): int => $left->compare($right));

        self::assertSame($uuid1->toString(), $uuids[0]->toString());
        self::assertSame($uuid2->toString(), $uuids[1]->toString());
        self::assertSame($uuid3->toString(), $uuids[2]->toString());
        self::assertSame($uuid4->toString(), $uuids[3]->toString());
    }

    /**
     * @throws Throwable
     */
    public function testCompareSameTimestamp(): void
    {
        $uuid1 = Uuid::new(new DateTimeImmutable('now'));
        $uuid2 = Uuid::new(new DateTimeImmutable('now'));
        $uuid3 = Uuid::new(new DateTimeImmutable('now'));
        $uuid4 = Uuid::new(new DateTimeImmutable('now'));

        self::assertSame(0, $uuid1->compare($uuid1));
        self::assertSame(0, $uuid1->compare($uuid2));
        self::assertSame(0, $uuid1->compare($uuid3));
        self::assertSame(0, $uuid1->compare($uuid4));

        self::assertSame(0, $uuid2->compare($uuid1));
        self::assertSame(0, $uuid2->compare($uuid2));
        self::assertSame(0, $uuid2->compare($uuid3));
        self::assertSame(0, $uuid2->compare($uuid4));

        self::assertSame(0, $uuid3->compare($uuid1));
        self::assertSame(0, $uuid3->compare($uuid2));
        self::assertSame(0, $uuid3->compare($uuid3));
        self::assertSame(0, $uuid3->compare($uuid4));

        self::assertSame(0, $uuid4->compare($uuid1));
        self::assertSame(0, $uuid4->compare($uuid2));
        self::assertSame(0, $uuid4->compare($uuid3));
        self::assertSame(0, $uuid4->compare($uuid4));

        /** @var array{0:UuidInterface,1:UuidInterface,2:UuidInterface,3:UuidInterface} $uuids */
        $uuids = [$uuid3, $uuid1, $uuid4, $uuid2];

        usort($uuids, static fn (UuidInterface $left, UuidInterface $right): int => $left->compare($right));

        self::assertSame($uuid1->toString(), $uuids[1]->toString());
        self::assertSame($uuid2->toString(), $uuids[3]->toString());
        self::assertSame($uuid3->toString(), $uuids[0]->toString());
        self::assertSame($uuid4->toString(), $uuids[2]->toString());
    }

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
    public function testNew(): void
    {
        $uuid = Uuid::new();
        $uuid1 = new Uuid($uuid->toString());

        self::assertNotSame($uuid1, $uuid);
        self::assertSame($uuid1->toString(), $uuid->toString());
    }

    /**
     * @throws Throwable
     */
    public function testNotSame(): void
    {
        self::assertNotSame(Uuid::new(), Uuid::new());
    }

    /**
     * @throws Throwable
     */
    public function testToString(): void
    {
        self::assertNotSame(Uuid::new()->toString(), Uuid::new()->toString());
    }
}
