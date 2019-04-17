<?php

use PHPUnit\Framework\TestCase;
use When\When;

class WhenMonthlyTest extends TestCase
{
    /**
     * Monthly on the 1st Friday for ten occurrences:
     * DTSTART;TZID=US-Eastern:19970905T090000
     * RRULE:FREQ=MONTHLY;COUNT=10;BYDAY=1FR
     */
    function testMonthlyOne()
    {
        $results[] = new DateTime('1997-09-05 09:00:00');
        $results[] = new DateTime('1997-10-03 09:00:00');
        $results[] = new DateTime('1997-11-07 09:00:00');
        $results[] = new DateTime('1997-12-05 09:00:00');
        $results[] = new DateTime('1998-01-02 09:00:00');
        $results[] = new DateTime('1998-02-06 09:00:00');
        $results[] = new DateTime('1998-03-06 09:00:00');
        $results[] = new DateTime('1998-04-03 09:00:00');
        $results[] = new DateTime('1998-05-01 09:00:00');
        $results[] = new DateTime('1998-06-05 09:00:00');

        $r = new When();
        $r->startDate(new DateTime("19970905T090000"))
          ->freq("monthly")
          ->count(10)
          ->byday('1FR')
          ->generateOccurrences();

        $occurrences = $r->occurrences;

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }

    /**
     * Monthly on the 1st Friday until December 24, 1997:
     * DTSTART;TZID=US-Eastern:19970905T090000
     * RRULE:FREQ=MONTHLY;UNTIL=19971224T000000Z;BYDAY=1FR
     */
    function testMonthlyTwo()
    {
        $results[] = new DateTime('1997-09-05 09:00:00');
        $results[] = new DateTime('1997-10-03 09:00:00');
        $results[] = new DateTime('1997-11-07 09:00:00');
        $results[] = new DateTime('1997-12-05 09:00:00');

        $r = new When();
        $r->startDate(new DateTime("19970905T090000"))
          ->until(new DateTime("19971224T000000Z"))
          ->freq("monthly")
          ->byday('1FR')
          ->generateOccurrences();

        $occurrences = $r->occurrences;

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }

    /**
     * Every other month on the 1st and last Sunday of the month for 10 occurrences:
     * DTSTART;TZID=US-Eastern:19970907T090000
     * RRULE:FREQ=MONTHLY;INTERVAL=2;COUNT=10;BYDAY=1SU,-1SU
     */
    function testMonthlyThree()
    {
        $results[] = new DateTime('1997-09-07 09:00:00');
        $results[] = new DateTime('1997-09-28 09:00:00');
        $results[] = new DateTime('1997-11-02 09:00:00');
        $results[] = new DateTime('1997-11-30 09:00:00');
        $results[] = new DateTime('1998-01-04 09:00:00');
        $results[] = new DateTime('1998-01-25 09:00:00');
        $results[] = new DateTime('1998-03-01 09:00:00');
        $results[] = new DateTime('1998-03-29 09:00:00');
        $results[] = new DateTime('1998-05-03 09:00:00');
        $results[] = new DateTime('1998-05-31 09:00:00');

        $r = new When();
        $r->startDate(new DateTime("19970907T090000"))
          ->freq("monthly")
          ->interval(2)
          ->count(10)
          ->byday('1SU,-1SU')
          ->generateOccurrences();

        $occurrences = $r->occurrences;

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }

    /**
     * Monthly on the second to last Monday of the month for 6 months:
     * DTSTART;TZID=US-Eastern:19970922T090000
     * RRULE:FREQ=MONTHLY;COUNT=6;BYDAY=-2MO
     */
    function testMonthlyFour()
    {
        $results[] = new DateTime('1997-09-22 09:00:00');
        $results[] = new DateTime('1997-10-20 09:00:00');
        $results[] = new DateTime('1997-11-17 09:00:00');
        $results[] = new DateTime('1997-12-22 09:00:00');
        $results[] = new DateTime('1998-01-19 09:00:00');
        $results[] = new DateTime('1998-02-16 09:00:00');

        $r = new When();
        $r->startDate(new DateTime("19970922T090000"))
          ->freq("monthly")
          ->count(6)
          ->byday('-2MO')
          ->generateOccurrences();

        $occurrences = $r->occurrences;

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }

