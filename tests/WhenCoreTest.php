<?php

use PHPUnit\Framework\TestCase;
use When\InvalidStartDate;
use When\When;

class WhenCoreTest extends TestCase {

    /*public function testValidDateString()
    {
        $test = new When();
        $test->startDate('20121010');

        $this->assertInstanceOf('DateTime', $test);
    }*/

    public function testInvalidDateString()
    {
        $this->expectException(InvalidArgumentException::class);

        $test = new When();
        $test->startDate('asdasd');
    }

    public function testValidStartDate()
    {
        $date = new DateTime();

        $test = new When();
        $test->startDate($date);

        $this->assertEquals($test->startDate, $date);
    }

    public function testValidFreq()
    {
        $test = new When();
        $test->freq("secondly");

        $this->assertEquals($test->freq, "secondly");

        // should be lower case
        $test = new When();
        $test->freq("HOURLY");

        $this->assertEquals($test->freq, "hourly");
    }

    public function testInvalidFreq()
    {
        $this->expectException(InvalidArgumentException::class);

        $test = new When();
        $test->freq("monthy");
    }

    public function testInvalidStartDate()
    {
        $this->expectException(InvalidArgumentException::class);

        $test = new When();
        $test->startDate("test");
    }

    public function testValidUntil()
    {
        $date = new DateTime();

        $test = new When();
        $test->until($date);

        $this->assertEquals($test->until, $date);
    }

    public function testInvalidUntil()
    {
        $this->expectException(InvalidArgumentException::class);

        $test = new When();
        $test->until("test");
    }

    public function testInvalidDateObject()
    {
        $this->expectException(InvalidArgumentException::class);

        $test = new When();
        $test->startDate(new WhenFakeObject);
    }

    /* it is important we have this working */
    public function testZuluTimeString()
    {
        $test = new When();
        $test->startDate(new DateTime("19970610T172345Z"));

        $this->assertInstanceOf('DateTime', $test);
    }

    /*public function testPrepareList()
    {
        $method = new ReflectionMethod('When\\When', 'prepareList');
        $method->setAccessible(true);

        $response = array(1, 2, 3, 4);

        $this->assertEquals($method::prepareList(1, 2, "3", 4), $response);
    }*/

    public function testValidWkst()
    {
        $test = new When;
        $test->wkst('mo');

        $this->assertEquals($test->wkst, 'mo');
    }

    public function testInvalidWkst()
    {
        $this->expectException(InvalidArgumentException::class);

        $test = new When;
        $test->wkst('va');
    }

    public function testValidByMonthDay()
    {
        $test = new When;
        $test->bymonthday(12);

        $this->assertEquals($test->bymonthdays, array(12));

        $test = new When;
        $test->bymonthday(-12);

        $this->assertEquals($test->bymonthdays, array(-12));

        // sloppy input works
        $test = new When;
        $test->bymonthday('1, 2,3 ');

        $this->assertEquals($test->bymonthdays, array(1, 2, 3));

        // sloppier input works
        $test = new When;
        $test->bymonthday('1, 2,-3 ,');

        $this->assertEquals($test->bymonthdays, array(1, 2, -3));

        $test = new When;
        $test->bymonthday(array(-1, 2, 3));

        $this->assertEquals($test->bymonthdays, array(-1, 2, 3));

        // different delimeter
        $test = new When;
        $test->bymonthday('1; 2; 3', ";");

        $this->assertEquals($test->bymonthdays, array(1, 2, 3));

        // different delimeter sloppy
        $test = new When;
        $test->bymonthday(';1; 2; 3;', ";");

        $this->assertEquals($test->bymonthdays, array(1, 2, 3));
    }

    public function testInvalidByMonthDay()
    {
        $this->expectException(InvalidArgumentException::class);

        $test = new When;
        $test->bymonthday(32);
    }

    public function testValidByYearDay()
    {
        $test = new When;
        $test->byyearday(12);

        $this->assertEquals($test->byyeardays, array(12));

        $test = new When;
        $test->byyearday(-12);

        $this->assertEquals($test->byyeardays, array(-12));

        // sloppy input works
        $test = new When;
        $test->byyearday('1, 2,3 ');

        $this->assertEquals($test->byyeardays, array(1, 2, 3));

        // sloppier input works
        $test = new When;
        $test->byyearday('1, 2,-3 ,');

        $this->assertEquals($test->byyeardays, array(1, 2, -3));

        $test = new When;
        $test->byyearday(array(-1, 2, 3));

        $this->assertEquals($test->byyeardays, array(-1, 2, 3));

        // different delimeter
        $test = new When;
        $test->byyearday('1; 2; 3', ";");

        $this->assertEquals($test->byyeardays, array(1, 2, 3));

        // different delimeter sloppy
        $test = new When;
        $test->byyearday(';1; 2; 3;', ";");

        $this->assertEquals($test->byyeardays, array(1, 2, 3));
    }

