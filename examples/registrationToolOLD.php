<?php

// require_once '/root/instapi/src/InstagramRegistration.php';



require_once '/Users/alex/home/dev/rails/instagram/InstAPI/src/InstagramRegistration.php';
require '/Users/alex/home/dev/rails/instagram/InstAPI/src/Instagram.php';


// NOTE: THIS IS A CLI TOOL
/// DEBUG MODE ///
$smile = "\u{1F609}";

$debug = true;
$proxy = "104.156.229.189:30003";
$user = "";
$photo = "/Users/alex/home/dev/rails/instagram/InstAPI/src/1/1.jpg"; 
$caption = "Cool! join Instagram!";
$filePhoto = "/Users/alex/home/dev/rails/instagram/InstAPI/src/1/2.jpg";
$caption2 = "Do you like?))";
$filePhoto2 = "/Users/alex/home/dev/rails/instagram/InstAPI/src/1/3.jpg";


$r = new InstagramRegistration($proxy, $debug);

echo "###########################\n";
echo "#                         #\n";
echo "# Instagram Register Tool #\n";
echo "#                         #\n";
echo "###########################\n";

do {
    echo "\n\nUsername: ";
    $username = trim(fgets(STDIN));
    $GLOBALS["user"] = $username;

    $check = $r->checkUsername($username);
    if ($check['available'] == false) {
        echo "Username $username not available, try with another one\n\n";
    }
} while ($check['available'] == false);

echo "Username $username is available\n\n";

echo "\nPassword: ";
$password = trim(fgets(STDIN));
 
echo "\nEmail: ";
$email = trim(fgets(STDIN));

$result = $r->createAccount($username, $password, $email);
 
$resToPrint =  var_export($result);
echo $resToPrint;
$findme = 'HTTP/1.1 200 OK';
$pos = strpos($result[0], $findme);

if ($pos !== false && isset($result[1]["account_created"]) && ($result[1]["account_created"] == true)) {
    echo "connection_established\n";

	 
	$debug = false;
	$i = new Instagram($GLOBALS["user"], $password, $proxy, $debug);
	//set profile picture
	try {
	    $i->changeProfilePicture($photo);
	} catch (Exception $e) {
	    echo $e->getMessage();
	}
	sleep(6);
	//edit profile
	try { 
		$url = "";
		$phone  = "";
		$first_name = "Vanessa Ruud";
		$biography = "";
		$gender = 2;
	    $i->editProfile($url, $phone, $first_name, $biography, $GLOBALS["email"], $gender);
	} catch (Exception $e) {
	    echo $e->getMessage();
	}
	sleep(6);
	//upload photo
	try {
	    $i->uploadPhoto($filePhoto, $caption);
	} catch (Exception $e) {
	    echo $e->getMessage();
	}
	sleep(8);
	//upload photo
	try {
	    $i->uploadPhoto($filePhoto2, $caption2);
	} catch (Exception $e) {
	    echo $e->getMessage();
	}
	echo "photo downloaded!\n";
	sleep(4);

	try {
		$usname = $i->searchUsername("suzannesvanevik");
		echo $usname;
	  
	} catch (Exception $e) {
	    echo $e->getMessage();
	}
	sleep(4);

	try {
	  $followers = $i->getUserFollowings("19097274", $maxid = null);
	  echo   $followers;
	} catch (Exception $e) {
	    echo $e->getMessage();
	}


	

}

// if (isset($result[1]["account_created"]) && ($result[1]["account_created"] == true)) {
//     echo "Your account was successfully created! :)";
// }