    /**
     * Monthly on the third to the last day of the month, forever:
     * DTSTART;TZID=US-Eastern:19970928T090000
     * RRULE:FREQ=MONTHLY;BYMONTHDAY=-3
     */
    function testMonthlyFive()
    {
        $results[] = new DateTime('1997-09-28 09:00:00');
        $results[] = new DateTime('1997-10-29 09:00:00');
        $results[] = new DateTime('1997-11-28 09:00:00');
        $results[] = new DateTime('1997-12-29 09:00:00');
        $results[] = new DateTime('1998-01-29 09:00:00');
        $results[] = new DateTime('1998-02-26 09:00:00');

        $r = new When();
        $r->startDate(new DateTime("19970928T090000"))
          ->freq("monthly")
          ->count(6)
          ->bymonthday(-3)
          ->generateOccurrences();

        $occurrences = $r->occurrences;

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }

    /**
     * Monthly on the 2nd and 15th of the month for 10 occurrences:
     * DTSTART;TZID=US-Eastern:19970902T090000
     * RRULE:FREQ=MONTHLY;COUNT=10;BYMONTHDAY=2,15
     */
    function testMonthlySix()
    {
        $results[] = new DateTime('1997-09-02 09:00:00');
        $results[] = new DateTime('1997-09-15 09:00:00');
        $results[] = new DateTime('1997-10-02 09:00:00');
        $results[] = new DateTime('1997-10-15 09:00:00');
        $results[] = new DateTime('1997-11-02 09:00:00');
        $results[] = new DateTime('1997-11-15 09:00:00');
        $results[] = new DateTime('1997-12-02 09:00:00');
        $results[] = new DateTime('1997-12-15 09:00:00');
        $results[] = new DateTime('1998-01-02 09:00:00');
        $results[] = new DateTime('1998-01-15 09:00:00');

        $r = new When();
        $r->startDate(new DateTime("19970902T090000"))
          ->freq("monthly")
          ->count(10)
          ->bymonthday("2, 15")
          ->generateOccurrences();

        $occurrences = $r->occurrences;

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }

    /**
     * Monthly on the first and last day of the month for 10 occurrences:
     * DTSTART;TZID=US-Eastern:19970930T090000
     * RRULE:FREQ=MONTHLY;COUNT=10;BYMONTHDAY=1,-1
     */
    function testMonthlySeven()
    {
        $results[] = new DateTime('1997-09-30 09:00:00');
        $results[] = new DateTime('1997-10-01 09:00:00');
        $results[] = new DateTime('1997-10-31 09:00:00');
        $results[] = new DateTime('1997-11-01 09:00:00');
        $results[] = new DateTime('1997-11-30 09:00:00');
        $results[] = new DateTime('1997-12-01 09:00:00');
        $results[] = new DateTime('1997-12-31 09:00:00');
        $results[] = new DateTime('1998-01-01 09:00:00');
        $results[] = new DateTime('1998-01-31 09:00:00');
        $results[] = new DateTime('1998-02-01 09:00:00');

        $r = new When();
        $r->startDate(new DateTime("19970930T090000"))
          ->freq("monthly")
          ->count(10)
          ->bymonthday("1, -1")
          ->generateOccurrences();

        $occurrences = $r->occurrences;

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }

    /**
     * Every 18 months on the 10th thru 15th of the month for 10 occurrences:
     * DTSTART;TZID=US-Eastern:19970910T090000
     * RRULE:FREQ=MONTHLY;INTERVAL=18;COUNT=10;BYMONTHDAY=10,11,12,13,14,15
     */
    function testMonhtlyEight()
    {
        $results[] = new DateTime('1997-09-10 09:00:00');
        $results[] = new DateTime('1997-09-11 09:00:00');
        $results[] = new DateTime('1997-09-12 09:00:00');
        $results[] = new DateTime('1997-09-13 09:00:00');
        $results[] = new DateTime('1997-09-14 09:00:00');
        $results[] = new DateTime('1997-09-15 09:00:00');
        $results[] = new DateTime('1999-03-10 09:00:00');
        $results[] = new DateTime('1999-03-11 09:00:00');
        $results[] = new DateTime('1999-03-12 09:00:00');
        $results[] = new DateTime('1999-03-13 09:00:00');

        $r = new When();
        $r->startDate(new DateTime("19970910T090000"))
          ->freq("monthly")
          ->interval(18)
          ->count(10)
          ->bymonthday("10,11,12,13,14,15")
          ->generateOccurrences();

        $occurrences = $r->occurrences;

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }

