<?php

require_once '/root/instapi/src/InstagramRegistration.php';

require '/root/instapi/src/Instagram.php';

 

// NOTE: THIS IS A CLI TOOL
/// DEBUG MODE ///
$smile = "\u{1F609}";

$debug = true;


$password = $argv[1]; 
$email= $argv[2]; 
$url = $argv[3];  
$biography = $argv[4];  
$gender = 2;
$phone  = "";
$photo = "/root/instapi/src/".$argv[5];  


// READ LOGINS AND FIRST NAMES FROM FILE
$login_names = @fopen("/root/insta/email_proxy/login_names", "r");
$lines=array();
if ($login_names) {
    while (($buffer = fgets($login_names, 4096)) !== false) {
    	$lines[]=trim($buffer); 
    }
    if (!feof($login_names)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($login_names);
}
// READ PROXIES FROM FILE
$proxy_list = @fopen("/root/insta/email_proxy/proxy_list", "r");
$prox=array();
if ($proxy_list) {
    while (($buffer = fgets($proxy_list, 4096)) !== false) {
    	$prox[]=trim($buffer); 
    }
    if (!feof($proxy_list)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($proxy_list);
}
 


$proxy = "";
$username = "";
$first_name = "";

$p = 0; 

while ($p < count($prox)) 
{
   
	$r = new InstagramRegistration($prox[$p], $debug);
	 
	
	$i = 0; 
	while ($i < count($lines)){
	    $pieces = explode(" ", $lines[$i]);
		$check = $r->checkUsername($pieces[0]);
	    if ($check['available'] == true) {
	    	$GLOBALS["username"] = $pieces[0];
	    	$GLOBALS["first_name"] = $pieces[1]." ".$pieces[2];
	    	$outar = array_slice($lines, $i+1);
	    	$GLOBALS["lines"] = $outar;
	    	file_put_contents("/root/insta/email_proxy/login_names", "");
	    	file_put_contents("/root/insta/email_proxy/login_names", implode("\n",$outar));
	    	
	        break;
	    }     
	    $i  = $i + 1;
	    sleep(6);
	} 
	 

	$result = $r->createAccount($username, $password, $email);

	$resToPrint =  var_export($result);
	echo $resToPrint;
	$findme = 'HTTP/1.1 200 OK';
	$pos = strpos($result[0], $findme);



	if ($pos !== false && isset($result[1]["account_created"]) && ($result[1]["account_created"] == true)) 
	{
	    
		echo "connection_established";

		$GLOBALS["proxy"] = $prox[$p];		 
		$debug = false;
		$i = new Instagram($username, $password, $proxy, $debug);
		//set profile picture
		try {
		    $i->changeProfilePicture($photo);
		} catch (Exception $e) {
		    echo $e->getMessage();
		}
		sleep(6);
		//edit profile
		try { 

		    $i->editProfile($GLOBALS["url"], $GLOBALS["phone"], $GLOBALS["first_name"], $GLOBALS["biography"], $GLOBALS["email"], $GLOBALS["gender"]);
		} catch (Exception $e) {
		    echo $e->getMessage();
		}

		// sleep(6);
		// //upload photo
		// try {
		//     $i->uploadPhoto($filePhoto, $caption);
		// } catch (Exception $e) {
		//     echo $e->getMessage();
		// }
		// sleep(8);
		// //upload photo
		// try {
		//     $i->uploadPhoto($filePhoto2, $caption2);
		// } catch (Exception $e) {
		//     echo $e->getMessage();
		// }
		// echo "photo downloaded!\n";
		sleep(4);

		// try {
		// 	$usname = $i->searchUsername("suzannesvanevik");

		// 	$resusname =  var_export($usname);
		// 	echo $resusname;
		  
		// } catch (Exception $e) {
		//     echo $e->getMessage();
		// }
		// sleep(4);
		//// list of 200 followers need more
		// try {
		//   $followers = $i->getUserFollowers("13226335", $maxid = null);
		//   $resfollowers=  var_export($followers);
		//   echo $resfollowers;
		// } catch (Exception $e) {
		//     echo $e->getMessage();
		// }

      $registered = $proxy." ".$username." ".$email." ".$password." ".$first_name."\n";
      file_put_contents("/root/insta/logs/regDone.dat",$registered, FILE_APPEND | LOCK_EX);  
		$outarray = array_slice($prox, $p+1);
		$GLOBALS["proxy_list"] = $outarray;
		file_put_contents("/root/insta/email_proxy/proxy_list", "");
		file_put_contents("/root/insta/email_proxy/proxy_list", implode("\n",$outarray));
	    break;
	}
	$p  = $p + 1;
	sleep(6);
}     
   






	
	 


// if (isset($result[1]["account_created"]) && ($result[1]["account_created"] == true)) {
//     echo "Your account was successfully created! :)";
// }

