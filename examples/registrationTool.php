<?php

require_once '/root/instapi/src/InstagramRegistration.php';

// NOTE: THIS IS A CLI TOOL
/// DEBUG MODE ///
$debug = false;

$r = new InstagramRegistration($debug);

// echo "###########################\n";
// echo "#                         #\n";
// echo "# Instagram Register Tool #\n";
// echo "#                         #\n";
// echo "###########################\n";

// do {
    // echo "\n\nUsername: ";
    // $username = trim(fgets(STDIN));
    $username = $argv[1];
    $check = $r->checkUsername($username);
    if ($check['available'] == false) {
        echo "$username not available\n";
    }
    else {
    	echo "$username is available - ";
    }

    //  $pwd = $argv[2]."\n";
    //  $em = $argv[3]."\n";
   	// echo $pwd;
   	// echo $em;

// } while ($check['available'] == false);


if ($check['available'] == true) {

	// echo "\nPassword: ";
	// $password = trim(fgets(STDIN));
	
	// echo "\nEmail: ";
	// $email = trim(fgets(STDIN));
	
	$password = $argv[2];
	$email = $argv[3];
	$result = $r->createAccount($username, $password, $email);

	if (isset($result['account_created']) && ($result['account_created'] == true)) {
    	echo "OK\n";
	}
}



