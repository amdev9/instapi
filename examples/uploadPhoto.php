<?php

require '/root/instapi/src/Instagram.php';

/////// CONFIG ///////
// $username = '4ewir';
// $password = 'qweqwe';

$username = $argv[1];
$password = $argv[2];
$photo = $argv[3];      // path to the photo


$debug = false;
$smile = "\u{1F60D}";
$caption = "";

if ($username == 'kupit_nike') {
$captionnike ='What do you think about it? '.$smile.$smile.' #Nike #NikeRun #NikeFree #NikeAir #NikeGirl #NikeOriginal #GirlBody #PerfectBody #LikeForLike #Like4Like'; // caption
$caption = $captionnike;

} 
elseif ($username ==  "fitness.body2") {

$captioneva ='Fitness body'.$smile; // caption
$caption = $captioneva;

}
 elseif ($username ==  'kupit_adidas') {

$captionadidas ='What do you think about it? '.$smile.$smile.' #Adidas #Adidasmurah #AdidasYeezy #AdidasOriginals #AdidasGirl #AdidasBoost #GirlBody #PerfectBody #LikeForLike #Like4Like'; // caption
$caption = $captionadidas;
} elseif ($username == 'mosmagazinefashion')
{
$captionfashion ='What do you think about it? '.$smile.$smile.' #Fashion #FashionGirl #FashionInsta #FashionMagazine #FashionBaby #FashionLove #GirlBody #PerfectBody #LikeForLike #Like4Like'; // caption
$caption = $captionfashion;
}
  					  
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


