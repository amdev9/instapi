<?php

// require_once '/root/instapi/src/InstagramRegistration.php';

// require '/root/instapi/src/Instagram.php';

// date_default_timezone_set('UTC');
 

// $romerINSTAPI = '/root/instapi/'; // FOR VPS
// $romerPREDIS = '/root/predis/';
// $romerINSTA = '/root/insta/';

	$romerINSTAPI = '/Users/alex/home/dev/rails/instagram/InstAPI/';
	$romerPREDIS = '/Users/alex/home/dev/redis/predis/';
	$romerINSTA = '/Users/alex/home/dev/rails/instagram/InstA/';

require_once $romerINSTAPI.'src/InstagramRegistration.php';

require $romerINSTAPI.'src/Instagram.php';
require $romerPREDIS.'autoload.php';


Predis\Autoloader::register();

$redis = new Predis\Client(array(
		"scheme" => "tcp",
		"host" => "127.0.0.1",
		"port" => 6379));


function functofollow($ilink, $usernamelink, $pkuser) {
	$tofollow = $GLOBALS["redis"]->smembers("followmebot");
    foreach ($tofollow as $fol) {	// randomizer to not follow like stupid bot all who registered?
    	if ($GLOBALS["redis"]->sismember("followedbybot", $usernamelink."".$fol ) != true && $fol != $pkuser) {
	   		try {
		   		 $ilink->follow($fol);
		   		 $GLOBALS["redis"]->sadd("followedbybot", $usernamelink."".$fol);
				} catch (Exception $e) {
		   		 echo $e->getMessage();
				}		
   		}
   		sleep(30);
   	}
}


function functocomment($ilink, $usernamelink) {

	try {
   		 $outputinfo = $ilink->getSelfUsernameInfo();
   		 
   		 $GLOBALS["followercount"] = $outputinfo['user']['follower_count'];
   		 $outputres = var_export($outputinfo);
	  	 echo $outputres;	 
		} catch (Exception $e) {
		  echo $e->getMessage();
		}		


//$GLOBALS["redis"]->sismember("comment_sent", $usernamelink) != true
	if ($GLOBALS["followercount"] > 0 ) {
		$influencers = ["253477742", "240333138", "7061024", "217566587"];
		// --byzova  , "267685466" --borodilya "22288455",
 		foreach ($influencers as $influencer) {

			$usfeedforcom = $ilink->getUserFeed($influencer, $maxid = null, $minTimestamp = null);
			$medcom = $usfeedforcom['items'][0]['pk'];

			if ($GLOBALS["redis"]->lrange("infpost_$influencer", -1,-1) != $medcom) {
				$GLOBALS["redis"]->rpush("infpost_$influencer",  $medcom); 
			}
			
			// if ($GLOBALS["redis"]->scard("infpost_$influencer") > 0) {
			// 	$GLOBALS["redis"]->spop("infpost_$influencer");
			// }
			// $GLOBALS["redis"]->sadd("infpost_$influencer",$medcom);
 			sleep(10);
		}


	// 	COMMENTS OF influencers
		 

 		try {
 		 

 			$influencer = $influencers[mt_rand(0, count($influencers) - 1)];


			$commentindexkeys = $GLOBALS["redis"]->hkeys("comments");		 // get  index of comment here
			$commentindex = $commentindexkeys[mt_rand(0, count($commentindexkeys) - 1)]; // make it RANDOM

			while ( $GLOBALS["redis"]->sismember("comment_sent", $usernamelink."_".$commentindex) == true) {
				//."_".$influencer
				$influencer = $influencers[mt_rand(0, count($influencers) - 1)];
				$commentindexkeys = $GLOBALS["redis"]->hkeys("comments");
				$commentindex = $commentindexkeys[mt_rand(0, count($commentindexkeys) - 1)]; 
			}
 			if ( $GLOBALS["redis"]->sismember("comment_sent", $usernamelink."_".$commentindex)!= true )
 			{
 				//."_".$influencer
 				$mediatocomment = $GLOBALS["redis"]->lrange("infpost_$influencer", -1, -1)[0];
				$commenttex = $GLOBALS["redis"]->hget("comments", $commentindex);	// change get from hash by commentindex
 	

			$smiles =  ["\u{1F44D}", "\u{1F44C}", "\u{1F478}" ];  
     		$smil = $smiles[mt_rand(0, count($smiles) - 1)];

      		   // $hiw = $commenttex[mt_rand(0, count($commenttex) - 1)];
      		$messageFinal = "$commenttex $smil";


		    $ilink->comment($mediatocomment, $messageFinal); 



		    if ($link['status']== "ok") { 
		    	$GLOBALS["redis"]->sadd("comment_sent", $usernamelink."_".$commentindex);//."_".$influencer
			}
			else 
			{
				$GLOBALS["redis"]->sadd("comment_fail", $usernamelink."_".$commentindex);//."_".$influencer
			}

		    // need pause? may be comment the same person?
		  
		    echo "comment sent!---->$influencer-->$messageFinal\n";
		     	sleep(14400);  
		    	
			}

			// add status
		} catch (Exception $e) {
		    echo $e->getMessage();
		}
	}
}