    public function testInvalidByYearDay()
    {
        $this->expectException(InvalidArgumentException::class);

        $test = new When;
        $test->byyearday(367);
    }

    public function testValidByWeekNo()
    {
        $test = new When;
        $test->byweekno(12);

        $this->assertEquals($test->byweeknos, array(12));

        $test = new When;
        $test->byweekno(-12);

        $this->assertEquals($test->byweeknos, array(-12));

        // sloppy input works
        $test = new When;
        $test->byweekno('1, 2,3 ');

        $this->assertEquals($test->byweeknos, array(1, 2, 3));

        // sloppier input works
        $test = new When;
        $test->byweekno('1, 2,-3 ,');

        $this->assertEquals($test->byweeknos, array(1, 2, -3));

        $test = new When;
        $test->byweekno(array(-1, 2, 3));

        $this->assertEquals($test->byweeknos, array(-1, 2, 3));

        // different delimeter
        $test = new When;
        $test->byweekno('1; 2; 3', ";");

        $this->assertEquals($test->byweeknos, array(1, 2, 3));

        // different delimeter sloppy
        $test = new When;
        $test->byweekno(';1; 2; 3;', ";");

        $this->assertEquals($test->byweeknos, array(1, 2, 3));
    }

    public function testInvalidByWeekNo()
    {
        $this->expectException(InvalidArgumentException::class);

        $test = new When;
        $test->byweekno(55);
    }

    public function testValidByMonth()
    {
        $test = new When;
        $test->bymonth(12);

        $this->assertEquals($test->bymonths, array(12));

        // sloppy input works
        $test = new When;
        $test->bymonth('1, 2,3 ');

        $this->assertEquals($test->bymonths, array(1, 2, 3));

        // sloppier input works
        $test = new When;
        $test->bymonth('1, 2,3 ,');

        $this->assertEquals($test->bymonths, array(1, 2, 3));

        $test = new When;
        $test->bymonth(array(1, 2, 3));

        $this->assertEquals($test->bymonths, array(1, 2, 3));

        // different delimeter
        $test = new When;
        $test->bymonth('1; 2; 3', ";");

        $this->assertEquals($test->bymonths, array(1, 2, 3));

        // different delimeter sloppy
        $test = new When;
        $test->bymonth(';1; 2; 3;', ";");

        $this->assertEquals($test->bymonths, array(1, 2, 3));
    }

    public function testInvalidByMonth()
    {
        $this->expectException(InvalidArgumentException::class);

        $test = new When;
        $test->bymonth(-1);
    }

    public function testValidBySetPos()
    {
        $test = new When;
        $test->bysetpos(12);

        $this->assertEquals($test->bysetpos, array(12));

        $test = new When;
        $test->bysetpos(-12);

        $this->assertEquals($test->bysetpos, array(-12));

        // sloppy input works
        $test = new When;
        $test->bysetpos('1, 2,3 ');

        $this->assertEquals($test->bysetpos, array(1, 2, 3));

        // sloppier input works
        $test = new When;
        $test->bysetpos('1, 2,-3 ,');

        $this->assertEquals($test->bysetpos, array(1, 2, -3));

        $test = new When;
        $test->bysetpos(array(-1, 2, 3));

        $this->assertEquals($test->bysetpos, array(-1, 2, 3));

        // different delimeter
        $test = new When;
        $test->bysetpos('1; 2; 3', ";");

        $this->assertEquals($test->bysetpos, array(1, 2, 3));

        // different delimeter sloppy
        $test = new When;
        $test->bysetpos(';1; 2; 3;', ";");

        $this->assertEquals($test->bysetpos, array(1, 2, 3));
    }

    public function testInvalidBySetPos()
    {
        $this->expectException(InvalidArgumentException::class);

        $test = new When;
        $test->bysetpos(367);
    }

