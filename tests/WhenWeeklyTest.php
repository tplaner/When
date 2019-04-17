<?php

use PHPUnit\Framework\TestCase;
use When\When;

class WhenWeeklyTest extends TestCase
{
    /**
     * Weekly for 10 occurrences:
     * DTSTART;TZID=America/New_York:19970902T090000
     * RRULE:FREQ=WEEKLY;COUNT=10
     */
    function testWeeklyOne()
    {
        $results[] = new DateTime('1997-09-02 09:00:00');
        $results[] = new DateTime('1997-09-09 09:00:00');
        $results[] = new DateTime('1997-09-16 09:00:00');
        $results[] = new DateTime('1997-09-23 09:00:00');
        $results[] = new DateTime('1997-09-30 09:00:00');
        $results[] = new DateTime('1997-10-07 09:00:00');
        $results[] = new DateTime('1997-10-14 09:00:00');
        $results[] = new DateTime('1997-10-21 09:00:00');
        $results[] = new DateTime('1997-10-28 09:00:00');
        $results[] = new DateTime('1997-11-04 09:00:00');

        $r = new When();
        $r->startDate(new DateTime("19970902T090000"))
          ->freq("weekly")
          ->count(10)
          ->generateOccurrences();

        $occurrences = $r->occurrences;

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }

    /**
     * Weekly until December 24, 1997:
     * DTSTART;TZID=America/New_York:19970902T090000
     * RRULE:FREQ=WEEKLY;UNTIL=19971224T000000Z
     */
    function testWeeklyTwo()
    {
        $results[] = new DateTime('1997-09-02 09:00:00');
        $results[] = new DateTime('1997-09-09 09:00:00');
        $results[] = new DateTime('1997-09-16 09:00:00');
        $results[] = new DateTime('1997-09-23 09:00:00');
        $results[] = new DateTime('1997-09-30 09:00:00');
        $results[] = new DateTime('1997-10-07 09:00:00');
        $results[] = new DateTime('1997-10-14 09:00:00');
        $results[] = new DateTime('1997-10-21 09:00:00');
        $results[] = new DateTime('1997-10-28 09:00:00');
        $results[] = new DateTime('1997-11-04 09:00:00');
        $results[] = new DateTime('1997-11-11 09:00:00');
        $results[] = new DateTime('1997-11-18 09:00:00');
        $results[] = new DateTime('1997-11-25 09:00:00');
        $results[] = new DateTime('1997-12-02 09:00:00');
        $results[] = new DateTime('1997-12-09 09:00:00');
        $results[] = new DateTime('1997-12-16 09:00:00');
        $results[] = new DateTime('1997-12-23 09:00:00');

        $r = new When();
        $r->startDate(new DateTime("19970902T090000"))
          ->freq("weekly")
          ->until(new DateTime("19971224T000000"))
          ->generateOccurrences();

        $occurrences = $r->occurrences;

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }

    /**
     * Every other week - forever:
     * DTSTART;TZID=America/New_York:19970902T090000
     * RRULE:FREQ=WEEKLY;INTERVAL=2;WKST=SU
     */
    function testWeeklyThree()
    {
        $results[] = new DateTime('1997-09-02 09:00:00');
        $results[] = new DateTime('1997-09-16 09:00:00');
        $results[] = new DateTime('1997-09-30 09:00:00');
        $results[] = new DateTime('1997-10-14 09:00:00');
        $results[] = new DateTime('1997-10-28 09:00:00');
        $results[] = new DateTime('1997-11-11 09:00:00');
        $results[] = new DateTime('1997-11-25 09:00:00');
        $results[] = new DateTime('1997-12-09 09:00:00');
        $results[] = new DateTime('1997-12-23 09:00:00');
        $results[] = new DateTime('1998-01-06 09:00:00');
        $results[] = new DateTime('1998-01-20 09:00:00');
        $results[] = new DateTime('1998-02-03 09:00:00');
        $results[] = new DateTime('1998-02-17 09:00:00');

        $r = new When();
        $r->startDate(new DateTime("19970902T090000"))
          ->freq("weekly")
          ->count(13)
          ->interval(2)
          ->wkst("SU")
          ->generateOccurrences();

        $occurrences = $r->occurrences;

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }

