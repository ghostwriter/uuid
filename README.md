# UUID - Universally Unique Identifier

[![Automation](https://github.com/ghostwriter/uuid/actions/workflows/automation.yml/badge.svg)](https://github.com/ghostwriter/uuid/actions/workflows/automation.yml)
[![Supported PHP Version](https://badgen.net/packagist/php/ghostwriter/uuid?color=8892bf)](https://www.php.net/supported-versions)
[![GitHub Sponsors](https://img.shields.io/github/sponsors/ghostwriter?label=Sponsor+@ghostwriter/uuid&logo=GitHub+Sponsors)](https://github.com/sponsors/ghostwriter)
[![Code Coverage](https://codecov.io/gh/ghostwriter/uuid/branch/main/graph/badge.svg)](https://codecov.io/gh/ghostwriter/uuid)
[![Type Coverage](https://shepherd.dev/github/ghostwriter/uuid/coverage.svg)](https://shepherd.dev/github/ghostwriter/uuid)
[![Psalm Level](https://shepherd.dev/github/ghostwriter/uuid/level.svg)](https://psalm.dev/docs/running_psalm/error_levels)
[![Latest Version on Packagist](https://badgen.net/packagist/v/ghostwriter/uuid)](https://packagist.org/packages/ghostwriter/uuid)
[![Downloads](https://badgen.net/packagist/dt/ghostwriter/uuid?color=blue)](https://packagist.org/packages/ghostwriter/uuid)

Version 7 UUIDs using a Unix timestamp for PHP

## Installation

You can install the package via composer:

``` bash
composer require ghostwriter/uuid
```

### Star ⭐️ this repo if you find it useful

You can also star (🌟) this repo to find it easier later.

## Usage

Initialize a new Uuid instance with a given UUID string

```php
use Ghostwriter\Uuid\Uuid;

$uuid = new Uuid('0000669c-8deb-7fe7-b9cc-692b216999a3');

echo $uuid->toString(); // 0000669c-8deb-7fe7-b9cc-692b216999a3
```

Generate a new UUID

```php
echo Uuid::new()->toString(); // 0000669c-8f99-711e-9ed0-72a35c3b6fb3
```

Generate a new UUID with a specific timestamp

```php
echo Uuid::new(new DateTimeImmutable())->toString(); // 0000669c-8faf-7e4b-9ed9-45c4c2b27f07
```

Compare UUIDs based on their timestamp

```php
$uuid1 = Uuid::new(new DateTimeImmutable('-1 year'));
$uuid2 = Uuid::new(new DateTimeImmutable('-1 month'));
$uuid3 = Uuid::new(new DateTimeImmutable('-1 week'));
$uuid4 = Uuid::new(new DateTimeImmutable('-1 day'));

assert(0 === $uuid1->compare($uuid1));
assert(-1 === $uuid1->compare($uuid2));
assert(-1 === $uuid1->compare($uuid3));
assert(-1 === $uuid1->compare($uuid4));

assert(1 === $uuid2->compare($uuid1));
assert(0 === $uuid2->compare($uuid2));
assert(-1 === $uuid2->compare($uuid3));
assert(-1 === $uuid2->compare($uuid4));

assert(1 === $uuid3->compare($uuid1));
assert(1 === $uuid3->compare($uuid2));
assert(0 === $uuid3->compare($uuid3));
assert(-1 === $uuid3->compare($uuid4));

assert(1 === $uuid4->compare($uuid1));
assert(1 === $uuid4->compare($uuid2));
assert(1 === $uuid4->compare($uuid3));
assert(0 === $uuid4->compare($uuid4));

/** @var array{0:UuidInterface,1:UuidInterface,2:UuidInterface,3:UuidInterface} $uuids */
$uuids = [$uuid3, $uuid1, $uuid4, $uuid2];

usort($uuids, static fn (UuidInterface $left, UuidInterface $right): int => $left->compare($right));

assert($uuid1->toString() === $uuids[0]->toString());
assert($uuid2->toString() === $uuids[1]->toString());
assert($uuid3->toString() === $uuids[2]->toString());
assert($uuid4->toString() === $uuids[3]->toString());
```

### Credits

- [Nathanael Esayeas](https://github.com/ghostwriter)
- [All Contributors](https://github.com/ghostwriter/uuid/contributors)

### Changelog

Please see [CHANGELOG.md](./CHANGELOG.md) for more information on what has changed recently.

### License

Please see [LICENSE](./LICENSE) for more information on the license that applies to this project.

### Security

Please see [SECURITY.md](./SECURITY.md) for more information on security disclosure process.