    public function testValidExclusions()
    {
        $validDateTimes = array(
            new DateTime('2019-01-01'),
            new DateTime('2019-01-02')
        );

        //Verify exclusion list can be generated with a string
        $test = new When;
        $test->exclusions('2019-01-01');
        $this->assertEquals($test->exclusions,array($validDateTimes[0]));

        //Verify exclusion list with multiple values can be generated by a comma separate string
        $test = new When;
        $test->exclusions('2019-01-01, 2019-01-02');
        $this->assertEquals($test->exclusions,array(
                $validDateTimes[0],
                $validDateTimes[1]
        ));

        //Verify exclusion list can be generated with multiple values separate by a custom delimiter
        $test = new When;
        $test->exclusions('2019-01-01|2019-01-02',"|");
        $this->assertEquals($test->exclusions,array(
                $validDateTimes[0],
                $validDateTimes[1]
        ));

        //Verify exclusion list can be generated after trimming a single trailing delimiters
        $test = new When;
        $test->exclusions('2019-01-01,2019-01-02,,');
        $this->assertEquals($test->exclusions,array(
                $validDateTimes[0],
                $validDateTimes[1]
        ));

        //Verify exclusion list can be generated after trimming a multiple trailing delimiters
        $test = new When;
        $test->exclusions('2019-01-01,2019-01-02,,,,');
        $this->assertEquals($test->exclusions,array(
                $validDateTimes[0],
                $validDateTimes[1]
        ));

        //Verify exclusion list can be generated by passing in an array of date_times
        $test = new When;
        $test->exclusions(array($validDateTimes[0],$validDateTimes[1]));
        $this->assertEquals($test->exclusions,array(
                $validDateTimes[0],
                $validDateTimes[1]
        ));

    }

    public function testInvalidExclusions()
    {
        $this->expectException(InvalidArgumentException::class);

        $test = new When;
        $test->exclusions('notDateStringOrArray');
    }

    public function testValidbyDay()
    {
        $test = new When;
        $test->byday(array("+5MO", "-20MO", "31TU", "SA"));

        $this->assertEquals($test->bydays, array("5mo", "-20mo", "31tu", "0sa"));

        $test = new When;
        $test->byday(array("+5mo", "-20MO", "31tU", "SA"));

        $this->assertEquals($test->bydays, array("5mo", "-20mo", "31tu", "0sa"));

        $test = new When;
        $test->byday("+5mo, -10MO, 31tU, SA");

        $this->assertEquals($test->bydays, array("5mo", "-10mo", "31tu", "0sa"));

        // trailing delimeter
        $test = new When;
        $test->byday(", +5mo, -10MO, 31tU, SA,");

        $this->assertEquals($test->bydays, array("5mo", "-10mo", "31tu", "0sa"));

        // different delimeter
        $test = new When;
        $test->byday("+5mo; -10MO; 31tU; SA;", ";");

        $this->assertEquals($test->bydays, array("5mo", "-10mo", "31tu", "0sa"));

        $test = new When;
        $test->byday("+5mo");

        $this->assertEquals($test->bydays, array("5mo"));
    }

    public function testInvalidbyDay()
    {
        $this->expectException(InvalidArgumentException::class);

        $test = new When;
        $test->byday(array("+5MO", "-20MO", "31TU", "-92SA"));
    }

    public function testValidByHour()
    {
        $test = new When;
        $test->byhour(12);

        $this->assertEquals($test->byhours, array(12));

        // sloppy input works
        $test = new When;
        $test->byhour('1, 2,3 ');

        $this->assertEquals($test->byhours, array(1, 2, 3));

        // sloppier input works
        $test = new When;
        $test->byhour('1, 2,3 ,');

        $this->assertEquals($test->byhours, array(1, 2, 3));

        $test = new When;
        $test->byhour(array(1, 2, 3));

        $this->assertEquals($test->byhours, array(1, 2, 3));

        // different delimeter
        $test = new When;
        $test->byhour('1; 2; 3', ";");

        $this->assertEquals($test->byhours, array(1, 2, 3));

        // different delimeter sloppy
        $test = new When;
        $test->byhour(';1; 2; 3;', ";");

        $this->assertEquals($test->byhours, array(1, 2, 3));
    }

    public function testInvalidByHourOne()
    {
        $this->expectException(InvalidArgumentException::class);

        $test = new When;
        $test->byhour(24);
    }

    public function testInvalidByHourTwo()
    {
        $this->expectException(InvalidArgumentException::class);

        $test = new When;
        $test->byhour('-1, -2');
    }

