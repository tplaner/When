<?php

use PHPUnit\Framework\TestCase;
use When\When;

class WhenNextPrevTest extends TestCase
{

    /**
     * Note: for this recurrence ...
     *   $r = new When();
     *   $r->startDate(new DateTime("19970902T090000"))
     *     ->rrule("FREQ=WEEKLY");
     *
     * The first few dates are:
     *
     *  $results[] = new DateTime('1997-09-02 09:00:00');
     *  $results[] = new DateTime('1997-09-09 09:00:00');
     *  $results[] = new DateTime('1997-09-16 09:00:00');
     *  $results[] = new DateTime('1997-09-23 09:00:00');
     *  $results[] = new DateTime('1997-09-30 09:00:00');
     *  $results[] = new DateTime('1997-10-07 09:00:00');
     *  $results[] = new DateTime('1997-10-14 09:00:00');
     *  $results[] = new DateTime('1997-10-21 09:00:00');
     *  $results[] = new DateTime('1997-10-28 09:00:00');
     *  $results[] = new DateTime('1997-11-04 09:00:00');
     */

    /* Test getting next occurrence */
    function testGetNextOccurrence() {

        $r = new When();
        $r->startDate(new DateTime("19970902T090000"))
          ->rrule("FREQ=WEEKLY");

        $expected = new DateTime('1997-09-23 09:00:00');
        $result = $r->getNextOccurrence(new DateTime("19970917T090000"));
        $this->assertEquals($expected, $result);

    }

    /* Test getting next occurrence, using $strictly_after=FALSE with date in recurrence  */
    function testGetNextOccurrenceNotStrictlyAfterMatchingDateTime() {

        $r = new When();
        $r->startDate(new DateTime("19970902T090000"))
          ->rrule("FREQ=WEEKLY");

        $expected = new DateTime('1997-09-16 09:00:00');
        $result = $r->getNextOccurrence(new DateTime("19970916T090000"), FALSE);
        $this->assertEquals($expected, $result);

    }

    /* Test getting next occurrence, using $strictly_after=FALSE with date in recurrence, time not. */
    function testGetNextOccurrenceNotStrictlyAfterMatchingDateMismatchedTime() {

        $r = new When();
        $r->startDate(new DateTime("19970902T090000"))
          ->rrule("FREQ=WEEKLY");

        $expected = new DateTime('1997-09-23 09:00:00');
        $result = $r->getNextOccurrence(new DateTime("19970916T093000"), FALSE);
        $this->assertEquals($expected, $result);

    }

    /* Test getting next occurrence, using $strictly_after=TRUE (default)  with date in recurrence  */
    function testGetNextOccurrenceStrictlyAfterMatchingDate() {

        $r = new When();
        $r->startDate(new DateTime("19970902T090000"))
          ->rrule("FREQ=WEEKLY");

        $expected = new DateTime('1997-09-23 09:00:00');
        $result = $r->getNextOccurrence(new DateTime("19970916T090000"));
        $this->assertEquals($expected, $result);

    }

    /* Test getting next occurence on last occurrence */
    function testGetNextOccurrenceFromLastOccurence() {
        $r = new When();
        $r->startDate(new DateTime("19970902T090000"))
          ->rrule("FREQ=WEEKLY")
          ->until(new DateTime("19971104T090000"));

        $result = $r->getNextOccurrence(new DateTime("19971104T090000"));
        $this->assertFalse($result);
    }


    /* Test getting previous occurrence */
    function testGetPrevOccurrenceFromLastOccurence() {
        $r = new When();
        $r->startDate(new DateTime("19970902T090000"))
          ->rrule("FREQ=WEEKLY")
          ->until(new DateTime("19971104T090000"));

        $expected = new DateTime("1997-10-28 09:00:00");

        $result = $r->getPrevOccurrence(new DateTime("19971104T090000"));
        $this->assertEquals($expected, $result);
    }

    /* Test that getting previous occurrence from the first returns FALSE */
    function testGetPrevOccurrenceFromFirstOccurence() {
        $r = new When();
        $r->startDate(new DateTime("19970902T090000"))
          ->rrule("FREQ=WEEKLY")
          ->until(new DateTime("19971104T090000"));

        $result = $r->getPrevOccurrence(new DateTime("19970902T090000"));
        $this->assertFalse($result);
    }

}
