# Uuid

[![GitHub Sponsors](https://img.shields.io/github/sponsors/ghostwriter?label=Sponsor+@ghostwriter/uuid&logo=GitHub+Sponsors)](https://github.com/sponsors/ghostwriter)
[![Automation](https://github.com/ghostwriter/uuid/actions/workflows/automation.yml/badge.svg)](https://github.com/ghostwriter/uuid/actions/workflows/automation.yml)
[![Supported PHP Version](https://badgen.net/packagist/php/ghostwriter/uuid?color=8892bf)](https://www.php.net/supported-versions)
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
// or
$uuid = Uuid::fromString('0000669c-8deb-7fe7-b9cc-692b216999a3');

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

Compare UUIDs based on their timestamp ( `0: equal`, `1: older`, `-1: newer`)

```php
$uuidLastYear = Uuid::new(new DateTimeImmutable('-1 year'));
$uuidLastMonth = Uuid::new(new DateTimeImmutable('-1 month'));
$uuidLastWeek = Uuid::new(new DateTimeImmutable('-1 week'));
$uuidYesterday = Uuid::new(new DateTimeImmutable('-1 day'));

// LastYear comparisons
// 0: LastYear is the same as LastYear
assert(0 === $uuidLastYear->compare($uuidLastYear));
// -1: LastMonth is newer than LastYear
assert(-1 === $uuidLastYear->compare($uuidLastMonth));
// -1: LastWeek is newer than LastYear
assert(-1 === $uuidLastYear->compare($uuidLastWeek));
// -1: Yesterday is newer than LastYear
assert(-1 === $uuidLastYear->compare($uuidYesterday));

// LastMonth comparisons
// 1: LastYear is older than LastMonth
assert(1 === $uuidLastMonth->compare($uuidLastYear));
// 0: LastMonth is the same as LastMonth
assert(0 === $uuidLastMonth->compare($uuidLastMonth));
// -1: LastWeek is newer than LastMonth
assert(-1 === $uuidLastMonth->compare($uuidLastWeek));
// -1: Yesterday is newer than LastMonth
assert(-1 === $uuidLastMonth->compare($uuidYesterday));

// LastWeek comparisons
// 1: LastYear is older than LastWeek
assert(1 === $uuidLastWeek->compare($uuidLastYear));
// 1: LastMonth is older than LastWeek
assert(1 === $uuidLastWeek->compare($uuidLastMonth));
// 0: LastWeek is the same as LastWeek
assert(0 === $uuidLastWeek->compare($uuidLastWeek));
// -1: Yesterday is newer than LastWeek
assert(-1 === $uuidLastWeek->compare($uuidYesterday));

// Yesterday comparisons
// 1: LastYear is older than Yesterday
assert(1 === $uuidYesterday->compare($uuidLastYear));
// 1: LastMonth is older than Yesterday
assert(1 === $uuidYesterday->compare($uuidLastMonth));
// 1: LastWeek is older than Yesterday
assert(1 === $uuidYesterday->compare($uuidLastWeek));
// 0: Yesterday is the same as Yesterday
assert(0 === $uuidYesterday->compare($uuidYesterday));

/** @var array{0:UuidInterface,1:UuidInterface,2:UuidInterface,3:UuidInterface} $uuids */
$uuids = [$uuidLastWeek, $uuidLastYear, $uuidYesterday, $uuidLastMonth];

usort($uuids, static fn (UuidInterface $left, UuidInterface $right): int => $left->compare($right));

// First: LastYear (oldest)
assert($uuidLastYear === $uuids[0]);
// Second: LastMonth
assert($uuidLastMonth === $uuids[1]);
// Third: LastWeek
assert($uuidLastWeek === $uuids[2]);
// Fourth: Yesterday (newest)
assert($uuidYesterday === $uuids[3]);
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
