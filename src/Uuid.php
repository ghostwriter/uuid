<?php

declare(strict_types=1);

namespace Ghostwriter\Uuid;

use DateTimeImmutable;
use DateTimeInterface;
use Ghostwriter\Uuid\Exception\InvalidUuidStringException;
use Ghostwriter\Uuid\Interface\UuidInterface;
use Override;
use Throwable;

use const STR_PAD_LEFT;

use function bin2hex;
use function dechex;
use function hexdec;
use function mb_str_pad;
use function mb_substr;
use function preg_match;
use function random_bytes;
use function sprintf;
use function str_replace;

/** @see UuidTest */
final readonly class Uuid implements UuidInterface
{
    public const string PATTERN = '#^[0-9a-f]{8}-[0-9a-f]{4}-7[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$#i';

    /**
     * @throws InvalidUuidStringException
     */
    public function __construct(
        private string $uuid
    ) {
        $match = preg_match(self::PATTERN, $uuid);
        if ($match === 0 || $match === false) {
            throw new InvalidUuidStringException($uuid);
        }
    }

    #[Override]
    public function compare(UuidInterface $uuid): int
    {
        return $this->timestamp($this) <=> $this->timestamp($uuid);
    }

    #[Override]
    public function toString(): string
    {
        return $this->uuid;
    }

    private function timestamp(UuidInterface $uuid): int
    {
        return hexdec(mb_substr(str_replace('-', '', $uuid->toString()), 0, 12, 'UTF-8'));
    }

    /**
     * @throws Throwable
     */
    public static function new(DateTimeInterface $dateTime = new DateTimeImmutable('now')): self
    {
        $hex = mb_str_pad(dechex($dateTime->getTimestamp()), 12, '0', STR_PAD_LEFT) . bin2hex(random_bytes(10));

        return new self(sprintf(
            '%08s-%04s-%04x-%04x-%012s',
            mb_substr($hex, 0, 8),
            mb_substr($hex, 8, 4),
            (hexdec(mb_substr($hex, 12, 4)) & 0x0fff) | 7 << 12,
            (hexdec(mb_substr($hex, 16, 4)) & 0x3fff) | 0x8000,
            mb_substr($hex, 20, 12)
        ));
    }
}
