<?php

require '/root/instapi/src/Instagram.php';

/////// CONFIG ///////
// $username = '4ewir';
// $password = 'qweqwe';

$username = $argv[1];
$password = $argv[2];
$photo = $argv[3];      // path to the photo
$caption =  $argv[4]; 

$debug = false;
$smile = "\u{1F60D}";


 
  					  
echo $caption;




$filePhoto = '/root/instapi/src/'.$photo;

// echo $caption;


//////////////////////

$i = new Instagram($username, $password, $debug);

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


