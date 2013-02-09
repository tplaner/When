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
    // this can be an array, comma seperated list, or individual number
    /*public function bysecond($seconds, $delimiter = ",")
    {
        if (!is_array($seconds))
        {
            $seconds = self::prepareItemsList($seconds, $delimiter);
        }

        if (is_array($seconds) && Valid::itemsList($seconds, 'second'))
        {
            $this->byseconds = $seconds;

            return $this;
        }

        throw new \InvalidArgumentException("bysecond: Accepts numeric values between 0 and 60");
    }*/

    public function bysecond($seconds, $delimiter = ",")
    {
        if ($this->byseconds = self::prepareItemsList($seconds, $delimiter, 'second'))
        {
            return $this;
        }

        throw new \InvalidArgumentException("bysecond: Accepts numeric values between 0 and 60");
    }

    // tested
    /*public function byminute($minutes, $delimiter = ",")
    {
        if (!is_array($minutes))
        {
            $minutes = self::prepareItemsList($minutes, $delimiter);
        }

        if (is_array($minutes) && Valid::itemsList($minutes, 'minute'))
        {
            $this->byminutes = $minutes;

            return $this;
        }

        throw new \InvalidArgumentException("byminute: Accepts numeric values between 0 and 59");
    }*/

    public function byminute($minutes, $delimiter = ",")
    {
        if ($this->byminutes = self::prepareItemsList($minutes, $delimiter, 'minute'))
        {
            return $this;
        }

        throw new \InvalidArgumentException("byminute: Accepts numeric values between 0 and 59");
    }

    // tested
    /*public function byhour($hours, $delimiter = ",")
    {
        if (!is_array($hours))
        {
            $hours = self::prepareItemsList($hours, $delimiter);
        }

        if (is_array($hours) && Valid::itemsList($hours, 'hour'))
        {
            $this->byhours = $hours;

            return $this;
        }

        throw new \InvalidArgumentException("byhour: Accepts numeric values between 0 and 23");
    }*/

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
    /*public function bymonthday($bymodaylist, $delimiter = ",")
    {
        if (!is_array($bymodaylist))
        {
            $bymodaylist = self::prepareItemsList($bymodaylist, $delimiter);
        }

        if (is_array($bymodaylist) && Valid::itemsList($bymodaylist, 'monthDayNum'))
        {
            $this->bymonthdays = $bymodaylist;

            return $this;
        }

        throw new \InvalidArgumentException("bymonthday: Accepts positive and negative values between 1 and 31");
    }*/

    public function bymonthday($bymodaylist, $delimiter = ",")
    {
        if($this->bymonthdays = self::prepareItemsList($bymodaylist, $delimiter, 'monthDayNum'))
        {
            return $this;
        }

        throw new \InvalidArgumentException("bymonthday: Accepts positive and negative values between 1 and 31");
    }

    // tested
    /*public function byyearday($byyrdaylist, $delimiter = ",")
    {
        if (!is_array($byyrdaylist))
        {
            $byyrdaylist = self::prepareItemsList($byyrdaylist, $delimiter);
        }

        if (is_array($byyrdaylist) && Valid::itemsList($byyrdaylist, 'yearDayNum'))
        {
            $this->byyeardays = $byyrdaylist;

            return $this;
        }

        throw new \InvalidArgumentException("byyearday: Accepts positive and negative values between 1 and 366");
    }*/

    public function byyearday($byyrdaylist, $delimiter = ",")
    {
        if($this->byyeardays = self::prepareItemsList($byyrdaylist, $delimiter, 'yearDayNum'))
        {
            return $this;
        }

        throw new \InvalidArgumentException("byyearday: Accepts positive and negative values between 1 and 366");
    }

    // tested
    /*public function byweekno($bywknolist, $delimiter = ",")
    {
        if (!is_array($bywknolist))
        {
            $bywknolist = self::prepareItemsList($bywknolist, $delimiter);
        }

        if (is_array($bywknolist) && Valid::itemsList($bywknolist, 'weekNum'))
        {
            $this->byweeknos = $bywknolist;

            return $this;
        }

        throw new \InvalidArgumentException("byweekno: Accepts positive and negative values between 1 and 53");
    }*/

    public function byweekno($bywknolist, $delimiter = ",")
    {
        if($this->byweeknos = self::prepareItemsList($bywknolist, $delimiter, 'weekNum'))
        {
            return $this;
        }

        throw new \InvalidArgumentException("byweekno: Accepts positive and negative values between 1 and 53");
    }

    /*public function bymonth($bymolist)
    {
        if (!is_array($bymolist))
        {
            $bymolist = self::prepareItemsList($bymolist, $delimiter);
        }

        if (is_array($bymolist) && Valid::itemsList($bymolist, 'monthNum'))
        {
            $this->bymonth = $bymolist;

            return $this;
        }

        throw new \InvalidArgumentException("bymonth: Accepts values between 1 and 12");
    }*/

    public function bymonth($bymolist)
    {
        if($this->bymonth = self::prepareItemsList($bymolist, $delimiter, 'monthNum'))
        {
            return $this;
        }

        throw new \InvalidArgumentException("bymonth: Accepts values between 1 and 12");
    }

    /*public function bysetpos($bysplist)
    {
        if (!is_array($bysplist))
        {
            $bysplist = self::prepareItemsList($bysplist, $delimiter);
        }

        if (is_array($bysplist) && Valid::itemsList($bysplist, 'setPosDay'))
        {
            $this->bysetpos = $bysplist;

            return $this;
        }

        throw new \InvalidArgumentException("bysetpos: Accepts positive and negative values between 1 and 366");
    }*/

    public function bysetpos($bysplist)
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

            $ordwk = 1;
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
