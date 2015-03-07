<?php

namespace When;

class When extends \DateTime
{
    public $startDate;
    public $freq;
    public $until;
    public $count;
    public $interval;

    public $byseconds;
    public $byminutes;
    public $byhours;
    public $bydays;
    public $bymonthdays;
    public $byyeardays;
    public $byweeknos;
    public $bymonths;
    public $bysetpos;
    public $wkst;

    public $occurrences = array();

    public function __construct($time = "now", $timezone = NULL)
    {
        $this->startDate = parent::__construct($time, $timezone);
    }

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

    public function freq($frequency)
    {
        if (Valid::freq($frequency))
        {
            $this->freq = strtolower($frequency);

            return $this;
        }

        throw new \InvalidArgumentException("freq: Accepts " . rtrim(implode(Valid::$frequencies, ", "), ","));
    }

    public function until($endDate)
    {
        if (Valid::dateTimeObject($endDate))
        {
            $this->until = clone $endDate;
            return $this;
        }

        throw new \InvalidArgumentException("until: Accepts valid DateTime objects");
    }

    public function count($count)
    {
        if (is_numeric($count))
        {
            $this->count = (int)$count;

            return $this;
        }

        throw new \InvalidArgumentException("count: Accepts numeric values");
    }

    public function interval($interval)
    {
        if (is_numeric($interval))
        {
            $this->interval = (int)$interval;

            return $this;
        }

        throw new \InvalidArgumentException("interval: Accepts numeric values");
    }

    public function bysecond($seconds, $delimiter = ",")
    {
        if ($this->byseconds = self::prepareItemsList($seconds, $delimiter, 'second'))
        {
            return $this;
        }

        throw new \InvalidArgumentException("bysecond: Accepts numeric values between 0 and 60");
    }

    public function byminute($minutes, $delimiter = ",")
    {
        if ($this->byminutes = self::prepareItemsList($minutes, $delimiter, 'minute'))
        {
            return $this;
        }

        throw new \InvalidArgumentException("byminute: Accepts numeric values between 0 and 59");
    }

    public function byhour($hours, $delimiter = ",")
    {
        if ($this->byhours = self::prepareItemsList($hours, $delimiter, 'hour'))
        {
            return $this;
        }

        throw new \InvalidArgumentException("byhour: Accepts numeric values between 0 and 23");
    }

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

    public function bymonthday($bymodaylist, $delimiter = ",")
    {
        if($this->bymonthdays = self::prepareItemsList($bymodaylist, $delimiter, 'monthDayNum'))
        {
            return $this;
        }

        throw new \InvalidArgumentException("bymonthday: Accepts positive and negative values between 1 and 31");
    }

    public function byyearday($byyrdaylist, $delimiter = ",")
    {
        if($this->byyeardays = self::prepareItemsList($byyrdaylist, $delimiter, 'yearDayNum'))
        {
            return $this;
        }

        throw new \InvalidArgumentException("byyearday: Accepts positive and negative values between 1 and 366");
    }

    public function byweekno($bywknolist, $delimiter = ",")
    {
        if($this->byweeknos = self::prepareItemsList($bywknolist, $delimiter, 'weekNum'))
        {
            return $this;
        }

        throw new \InvalidArgumentException("byweekno: Accepts positive and negative values between 1 and 53");
    }

    public function bymonth($bymolist, $delimiter = ",")
    {
        if($this->bymonths = self::prepareItemsList($bymolist, $delimiter, 'monthNum'))
        {
            return $this;
        }

        throw new \InvalidArgumentException("bymonth: Accepts values between 1 and 12");
    }

    public function bysetpos($bysplist, $delimiter = ",")
    {
        if ($this->bysetpos = self::prepareItemsList($bysplist, $delimiter, 'setPosDay'))
        {
            return $this;
        }

        throw new \InvalidArgumentException("bysetpos: Accepts positive and negative values between 1 and 366");
    }

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

