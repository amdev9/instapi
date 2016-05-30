<?php

require '/root/instapi/src/Instagram.php';

/////// CONFIG ///////
// $username = '4ewir';
// $password = 'qweqwe';


$smile = "\u{1F609}";

$proxy = $argv[1];
$username = $argv[2];
$password = $argv[3];

$photo = $argv[4];      // path to the photo
$caption = $smile.''.$argv[5];      
 
$debug = true;






$filePhoto = '/root/instapi/src/'.$photo;

// echo $caption;


//////////////////////

$i = new Instagram($username, $password, $proxy, $debug);

try {
    $i->login();
} catch (InstagramException $e) {
    $e->getMessage();
    exit();
}

//////////////////////



try {
    $i->uploadPhoto($filePhoto, $caption);
} catch (Exception $e) {
    echo $e->getMessage();
}


