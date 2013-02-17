<?php

namespace When;

class When extends \DateTime
{
    public $startDate;

    public function __construct($time = "now", $timezone = NULL)
    {
        //parent::__construct($time, $timezone);
    }

    // tested
    public function startDate($startDate)
    {
        if (Valid::dateTimeObject($startDate))
        {
            $this->startDate = clone $startDate;

            return $this;
        }
        else
        {
            throw new \InvalidArgumentException("startDate: Accepts valid DateTime objects");
        }
    }

    // tested
    public function freq($frequency)
    {
        if (Valid::freq($frequency))
        {
            $this->freq = strtolower($frequency);

            return $this;
        }

        throw new \InvalidArgumentException("freq: Accepts " . rtrim(implode(Valid::$frequencies, ", "), ","));
    }

    // tested
    public function until($endDate)
    {
        if (Valid::dateTimeObject($endDate))
        {
            $this->until = clone $endDate;

            return $this;
        }

        throw new \InvalidArgumentException("until: Accepts valid DateTime objects");
    }

    // tested
    public function count($count)
    {
        if (is_numeric($count))
        {
            $this->count = (int)$count;

            return $this;
        }

        throw new \InvalidArgumentException("count: Accepts numeric values");
    }

    // tested
    public function interval($interval)
    {
        if (is_numeric($interval))
        {
            $this->interval = (int)$interval;

            return $this;
        }

        throw new \InvalidArgumentException("interval: Accepts numeric values");
    }

    // tested
    public function bysecond($seconds, $delimiter = ",")
    {
        if ($this->byseconds = self::prepareItemsList($seconds, $delimiter, 'second'))
        {
            return $this;
        }

        throw new \InvalidArgumentException("bysecond: Accepts numeric values between 0 and 60");
    }

    // tested
    public function byminute($minutes, $delimiter = ",")
    {
        if ($this->byminutes = self::prepareItemsList($minutes, $delimiter, 'minute'))
        {
            return $this;
        }

        throw new \InvalidArgumentException("byminute: Accepts numeric values between 0 and 59");
    }

    // tested
    public function byhour($hours, $delimiter = ",")
    {
        if ($this->byhours = self::prepareItemsList($hours, $delimiter, 'hour'))
        {
            return $this;
        }

        throw new \InvalidArgumentException("byhour: Accepts numeric values between 0 and 23");
    }

    // tested
    public function byday($bywdaylist, $delimiter = ",")
    {
        if (is_string($bywdaylist) && strpos($bywdaylist, $delimiter) !== false)
        {
            // remove any accidental delimiters
            $bywdaylist = trim($bywdaylist, $delimiter);

            $bywdaylist = explode($delimiter, $bywdaylist);
        }
        else if(is_string($bywdaylist))
        {
            // remove any accidental delimiters
            $bywdaylist = trim($bywdaylist, $delimiter);

            $bywdaylist = array($bywdaylist);
        }

        if (is_array($bywdaylist) && Valid::daysList($bywdaylist))
        {
            $this->bydays = self::createDaysList($bywdaylist);

            return $this;
        }

        throw new \InvalidArgumentException("bydays: Accepts (optional) positive and negative values between 1 and 53 followed by a valid week day");
    }

    // tested
    public function bymonthday($bymodaylist, $delimiter = ",")
    {
        if($this->bymonthdays = self::prepareItemsList($bymodaylist, $delimiter, 'monthDayNum'))
        {
            return $this;
        }

        throw new \InvalidArgumentException("bymonthday: Accepts positive and negative values between 1 and 31");
    }

    // tested
    public function byyearday($byyrdaylist, $delimiter = ",")
    {
        if($this->byyeardays = self::prepareItemsList($byyrdaylist, $delimiter, 'yearDayNum'))
        {
            return $this;
        }

        throw new \InvalidArgumentException("byyearday: Accepts positive and negative values between 1 and 366");
    }

    // tested
    public function byweekno($bywknolist, $delimiter = ",")
    {
        if($this->byweeknos = self::prepareItemsList($bywknolist, $delimiter, 'weekNum'))
        {
            return $this;
        }

        throw new \InvalidArgumentException("byweekno: Accepts positive and negative values between 1 and 53");
    }

    // tested
    public function bymonth($bymolist, $delimiter = ",")
    {
        if($this->bymonths = self::prepareItemsList($bymolist, $delimiter, 'monthNum'))
        {
            return $this;
        }

        throw new \InvalidArgumentException("bymonth: Accepts values between 1 and 12");
    }

    // tested
    public function bysetpos($bysplist, $delimiter = ",")
    {
        if ($this->bysetpos = self::prepareItemsList($bysplist, $delimiter, 'setPosDay'))
        {
            return $this;
        }

        throw new \InvalidArgumentException("bysetpos: Accepts positive and negative values between 1 and 366");
    }