    public function rrule($rrule)
    {
        // strip off a trailing semi-colon
        $rrule = trim($rrule, ";");

        $parts = explode(";", $rrule);

        foreach($parts as $part)
        {
            list($rule, $param) = explode("=", $part);

            $rule = strtoupper($rule);
            $param = strtoupper($param);

            switch($rule)
            {
                case "UNTIL":
                    $this->until(new \DateTime($param));
                    break;
                case "FREQ":
                case "COUNT":
                case "INTERVAL":
                case "WKST":
                    $this->{$rule}($param);
                    break;
                case "BYDAY":
                case "BYMONTHDAY":
                case "BYYEARDAY":
                case "BYWEEKNO":
                case "BYMONTH":
                case "BYSETPOS":
                case "BYHOUR":
                case "BYMINUTE":
                case "BYSECOND":
                    $params = explode(",", $param);
                    $this->{$rule}($params);
                    break;
            }
        }

        return $this;
    }

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
        $dayFromEndOfMonth = -((int)$date->format('t') + 1 - (int)$day);

        $leapYear = (int)$date->format('L');

        $yearDay = $date->format('z') + 1;
        $yearDayNeg = -366 + (int)$yearDay;
        if ($leapYear)
        {
            $yearDayNeg = -367 + (int)$yearDay;
        }

        // this is the nth occurrence of the date
        $occur = ceil($day / 7);
        $occurNeg = -1 * ceil(abs($dayFromEndOfMonth) / 7);

        // starting on a monday
        $week = $date->format('W');
        $weekDay = strtolower($date->format('D'));

        $dayOfWeek = $date->format('l');
        $dayOfWeekAbr = strtolower(substr($dayOfWeek, 0, 2));

        // the date has to be greater then the start date
        if ($date < $this->startDate)
        {
            return false;
        }

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
            if (!in_array(0 . $dayOfWeekAbr, $this->bydays) &&
                !in_array($occur . $dayOfWeekAbr, $this->bydays) &&
                !in_array($occurNeg . $dayOfWeekAbr, $this->bydays))
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

