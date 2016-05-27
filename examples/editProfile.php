<?php

// require '/root/instapi/src/Instagram.php';
require '/root/instapi/src/Instagram.php';

/////// CONFIG ///////
// $username = '4ewir';
// $password = 'qweqwe';

$proxy = $argv[1];//45.55.178.19:5006
$username = $argv[2];//fitness.body3
$password = $argv[3];//qweqwe123123

$debug = false;
 
// $smile = "\u{1F60D}";


$url = "";
$phone = "";//work
$first_name = "Fitness Body";
$biography = "Best fitness motivation here";
$email = "magazin.efashionshop@gmail.com";
$gender = ""; // not allowed to change


//////////////////////

$i = new Instagram($username, $password, $proxy, $debug);
echo "0";
try {
  echo "1";
    $i->login();
} catch (InstagramException $e) {
    $e->getMessage();
    exit();
}
 
try { 
  echo "2";
    $i->editProfile($url, $phone, $first_name, $biography, $email, $gender);
    
} catch (Exception $e) {
    echo $e->getMessage();
}



 
 
