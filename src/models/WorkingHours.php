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
}
