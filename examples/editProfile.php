<?php

// require '/root/instapi/src/Instagram.php';
require '/root/instapi/src/Instagram.php';

/////// CONFIG ///////
// $username = '4ewir';
// $password = 'qweqwe';

$username = $argv[1];
$password = $argv[2];

$debug = false;


// $smile = "\u{1F60D}";
// $caption ='What do you think about it? '.$smile.' #Nike #NikeRun #NikeFree #NikeAir #NikeGirl #NikeOriginal #GirlBody #PerfectBody #LikeForLike #Like4Like'; // caption
// $photo = $argv[3];      // path to the photo
  					  
// echo $caption;
// $filePhoto = '/root/instapi/src/'.$photo;

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

  /**
   * Edit profile.
   *
   * @param string $url
   *   Url - website. "" for nothing
   * @param string $phone
   *   Phone number. "" for nothing
   * @param string $first_name
   *   Name. "" for nothing
   * @param string $email
   *   Email. Required.
   * @param int $gender
   *   Gender. male = 1 , female = 0
   *
   * @return array
   *   edit profile data
   */
  

$url = "";
$phone = "";
$first_name = "Eva Gross";
$biography = "";
$email = "magaz.inefashionshop@gmail.com";
$gender = 0;


// set profile picture
$photo = "12.jpg";
$filePhoto = '/root/instapi/src/'.$photo;



// Create separate file and define $url, $phone, $first_name, $biography, $email, $gender
// our case: $first_name = $argv[1]; 
try {
    $i->editProfile($url, $phone, $first_name, $biography, $email, $gender);
} catch (Exception $e) {
    echo $e->getMessage();
}

try {
    $i->changeProfilePicture($filePhoto);
} catch (Exception $e) {
    echo $e->getMessage();
}


// try {
//     $i->uploadPhoto($filePhoto, $caption);
// } catch (Exception $e) {
//     echo $e->getMessage();
// }


