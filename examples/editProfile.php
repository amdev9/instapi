<?php

// require '/root/instapi/src/Instagram.php';
require '/root/instapi/src/Instagram.php';

/////// CONFIG ///////
// $username = '4ewir';
// $password = 'qweqwe';

$proxy = $argv[1]; 
$username = $argv[2];
$password = $argv[3]; 

$debug = false;
 
$smile = "\u{1F60D}";

$url = "";
$phone = "";
$first_name = $smile.'Fitness Body'.$smile;
$biography = "Fitness here";
$email = "magazin.efashionshop@gmail.com";
$gender = 3; // male = 1 female =2  not spec = 3


//////////////////////

$i = new Instagram($username, $password, $proxy, $debug);

try {
    $i->login();
} catch (InstagramException $e) {
    $e->getMessage();
    exit();
}
 
try { 
    $i->editProfile($url, $phone, $first_name, $biography, $email, $gender);
} catch (Exception $e) {
    echo $e->getMessage();
}



 
 
