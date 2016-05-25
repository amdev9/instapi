<?php

require '/root/instapi/src/Instagram.php';

/////// CONFIG ///////
// $username = '4ewir';
// $password = 'qweqwe';
$proxy = $argv[1];
$username = $argv[2];
$password = $argv[3];

$photo = $argv[4];      // path to the photo
$caption =  'What do you think about it?';

$tags = "#SensualBoyes #Girl #PerfectBody #LikeForLike #Like4Like";

$debug = true;
$smile = "\u{1F60D}";



  
$caption = $caption.'\u{1F60D}'.$tags;




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


