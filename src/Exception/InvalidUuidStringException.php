<?php

declare(strict_types=1);

namespace Ghostwriter\Uuid\Exception;

use Ghostwriter\Uuid\Interface\UuidExceptionInterface;
use InvalidArgumentException;

/**
 * @see InvalidUuidStringExceptionTest
 */
final class InvalidUuidStringException extends InvalidArgumentException implements UuidExceptionInterface
{
}