function funcrecur($ilink, $usernamelink, $pkuser) {

	functofollow($ilink, $usernamelink, $pkuser);	

	//  LATEST POSTS MONITORING OF influencers
	// wow russia influencers

   	$followercount = 0;
	functocomment($ilink, $usernamelink);
	
	sleep(10);
	funcrecur($ilink, $usernamelink, $pkuser);

	// sleep before next cycle iteration

}
///check if string contains arabic
function f_rand($min=0,$max=1,$mul=100000){
		    if ($min>$max) return false;
		    return mt_rand($min*$mul,$max*$mul)/$mul;
		}
function add_time($time) {
	// Make some random for next iteration 
	// echo ($time*0.9 + $time*0.2*f_rand(0,1))."\n";
	return $time*0.8 + $time*0.3*f_rand(0,1);
}
function timer($del) {
	$next_iteration_time = time() + add_time($del);
	return $next_iteration_time;
} 

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



function funcparse($followers, $i, $redis, $influencer) {

		$counter = 0;
		while ($counter < 20) {  // fix to 20

			for($iter = 0, $c = count($followers['users']); $iter < $c; $iter++) {
		        
		        
		        echo $followers['users'][$iter]['pk'];

				try {
					if ($followers['users'][$iter]['is_private'] == false) {
					    $usfeed = $i->getUserFeed($followers['users'][$iter]['pk'], $maxid = null, $minTimestamp = null);

					    if (isset($usfeed['items'][0]['pk'])) {
						    $med = $usfeed['items'][0]['pk'];
						    echo $med.":med\n";// use the same caption
						    if (isset($usfeed['items'][0]['lat']) && isset($usfeed['items'][0]['lng'])) {
								$lat = $usfeed['items'][0]['lat'];
								$long = $usfeed['items'][0]['lng'];

	 							$filterDate = strtotime('-3 month', time()); 

								$data = array('lat'=> $lat,
					              'lng'=> $long,
					              'username'=> 'blackkorol'
					              );

								$params = http_build_query($data);

								$service_url = 'http://api.geonames.org/countryCodeJSON?'.$params;

								// $service_url = 'http://scatter-otl.rhcloud.com/location?'.$params;

								 // create curl resource 
								$ch = curl_init(); 

								// set url 
								curl_setopt($ch, CURLOPT_URL, $service_url); 

								//return the transfer as a string 
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

								// $output contains the output string 
								$output = curl_exec($ch); 
								$js =  json_decode($output);
								// echo $js->countryCode;
					 			$country = $js->countryCode;

								// $key = "wowrussia";
								$key = "adultus";
								if ($followers['users'][$iter]['has_anonymous_profile_picture'] == false && is_arabic($followers['users'][$iter]['full_name']) == false && isset($country) && ($country == "US" || $country == "CA" || $country == "AU" || $country == "GB" || $country == "NZ" || $country == "ZA" ) && $usfeed['items'][0]['taken_at'] > $filterDate &&  $usfeed['num_results'] > 9) {
						
						
									$redis->sadd($key, $followers['users'][$iter]['pk'].":".$med);
						  
					
								}
							} else {
									echo "no geo:med\n";
								// $filterDate = strtotime('-3 month', time()); 

								// // $key = "wowrussia";
								// $key = "adultus";
								// if ($followers['users'][$iter]['has_anonymous_profile_picture'] == false && is_arabic($followers['users'][$iter]['full_name']) == false && $usfeed['items'][0]['taken_at'] > $filterDate ) {
						
						
								// 	  $redis->sadd($key, $followers['users'][$iter]['pk'].":".$med);
						  
						 	// 	}
						 	}
						} else {
							echo "no media yet:med\n";
						}
					} else {
						// $key = "wowrussia";
						$key = "adultus";
						echo "private:med\n";
						// need test how to count?
						// if ($followers['users'][$iter]['has_anonymous_profile_picture'] == false ) {
						// 	$redis->sadd($key, $followers['users'][$iter]['pk'].":private");
						// }
					}
				
				} catch (Exception $e) {
					echo $e->getMessage();
				}
			}
					
			$tmpfollowers = $followers;
			echo $tmpfollowers['next_max_id'];

			$redis->rpush("$influencer:max_id",  $tmpfollowers['next_max_id']); 
			try {
				$followers = $i->getUserFollowers($influencer, $tmpfollowers['next_max_id'] ); 
			} catch (Exception $e) {
			    echo $e->getMessage();
			}
			 				
			$counter = $counter + 1;
			sleep(6);
		}
}
// NOTE: THIS IS A CLI TOOL
/// DEBUG MODE ///
 
