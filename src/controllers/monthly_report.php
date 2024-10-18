<?php 
session_start();
requireValidSession();

$currentDate = new DateTime();

$user = $_SESSION['user'];
$users = null;
if ($user->is_admin) {
    $users = User::get();
}

$selectedPeriod = $_POST['period'] ? $_POST['period'] : $currentDate->format('Y-m');
$periods = [];
for($yearDiff = 2; $yearDiff >= 0; $yearDiff--){
    $year = date('Y') - $yearDiff;
    for ($month=1; $month <= 12; $month++) { 
        $date = new DateTime("$year-$month-1");
        $periods[$date->format('Y-M')] = strftime('%B de %Y', $date->getTimestamp());
    }
}

$registries = WorkingHours::getMonthlyReport($user->id, $currentDate);

$report = [];
$workDay = 0;
$sumOfWorkedTime = 0;
$lastDay = getLastDayOfMonth($selectedPeriod)->format('d');

for ($day = 1; $day <= $lastDay; $day++) {
    $date = $selectedPeriod . '-' . sprintf('%02d', $day);
    $registry = $registries[$date];

    if (isPastWorkday($date)) $workDay++;

    if ($registry) {
        $sumOfWorkedTime += $registry->worked_time;
        $report[] = $registry;
    } else {
        $report[] = new WorkingHours([
            'work_date' => $date,
            'worked_time' => 0
        ]);
    }
}

$expectedTime = $workDay * DAILY_TIME;
$balance = getTimeStringFromSeconds(abs($sumOfWorkedTime - $expectedTime));
$sign = ($sumOfWorkedTime >= $expectedTime) ? '+' : '-';

loadTemplateView('monthly_report', [
    'report' => $report,
    'sumOfWorkedTime' => getTimeStringFromSeconds($sumOfWorkedTime),
    'balance' => "{$sign}{$balance}",
    'periods' => $periods,
    'users' => $users,
]);