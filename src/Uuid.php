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
    public function toString(): string
    {
        return $this->uuid;
    }

    /**
     * @throws Throwable
     */
    public static function new(DateTimeInterface $dateTime = new DateTimeImmutable()): self
    {
        $hex = mb_str_pad(dechex($dateTime->getTimestamp()), 12, '0', STR_PAD_LEFT) . bin2hex(random_bytes(10));

        return new self(sprintf(
            '%08s-%04s-%04x-%04x-%12s',
            /**  32 bits for "time_low" */
            mb_substr($hex, 0, 8),
            /** 16 bits for "time_mid" */
            mb_substr($hex, 8, 4),
            /**
             * 16 bits for "time_hi_and_version",
             * four most significant bits holds version number.
             */
            (hexdec(mb_substr($hex, 12, 4)) & 0x0fff) | 7 << 12,
            /**
             * 16 bits, 8 bits for "clk_seq_hi_res", 8 bits for "clk_seq_low",
             * two most significant bits holds zero and one for variant DCE1.1.
             */
            (hexdec(mb_substr($hex, 16, 4)) & 0x3fff) | 0x8000,
            /** 48 bits for "node" */
            mb_substr($hex, 20, 12)
        ));
    }
}