    /**
     * Weekly on Tuesday and Thursday for five weeks:
     * DTSTART;TZID=America/New_York:19970902T090000
     * RRULE:FREQ=WEEKLY;UNTIL=19971007T000000Z;WKST=SU;BYDAY=TU,TH
     * or
     * RRULE:FREQ=WEEKLY;COUNT=10;WKST=SU;BYDAY=TU,TH
     */
    function testWeeklyFour()
    {
        $results[] = new DateTime('1997-09-02 09:00:00');
        $results[] = new DateTime('1997-09-04 09:00:00');
        $results[] = new DateTime('1997-09-09 09:00:00');
        $results[] = new DateTime('1997-09-11 09:00:00');
        $results[] = new DateTime('1997-09-16 09:00:00');
        $results[] = new DateTime('1997-09-18 09:00:00');
        $results[] = new DateTime('1997-09-23 09:00:00');
        $results[] = new DateTime('1997-09-25 09:00:00');
        $results[] = new DateTime('1997-09-30 09:00:00');
        $results[] = new DateTime('1997-10-02 09:00:00');

        $r = new When();
        $r->startDate(new DateTime("19970902T090000"))
          ->freq("weekly")
          ->until(new DateTime("19971007T000000"))
          ->wkst("SU")
          ->byday(array('TU', 'TH'))
          ->generateOccurrences();

        $occurrences = $r->occurrences;

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }

        unset($r);

        $r = new When();
        $r->startDate(new DateTime("19970902T090000"))
          ->freq("weekly")
          ->count(10)
          ->wkst("SU")
          ->byday(array('TU', 'TH'))
          ->generateOccurrences();

