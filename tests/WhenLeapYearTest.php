<?php

use PHPUnit\Framework\TestCase;

class WhenLeapYearTest extends TestCase
{
    public function testRRuleEndOfMonthOnLeapYear()
    {
        $recur = new \When\When;
        $recur->startDate(new \DateTime('2016-02-29 00:00:00'))->rrule('FREQ=YEARLY;BYMONTH=2;BYMONTHDAY=-1');
        $recur->rangeLimit = 5;
        $recur->generateOccurrences();

        $dates = array(
            '2016-02-29 00:00:00',
            '2017-02-28 00:00:00',
            '2018-02-28 00:00:00',
            '2019-02-28 00:00:00',
            '2020-02-29 00:00:00'
        );
        foreach ($dates as $i => $d) {
            $dt = new \DateTime($d, new \DateTimeZone('UTC'));
            $this->assertEquals($dt, $recur->occurrences[$i]);
        }
    }

    public function testRRuleEndOfMonthByMonthOnLeapYear()
    {
        $recur = new \When\When();
        $recur->startDate(new \DateTime('2016-02-29 00:00:00'))->rrule('FREQ=MONTHLY;BYMONTHDAY=-1');
        $recur->rangeLimit = 5;
        $recur->generateOccurrences();

        $dates = array(
            '2016-02-29 00:00:00',
            '2016-03-31 00:00:00',
            '2016-04-30 00:00:00',
            '2016-05-31 00:00:00',
            '2016-06-30 00:00:00'
        );
        foreach ($dates as $i => $d) {
            $dt = new \DateTime($d, new \DateTimeZone('UTC'));
            $this->assertEquals($dt, $recur->occurrences[$i]);
        }
    }

    public function testRRuleEndOfMonthByMonthOnLeapYear2()
    {
        $recur = new \When\When;
        $recur->startDate(new \DateTime('2020-01-31 00:00:00'))->rrule('FREQ=MONTHLY;BYMONTHDAY=-1,3');
        $recur->rangeLimit = 5;
        $recur->generateOccurrences();

        $dates = array(
            '2020-01-31 00:00:00',
            '2020-02-03 00:00:00',
            '2020-02-29 00:00:00',
            '2020-03-03 00:00:00',
            '2020-03-31 00:00:00'
        );
        foreach ($dates as $i => $d) {
            $dt = new \DateTime($d, new \DateTimeZone('UTC'));
            $this->assertEquals($dt, $recur->occurrences[$i]);
        }
    }

    public function testRRuleEndOfMonthOnRegularYear()
    {
        $recur = new \When\When;
        $recur->startDate(new \DateTime('2016-01-31 00:00:00'))->rrule('FREQ=YEARLY;BYMONTH=1;BYMONTHDAY=-1');
        $recur->rangeLimit = 3;
        $recur->generateOccurrences();

        $dates = array(
            '2016-01-31 00:00:00',
            '2017-01-31 00:00:00',
            '2018-01-31 00:00:00'
        );
        foreach ($dates as $i => $d) {
            $dt = new \DateTime($d, new \DateTimeZone('UTC'));
            $this->assertEquals($dt, $recur->occurrences[$i]);
        }
    }

    public function testRRuleEndOfMonthByMonth()
    {
        $recur = new \When\When;
        $recur->startDate(new \DateTime('2016-01-31 00:00:00'))->rrule('FREQ=MONTHLY;BYMONTHDAY=-1');
        $recur->rangeLimit = 3;
        $recur->generateOccurrences();

        $dates = array(
            '2016-01-31 00:00:00',
            '2016-02-29 00:00:00',
            '2016-03-31 00:00:00'
        );
        foreach ($dates as $i => $d) {
            $dt = new \DateTime($d, new \DateTimeZone('UTC'));
            $this->assertEquals($dt, $recur->occurrences[$i]);
        }
    }
}
