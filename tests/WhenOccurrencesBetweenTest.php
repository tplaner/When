<?php

use PHPUnit\Framework\TestCase;
use When\When;

class WhenOccurrencesBetweenTest extends TestCase
{

    /* Get slices of an unbounded weekly recurrence */
    function testGetWeeklyOccurrencesBetweenEarlySlice() {
        $results = array();
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
          ->rrule("FREQ=WEEKLY");

        $occurrences = $r->getOccurrencesBetween(new DateTime('1997-09-02 09:00:00'),
        new DateTime('1997-11-04 09:01:00'));

        foreach ($results as $key => $result) {
             $this->assertEquals($result, $occurrences[$key]);
        }

        /* Check that $occurrences doesn't have extra dates, as well */
        $this->assertEquals(count($occurrences), count($results));
    }

    /* Get slices of an unbounded weekly recurrence */
    function testGetWeeklyOccurrencesBetweenLaterSlice() {

        $results = array();
        $results[] = new DateTime('2016-01-26 09:00:00');
        $results[] = new DateTime('2016-02-02 09:00:00');
        $results[] = new DateTime('2016-02-09 09:00:00');
        $results[] = new DateTime('2016-02-16 09:00:00');
        $results[] = new DateTime('2016-02-23 09:00:00');
        $results[] = new DateTime('2016-03-01 09:00:00');
        $results[] = new DateTime('2016-03-08 09:00:00');
        $results[] = new DateTime('2016-03-15 09:00:00');
        $results[] = new DateTime('2016-03-22 09:00:00');

        $r = new When();
        $r->startDate(new DateTime("19970902T090000"))
          ->rrule("FREQ=WEEKLY");

        $occurrences = $r->getOccurrencesBetween(new DateTime('2016-01-25 09:00:00'),
        new DateTime('2016-03-22 09:01:00'));

        foreach ($results as $key => $result) {
             $this->assertEquals($result, $occurrences[$key]);
        }

        /* Check that $occurrences doesn't have extra dates, as well */
        $this->assertEquals(count($occurrences), count($results));
    }


    /* Get a slice of an unbounded recurrence, with a limit */
    function testGetWeeklyOccurrencesBetweenEarlySliceWithLimit() {
        $results = array();
        $results[] = new DateTime('1997-09-02 09:00:00');
        $results[] = new DateTime('1997-09-09 09:00:00');
        $results[] = new DateTime('1997-09-16 09:00:00');

        $r = new When();
        $r->startDate(new DateTime("19970902T090000"))
          ->rrule("FREQ=WEEKLY");

        $occurrences = $r->getOccurrencesBetween(new DateTime('1997-09-02 09:00:00'),
        new DateTime('1997-11-04 09:01:00'), 3);

        foreach ($results as $key => $result) {
             $this->assertEquals($result, $occurrences[$key]);
        }
    }


    function testGetWeeklyOccurrenceWindowBeforeStartDate() {
        $results = array();
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
          ->rrule("FREQ=WEEKLY");

        $occurrences = $r->getOccurrencesBetween(new DateTime('1987-09-02 09:00:00'),
        new DateTime('1997-11-04 09:01:00'));

        foreach ($results as $key => $result) {
             $this->assertEquals($result, $occurrences[$key]);
        }
    }


    /* Test use of until date on bounded occurrence */
    function testGetWeeklyOccurrenceWindowAfterUntilDate() {
        $results = array();
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
          ->rrule("FREQ=WEEKLY")
          ->until(new DateTime("19971105T090000"));;

        $occurrences = $r->getOccurrencesBetween(new DateTime('1997-09-02 09:00:00'),
        new DateTime('2007-11-04 09:01:00'));

        $this->assertEquals(count($results), count($occurrences));
        foreach ($results as $key => $result) {
             $this->assertEquals($result, $occurrences[$key]);
        }
    }

    /* Test use of count on bounded occurrence */
    function testGetWeeklyOccurrenceWindowBoundedByCount() {
        $results = array();
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
          ->rrule("FREQ=WEEKLY")
          ->count(10);

        $occurrences = $r->getOccurrencesBetween(new DateTime('1997-09-02 09:00:00'),
        new DateTime('2007-11-04 09:01:00'));

        $this->assertEquals(count($results), count($occurrences));
        foreach ($results as $key => $result) {
             $this->assertEquals($result, $occurrences[$key]);
        }
    }

