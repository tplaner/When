<?php

use PHPUnit\Framework\TestCase;
use When\When;

class WhenMinutelyRruleTest extends TestCase
{
    /**
     * Every hour and a half for 4 occurrences:
     * DTSTART;TZID=America/New_York:19970902T090000
     * RRULE:FREQ=MINUTELY;INTERVAL=90;COUNT=4
     */
    public function testMinutelyOne()
    {
        $results[] = new DateTime('1997-09-02 09:00:00');
        $results[] = new DateTime('1997-09-02 10:30:00');
        $results[] = new DateTime('1997-09-02 12:00:00');
        $results[] = new DateTime('1997-09-02 13:30:00');

        $r = new When();
        $r->startDate(new DateTime("19970902T090000"))
          ->rrule("FREQ=MINUTELY;INTERVAL=90;COUNT=4")
          ->generateOccurrences();

        $occurrences = $r->occurrences;

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }

    /**
     * Every 15 minutes for 6 occurrences:
     * DTSTART;TZID=America/New_York:19970902T090000
     * RRULE:FREQ=MINUTELY;INTERVAL=15;COUNT=6
     */
    public function testMinutelyTwo()
    {
        $results[] = new DateTime('1997-09-02 09:00:00');
        $results[] = new DateTime('1997-09-02 09:15:00');
        $results[] = new DateTime('1997-09-02 09:30:00');
        $results[] = new DateTime('1997-09-02 09:45:00');
        $results[] = new DateTime('1997-09-02 10:00:00');
        $results[] = new DateTime('1997-09-02 10:15:00');

        $r = new When();
        $r->startDate(new DateTime("19970902T090000"))
          ->rrule("FREQ=MINUTELY;INTERVAL=15;COUNT=6")
          ->generateOccurrences();

        $occurrences = $r->occurrences;

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }

}
