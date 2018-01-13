<?php

set_time_limit(0);
date_default_timezone_set('Europe/Moscow');

require __DIR__.'/vendor/autoload.php';

/////// CONFIG ///////
$username = 'yesemyes517715';
$password = 'qwerty123456';
$debug = false;
$truncatedDebug = false;
//////////////////////

/////// MEDIA ////////
$photoFilename = '';
$captionText = '';
//////////////////////

$ig = new \InstagramAPI\Instagram($debug, $truncatedDebug);

try {
    $ig->login($username, $password);
} catch (\Exception $e) {
    echo 'Something went wrong: '.$e->getMessage()."\n";
    exit(0);
}

try {
    $ig->timeline->uploadPhoto($photoFilename, ['caption' => $captionText]);
} catch (\Exception $e) {
    echo 'Something went wrong: '.$e->getMessage()."\n";
}
