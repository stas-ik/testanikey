<?php

require __DIR__ . '/vendor/autoload.php';

use app\models\Videos;

$schedule = new Schedule;
$schedule->call(function(){
	Videos::updateAllVideoInfo();
})->hourly();

date_default_timezone_set('UTC');
