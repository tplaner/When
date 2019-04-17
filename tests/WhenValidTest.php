<?php

use PHPUnit\Framework\TestCase;
use When\Valid;

class WhenValidTest extends TestCase
{

    public function testValidDateTimeObject()
    {
        $this->assertTrue(Valid::dateTimeObject(new DateTime()));
    }

    public function testInvalidDateTimeObject()
    {
        $this->assertFalse(Valid::dateTimeObject(new FakeObject()));
        $this->assertFalse(Valid::dateTimeObject(array()));
        $this->assertFalse(Valid::dateTimeObject("20121010"));
    }

    public function testValidValidFreq()
    {
        // case insensitive
        $this->assertTrue(Valid::freq("Secondly"));
        $this->assertTrue(Valid::freq("minuTely"));
        $this->assertTrue(Valid::freq("HOURLY"));
        $this->assertTrue(Valid::freq("daily"));
        $this->assertTrue(Valid::freq("weekly"));
        $this->assertTrue(Valid::freq("monthly"));
        $this->assertTrue(Valid::freq("yearly"));
    }

    public function testInvalidValidFreq()
    {
        $this->assertFalse(Valid::freq("month"));
    }

    public function testValidValidWeekDay()
    {
        // case insensitive
        $this->assertTrue(Valid::weekDay("SU"));
        $this->assertTrue(Valid::weekDay("MO"));
        $this->assertTrue(Valid::weekDay("tu"));
        $this->assertTrue(Valid::weekDay("We"));
        $this->assertTrue(Valid::weekDay("th"));
        $this->assertTrue(Valid::weekDay("FR"));
        $this->assertTrue(Valid::weekDay("sa"));
    }

    public function testInvalidValidWeekDay()
    {
        $this->assertFalse(Valid::weekDay("va"));
    }

    public function testValidValidSecond()
    {
        $this->assertTrue(Valid::second(0));
        $this->assertTrue(Valid::second(1));
        $this->assertTrue(Valid::second("5"));
        $this->assertTrue(Valid::second("59"));
        $this->assertTrue(Valid::second(60));
    }

    public function testInvalidValidSecond()
    {
        $this->assertFalse(Valid::second(-1));
        $this->assertFalse(Valid::second(90));
        $this->assertFalse(Valid::second("61"));
        $this->assertFalse(Valid::second(-60));
    }

    public function testValidValidMinute()
    {
        $this->assertTrue(Valid::minute(0));
        $this->assertTrue(Valid::minute(21));
        $this->assertTrue(Valid::minute("31"));
        $this->assertTrue(Valid::minute("55"));
        $this->assertTrue(Valid::minute(59));
    }

    public function testInvalidValidMinute()
    {
        $this->assertFalse(Valid::minute(-1));
        $this->assertFalse(Valid::minute(99));
        $this->assertFalse(Valid::minute("60"));
        $this->assertFalse(Valid::minute(-60));
    }

    public function testValidValidHour()
    {
        $this->assertTrue(Valid::hour(0));
        $this->assertTrue(Valid::hour(5));
        $this->assertTrue(Valid::hour("8"));
        $this->assertTrue(Valid::hour("19"));
        $this->assertTrue(Valid::hour(23));
    }

    public function testInvalidValidHour()
    {
        $this->assertFalse(Valid::hour(-1));
        $this->assertFalse(Valid::hour(24));
        $this->assertFalse(Valid::hour(1000));
        $this->assertFalse(Valid::hour("60"));
        $this->assertFalse(Valid::hour(-60));
    }

    public function testValidWeekNum()
    {
        $this->assertTrue(Valid::weekNum("1"));
        $this->assertTrue(Valid::weekNum(-1));
        $this->assertTrue(Valid::weekNum("52"));
        $this->assertTrue(Valid::weekNum(-53));
    }

    public function testInvalidWeekNum()
    {
        $this->assertFalse(Valid::weekNum(0));
        $this->assertFalse(Valid::weekNum(-54));
        $this->assertFalse(Valid::weekNum("54"));
        $this->assertFalse(Valid::weekNum(93));
    }

    public function testValidOrdWk()
    {
        $this->assertTrue(Valid::ordWk("1"));
        $this->assertTrue(Valid::ordWk(1));
        $this->assertTrue(Valid::ordWk("52"));
        $this->assertTrue(Valid::ordWk(53));
    }

    public function testInvalidOrdWk()
    {
        $this->assertFalse(Valid::ordWk(0));
        $this->assertFalse(Valid::ordWk(-1));
        $this->assertFalse(Valid::ordWk("54"));
        $this->assertFalse(Valid::ordWk(93));
    }

    public function testValidYearDayNum()
    {
        $this->assertTrue(Valid::yearDayNum("1"));
        $this->assertTrue(Valid::yearDayNum(-1));
        $this->assertTrue(Valid::yearDayNum("90"));
        $this->assertTrue(Valid::yearDayNum(-366));
    }

    public function testInvalidYearDayNum()
    {
        $this->assertFalse(Valid::yearDayNum(0));
        $this->assertFalse(Valid::yearDayNum(-367));
        $this->assertFalse(Valid::yearDayNum("380"));
        $this->assertFalse(Valid::yearDayNum(399));
    }