    public function testValidByMinute()
    {
        $test = new When;
        $test->byminute(12);

        $this->assertEquals($test->byminutes, array(12));

        // sloppy input works
        $test = new When;
        $test->byminute('1, 2,3 ');

        $this->assertEquals($test->byminutes, array(1, 2, 3));

        // sloppier input works
        $test = new When;
        $test->byminute('1, 2,3 ,');

        $this->assertEquals($test->byminutes, array(1, 2, 3));

        $test = new When;
        $test->byminute(array(1, 2, 3));

        $this->assertEquals($test->byminutes, array(1, 2, 3));

        // different delimeter
        $test = new When;
        $test->byminute('1; 2; 3', ";");

        $this->assertEquals($test->byminutes, array(1, 2, 3));

        // different delimeter sloppy
        $test = new When;
        $test->byminute(';1; 2; 3;', ";");

        $this->assertEquals($test->byminutes, array(1, 2, 3));
    }

    public function testInvalidByMinuteOne()
    {
        $this->expectException(InvalidArgumentException::class);

        $test = new When;
        $test->byminute(65);
    }

    public function testInvalidByMinuteTwo()
    {
        $this->expectException(InvalidArgumentException::class);

        $test = new When;
        $test->byminute('-1, -2');
    }

    public function testValidBySecond()
    {
        $test = new When;
        $test->bysecond(12);

        $this->assertEquals($test->byseconds, array(12));

        // sloppy input works
        $test = new When;
        $test->bysecond('1, 2,3 ');

        $this->assertEquals($test->byseconds, array(1, 2, 3));

        // sloppier input works
        $test = new When;
        $test->bysecond('1, 2,3 ,');

        $this->assertEquals($test->byseconds, array(1, 2, 3));

        $test = new When;
        $test->bysecond(array(1, 2, 3));

        $this->assertEquals($test->byseconds, array(1, 2, 3));

        // different delimeter
        $test = new When;
        $test->bysecond('1; 2; 3', ";");

        $this->assertEquals($test->byseconds, array(1, 2, 3));

        // different delimeter sloppy
        $test = new When;
        $test->bysecond(';1; 2; 3;', ";");

        $this->assertEquals($test->byseconds, array(1, 2, 3));
    }

    public function testInvalidBySecondOne()
    {
        $this->expectException(InvalidArgumentException::class);

        $test = new When;
        $test->bysecond(65);
    }

    public function testInvalidBySecondTwo()
    {
        $this->expectException(InvalidArgumentException::class);

        $test = new When;
        $test->bysecond('-1, -2');
    }

    public function testValidInterval()
    {
        $test = new When;
        $test->interval(20);

        $this->assertEquals($test->interval, 20);

        $test = new When;
        $test->interval('20');

        $this->assertEquals($test->interval, 20);
    }

    public function testInvalidInterval()
    {
        $this->expectException(InvalidArgumentException::class);

        $test = new When;
        $test->interval('week');
    }

    public function testValidCount()
    {
        $test = new When;
        $test->count(20);

        $this->assertEquals($test->count, 20);

        $test = new When;
        $test->count('20');

        $this->assertEquals($test->count, 20);
    }

    public function testInvalidCount()
    {
        $this->expectException(InvalidArgumentException::class);

        $test = new When;
        $test->count('weekly');
    }

    public function testGenerateOccurrencesErrorException()
    {
        $this->expectException(InvalidStartDate::class);

        $test = new When;

        $test->startDate(new DateTime("19970905T090000"))
            ->rrule("FREQ=MONTHLY;COUNT=3;BYDAY=TU,WE,TH;BYSETPOS=3")
            ->generateOccurrences();
    }

    public function testGenerateOccurrencesErrorIgnored()
    {
        $results[] = new DateTime('1997-10-07 09:00:00');
        $results[] = new DateTime('1997-11-06 09:00:00');

        $test = new When;

        $test->RFC5545_COMPLIANT = When::IGNORE;

        $test->startDate(new DateTime("19970905T090000"))
            ->rrule("FREQ=MONTHLY;COUNT=3;BYDAY=TU,WE,TH;BYSETPOS=3")
            ->generateOccurrences();

        $occurrences = $test->occurrences;

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }

    public function testIgnoreRrulePrefix()
    {
        $results[] = new DateTime('1997-09-02 09:00:00');
        $results[] = new DateTime('1997-09-12 09:00:00');
        $results[] = new DateTime('1997-09-22 09:00:00');
        $results[] = new DateTime('1997-10-02 09:00:00');
        $results[] = new DateTime('1997-10-12 09:00:00');

        $r = new When();
        $r->startDate(new DateTime("19970902T090000"))
            ->rrule("RRULE:FREQ=DAILY;INTERVAL=10;COUNT=5")
            ->generateOccurrences();

        $occurrences = $r->occurrences;

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }
}

class WhenFakeObject {}
