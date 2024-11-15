<?php 
session_start();
requireValidSession();

$user = $_SESSION['user'];
$records = WorkingHours::loadFromUserAndDate($user->id, date('Y-m-d'));

try {
    $currentTime = strftime('%H:%M:%S', time());
    $records->innout($currentTime); 
    addSuccessMsg('Ponto inserido com sucesso!');
} catch (AppExceptions $e) {
    addErrorMsg($e->getMessage());
}

header('Location: day_records.php');