    public function testValidSetPosDay()
    {
        $this->assertTrue(Valid::setPosDay("1"));
        $this->assertTrue(Valid::setPosDay(-1));
        $this->assertTrue(Valid::setPosDay("150"));
        $this->assertTrue(Valid::setPosDay(-366));
    }

    public function testInvalidSetPosDay()
    {
        $this->assertFalse(Valid::setPosDay(0));
        $this->assertFalse(Valid::setPosDay(-367));
        $this->assertFalse(Valid::setPosDay("380"));
        $this->assertFalse(Valid::setPosDay(399));
    }

    public function testValidMonthNum()
    {
        $this->assertTrue(Valid::monthNum("1"));
        $this->assertTrue(Valid::monthNum(1));
        $this->assertTrue(Valid::monthNum("9"));
        $this->assertTrue(Valid::monthNum(12));
    }

    public function testInvalidMonthNum()
    {
        $this->assertFalse(Valid::monthNum("-1"));
        $this->assertFalse(Valid::monthNum(0));
        $this->assertFalse(Valid::monthNum("99"));
        $this->assertFalse(Valid::monthNum(-12));
    }

    public function testValidOrdYrDay()
    {
        $this->assertTrue(Valid::ordYrDay("1"));
        $this->assertTrue(Valid::ordYrDay(1));
        $this->assertTrue(Valid::ordYrDay("366"));
        $this->assertTrue(Valid::ordYrDay(365));
    }

    public function testInvalidOrdYrDay()
    {
        $this->assertFalse(Valid::ordYrDay("-1"));
        $this->assertFalse(Valid::ordYrDay(0));
        $this->assertFalse(Valid::ordYrDay("-366"));
        $this->assertFalse(Valid::ordYrDay(367));
    }

    public function testValidValidItemsList()
    {
        $this->assertTrue(Valid::itemsList(array(1, 3, 5), 'second'));
        $this->assertTrue(Valid::itemsList(array(1, 3, 5), 'minute'));
        $this->assertTrue(Valid::itemsList(array(1, 3, 5), 'hour'));
        $this->assertTrue(Valid::itemsList(array(-1, -3, -5, 5, 30), 'monthDayNum'));
        $this->assertTrue(Valid::itemsList(array(-300, -3, -5, 5, 366), 'yearDayNum'));
    }

    public function testInvalidValidItemsList()
    {
        $this->assertFalse(Valid::itemsList(array(1, 3, 99), 'second'));
        $this->assertFalse(Valid::itemsList(array(1, -3, 51), 'minute'));
        $this->assertFalse(Valid::itemsList(array(-1, 3, 24), 'hour'));
        $this->assertFalse(Valid::itemsList(array(-1, -3, -5, 5, 55), 'monthDayNum'));
        $this->assertFalse(Valid::itemsList(array(-300, -3, -5, 5, 367), 'yearDayNum'));
    }

    public function testValidValidDaysList()
    {
        $this->assertTrue(Valid::daysList(array("-52MO", "-2TU", "+1WE", "SA", "40TU")));
        $this->assertTrue(Valid::daysList(array("-52Mo", "-2tU", "+1WE", "SA", "40TU")));
    }

    public function testInvalidValidDaysList()
    {
        $this->assertFalse(Valid::daysList(array("-asdf")));
        $this->assertFalse(Valid::daysList(array("-54mo")));
        $this->assertFalse(Valid::daysList(array("-54TA")));
        $this->assertFalse(Valid::daysList(array("-52MO", "+1WA")));
    }

    public function testValidMonthDayNum()
    {
        $this->assertTrue(Valid::monthDayNum("1"));
        $this->assertTrue(Valid::monthDayNum(-1));
        $this->assertTrue(Valid::monthDayNum("-23"));
        $this->assertTrue(Valid::monthDayNum(31));
    }

    public function testInvalidMonthDayNum()
    {
        $this->assertFalse(Valid::monthDayNum(0));
        $this->assertFalse(Valid::monthDayNum(-32));
        $this->assertFalse(Valid::monthDayNum("99"));
        $this->assertFalse(Valid::monthDayNum(32));
    }

    public function testValidOrdMoDay()
    {
        $this->assertTrue(Valid::ordMoDay("1"));
        $this->assertTrue(Valid::ordMoDay(1));
        $this->assertTrue(Valid::ordMoDay("23"));
        $this->assertTrue(Valid::ordMoDay(31));
    }

    public function testInvalidOrdMoDay()
    {
        $this->assertFalse(Valid::ordMoDay(0));
        $this->assertFalse(Valid::ordMoDay(-1));
        $this->assertFalse(Valid::ordMoDay("99"));
        $this->assertFalse(Valid::ordMoDay(32));
    }

    /*public function testByFreqValid()
    {

    }*/

    public function testValidDateTimeList()
    {
        $this->assertTrue(Valid::dateTimeList([date_create()]));
        $this->assertTrue(Valid::dateTimeList([date_create(),date_create()]));
        $this->assertTrue(Valid::dateTimeList([date_create(), 'string']));
    }

    public function testInvalidDateTimeList() {
        $this->assertFalse(Valid::dateTimeList([]));
        $this->assertFalse(Valid::dateTimeList('string'));
        $this->assertFalse(Valid::dateTimeList('string, string2'));
        $this->assertFalse(Valid::dateTimeList(['string', 'string2']));
    }
}

class FakeObject {}