$debug = true;


$password = $argv[1]; 
$email= $argv[2]; 
$url  = $argv[3]; 
$biography = $argv[4];  
$caption = $argv[5];  

$gender = 2;
$phone  = "";
$photo = $romerINSTAPI."src/".$argv[6]; 
$profileSetter = $argv[7]; 
$dir    = $romerINSTAPI.'src/'.$profileSetter; 

// $filePhoto = "/Users/alex/home/dev/rails/instagram/InstAPI/src/1/2.jpg";
// $filePhoto2 = "/Users/alex/home/dev/rails/instagram/InstAPI/src/1/16.jpg";
// $caption = "Cool!";
// $caption2 = "Cool!";


// READ LOGINS AND FIRST NAMES FROM FILE
// $login_names = @fopen( $romerINSTA."email_proxy/login_names", "r");
// $lines=array();
// if ($login_names) {
//     while (($buffer = fgets($login_names, 4096)) !== false) {
//     	$lines[]=trim($buffer); 
//     }
//     if (!feof($login_names)) {
//         echo "Error: unexpected fgets() fail\n";
//     }
//     fclose($login_names);
// }
// READ PROXIES FROM FILE
// $proxy_list = @fopen($romerINSTA."email_proxy/proxy_list", "r");
// $prox=array();
// if ($proxy_list) {
//     while (($buffer = fgets($proxy_list, 4096)) !== false) {
//     	$prox[]=trim($buffer); 
//     }
//     if (!feof($proxy_list)) {
//         echo "Error: unexpected fgets() fail\n";
//     }
//     fclose($proxy_list);
// }
 


$proxy = "";
$username = "";
$first_name = "";
$qs_stamp = "";

// $p = 0; 

// while ($p < count($prox)) 

