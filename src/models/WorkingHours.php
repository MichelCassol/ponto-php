<?php 

class WorkingHours extends Model
{
    protected static $tableName = 'working_hours';
    protected static $coluns = [
        'id',
        'user_id',
        'work_date',
        'time1',
        'time2',
        'time3',
        'time4',
        'worked_time'
    ];

    public static function loadFromUserAndDate($userId, $workDate)
    {
        $regitry = self::getOne(['user_id' => $userId, 'work_date' => $workDate]);

        if (!$regitry) {
            $regitry = new WorkingHours([
                'user_id' => $userId, 
                'work_date' => $workDate,
                'worked_time' => 0
            ]);
        }

        return $regitry;
    }

    public function getActiveClock()
    {
        $nextTime = $this->getNextTime();
        if ($nextTime === 'time1' || $nextTime === 'time3') {
            return 'exitTime';
        } elseif ($nextTime === 'time2' || $nextTime === 'time4') {
            return 'workedInterval';
        } else {
            return  null;
        }
    }

    public function getNextTime()
    {
        if (!$this->time1) return 'time1';
        if (!$this->time2) return 'time2';
        if (!$this->time3) return 'time3';
        if (!$this->time4) return 'time4';
        return null;
    }

    public function innout($time)
    {
        $timeColumn = $this->getNextTime();
        if (!$timeColumn) {
            throw new AppExceptions("Você já fez os 4 batimentos do dia!");
        }
        $this->$timeColumn = $time;
        $this->worked_time = getSecondsFromDateInterval($this->getWorkedInterval());
        if ($this->id) {
            $this->update();
        } else {
            $this->insert();
        }
    }

    public function getWorkedInterval()
    {
        [$t1, $t2, $t3, $t4] = $this->getTimes();

        $part1 = new DateInterval('PT0S');
        $part2 = new DateInterval('PT0S');

        if ($t1) $part1 = $t1->diff(new DateTime());
        if ($t2) $part1 = $t1->diff($t2);
        if ($t3) $part2 = $t3->diff(new DateTime());
        if ($t4) $part2 = $t3->diff($t4);

        return sumIntervals($part1, $part2);
    }

    public function getLauchInterval()
    {
        [, $t2, $t3,] = $this->getTimes();
        $breakInterval = new DateInterval('PT0S');
        
        if ($t2) $breakInterval = $t2->diff(new DateTime());
        if ($t3) $breakInterval = $t2->diff($t3);

        return $breakInterval;
    }

    public function getExitTime()
    {
        [$t1,,,$t4] = $this->getTimes();
        $workday = DateInterval::createFromDateString('8 hours');

        if (!$t1) {
            return (new DateTimeImmutable())->add($workday);
        } elseif ($t4) {
            return $t4;
        } else {
            $total = sumIntervals($workday,$this->getLauchInterval());
            return $t1->add($total);
        }
    }

    function getBalance()
    {
        if(!$this->time1 && !isPastWorkday($this->work_date)) return '';
        if($this->worked_time == DAILY_TIME) return '';

        $balance = $this->worked_time - DAILY_TIME;
        $balanceString = getTimeStringFromSeconds(abs($balance));
        $sing = $this->worked_time >= DAILY_TIME ? '+' : '-';
        return "{$sing}{$balanceString}";
    }

    public static function getAbsentUsers()
    {
        $today = new DateTime();
        $result = Database::getResultFromQuery("
            SELECT name FROM users WHERE end_date IS NULL AND NOT EXISTS (
                SELECT 1 FROM working_hours WHERE work_date = '{$today->format('Y-m-d')}' AND time1 IS NOT NULL AND users.id = working_hours.user_id
            )
        ");

        $absentUsers = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $absentUsers[] = $row['name'];
            }
        }

        return $absentUsers;
    }

    public static function getWorkedTimeInMonth($yearAndMonth) 
    {
        $startDate = (new DateTime("$yearAndMonth-1"))->format('Y-m-d');
        $endDate = getLastDayOfMonth($yearAndMonth)->format('Y-m-d');
        $result = static::getResultSetFromSelect([
            'raw' => "work_date BETWEEN '$startDate' AND '$endDate'"
        ], "SUM(worked_time) AS sum");
        return $result->fetch_assoc()['sum'];
    }

    public static function getMonthlyReport($userId, $date)
    {
        $registries = [];
        $startDate = getFirstDayOfMonth($date)->format('Y-m-d');
        $endDate = getLastDayOfMonth($date)->format('Y-m-d');

        $result = static::getResultSetFromSelect([
            'user_id' => $userId,
            'raw' => "work_date BETWEEN '$startDate' AND '$endDate'"
        ]);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $registries[$row['work_date']] = new WorkingHours($row);
            }
        }

        return $registries;
    }

    private function getTimes()
    {
        $times = [];

        $this->time1 ? array_push($times, getDateFromString($this->time1)) : array_push($times, null );
        $this->time2 ? array_push($times, getDateFromString($this->time2)) : array_push($times, null );
        $this->time3 ? array_push($times, getDateFromString($this->time3)) : array_push($times, null );
        $this->time4 ? array_push($times, getDateFromString($this->time4)) : array_push($times, null );

        return $times;
    }
}
