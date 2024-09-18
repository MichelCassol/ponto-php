<?php 
session_start();
requireValidSession();

$date = (new DateTime())->getTimestamp();
// $today = date("j \d\\e F \d\\e Y", $date);
$today = strftime('%d de %B de %Y',$date);

loadTemplateView('day_records', ['today' => $today]);

