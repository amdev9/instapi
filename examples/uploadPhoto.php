<?php

require '/root/instapi/src/Instagram.php';

/////// CONFIG ///////
// $username = '4ewir';
// $password = 'qweqwe';

$username = $argv[1];
$password = $argv[2];

$debug = false;
$caption ='What do you think about it? #Nike #NikeRun #NikeFree #NikeAir #NikeGirl #NikeOriginal #GirlBody #PerfectBody #LikeForLike #Like4Like'; // caption
$photo = $argv[3];      // path to the photo
  					  

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

try {
    $i->uploadPhoto($filePhoto, $caption);
} catch (Exception $e) {
    echo $e->getMessage();
}


