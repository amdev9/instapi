<?php

 
require '/root/instapi/src/Instagram.php';
 

$proxy = $argv[1];
$username = $argv[2];
$password = $argv[3];
$photo = $argv[4]; 


echo $photo;


$filePhoto = '/root/instapi/src/'.$photo;
 


$debug = false;


$i = new Instagram($username, $password, $proxy, $debug);

try {
    $i->login();
} catch (InstagramException $e) {
    $e->getMessage();
    exit();
}
 
// set profile picture


try {
    $i->changeProfilePicture($filePhoto);
} catch (Exception $e) {
    echo $e->getMessage();
}

 
