<?php

use PHPUnit\Framework\TestCase;
use When\When;

class WhenHourlyRruleTest extends TestCase
{
    /**
     * I believe this rrule has a typo, the time zones don't match.
     *
     * Every 3 hours from 9:00 AM to 5:00 PM on a specific day:
     * DTSTART;TZID=America/New_York:19970902T090000
     * RRULE:FREQ=HOURLY;INTERVAL=3;UNTIL=19970902T170000Z
     */
    public function testHourlyOne()
    {
        $results[] = new DateTime('1997-09-02 09:00:00Z');
        $results[] = new DateTime('1997-09-02 12:00:00Z');
        $results[] = new DateTime('1997-09-02 15:00:00Z');

        $r = new When();
        $r->startDate(new DateTime("19970902T090000Z"))
          ->rrule("FREQ=HOURLY;INTERVAL=3;UNTIL=19970902T170000Z")
          ->generateOccurrences();

        $occurrences = $r->occurrences;

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }

}
