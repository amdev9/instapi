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
 
// $smile = "\u{1F60D}";


$url = "";
$phone = "";//work
$first_name = "Fitness Body";
$biography = "Fitness here";
$email = "magazin.efashionshop@gmail.com";
$gender = 3; // male = 1 female =2  not spec = 3


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



 
 