while ( $redis->scard("proxy") > 0 ) 
{
  	
	// SDIFF "used_proxy" "black_proxy" used_proxy - black_proxy
	// SDIFFSTORE "proxy" "used_proxy" "black_proxy"
	$prox =  $redis->spop("proxy");	
 	echo "\n******************------------>".$prox."<------------*********************\n";
    // $prox[$p]."<-------------------------*********************\n";
	
	$redis->sadd("used_proxy", $prox);

	$r = new InstagramRegistration($prox, $debug);
	 
//+1) check email qe_id = guid = uuid ; //android waterfall_id = UUID.randomUUID().toString(); //with '-'
	//+2)fetch headers with crstoken
	//3) username suggestions with same cookie
	//+4) check username with same cookie
	//+5) create acc and set new cookie  
	//6) sync
	//7) friendships autocompete user 

	// POST https://android.clients.google.com/c2dm/register3 HTTP/1.1

	//8) api/v1/push/register/   with phone_id newly before acc create  
	//9) v1/direct_share/recent_recipients/
	//10) again push


	 $check = $r->checkEmail($email);
 
       if ($check[1]['available'] == false) {
	    	$redis->sadd("blacklist_email",  $email);
	        break;
	    }     

	$outputs = $r->fetchHeaders();
	 

	 if ($outputs[1]['status'] == 'ok') {
		$iterations =   $outputs[1]['iterations'];
		$size = $outputs[1]['size']; 
		$edges= $outputs[1]['edges'];
		$shift = $outputs[1]['shift']; 
		$header = $outputs[1]['header'];

		exec("/Users/alex/Desktop/asm/Newfolder/qsta/quicksand $iterations $size $edges $shift $header", $qsstamper);
		echo $qsstamper[0];	
		$GLOBALS["qs_stamp"] = $qsstamper[0];
		 
	}	
      
      
	$r->usernameSuggestions($email);			// for full emulation
	sleep(2);
    while ( $redis->scard("names") > 0 ) {  
    	$pieces = explode(" ",  $redis->spop("names"));
        $check = $r->checkUsername($pieces[0] );
	  
	    if ($check['available'] == true) {
	    	$GLOBALS["username"] = $pieces[0];
	    	$GLOBALS["first_name"] = $pieces[1]." ".$pieces[2];

	        break;
	    }     
	    sleep(3);
	} 
	 
	
	// echo "OUTPUTS--->";
	
	$result = $r->createAccount($username, $password, $email, $qs_stamp );

	$resToPrint =  var_export($result);
	echo $resToPrint;
	$findme = 'HTTP/1.1 200 OK';
	$pos = strpos($result[0], $findme);
 
	  if (isset($result[1]['errors']) &&  isset($result[1]['errors']['email'][0]) && strpos($result[1]['errors']['email'][0], 'Another account is using') !== false) {
    	echo 'Another account is using email: $email';
    	$redis->sadd("blacklist_email",  $email);
    	break;
	}

	if ($pos !== false && isset($result[1]["account_created"]) && ($result[1]["account_created"] == true)) {
	    

	    echo "PKKEY: ".$result[1]['created_user']['pk']."\n\n";

///////////////////////////////////
	    $pk = $result[1]['created_user']['pk'];
	    $redis->sadd("followmebot", $pk);

	  
	   

	 //   		try {
	 //   		 $outputinfo = $i->getSelfUsernameInfo();
	 //   		 //check if has some followers
	 //   		 //???
	 //   		 $outputres = var_export($outputinfo);
		//   	 echo $outputres;	 
		// 	} catch (Exception $e) {
		// 	  echo $e->getMessage();
		// 	}		


	  	 
	  	
		// } 
///////////////////////////////////
		echo "\nconnection_established\n";


		echo "\n\n PROX ---------->".$prox. "\n\n";
		$GLOBALS["proxy"] = $prox;		 
		// echo "\n _proxy_------>".$proxy."\n";
		$debug = true; // false FOR VPS  

		$regUuid = $r->returnUUID();
		$regDeviceId = $r->returnDeviceId();
		$regPhoneId = $r->returnPhoneId();

		//need test WOULD IT BE BETTER TO COMBINE TWO CLASSES - NO NEED REQUEST BELOW
		$i = new Instagram($username, $password, $proxy, $regUuid, $regDeviceId, $regPhoneId, $debug );
		//set profile picture
		sleep(3);

		try {
		    $i->changeProfilePicture($photo);
		} catch (Exception $e) {
		    echo $e->getMessage();
		}
		sleep(3);

		$registered = $proxy." ".$username." ".$email." ".$password." ".$first_name;
      	file_put_contents($romerINSTA."logs/regDone.dat",$registered."\n", FILE_APPEND | LOCK_EX);  

     	$redis->sadd("registered", $registered);
     	$redis->sadd("blacklist_email",  $email);
     	$redis->sadd("black_proxy",  $proxy);


		//edit profile
		try { 

		    $i->editProfile($GLOBALS["url"], $GLOBALS["phone"], $GLOBALS["first_name"], $GLOBALS["biography"], $GLOBALS["email"], $GLOBALS["gender"]);
		} catch (Exception $e) {
		    echo $e->getMessage();
		}

		sleep(6);


	 

		// PARSE PK BY LOCATION
		// $lat = '56.759945';
		// $long =  '37.1314441';
		// $nnnames = $i->locationParser($lat, $long);//return venues[0..n][name] -> searchLocation(/\) -> getLocationFeed( $locationdata['items'][0]['location']['pk']);
		//  echo "\n\n".$nnnames['venues'][0]['name'];
		//  echo "\n\n".$nnnames['venues'][1]['name'];


		$approxer = 3;//10
		 
		$a =  [55.880088, 37.368901];
		$b =  [55.608911, 37.917495];

		$lengthY = abs($a[0]-$b[0]);
		$lengthX = abs($a[1]-$b[1]);

		if ($lengthX > $lengthY) {
			$sq_a = $lengthY/$approxer;
		}
		else {
			$sq_a = $lengthX/$approxer;
		}

		 
		for ($m =0; $m < 1000; $m++)
		 	for ($n =0; $n < 1000; $n++)
		 		if ($a[0]-$m*$sq_a > $b[0]) { 
		 			if ($a[1]+$n*$sq_a < $b[1]) {
						
						echo "---->(".sprintf( "%0.06f", ($a[0] + $m*$sq_a)).",".sprintf( "%0.06f", ($a[1] + $n*$sq_a)).")\n";
						

				$nnnames = $i->searchLocation(sprintf( "%0.06f", ($a[0] + $m*$sq_a)), sprintf( "%0.06f", ($a[1] + $n*$sq_a)));

					$itemsCount = 0;
					while (isset($nnnames['items'][$itemsCount] == true) ) {
					if (explode('.',$nnnames['items'][$itemsCount]['location']['lat'])[0]  == explode('.',sprintf( "%0.06f", ($a[0] + $m*$sq_a))) && explode('.',$nnnames['items'][$itemsCount]['location']['lng'])[0]  == explode('.',sprintf( "%0.06f", ($a[1] + $n*$sq_a)))[0]) {

						     	$redis->sadd($a[0].":".$b[0], $nnnames['items'][$itemsCount]['location']['pk']);

							}
						 	$itemsCount = $itemsCount + 1;
						 }

						# puts n.to_s + "=" + m.to_s
		 			}
		 		 }
		 	

	
		// $nnnames = $i->searchLocation('55.706440','37.577896');
 		// $loc = var_export($nnnames);
		// echo $loc."\n\n";

		// try { 
		//     // $locationdata = $i->searchLocationByQuery('New York'); // New%20York  New+York - test
		 
		//      $getl = $i->getLocationFeed( $nnnames['items'][0]['location']['pk']);
		//      echo $getl['ranked_items'][0]['user']['pk']."<----user\n";//['ranked_items']
		//      $lc = var_export($getl);
		//      echo $lc;

		//      $countertrue = 0;
		//      while ($getl['more_available'] ==true && $countertrue < 4) {
		//      	$next_next_max_id = $getl['next_max_id'];
		//      	echo $next_next_max_id."<---next_max_id\n";
		//      	 $getnewl = $i->getLocationFeed( $nnnames['items'][0]['location']['pk'], $next_next_max_id);
 	// 			echo $getnewl['items'][0]['user']['pk']."<----user\n";
 	// 			$countertrue = $countertrue + 1;
		//      }
		// } catch (Exception $e) {
		//     echo $e->getMessage();
		// }
		//  sleep(6);

/////////////////////////////////////////////
	 
		// $files1 = scandir($dir);
		// foreach ( $files1 as $k => $value ) {
		//     $ext = pathinfo($value, PATHINFO_EXTENSION);
		//     if ($ext == "jpg") {
		// 		try {
		// 		    $i->uploadPhoto($dir.'/'.$value, $caption); // use the same caption
		// 		} catch (Exception $e) {
		// 		    echo $e->getMessage();
		// 		}

		// 		sleep(10);
		//     }
		// }

		// echo "photo downloaded!\n";
		
 //////////// //////////// //////////// //////////// //////////// //////////// ////////////

	  	// funcrecur($i, $username, $pk); ///-------------<--------

 ////////////  //////////// //////////// //////////// //////////// ////////////

		//sleep before next action
		// sleep(10);

	    
		 // setting up private account
		// try {
		//     $i->setPrivateAccount();
		// } catch (Exception $e) {
		//     echo $e->getMessage();
		// }
		//  sleep(6);
		

		 
		// try {
		// 	$usname = $i->searchUsername("girlshothere"); // buzova86 -> 267685466
		// 	$iduser = $usname['pk'];
		// 	$resusname =  var_export($usname);
		// 	echo "girlshothere--->".$resusname."\n\n";
		  
		// } catch (Exception $e) {
		//     echo $e->getMessage();
		// }

		// sleep(4);

		  


		// try {
		//     $usfeed = $i->getUserFeed("3153242478", $maxid = null, $minTimestamp = null);// use the same caption
		    
		//    $resusfeed = var_export($usfeed);
		// 	 echo $resusfeed;
		  

		// //     echo $usfeed['items'][0]['pk']; //-- put it to redis

		// // // time created 
		// // 	// echo $usfeed['items'][0]['taken_at'];
	 // // 		// echo date('m/d/Y', $usfeed['items'][0]['taken_at']);

	 // // 		// $filterDate = strtotime('-3 month', time()); 
		// // 	// echo date('m/d/Y H:i:s', $newDate)."\n";
			
		
		// // // location
		// // 	// echo $usfeed['items'][0]['lat'];
		 
		// // 	// echo lastest post data
			
		// } catch (Exception $e) {
		//     echo $e->getMessage();
		// }
		// sleep(10);


		// 	try {
 	// 	$i->follow($userId);
		// } catch (Exception $e) {
		//     echo $e->getMessage();
		// }
		// sleep(6);



	// 	try {
 			 
 // 			// $mediaId = $redis->spop($key = "media"); 		// media id from redis
	// 	   	$i->like("1270615353921552313");
		    

	// 	} catch (Exception $e) {
	// 	    echo $e->getMessage();
	// 	}
	// 	sleep(6);	

/////////////////////////////////////////////////////

// 		////////////////////////
// 		//WHILE PAGE SIZE < 200

// 		//USA 
// 		 $influencers = ["2282477435", "2204060085", "2275299806","1447362645","331474338", "1284472953"];
// // 		// wow russia influencers
// // 		// $influencers = ["253477742", "240333138", "7061024","22288455","217566587", "267685466"];
// 		$influencer = $influencers[mt_rand(0, count($influencers) - 1)];

// 		$red = $redis->lrange("$influencer:max_id", -1, -1); 

// 		if(empty ($red)) {
// 			try {
// 				 $followers = $i->getUserFollowers($influencer, $maxid = null);
// 			} catch (Exception $e) {
// 			    echo $e->getMessage();
// 			}

// 		} else {
// 			try {
// 				 $followers = $i->getUserFollowers($influencer, $red[0]);
// 			} catch (Exception $e) {
// 			    echo $e->getMessage();
// 			}
// 		}
// 	    funcparse($followers, $i, $redis, $influencer);

		
// // ///////////////////////////// DIRECT SHARE MAX 15 people in group  4ewir: 1009845355 ; blac.kkorol: 3299015045
		
// 		$time_in_day = 24*60*60;
// 		$posts_per_day = 200; 		// 300 - 60?   400 ->60  500->50    700->34
// 		$delay = $time_in_day / $posts_per_day;
// 		$next_iteration_time = time() + $delay; 

		

// 		// $outarray = array_slice($prox, $p+1);
// 		// $GLOBALS["proxy_list"] = $outarray;
// 		// file_put_contents($romerINSTA."email_proxy/proxy_list", "");
// 		// file_put_contents($romerINSTA."email_proxy/proxy_list", implode("\n",$outarray));
//      	$key = "adultus";
// 		while (true) {
// 				 if ($redis->scard($key) == 0)
// 				{
// 				 funcparse($followers, $i, $redis, $influencer);
// 				}	
  			
// 				if (time() >  $next_iteration_time) {

			 
			 
// 	$ad_media_list  = ["1277470816705363477", "1277466307392355679", "1277436633060654628", "1277425043150126380", "1277422432296549618", "1276704501912747284", "1276702167556078800", "1276701053179837627", "1276700215979981984", "1276699612360916114"];
				
// 		    	$ad_media_id = $ad_media_list[mt_rand(0, count($ad_media_list) - 1)];
				
// 				$followlike  = $redis->spop($key);   
// 			    $resarr = explode(":",$followlike);
// 				$message_recipient = $resarr[0];


// 				try {	
// 					$i->follow($resarr[0]);
// 				} catch (Exception $e) {
// 				    echo $e->getMessage();
// 				}
// 				sleep(6);
// 				try {	
// 					$i->like($resarr[1]);
// 				} catch (Exception $e) {
// 				    echo $e->getMessage();
// 				}
// 				sleep(6);

//   						   //check if message_recipient is NULL!!!!!!!!!!!!
  	 
//   		// return user ID 

// 				$smiles_list =  ["\u{1F60C}" ,"\u{1F60D}" , "\u{1F61A}"  ,"\u{1F618}", "\u{2764}", "\u{1F64C}"];
// 				$smiles_hi =  ["\u{26A1}", "\u{1F48B}","\u{1F609}", "\u{1F633}", "\u{1F60C}" , "\u{1F61A}"  ,"\u{1F618}", "\u{270C}", "\u{1F47B}", "\u{1F525}", "\u{1F607}", "\u{1F617}", "\u{1F619}", "\u{1F60E}", "\u{1F61C}", "\u{270B}",  "\u{1F60B}"];
// 				 $smiles =  ["\u{1F609}", "\u{1F60C}" ];  
// 				$cursors = ["\u{261D}" , "\u{2B06}", "\u{2934}", "\u{1F53C}", "\u{1F51D}" ];  
// 			    $cur = $cursors[mt_rand(0, count($cursors) - 1)];
// 			    $smi = $smiles_list[mt_rand(0, count($smiles_list) - 1)];
// 			    $smi_hi = $smiles_hi[mt_rand(0, count($smiles_hi) - 1)];
// 			    $smil = $smiles[mt_rand(0, count($smiles) - 1)];
// 				$first_name_txt = explode(" ",$first_name);
// 				$hi_word = ["Hey! What's up? I am", "Hi! I am", "Hey there, I am"];
// 		 		$hiw = $hi_word[mt_rand(0, count($hi_word) - 1)];

// 				$text = "$hiw $first_name_txt[0] $smi_hi  Do you wanna play with me? $smil  I'm online here @girlshothere                @girlshothere                @girlshothere $smi $cur $cur $cur";

              
// 				try {
// 				//    $dirsh =  $i->direct_share("1244961383516529243", "1009845355", "hi) thats coool!!"); //send to one user
// 				//$i->direct_share("1244961383516529243", array("1009845355", "3299015045"), "hi! thats woow!");  
		 			
// 		 			$answer = $i->direct_share($ad_media_id, $message_recipient, $text ); 

// 		 			 // $i->direct_share($ad_media_id, "1009845355", $text );    
// 		 			 echo "\n\n**SEND**\n\n";
// 		 			 if ($answer == "ok") {
// 		 			$redis->rpush("recieved",  $message_recipient); 
// 		 			} else {

// 		 				$redis->rpush("not_recieved",  $message_recipient);  // track not sended messages

// 		 				sleep(14400); // 4 hours sleep
		 			 
// 		 			}

// 				} catch (Exception $e) {
// 				    echo $e->getMessage();
// 				}


// 				$next_iteration_time = timer($delay);
			
// 				}	
			 

// 			sleep(2);
		
// 		 }

	
	    break;
	}
	sleep(6);
}     
   