    /**
     * Every Tuesday, every other month:
     * DTSTART;TZID=US-Eastern:19970902T090000
     * RRULE:FREQ=MONTHLY;INTERVAL=2;BYDAY=TU
     */
    function testMonthlyNine()
    {
        $results[] = new DateTime('1997-09-02 09:00:00');
        $results[] = new DateTime('1997-09-09 09:00:00');
        $results[] = new DateTime('1997-09-16 09:00:00');
        $results[] = new DateTime('1997-09-23 09:00:00');
        $results[] = new DateTime('1997-09-30 09:00:00');
        $results[] = new DateTime('1997-11-04 09:00:00');
        $results[] = new DateTime('1997-11-11 09:00:00');
        $results[] = new DateTime('1997-11-18 09:00:00');
        $results[] = new DateTime('1997-11-25 09:00:00');
        $results[] = new DateTime('1998-01-06 09:00:00');
        $results[] = new DateTime('1998-01-13 09:00:00');
        $results[] = new DateTime('1998-01-20 09:00:00');
        $results[] = new DateTime('1998-01-27 09:00:00');
        $results[] = new DateTime('1998-03-03 09:00:00');
        $results[] = new DateTime('1998-03-10 09:00:00');
        $results[] = new DateTime('1998-03-17 09:00:00');
        $results[] = new DateTime('1998-03-24 09:00:00');
        $results[] = new DateTime('1998-03-31 09:00:00');

        $r = new When();
        $r->startDate(new DateTime("19970902T090000"))
          ->freq("monthly")
          ->interval(2)
          ->count(18)
          ->byday("tu")
          ->generateOccurrences();

        $occurrences = $r->occurrences;

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }

    /**
     * Every Friday the 13th, forever:
     * DTSTART;TZID=US-Eastern:19970902T090000
     * EXDATE;TZID=America/New_York:19970902T090000
     * RRULE:FREQ=MONTHLY;BYDAY=FR;BYMONTHDAY=13
     *
     * TODO: When we add in the ability to EXDATE
     *       this DTSTART needs to be changed
     */
    function testMonhtlyTen()
    {
        $results[] = new DateTime('1998-02-13 09:00:00');
        $results[] = new DateTime('1998-03-13 09:00:00');
        $results[] = new DateTime('1998-11-13 09:00:00');
        $results[] = new DateTime('1999-08-13 09:00:00');
        $results[] = new DateTime('2000-10-13 09:00:00');

        $r = new When();
        $r->startDate(new DateTime("19980213T090000"))
          ->freq("monthly")
          ->count(5)
          ->byday("fr")
          ->bymonthday(13)
          ->generateOccurrences();

        $occurrences = $r->occurrences;

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }

    /**
     * The first Saturday that follows the first Sunday of the month, forever:
     * DTSTART;TZID=US-Eastern:19970913T090000
     * RRULE:FREQ=MONTHLY;BYDAY=SA;BYMONTHDAY=7,8,9,10,11,12,13
     */
    function testMonthlyEleven()
    {
        $results[] = new DateTime('1997-09-13 09:00:00');
        $results[] = new DateTime('1997-10-11 09:00:00');
        $results[] = new DateTime('1997-11-08 09:00:00');
        $results[] = new DateTime('1997-12-13 09:00:00');
        $results[] = new DateTime('1998-01-10 09:00:00');
        $results[] = new DateTime('1998-02-07 09:00:00');
        $results[] = new DateTime('1998-03-07 09:00:00');
        $results[] = new DateTime('1998-04-11 09:00:00');
        $results[] = new DateTime('1998-05-09 09:00:00');
        $results[] = new DateTime('1998-06-13 09:00:00');

        $r = new When();
        $r->startDate(new DateTime("19970913T090000"))
          ->freq("monthly")
          ->count(10)
          ->byday("sa")
          ->bymonthday("7,8,9,10,11,12,13")
          ->generateOccurrences();

        $occurrences = $r->occurrences;

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }

    /**
     * The 3rd instance into the month of one of Tuesday, Wednesday or Thursday, for the next 3 months:
     * DTSTART;TZID=US-Eastern:19970904T090000
     * RRULE:FREQ=MONTHLY;COUNT=3;BYDAY=TU,WE,TH;BYSETPOS=3
     */
    function testMonthlyTwelve()
    {
        $results[] = new DateTime('1997-09-04 09:00:00');
        $results[] = new DateTime('1997-10-07 09:00:00');
        $results[] = new DateTime('1997-11-06 09:00:00');

        $r = new When();
        $r->startDate(new DateTime("19970904T090000"))
          ->freq("monthly")
          ->count(3)
          ->byday("TU, WE, TH")
          ->bysetpos("3")
          ->generateOccurrences();

        $occurrences = $r->occurrences;

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }

    /**
     * An example where an invalid date (i.e., February 30) is ignored.
     * DTSTART;TZID=America/New_York:20070115T090000
     * RRULE:FREQ=MONTHLY;BYMONTHDAY=15,30;COUNT=5
     */
    function testMonthlyThirteen()
    {
        $results[] = new DateTime('2007-01-15 09:00:00');
        $results[] = new DateTime('2007-01-30 09:00:00');
        $results[] = new DateTime('2007-02-15 09:00:00');
        $results[] = new DateTime('2007-03-15 09:00:00');
        $results[] = new DateTime('2007-03-30 09:00:00');

        $r = new When();
        $r->startDate(new DateTime("20070115T090000"))
          ->freq("monthly")
          ->count(5)
          ->bymonthday("15,30")
          ->generateOccurrences();

        $occurrences = $r->occurrences;

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }

    /**
     * The second-to-last weekday of the month:
     * DTSTART;TZID=America/New_York:19970929T090000
     * RRULE:FREQ=MONTHLY;BYDAY=MO,TU,WE,TH,FR;BYSETPOS=-2
     */
    function testMonthylFourteen()
    {
        $results[] = new DateTime('1997-09-29 09:00:00');
        $results[] = new DateTime('1997-10-30 09:00:00');
        $results[] = new DateTime('1997-11-27 09:00:00');
        $results[] = new DateTime('1997-12-30 09:00:00');
        $results[] = new DateTime('1998-01-29 09:00:00');
        $results[] = new DateTime('1998-02-26 09:00:00');
        $results[] = new DateTime('1998-03-30 09:00:00');

        $r = new When();
        $r->startDate(new DateTime("19970929T090000"))
          ->freq("monthly")
          ->count(7)
          ->byday(array('MO', 'TU', 'WE', 'TH', 'FR'))
          ->bysetpos(array(-2))
          ->generateOccurrences();
        //$r->recur('19970929T090000', 'monthly')->count(7)->byday(array('MO', 'TU', 'WE', 'TH', 'FR'))->bysetpos(array(-2));

        $occurrences = $r->occurrences;

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }

    /**
     * FREQ=MONTHLY recur rule breaks (ticket #8)
     * DTSTART;TZID=America/New_York:20110915T100000
     * RRULE:INTERVAL=1;FREQ=MONTHLY;UNTIL=2016-09-15T10:00:00+0100
     */
    function testMonthlyFifteen()
    {
        $results[] = new DateTime('2011-09-15 10:00:00');
        $results[] = new DateTime('2011-10-15 10:00:00');
        $results[] = new DateTime('2011-11-15 10:00:00');
        $results[] = new DateTime('2011-12-15 10:00:00');
        $results[] = new DateTime('2012-01-15 10:00:00');
        $results[] = new DateTime('2012-02-15 10:00:00');
        $results[] = new DateTime('2012-03-15 10:00:00');
        $results[] = new DateTime('2012-04-15 10:00:00');
        $results[] = new DateTime('2012-05-15 10:00:00');
        $results[] = new DateTime('2012-06-15 10:00:00');
        $results[] = new DateTime('2012-07-15 10:00:00');
        $results[] = new DateTime('2012-08-15 10:00:00');
        $results[] = new DateTime('2012-09-15 10:00:00');
        $results[] = new DateTime('2012-10-15 10:00:00');
        $results[] = new DateTime('2012-11-15 10:00:00');
        $results[] = new DateTime('2012-12-15 10:00:00');
        $results[] = new DateTime('2013-01-15 10:00:00');
        $results[] = new DateTime('2013-02-15 10:00:00');
        $results[] = new DateTime('2013-03-15 10:00:00');
        $results[] = new DateTime('2013-04-15 10:00:00');
        $results[] = new DateTime('2013-05-15 10:00:00');
        $results[] = new DateTime('2013-06-15 10:00:00');
        $results[] = new DateTime('2013-07-15 10:00:00');
        $results[] = new DateTime('2013-08-15 10:00:00');
        $results[] = new DateTime('2013-09-15 10:00:00');
        $results[] = new DateTime('2013-10-15 10:00:00');
        $results[] = new DateTime('2013-11-15 10:00:00');
        $results[] = new DateTime('2013-12-15 10:00:00');
        $results[] = new DateTime('2014-01-15 10:00:00');
        $results[] = new DateTime('2014-02-15 10:00:00');
        $results[] = new DateTime('2014-03-15 10:00:00');
        $results[] = new DateTime('2014-04-15 10:00:00');
        $results[] = new DateTime('2014-05-15 10:00:00');
        $results[] = new DateTime('2014-06-15 10:00:00');
        $results[] = new DateTime('2014-07-15 10:00:00');
        $results[] = new DateTime('2014-08-15 10:00:00');
        $results[] = new DateTime('2014-09-15 10:00:00');
        $results[] = new DateTime('2014-10-15 10:00:00');
        $results[] = new DateTime('2014-11-15 10:00:00');
        $results[] = new DateTime('2014-12-15 10:00:00');
        $results[] = new DateTime('2015-01-15 10:00:00');
        $results[] = new DateTime('2015-02-15 10:00:00');
        $results[] = new DateTime('2015-03-15 10:00:00');
        $results[] = new DateTime('2015-04-15 10:00:00');
        $results[] = new DateTime('2015-05-15 10:00:00');
        $results[] = new DateTime('2015-06-15 10:00:00');
        $results[] = new DateTime('2015-07-15 10:00:00');
        $results[] = new DateTime('2015-08-15 10:00:00');
        $results[] = new DateTime('2015-09-15 10:00:00');
        $results[] = new DateTime('2015-10-15 10:00:00');
        $results[] = new DateTime('2015-11-15 10:00:00');
        $results[] = new DateTime('2015-12-15 10:00:00');
        $results[] = new DateTime('2016-01-15 10:00:00');
        $results[] = new DateTime('2016-02-15 10:00:00');
        $results[] = new DateTime('2016-03-15 10:00:00');
        $results[] = new DateTime('2016-04-15 10:00:00');
        $results[] = new DateTime('2016-05-15 10:00:00');
        $results[] = new DateTime('2016-06-15 10:00:00');
        $results[] = new DateTime('2016-07-15 10:00:00');
        $results[] = new DateTime('2016-08-15 10:00:00');

        $r = new When();
        $r->startDate(new DateTime("2011-09-15 10:00:00"))
          ->freq("monthly")
          ->interval(1)
          ->until(new DateTime("2016-09-15T10:00:00+0100"))
          ->generateOccurrences();

        $occurrences = $r->occurrences;

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }

    /**
     * The third instance into the month of one of Tuesday, Wednesday, or Thursday, for the next 3 months:
     * DTSTART;TZID=America/New_York:19970904T090000
     * RRULE:FREQ=MONTHLY;COUNT=3;BYDAY=TU,WE,TH;BYSETPOS=3
     */
    function testMonthlySixteen()
    {
        $results[] = new DateTime('1997-09-04 09:00:00');
        $results[] = new DateTime('1997-10-07 09:00:00');
        $results[] = new DateTime('1997-11-06 09:00:00');

        $r = new When();
        $r->startDate(new DateTime("19970904T090000"))
          ->freq("monthly")
          ->count(3)
          ->byday("tu, we, th")
          ->bysetpos(3)
          ->generateOccurrences();

        $occurrences = $r->occurrences;

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }

    /**
     * Every three months (quarterly) on the first Monday of the month,
     * starting January 7 2019, until February 2, 2021 (issue #71)
     * DTSTART;TZID=America/New_York:20190107T170000
     * RRULE:FREQ=MONTHLY;INTERVAL=3;BYDAY=1MO;WKST=MO;UNTIL=2021-02-01T18:00:00-0500
     */
    function testQuarterlyOne()
    {
        $tz = new DateTimeZone("America/New_York");

        $results[] = new DateTime('2019-01-07 17:00:00', $tz);
        $results[] = new DateTime('2019-04-01 17:00:00', $tz);
        $results[] = new DateTime('2019-07-01 17:00:00', $tz);
        $results[] = new DateTime('2019-10-07 17:00:00', $tz);
        $results[] = new DateTime('2020-01-06 17:00:00', $tz);
        $results[] = new DateTime('2020-04-06 17:00:00', $tz);
        $results[] = new DateTime('2020-07-06 17:00:00', $tz);
        $results[] = new DateTime('2020-10-05 17:00:00', $tz);
        $results[] = new DateTime('2021-01-04 17:00:00', $tz);

        $r = new When();
        $r->startDate(new DateTime("20190107T170000", $tz))
          ->freq("monthly")
          ->interval(3)
          ->byday('1MO')
          ->until(new DateTime("2021-02-01T18:00:00", $tz))
          ->generateOccurrences();

        $occurrences = $r->occurrences;

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }

        /* Check that $occurrences doesn't have extra results, as well */
        $this->assertEquals(count($occurrences), count($results));
    }

}