    // tested
    public function wkst($weekDay)
    {
        if (Valid::weekDay($weekDay))
        {
            $this->wkst = strtolower($weekDay);

            return $this;
        }
        else
        {
            throw new \InvalidArgumentException("wkst: Accepts " . rtrim(implode(Valid::$weekDays, ", "), ","));
        }
    }

    // returns true or false depending on if it occurs on the date or not
    //
    public function occursOn($date)
    {
        if (!Valid::dateTimeObject($date))
        {
            throw new \InvalidArgumentException("occursOn: Accepts valid DateTime objects");
        }

        // breakdown the date
        $year = $date->format('Y');
        $month = $date->format('n');
        $day = $date->format('j');
        $dayFromEndOfMonth = (int)$date->format('t') + 1 - (int)$day;

        $leapYear = (int)$date->format('L');

        $yearDay = $date->format('z') + 1;
        $yearDayNeg = -366 + (int)$yearDay;
        if ($leapYear)
        {
            $yearDayNeg = -367 + (int)$yearDay;
        }

        // this is the nth occurence of the date
        $occur = ceil($day / 7);
        $occurNeg = -1 * ceil($dayFromEndOfMonth / 7);

        $week = $date->format('W');

        $dayOfWeek = $date->format('l');
        $dayOfWeekAbr = strtolower(substr($dayOfWeek, 0, 2));

        $hour = (int)$date->format('G');
        $minute = (int)$date->format('i');
        $second = (int)$date->format('s');

        // if the there is an end date, make sure date is under
        if (isset($this->until))
        {
            if ($date > $this->until)
            {
                return false;
            }
        }

        if (isset($this->bymonths))
        {
            if (!in_array($month, $this->bymonths))
            {
                return false;
            }
        }

        if (isset($this->bydays))
        {
            if (!in_array(0 . $dayOfWeek, $this->bydays) &&
                !in_array($occur . $dayOfWeek, $this->bydays) &&
                !in_array($occurNeg . $dayOfWeek, $this->bydays))
            {
                return false;
            }
        }

        if (isset($this->byweeknos))
        {
            if (!in_array($week, $this->byweeknos))
            {
                return false;
            }
        }

        if (isset($this->bymonthdays))
        {
            if (!in_array($day, $this->bymonthdays) &&
                !in_array($dayFromEndOfMonth, $this->bymonthdays))
            {
                return false;
            }
        }

        if (isset($this->byyeardays))
        {
            if (!in_array($yearDay, $this->byyeardays) &&
                !in_array($yearDayNeg, $this->byyeardays))
            {
                return false;
            }
        }

        if (isset($this->byhours))
        {
            if (!in_array($hour, $this->byhours))
            {
                return false;
            }
        }

        if (isset($this->byminutes))
        {
            if (!in_array($minute, $this->byminutes))
            {
                return false;
            }
        }

        if (isset($this->byseconds))
        {
            if (!in_array($second, $this->byseconds))
            {
                return false;
            }
        }

        return true;
    }

    public function byFreqValid()
    {
        if (isset($this->byweeknos) && $this->freq !== "yearly")
        {
            throw new InvalidCombination();
        }

        if (isset($this->byyeardays) && !in_array($this->freq, array("daily", "weekly", "monthly")))
        {
            throw new InvalidCombination();
        }

        if (isset($this->bymonthdays) && $this->freq === "weekly")
        {
            throw new InvalidCombination();
        }

        return true;
    }

    protected static function createItemsList($list, $delimiter)
    {
        $items = explode($delimiter, $list);

        return array_map('intval', $items);
    }

    protected static function prepareItemsList($items, $delimiter = ",", $validator=null)
    {
        $_items = false;

        if (is_numeric($items))
        {
            $_items = array(intval($items));
        }

        if (is_string($items) && $_items === false)
        {
            // remove any accidental delimiters
            $items = trim($items, $delimiter);

            $_items = self::createItemsList($items, $delimiter);
        }

        if (is_array($items))
        {
            $_items = $items;
        }

        if (is_array($_items) && Valid::itemsList($_items, $validator))
        {
            return $_items;
        }
        else
        {
            return false;
        }
    }

    protected static function createDaysList($days)
    {
        $_days = array();

        foreach($days as $day)
        {
            $day = ltrim($day, "+");
            $day = trim($day);

            $ordwk = 0;
            $weekday = false;

            if (strlen($day) === 2)
            {
                $weekday = $day;
            }
            else
            {
                list($ordwk, $weekday) = sscanf($day, "%d%s");
            }

            $_days[] = $ordwk . strtolower($weekday);
        }

        return $_days;
    }
}

class InvalidCombination extends \Exception 
{
    public function __construct($message = "Invalid combination.", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