        $occurrences = $r->occurrences;

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }

    /**
     * Every other week on Monday, Wednesday, and Friday until December 24, 1997, starting on Monday, September 1, 1997:
     * DTSTART;TZID=America/New_York:19970901T090000
     * RRULE:FREQ=WEEKLY;INTERVAL=2;UNTIL=19971224T000000Z;WKST=SU;BYDAY=MO,WE,FR
     */
    function testWeeklyFive()
    {
        $results[] = new DateTime('1997-09-01 09:00:00');
        $results[] = new DateTime('1997-09-03 09:00:00');
        $results[] = new DateTime('1997-09-05 09:00:00');
        $results[] = new DateTime('1997-09-15 09:00:00');
        $results[] = new DateTime('1997-09-17 09:00:00');
        $results[] = new DateTime('1997-09-19 09:00:00');
        $results[] = new DateTime('1997-09-29 09:00:00');
        $results[] = new DateTime('1997-10-01 09:00:00');
        $results[] = new DateTime('1997-10-03 09:00:00');
        $results[] = new DateTime('1997-10-13 09:00:00');
        $results[] = new DateTime('1997-10-15 09:00:00');
        $results[] = new DateTime('1997-10-17 09:00:00');
        $results[] = new DateTime('1997-10-27 09:00:00');
        $results[] = new DateTime('1997-10-29 09:00:00');
        $results[] = new DateTime('1997-10-31 09:00:00');
        $results[] = new DateTime('1997-11-10 09:00:00');
        $results[] = new DateTime('1997-11-12 09:00:00');
        $results[] = new DateTime('1997-11-14 09:00:00');
        $results[] = new DateTime('1997-11-24 09:00:00');
        $results[] = new DateTime('1997-11-26 09:00:00');
        $results[] = new DateTime('1997-11-28 09:00:00');
        $results[] = new DateTime('1997-12-08 09:00:00');
        $results[] = new DateTime('1997-12-10 09:00:00');
        $results[] = new DateTime('1997-12-12 09:00:00');
        $results[] = new DateTime('1997-12-22 09:00:00');

        $r = new When();
        $r->startDate(new DateTime("19970901T090000"))
          ->freq("weekly")
          ->until(new DateTime("19971224T000000"))
          ->wkst("SU")
          ->interval(2)
          ->byday(array('MO', 'WE', 'FR'))
          ->generateOccurrences();

        $occurrences = $r->occurrences;

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }

    /**
     * Every other week on Tuesday and Thursday, for 8 occurrences:
     * DTSTART;TZID=America/New_York:19970902T090000
     * RRULE:FREQ=WEEKLY;INTERVAL=2;COUNT=8;WKST=SU;BYDAY=TU,TH
     */
    function testWeeklySix()
    {
        $results[] = new DateTime('1997-09-02 09:00:00');
        $results[] = new DateTime('1997-09-04 09:00:00');
        $results[] = new DateTime('1997-09-16 09:00:00');
        $results[] = new DateTime('1997-09-18 09:00:00');
        $results[] = new DateTime('1997-09-30 09:00:00');
        $results[] = new DateTime('1997-10-02 09:00:00');
        $results[] = new DateTime('1997-10-14 09:00:00');
        $results[] = new DateTime('1997-10-16 09:00:00');

        $r = new When();
        $r->startDate(new DateTime("19970902T090000"))
          ->freq("weekly")
          ->wkst("SU")
          ->interval(2)
          ->count(8)
          ->byday(array('TU', 'TH'))
          ->generateOccurrences();

        $occurrences = $r->occurrences;

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }

    /**
     * An example where the days generated makes a difference because of WKST:
     * DTSTART;TZID=America/New_York:19970805T090000
     * RRULE:FREQ=WEEKLY;INTERVAL=2;COUNT=4;BYDAY=TU,SU;WKST=MO
     */
    function testWeeklySeven()
    {
        $results[] = new DateTime('1997-08-05 09:00:00');
        $results[] = new DateTime('1997-08-10 09:00:00');
        $results[] = new DateTime('1997-08-19 09:00:00');
        $results[] = new DateTime('1997-08-24 09:00:00');

        $r = new When();
        $r->startDate(new DateTime("19970805T090000"))
          ->freq("weekly")
          ->interval(2)
          ->count(4)
          ->byday(array('TU', 'SU'))
          ->wkst('MO')
          ->generateOccurrences();

        $occurrences = $r->occurrences;

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }

    /**
     * changing only WKST from MO to SU, yields different results...
     * DTSTART;TZID=America/New_York:19970805T090000
     * RRULE:FREQ=WEEKLY;INTERVAL=2;COUNT=4;BYDAY=TU,SU;WKST=SU
     */
    function testWeeklyEight()
    {
        $results[] = new DateTime('1997-08-05 09:00:00');
        $results[] = new DateTime('1997-08-17 09:00:00');
        $results[] = new DateTime('1997-08-19 09:00:00');
        $results[] = new DateTime('1997-08-31 09:00:00');

        $r = new When();
        $r->startDate(new DateTime("19970805T090000"))
          ->freq("weekly")
          ->interval(2)
          ->count(4)
          ->byday(array('TU', 'SU'))
          ->wkst('SU')
          ->generateOccurrences();

        $occurrences = $r->occurrences;

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }

    /**
     * Every other week - forever:
     * DTSTART;TZID=America/New_York:19970902T000000
     * RRULE:FREQ=WEEKLY;INTERVAL=2;WKST=TU
     *
     * Weekstart meets first occurrence,
     * time is midnight.
     *
     * @see https://github.com/tplaner/When/issues/45
     */
    function testWeeklyNine()
    {
        $results[] = new DateTime('1997-09-02 00:00:00');
        $results[] = new DateTime('1997-09-16 00:00:00');
        $results[] = new DateTime('1997-09-30 00:00:00');
        $results[] = new DateTime('1997-10-14 00:00:00');
        $results[] = new DateTime('1997-10-28 00:00:00');
        $results[] = new DateTime('1997-11-11 00:00:00');
        $results[] = new DateTime('1997-11-25 00:00:00');
        $results[] = new DateTime('1997-12-09 00:00:00');
        $results[] = new DateTime('1997-12-23 00:00:00');
        $results[] = new DateTime('1998-01-06 00:00:00');
        $results[] = new DateTime('1998-01-20 00:00:00');
        $results[] = new DateTime('1998-02-03 00:00:00');
        $results[] = new DateTime('1998-02-17 00:00:00');

        $r = new When();
        $r->startDate(new \DateTime('1997-09-02 00:00:00'))
            ->freq('weekly')
            ->interval(2)
            ->wkst('TU')
            ->count(13)
            ->generateOccurrences();

        $occurrences = $r->occurrences;

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }
}