        return true;
    }

    public function occursAt($date)
    {
        $hour = (int)$date->format('G');
        $minute = (int)$date->format('i');
        $second = (int)$date->format('s');

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
    }

    public function generateOccurrences()
    {
        self::prepareDateElements();

        $count = 0;

        $dateLooper = clone $this->startDate;

        // add the start date to the list of occurrences
        if ($this->occursOn($dateLooper))
        {
            $this->addOccurrence($this->generateTimeOccurrences($dateLooper));
        }
        else
        {
            throw new InvalidStartDate();
        }

        while ($dateLooper < $this->until && count($this->occurrences) < $this->count)
        {
            if ($this->freq === "yearly")
            {
                if (isset($this->bymonths))
                {
                    foreach ($this->bymonths as $month)
                    {
                        if (isset($this->bydays))
                        {
                            $dateLooper->setDate($dateLooper->format("Y"), $month, 1);

                            // get the number of days
                            $totalDays = $dateLooper->format("t");
                            $today = 0;

                            while ($today < $totalDays)
                            {
                                if ($this->occursOn($dateLooper))
                                {
                                    $this->addOccurrence($this->generateTimeOccurrences($dateLooper));

                                }

                                $dateLooper->add(new \DateInterval('P1D'));
                                $today++;
                            }
                        }
                        else
                        {
                            $dateLooper->setDate($dateLooper->format("Y"), $month, $dateLooper->format("j"));

                            if ($this->occursOn($dateLooper))
                            {
                                $this->addOccurrence($this->generateTimeOccurrences($dateLooper));

                            }
                        }
                    }
                }
                else
                {
                    $dateLooper->setDate($dateLooper->format("Y"), 1, 1);

                    $leapYear = (int)$dateLooper->format("L");
                    if ($leapYear)
                    {
                        $days = 366;
                    }
                    else
                    {
                        $days = 365;
                    }

                    $day = 0;
                    while ($day < $days)
                    {
                        if ($this->occursOn($dateLooper))
                        {
                            $this->addOccurrence($this->generateTimeOccurrences($dateLooper));

                        }
                        $dateLooper->add(new \DateInterval('P1D'));
                        $day++;
                    }
                }

                $dateLooper = clone $this->startDate;
                $dateLooper->add(new \DateInterval('P' . ($this->interval * ++$count) . 'Y'));
            }
            else if ($this->freq === "monthly")
            {
                $days = (int)$dateLooper->format("t");

                $day = (int)$dateLooper->format("j");

                $occurrences = array();
                while ($day <= $days)
                {
                    if ($this->occursOn($dateLooper))
                    {
                        $occurrences = array_merge($occurrences, $this->generateTimeOccurrences($dateLooper));
                    }

                    $dateLooper->add(new \DateInterval('P1D'));
                    $day++;
                }

                // if bysetpos is set we need to limit the
                // number of occurrences to only those which
                // meet the setpos
                if (isset($this->bysetpos))
                {
                    if ($count > 0)
                    {
                        $occurrenceCount = count($occurrences);

                        foreach ($this->bysetpos as $setpos)
                        {
                            if ($setpos > 0)
                            {
                                $this->occurrences[] = $occurrences[$setpos - 1];
                            }
                            else
                            {
                                $this->occurrences[] = $occurrences[$occurrenceCount + $setpos];
                            }
                        }
                    }
                }
                else
                {
                    $this->addOccurrence($occurrences);
                }

                $dateLooper = clone $this->startDate;
                $dateLooper->setDate($dateLooper->format("Y"), $dateLooper->format("n"), 1);
                $dateLooper->add(new \DateInterval('P' . ($this->interval * ++$count) . 'M'));
            }
            else if ($this->freq === "weekly")
            {
                $dateLooper->setDate($dateLooper->format("Y"), $dateLooper->format("n"), $dateLooper->format("j"));

                switch ($this->wkst)
                {
                    case "su":
                        $wkst = "Sunday";
                        break;
                    case "mo":
                        $wkst = "Monday";
                        break;
                    case "tu":
                        $wkst = "Tuesday";
                        break;
                    case "we":
                        $wkst = "Wednesday";
                        break;
                    case "th":
                        $wkst = "Thursday";
                        break;
                    case "fr":
                        $wkst = "Friday";
                        break;
                    case "sa":
                        $wkst = "Saturday";
                        break;
                }

                $daysLeft = 7;

                // not very happy with this
                if ($count === 0)
                {
                    $startWeekDay = clone $this->startDate;
                    $startWeekDay->modify("next " . $wkst);

                    $daysLeft = $dateLooper->diff($startWeekDay)->format("%a") + 1;

                    $startWeekDay->modify("last " . $wkst);
                }

                while ($daysLeft > 0)
                {
                    if ($this->occursOn($dateLooper))
                    {
                        $this->addOccurrence($this->generateTimeOccurrences($dateLooper));
                    }

                    $dateLooper->add(new \DateInterval('P1D'));
                    $daysLeft--;
                }

                $dateLooper = clone $this->startDate;
                $dateLooper->setDate($startWeekDay->format("Y"), $startWeekDay->format("n"), $startWeekDay->format('j'));
                $dateLooper->add(new \DateInterval('P' . ($this->interval * (++$count * 7)) . 'D'));
            }
            else if ($this->freq === "daily")
            {
                if ($this->occursOn($dateLooper))
                {
                    $this->addOccurrence($this->generateTimeOccurrences($dateLooper));
                }

                $dateLooper = clone $this->startDate;
                $dateLooper->setDate($dateLooper->format("Y"), $dateLooper->format("n"), $dateLooper->format('j'));
                $dateLooper->add(new \DateInterval('P' . ($this->interval * ++$count) . 'D'));
            }
            else if ($this->freq === "hourly")
            {
                $occurrence = array();
                if ($this->occursOn($dateLooper))
                {
                    $occurrence[] = $dateLooper;
                    $this->addOccurrence($occurrence);
                }

                $dateLooper = clone $this->startDate;
                $dateLooper->add(new \DateInterval('PT' . ($this->interval * ++$count) . 'H'));
            }
            else if ($this->freq === "minutely")
            {
                $occurrence = array();
                if ($this->occursOn($dateLooper))
                {
                    $occurrence[] = $dateLooper;
                    $this->addOccurrence($occurrence);
                }

                $dateLooper = clone $this->startDate;
                $dateLooper->add(new \DateInterval('PT' . ($this->interval * ++$count) . 'M'));
            }
            else if ($this->freq === "secondly")
            {
                $occurrence = array();
                if ($this->occursOn($dateLooper))
                {
                    $occurrence[] = $dateLooper;
                    $this->addOccurrence($occurrence);
                }

                $dateLooper = clone $this->startDate;
                $dateLooper->add(new \DateInterval('PT' . ($this->interval * ++$count) . 'S'));

            }
        }
    }

    protected function addOccurrence($occurrences)
    {
        foreach ($occurrences as $occurrence)
        {
            // make sure that this occurrence isn't already in the list
            if (!in_array($occurrence, $this->occurrences))
            {
                $this->occurrences[] = $occurrence;
            }
        }
    }

    // not happy with this.
    protected function generateTimeOccurrences($dateLooper)
    {
        $occurrences = array();

        foreach ($this->byhours as $hour)
        {
            foreach ($this->byminutes as $minute)
            {
                foreach ($this->byseconds as $second)
                {
                    if (count($this->occurrences) < $this->count)
                    {
                        $occurrence = clone $dateLooper;
                        $occurrence->setTime($hour, $minute, $second);
                        $occurrences[] = $occurrence;
                    }
                    else
                    {
                        break 3;
                    }
                }
            }
        }

        return $occurrences;
    }

    protected function prepareDateElements()
    {
        // if the interval isn't set, set it.
        if (!isset($this->interval))
        {
            $this->interval = 1;
        }

        // must have a frequency
        if (!isset($this->freq) && Valid::byFreqValid($this->freq, $this->byweeknos, $this->byyeardays, $this->bymonthdays))
        {
            throw new FrequencyRequired();
        }

        if (!isset($this->count))
        {
            $this->count = 200;
        }

        // "Similarly, if the BYMINUTE, BYHOUR, BYDAY,
        // BYMONTHDAY, or BYMONTH rule part were missing, the appropriate
        // minute, hour, day, or month would have been retrieved from the
        // "DTSTART" property."

        // if there is no startDate, make it now
        if (!$this->startDate)
        {
            $this->startDate = new \DateTime();
        }

        // the calendar repeats itself every 400 years, so if a date
        // doesn't exist for 400 years, I don't think it will ever
        // occur
        if (!isset($this->until))
        {
            $this->until = new \DateTime();
            $this->until->add(new \DateInterval('P400Y'));
        }

        if (!isset($this->byminutes))
        {
            $this->byminutes = array((int)$this->startDate->format('i'));
        }

        if (!isset($this->byhours))
        {
            $this->byhours = array((int)$this->startDate->format('G'));
        }

        if (!isset($this->byseconds))
        {
            $this->byseconds = array((int)$this->startDate->format('s'));
        }

        if (!isset($this->wkst))
        {
            $this->wkst = "mo";
        }

        /*if (!isset($this->bydays))
        {
            $dayOfWeek = $this->startDate->format('l');
            $dayOfWeekAbr = strtolower(substr($dayOfWeek, 0, 2));
            $this->bydays = array($dayOfWeekAbr);
        }*/

        if ($this->freq === "monthly")
        {
            if (!isset($this->bymonthdays) && !isset($this->bydays))
            {
                $this->bymonthdays = array((int)$this->startDate->format('j'));
            }
        }

        if ($this->freq === "weekly")
        {
            if (!isset($this->bymonthdays) && !isset($this->bydays))
            {
                $dayOfWeek = $this->startDate->format('l');
                $dayOfWeekAbr = strtolower(substr($dayOfWeek, 0, 2));
                $this->bydays = array("0" . $dayOfWeekAbr);
            }
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

class FrequencyRequired extends \Exception
{
    public function __construct($message = "You are required to set a frequency.", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class InvalidStartDate extends \Exception
{
    public function __construct($message = "The start date must be the first occurrence.", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
