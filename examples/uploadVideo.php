<?php

require '../src/Instagram.php';

// require '/Users/alex/home/dev/rails/instagram/InstAPI/src';
/////// CONFIG ///////
$proxy = $argv[1];
$username = $argv[2];
$password = $argv[3];

 
$debug = true;

$video = "/Users/alex/home/dev/rails/instagram/InstAPI/src/video00.mp4";     // path to the video
$caption = 'Want to meet me in real live?';     // caption
//////////////////////


$i = new Instagram($username, $password, $proxy, $debug);

try {
    $i->login();
} catch (InstagramException $e) {
    $e->getMessage();
    exit();
}

try {
    $i->uploadVideo($video, $caption);
} catch (Exception $e) {
    echo $e->getMessage();
}
