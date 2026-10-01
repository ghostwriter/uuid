<?php

declare(strict_types=1);

namespace Ghostwriter\Uuid;

use DateTimeImmutable;
use DateTimeInterface;
use Ghostwriter\Uuid\Exception\InvalidUuidStringException;
use Ghostwriter\Uuid\Interface\UuidInterface;
use Override;
use Throwable;

use function bin2hex;
use function dechex;
use function hexdec;
use function mb_substr;
use function preg_match;
use function random_bytes;
use function sprintf;
use function str_replace;

/**
 * @see UuidTest
 */
final readonly class Uuid implements UuidInterface
{
    public const string PATTERN = '#^[0-9a-f]{8}-[0-9a-f]{4}-7[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$#i';

    /** @throws InvalidUuidStringException */
    public function __construct(
        private string $uuid
    ) {
        if (1 !== preg_match(self::PATTERN, $uuid)) {
            throw new InvalidUuidStringException($uuid);
        }
    }

    /** @throws InvalidUuidStringException */
    public static function new(DateTimeInterface $dateTime = new DateTimeImmutable('now')): self
    {
        $milliseconds = (int) $dateTime->format('Uv');

        $random = bin2hex(random_bytes(10));

        return new self(sprintf(
            '%08s-%04s-7%03s-%1s%03s-%012s',
            dechex($milliseconds >> 16),
            dechex($milliseconds & 0xFFFF),
            mb_substr($random, 0, 3),
            '89ab'[hexdec($random[3]) >> 2],
            mb_substr($random, 4, 3),
            mb_substr($random, 7, 12),
        ));
    }

    #[Override]
    public function compare(UuidInterface $uuid): int
    {
        return $this->timestamp() <=> $uuid->timestamp();
    }

    #[Override]
    public function timestamp(): int
    {
        return hexdec(mb_substr(str_replace('-', '', $this->uuid), 0, 12, 'UTF-8'));
    }

    #[Override]
    public function toString(): string
    {
        return $this->uuid;
    }

    public static function fromString(string $uuid): self
    {
        return new self($uuid);
    }
}
