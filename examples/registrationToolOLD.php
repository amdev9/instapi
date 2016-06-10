<?php

// require_once '/root/instapi/src/InstagramRegistration.php';

// require '/root/instapi/src/Instagram.php';

 
require_once '/Users/alex/home/dev/rails/instagram/InstAPI/src/InstagramRegistration.php';

require '/Users/alex/home/dev/rails/instagram/InstAPI/src/Instagram.php';
require '/Users/alex/home/dev/redis/predis/autoload.php';



///check if string contains arabic

function uniord($u) {
    // i just copied this function fron the php.net comments, but it should work fine!
    $k = mb_convert_encoding($u, 'UCS-2LE', 'UTF-8');
    $k1 = ord(substr($k, 0, 1));
    $k2 = ord(substr($k, 1, 1));
    return $k2 * 256 + $k1;
}
function is_arabic($str) {
	if(strlen($str) == 0) {
		return false;
	} else {

	    if(mb_detect_encoding($str) !== 'UTF-8') {
	        $str = mb_convert_encoding($str,mb_detect_encoding($str),'UTF-8');
	    }

	    /*
	    $str = str_split($str); <- this function is not mb safe, it splits by bytes, not characters. we cannot use it
	    $str = preg_split('//u',$str); <- this function woulrd probably work fine but there was a bug reported in some php version so it pslits by bytes and not chars as well
	    */
	    preg_match_all('/.|\n/u', $str, $matches);
	    $chars = $matches[0];
	    $arabic_count = 0;
	    $latin_count = 0;
	    $total_count = 0;
	    foreach($chars as $char) {
	        //$pos = ord($char); we cant use that, its not binary safe 
	        $pos = uniord($char);
	        // echo $char ." --> ".$pos.PHP_EOL;

	        if($pos >= 1536 && $pos <= 1791) {
	            $arabic_count++;
	        } else if($pos > 123 && $pos < 123) {
	            $latin_count++;
	        }
	        $total_count++;
	    }
	    if(($arabic_count/$total_count) > 0.0001) {
	        // 60% arabic chars, its probably arabic
	        return true;
	    }
	    return false;
	}
}

// NOTE: THIS IS A CLI TOOL
/// DEBUG MODE ///
$smile =  "\u{1F609}"; // for 7 version php

$debug = true;


$password = $argv[1]; 
$email= $argv[2]; 
$url = $argv[3];  
$biography = $argv[4];  
$caption = $argv[5];  
$gender = 2;
$phone  = "";
$photo = "/Users/alex/home/dev/rails/instagram/InstAPI/src/".$argv[6]; 
$profileSetter = $argv[7]; 
$dir    = '/Users/alex/home/dev/rails/instagram/InstAPI/src/'.$profileSetter; 

// $filePhoto = "/Users/alex/home/dev/rails/instagram/InstAPI/src/1/2.jpg";
// $filePhoto2 = "/Users/alex/home/dev/rails/instagram/InstAPI/src/1/16.jpg";
// $caption = "Cool!";
// $caption2 = "Cool!";


