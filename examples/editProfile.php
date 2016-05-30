<?php
 
require '/root/instapi/src/Instagram.php';
 
$proxy = $argv[1]; 
$username = $argv[2];
$password = $argv[3]; 

$debug = false;
 
$smileInLove = "\u{1F60D}";
$smileKiss = "\u{1F618}";


$url = $argv[4]; 
$phone = $argv[5];
$first_name = $argv[6].''.$smileInLove;
$biography = $argv[7].' '.$smileKiss;
$email = $argv[8];


// $url = "";
// $phone = "";
// $first_name = $smile.'Fitness Body'.$smile;
// $biography = "Fitness here";
// $email = "magazin.efashionshop@gmail.com";

$gender = 2; // male = 1 female =2  not spec = 3 for parseint -  intval
 

// //////////////////////

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



 
 
