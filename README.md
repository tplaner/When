# When
Date/Calendar recursion library for PHP 7.1+

[![Build Status](https://github.com/tplaner/When/actions/workflows/tests.yml/badge.svg)](https://github.com/tplaner/When/actions)
[![Total Downloads](https://img.shields.io/packagist/dt/tplaner/When)](https://packagist.org/packages/tplaner/When)
[![Latest Stable Version](https://img.shields.io/packagist/v/tplaner/When)](https://packagist.org/packages/tplaner/When)
[![License](https://img.shields.io/packagist/l/tplaner/When)](https://packagist.org/packages/tplaner/When)

Author: [Tom Planer](https://twitter.com/tplaner)

## Installation
```
composer require tplaner/When
```

## Current Features
When offers full support for [RFC5455 Recurrence Rule](https://datatracker.ietf.org/doc/html/rfc5545#section-3.8.5) features (and some bonus features). Please check the [unit tests](https://github.com/tplaner/When/tree/master/tests) for information and examples about how to use it.

Here are some basic examples.

```php
// friday the 13th for the next 5 occurrences
$r = new When();
$r->startDate(new DateTime("19980213T090000"))
  ->freq("monthly")
  ->count(5)
  ->byday("fr")
  ->bymonthday(13)
  ->generateOccurrences();

print_r($r->occurrences);
```

```php
// friday the 13th for the next 5 occurrences rrule
$r = new When();
$r->startDate(new DateTime("19980213T090000"))
  ->rrule("FREQ=MONTHLY;BYDAY=FR;BYMONTHDAY=13;COUNT=5")
  ->generateOccurrences();

print_r($r->occurrences);
```

```php
// friday the 13th for the next 5 occurrences, skipping known friday the 13ths
$r = new When();
$r->startDate(new DateTime("19980213T090000"))
  ->freq("monthly")
  ->count(5)
  ->byday("fr")
  ->bymonthday(13)
  ->exclusions('19990813T090000,20001013T090000')
  ->generateOccurrences();

print_r($r->occurrences);
```

```php
// friday the 13th forever; see which ones occur in 2018
$r = new When();
$r->startDate(new DateTime("19980213T090000"))
  ->rrule("FREQ=MONTHLY;BYDAY=FR;BYMONTHDAY=13");

$occurrences = $r->getOccurrencesBetween(new DateTime('2018-01-01 09:00:00'),
                                         new DateTime('2019-01-01 09:00:00'));
print_r($occurrences);
```

## InvalidStartDate Exception: The start date must be the first occurrence

According to [the specification](https://datatracker.ietf.org/doc/html/rfc5545) the starting date should be the first recurring date. This can often be troublesome, especially if you're generating the recurring dates from user input as it will throw an exception. You can disable this functionality easily:

```php
$r = new When();
$r->RFC5545_COMPLIANT = When::IGNORE;

// get the last Friday of the month for the next 5 occurrences
$r->startDate(new DateTime())
  ->rrule("FREQ=MONTHLY;BYDAY=-1FR;COUNT=5")
  ->generateOccurrences();

print_r($r->occurrences);
```

## Additional examples:

```php
$r = new When();
$r->RFC5545_COMPLIANT = When::IGNORE;

// second to last day of the month
$r->startDate(new DateTime())
  ->rrule("FREQ=MONTHLY;BYMONTHDAY=-2;COUNT=5")
  ->generateOccurrences();

print_r($r->occurrences);
```

```php
$r = new When();
$r->RFC5545_COMPLIANT = When::IGNORE;

// every other week
$r->startDate(new DateTime())
    ->rrule("FREQ=WEEKLY;INTERVAL=2;COUNT=10")
    ->generateOccurrences();

print_r($r->occurrences);
```

```php
$r1 = new When();
$r2 = new When();
$r1->RFC5545_COMPLIANT = When::IGNORE;
$r2->RFC5545_COMPLIANT = When::IGNORE;

// complex example of a payment schedule
// borrowed from: https://www.mikeyroy.com/2019/10/25/google-calendar-recurring-event-for-twice-monthly-payroll-only-on-weekdays/
//
// you're paid on the 15th, (or closest to it, but only on a weekday)
$r1->startDate(new DateTime())
   ->rrule("FREQ=MONTHLY;INTERVAL=1;BYSETPOS=-1;BYDAY=MO,TU,WE,TH,FR;BYMONTHDAY=13,14,15;COUNT=12")
   ->generateOccurrences();

// you're also paid on the last weekday of the month
$r2->startDate(new DateTime())
    ->rrule("FREQ=MONTHLY;INTERVAL=1;BYSETPOS=-1;BYDAY=MO,TU,WE,TH,FR;BYMONTHDAY=26,27,28,29,30,31;COUNT=12")
    ->generateOccurrences();

$totalPaydays = count($r1->occurrences);
for ($i = 0; $i < $totalPaydays; $i++)
{
    echo "You'll be paid on: " . $r1->occurrences[$i]->format('F d, Y') . "\n";
    echo "You'll be paid on: " . $r2->occurrences[$i]->format('F d, Y') . "\n";
}
```

## Performance

When is pretty fast, and shouldn't be able to loop infinitely. This is because the gregorian calendar actually repeats fully every 400 years. Therefore, this is an imposed upper limit to When, it will not generate occurrences more than 400 years into the future, and if it can't find a match in the next 400 years the pattern just doesn't exist.

By default, we do not generate more than 200 occurrences, though this can be configured simply by specifying a higher `COUNT` or by modifying the `$rangeLimit` prior to calling `generateOccurrences()`:

```php
$r = new When();
$r->RFC5545_COMPLIANT = When::IGNORE;

$r->startDate(new DateTime())
  ->rrule("FREQ=MONTHLY;BYDAY=FR;BYMONTHDAY=13")
  ->generateOccurrences();

// will generate an array of 200
print_r($r->occurrences);
```

The following is a pretty intensive benchmark the final occurrence is in the year 2254. On my machine this generates the results in about `0.28s`.

```php
$r = new When();
$r->RFC5545_COMPLIANT = When::IGNORE;

$r->startDate(new DateTime(20210101))
  ->rrule("FREQ=MONTHLY;BYDAY=FR;BYMONTHDAY=13;COUNT=400")
  ->generateOccurrences();

// will generate an array of 400
print_r($r->occurrences);
```

`COUNT` with an `UNTIL`, only 5 Friday the 13ths from 2021 to 2025.

```php
$r = new When();
$r->RFC5545_COMPLIANT = When::IGNORE;

$r->startDate(new DateTime(20210101))
  ->rrule("FREQ=MONTHLY;BYDAY=FR;BYMONTHDAY=13;COUNT=400;UNTIL=20250101")
  ->generateOccurrences();

// will generate until 2023-01-01 or 400
print_r($r->occurrences);
```

Limiting by `$rangeLimit`:

```php
$r = new When();
$r->RFC5545_COMPLIANT = When::IGNORE;

$r->rangeLimit = 400;

$r->startDate(new DateTime())
  ->rrule("FREQ=MONTHLY;BYDAY=-1FR")
  ->generateOccurrences();

// 400 occurrences, limited by the rangeLimit
print_r($r->occurrences);
```