// READ LOGINS AND FIRST NAMES FROM FILE
$login_names = @fopen("/Users/alex/home/dev/rails/instagram/InstA/email_proxy/login_names", "r");
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
$proxy_list = @fopen("/Users/alex/home/dev/rails/instagram/instA/email_proxy/proxy_list", "r");
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
	    	file_put_contents("/Users/alex/home/dev/rails/instagram/InstA/email_proxy/login_names", "");
	    	file_put_contents("/Users/alex/home/dev/rails/instagram/InstA/email_proxy/login_names", implode("\n",$outar));
	    	
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
	    
		echo "\nconnection_established\n";

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

		sleep(6);
		//upload photo
		// try {
		//     $i->uploadPhoto($filePhoto, $caption);
		// } catch (restore_exception_handler(oid)n $e) {
		//     echo $e->getMessage();
		// }
		// sleep(8);

		$files1 = scandir($dir);
		foreach ( $files1 as $key => $value ) {
		    $ext = pathinfo($value, PATHINFO_EXTENSION);
		    if ($ext == "jpg") {
				try {
				    $i->uploadPhoto($dir.'/'.$value, $caption); // use the same caption
				} catch (Exception $e) {
				    echo $e->getMessage();
				}

				sleep(40);
		    }
		}

		echo "photo downloaded!\n";
		sleep(7);

		// try {
		// 	$usname = $i->searchUsername("blac.kkorol");

		// 	$resusname =  var_export($usname);
		// 	echo $resusname;
		  
		// } catch (Exception $e) {
		//     echo $e->getMessage();
		// }

		// sleep(4);
		
	 
		// try {
		//     $usfeed = $i->getUserFeed("13226335", $maxid = null, $minTimestamp = null);// use the same caption
		    
		//  //    $resusfeed = var_export($usfeed);
		// 	// echo $resusfeed;

		//     echo $usfeed['items'][0]['pk'];


		// 	// echo lastest post data
			
		// } catch (Exception $e) {
		//     echo $e->getMessage();
		// }
		// sleep(10);

		Predis\Autoloader::register();

        $redis = new Predis\Client(array(
         "scheme" => "tcp",
         "host" => "127.0.0.1",
         "port" => 6379));


		 $key = "adult";

	
		try {
		/// WHILE PAGE SIZE < 200


			$counter = 0;
		    $followers = $i->getUserFollowers("13226335", $maxid = null);
			while ($counter < 4) {

				


		for($iter = 0, $c = count($followers['users']); $iter < $c; $iter++) {
		        

				// echo $followers['users'][0]['is_private'];
	 if ($followers['users'][$iter]['has_anonymous_profile_picture'] == false && is_arabic($followers['users'][$iter]['full_name']) == false) {
			
					$redis->sadd($key, $followers['users'][$iter]['pk']);
					// echo $followers['users'][$i]['pk'];
				
				}

			}
				
				$tmpfollowers = $followers;
				$followers = $i->getUserFollowers("13226335", $tmpfollowers['next_max_id'] );
				 
				// $resfollowers2 = var_export($followers2);
				// echo $resfollowers2;
				$counter = $counter +1;
			}


		} catch (Exception $e) {
		    echo $e->getMessage();
		}

		// setting up private account
		// try {
		//     $i->setPrivateAccount();
		// } catch (Exception $e) {
		//     echo $e->getMessage();
		// }
		 
		

///////////////////////////// DIRECT SHARE MAX 15 people in group  4ewir: 1009845355 ; blac.kkorol: 3299015045
			// $tes = $redis->spop($key);   /// return user ID 

		// try {
		// //    $dirsh =  $i->direct_share("1244961383516529243", "1009845355", "hi) thats coool!!"); //send to one user
		// //$i->direct_share("1244961383516529243", array("1009845355", "3299015045"), "hi! thats woow!");  
 	// 		$i->direct_share("1244961383516529243", array("1009845355", "3299015045"), "hi! thats so cooool!");   
 	// 		echo "looks like SUCCESS!"

		// } catch (Exception $e) {
		//     echo $e->getMessage();
		// }



      $registered = $proxy." ".$username." ".$email." ".$password." ".$first_name."\n";
      file_put_contents("/Users/alex/home/dev/rails/instagram/InstA/logs/regDone.dat",$registered, FILE_APPEND | LOCK_EX);  
		$outarray = array_slice($prox, $p+1);
		$GLOBALS["proxy_list"] = $outarray;
		file_put_contents("/Users/alex/home/dev/rails/instagram/InstA/email_proxy/proxy_list", "");
		file_put_contents("/Users/alex/home/dev/rails/instagram/InstA/email_proxy/proxy_list", implode("\n",$outarray));
	    break;
	}
	$p  = $p + 1;
	sleep(6);
}     
   






	
	 


// if (isset($result[1]["account_created"]) && ($result[1]["account_created"] == true)) {
//     echo "Your account was successfully created! :)";
// }