    /* Test use of count on bounded occurrence with window starting after recurrence start*/
    function testGetWeeklyOccurrenceWindowCountAndStartDate() {
        $results = array();
        $results[] = new DateTime('1997-09-23 09:00:00');
        $results[] = new DateTime('1997-09-30 09:00:00');
        $results[] = new DateTime('1997-10-07 09:00:00');
        $results[] = new DateTime('1997-10-14 09:00:00');
        $results[] = new DateTime('1997-10-21 09:00:00');
        $results[] = new DateTime('1997-10-28 09:00:00');
        $results[] = new DateTime('1997-11-04 09:00:00');

        $r = new When();
        $r->startDate(new DateTime("19970902T090000"))
          ->rrule("FREQ=WEEKLY")
          ->count(10);

        $occurrences = $r->getOccurrencesBetween(new DateTime('1997-09-23 09:00:00'),
        new DateTime('2007-11-04 09:01:00'));

        $this->assertEquals(count($results), count($occurrences));
        foreach ($results as $key => $result) {
             $this->assertEquals($result, $occurrences[$key]);
        }
    }

    /* Test use of count on bounded occurrence, where no events match window */
    function testGetWeeklyOccurrenceWindowCountAndStartDateNoResults() {

        $r = new When();
        $r->startDate(new DateTime("19970902T090000"))
          ->rrule("FREQ=WEEKLY")
          ->count(10);

        $occurrences = $r->getOccurrencesBetween(new DateTime('1997-11-05 09:00:00'),
        new DateTime('2007-11-04 09:01:00'));

        $this->assertEquals(0, count($occurrences));
    }

    /* Empty results on backwards date range */
    function testGetWeeklyOccurrencesBackwardsDateRange() {
        $r = new When();
        $r->startDate(new DateTime("19970902T090000"))
          ->rrule("FREQ=WEEKLY");

        $occurrences = $r->getOccurrencesBetween(new DateTime('1997-11-04 09:01:00'),
        new DateTime('1997-09-02 09:00:00'));

        $this->assertEquals(0, count($occurrences));
    }

    /**
     * Every 2nd Monday between Sept 1 - Dec 1 1997 (issue #58)
     * Checking single BYDAY with BYSETPOS while Monthly
     * DTSTART;TZID=America/New_York:19970908T090000
     * RRULE:FREQ=MONTHLY;BYDAY=MO;BYSETPOS=2;
     */
    function testGetMonthlyOccurrencesBydayBysetpos()
    {
        $results[] = new DateTime("1997-09-08 09:00:00");
        $results[] = new DateTime("1997-10-13 09:00:00");
        $results[] = new DateTime("1997-11-10 09:00:00");

        $r = new When();
        $r->startDate(new DateTime("19970908T090000"))
          ->rrule("FREQ=MONTHLY;BYDAY=MO;BYSETPOS=2;");
        $occurrences = $r->getOccurrencesBetween(
            new DateTime( "19970901T090000" ),
            new DateTime( "19971201T090000" )
        );

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }

    /**
     * First 4 2nd Fridays between July 3 - Nov 3 2016
     * Checking against BYSETPOS caused undefined offset
     * DTSTART;TZID=America/New_York:20160610T090000
     * RRULE:FREQ=MONTHLY;BYDAY=FR;BYSETPOS=2;COUNT=3;
     */
    function testGetMonthlyOccurrencesBysetposUndefinedOffset()
    {
        $results[] = new DateTime("2016-07-08 09:00:00");
        $results[] = new DateTime("2016-08-12 09:00:00");
        $results[] = new DateTime("2016-09-09 09:00:00");
        $results[] = new DateTime("2016-10-14 09:00:00");

        $r = new When();
        $r->startDate(new DateTime("20160610T090000"))
          ->rrule("FREQ=MONTHLY;BYDAY=FR;BYSETPOS=2");
        $occurrences = $r->getOccurrencesBetween(
            new DateTime( "20160703T090000" ),
            new DateTime( "20161103T090000" )
        );

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }

