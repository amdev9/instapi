<?php

require_once '/root/instapi/src/InstagramRegistration.php';

// NOTE: THIS IS A CLI TOOL
/// DEBUG MODE ///
$debug = false;

$proxy = $argv[1];
$username = $argv[2];
$email = $argv[3];
$password = $argv[4];

$r = new InstagramRegistration($proxy , $debug);

$check = $r->checkUsername($username);
if ($check['available'] == false) {
    echo "$username not available\n";
}
else {
    echo "$username is available - ";
}


if ($check['available'] == true) {	

	$result = $r->createAccount($username, $password, $email);

	if (isset($result['account_created']) && ($result['account_created'] == true)) {
    	echo "OK\n";
	}
}