    function testGetOccurrencesBetweenWithExclusions() {
        $results[] = new DateTime("2016-07-08 09:00:00");
        $results[] = new DateTime("2016-09-09 09:00:00");
        $results[] = new DateTime("2016-10-14 09:00:00");

        $r = new When();
        $r->startDate(new DateTime("20160610T090000"))
          ->rrule("FREQ=MONTHLY;BYDAY=FR;BYSETPOS=2")
          ->exclusions(array(new DateTime("2016-08-12 09:00:00")));
        $occurrences = $r->getOccurrencesBetween(
            new DateTime( "20160703T090000" ),
            new DateTime( "20161103T090000" )
        );

         foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }

    }

    /**
     * Check if we capture occurrences beyond rangeLimit (200)
     * DTSTART;TZID=America/New_York:19970902T090000
     * RRULE:FREQ=WEEKLY;
     *
     * '2001-07-03 09:00:00' = #201
     * '2001-07-31 09:00:00' = #205
     */
    function testOutsideRangeLimit()
    {
        $results[] = new DateTime('2001-07-03 09:00:00');
        $results[] = new DateTime('2001-07-10 09:00:00');
        $results[] = new DateTime('2001-07-17 09:00:00');
        $results[] = new DateTime('2001-07-24 09:00:00');
        $results[] = new DateTime('2001-07-31 09:00:00');

        $r = new When();
        $r->startDate(new DateTime("19970902T090000"))
          ->rrule("FREQ=WEEKLY;");
        $occurrences = $r->getOccurrencesBetween(
            new DateTime( "20010702T090000" ),
            new DateTime( "20010801T090000" )
        );

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }

    /**
     * Check if we capture occurrences within and beyond rangeLimit (200)
     * DTSTART;TZID=America/New_York:19970902T090000
     * RRULE:FREQ=WEEKLY;
     *
     * '2001-05-22 09:00:00' = #195
     * '2001-07-31 09:00:00' = #205
     */
    function testRangeLimit()
    {
        $results[] = new DateTime('2001-05-22 09:00:00');
        $results[] = new DateTime('2001-05-29 09:00:00');
        $results[] = new DateTime('2001-06-05 09:00:00');
        $results[] = new DateTime('2001-06-12 09:00:00');
        $results[] = new DateTime('2001-06-19 09:00:00');
        $results[] = new DateTime('2001-06-26 09:00:00');
        $results[] = new DateTime('2001-07-03 09:00:00');
        $results[] = new DateTime('2001-07-10 09:00:00');
        $results[] = new DateTime('2001-07-17 09:00:00');
        $results[] = new DateTime('2001-07-24 09:00:00');
        $results[] = new DateTime('2001-07-31 09:00:00');

        $r = new When();
        $r->startDate(new DateTime("19970902T090000"))
          ->rrule("FREQ=WEEKLY;");
        $occurrences = $r->getOccurrencesBetween(
            new DateTime( "20010521T090000" ),
            new DateTime( "20010801T090000" )
        );

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }

    /**
     * Check that we don't alter results
     * DTSTART;TZID=America/New_York:19970902T090000
     * RRULE:FREQ=WEEKLY;
     *
     * '2001-07-03 09:00:00' = #201
     * '2001-07-31 09:00:00' = #205
     */
    function testCurruptingThis()
    {
        $results[] = new DateTime('2001-07-03 09:00:00');
        $results[] = new DateTime('2001-07-10 09:00:00');
        $results[] = new DateTime('2001-07-17 09:00:00');
        $results[] = new DateTime('2001-07-24 09:00:00');
        $results[] = new DateTime('2001-07-31 09:00:00');

        $r = new When();
        $r->startDate(new DateTime("19970902T090000"))
          ->rrule("FREQ=WEEKLY;");
        $occurrences = $r->getOccurrencesBetween(
            new DateTime( "20010521T090000" ),
            new DateTime( "20010612T090000" )
        );

        $occurrences2 = $r->getOccurrencesBetween(
            new DateTime( "20010702T090000" ),
            new DateTime( "20010801T090000" )
        );

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences2[$key]);
        }
    }

    /**
     * Every three months (quarterly) on the first Monday of the month,
     * starting January 7 2019, until February 2, 2021 (issue #71)
     * DTSTART;TZID=America/Los_Angeles:20190107T170000
     * RRULE:FREQ=MONTHLY;INTERVAL=3;BYDAY=1MO;WKST=MO;UNTIL=2021-02-01T18:00:00-0800
     */
    function testGetQuarterlyOccurrencesByDay()
    {
        $tz = new DateTimeZone("America/New_York");

        $results[] = new DateTime('2019-01-07 17:00:00', $tz);
        $results[] = new DateTime('2019-04-01 17:00:00', $tz);
        $results[] = new DateTime('2019-07-01 17:00:00', $tz);
        $results[] = new DateTime('2019-10-07 17:00:00', $tz);
        $results[] = new DateTime('2020-01-06 17:00:00', $tz);

        $startDt = new DateTime("20190107T170000", $tz);

        $r = new When();
        $r->startDate($startDt)
          ->freq("monthly")
          ->interval(3)
          ->byday("1MO")
          ->wkst("MO")
          ->until(new DateTime("2021-02-01T18:00:00", $tz))
          ->generateOccurrences();

        $occurrences = $r->getOccurrencesBetween(
            new DateTime("20190101T170000"),
            new DateTime("20200301T170000")
        );

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }

        /* Check that $occurrences doesn't have extra dates, as well */
        $this->assertEquals(count($occurrences), count($results));
    }


}
