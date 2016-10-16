<?php


// $romerINSTAPI = '/root/instapi/';
// $romerPREDIS = '/root/redis/predis/';
// $romerINSTA = '/root/insta/';

$romerINSTAPI = '/Users/alex/dev/instagram/instapi/';
$romerPREDIS = '/Users/alex/dev/instagram/redis/predis/';
$romerINSTA = '/Users/alex/dev/instagram/insta/';

require_once $romerINSTAPI.'src/InstagramRegistration.php';
require $romerINSTAPI.'src/Instagram.php';
 

class RegisterTool extends Threaded
{
	 
	protected $email;
 	protected $password; 
  	protected $username;
  	protected $proxy;
  	protected $debug;
  	protected $qs_stamp;

	public function imap_reader( $username, $password )
	{
		shell_exec('tunnelbear stop');
		echo "tunnelbear stopped\n";
		sleep(20);
		$hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
		//$username = 'iprofilenumberqweqweqweqweqweq@gmail.com';
		//$password = 'iprofilenumber';
		$inbox = imap_open($hostname,$username,$password); 
		echo "fine";
		$message_len = imap_num_msg($inbox)."\n";
		$emails = imap_search($inbox,'ALL');
		rsort($emails);
		$code = '';
		foreach($emails as $email_number) {
			// $overview = imap_fetch_overview($inbox,$email_number,0);
			$message = quoted_printable_decode(imap_fetchbody($inbox,$email_number,1)); 

			$re1='(Use)';  # Word 1
			$re2='.*?'; # Non-greedy match on filler
			$re3='(\\d+)';  # Integer Number 1
			$re4='.*?'; # Non-greedy match on filler
			$re5='(\\d+)';  # Integer Number 2
			$re6='.*?'; # Non-greedy match on filler
			$re7='(to)';  # Word 2
			$re8='.*?'; # Non-greedy match on filler
			$re9='(verify)';  # Word 3

			if ($c=preg_match_all ("/".$re1.$re2.$re3.$re4.$re5.$re6.$re7.$re8.$re9."/is", $message, $matches))
			{
				$word1=$matches[1][0];
				$int1=$matches[2][0];
				$int2=$matches[3][0];
				$word2=$matches[4][0];
				$word3=$matches[5][0];
				$code =  $int1."".$int2;

				break;
			}
			echo "+";
		}
		imap_close($inbox);
		shell_exec('tunnelbear UnitedStates');
		sleep(5);
		return $code;
	}

	public  function shuffle_assoc($list) { 
	  if (!is_array($list)) return $list; 

	  $keys = array_keys($list); 
	  shuffle($keys); 
	  $random = array(); 
	  foreach ($keys as $key) { 
	    $random[$key] = $list[$key]; 
	  }
	  return $random; 
	} 

	public  function functofollow($ilink, $usernamelink, $pkuser) {
		$tofollow = $redis->smembers("followmebot");

		if ($redis->scard("followedbybot_".$usernamelink) < 5 ) {

	    foreach ($tofollow as $fol) {	 
	    	if ($redis->sismember("followedbybot", $usernamelink."".$fol ) != true && $fol != $pkuser ) {

		   		try {
			   		 $ilink->follow($fol);
			   		 $redis->sadd("followedbybot", $usernamelink."".$fol);
			   		 
			   		 $redis->sadd("followedbybot_".$usernamelink , $fol);

					} catch (Exception $e) {
			   		 echo $e->getMessage();
					}		
	   			}
	   			sleep(30);
	   		}
		}	
	}

	public function functocomment($ilink, $usernamelink) 
	{

	        $influencers = [ "253477742", "240333138", "256489055", "190082554", "260958616", "241024950", "804080917", "404148826", "459946968", "1036771838", "1282684193", "268042440", "1457024717", "1190583665",  "217566587", "27133622", "243939213", "487569708","1394883667", "324942506", "3164294", "179302148", "7061024", "53029140",  "544300908",  "256293874", "604890697", "1286322852", "533244285", "181360417", "479888539", "25194884", "209835405", "1474275139", "313432062", "5697152", "209042133", "13338159", "196875629", "248748736", "7320858", "178170399", "173735863", "249609133",  "2665639", "540990470", "189857544", "203773727",  "25769240", "235258491",  "52869065", "22442174", "183084146",  "50918978","14589128", "24597242", "12496926", "510101416", "18070921", "440481453", "363632546", "195781248", "4960717", "5936478",  "25019328", "26023179", "209396541", "26023306",  "173623875", "19343908", "5510916", "3073135", "269508131",   "178926270",  "507001111", "295656006", "490055695", "1530569558",   "333052291", "601451280", "18114820",  "2030072568", "9009373", "265457536", "1100997240", "208909399",  "8541943", "336735088", "305007657", "408057861", "1750942627", "223469204", "733589668", "13115790" ,"311630651", "26468707", "466579064", "477239309", "1309665720", "194697262", "37568323", "6423886", "8741343", "267685466", "281277133","197209513", "293418826", "307808258", "335952555", "237074561", "20717765", "174492640", "401062883","2153087871", "265535236" ,"371956863" ];
	 
			// $influencers_ADULT = ['13224318', '327139047', '16494719', '271720365', '19351330', '7962893', '1672489480', '1507448263', '26257074', '22676717', '5211436', '465805681', '1475313335', '17240139', '24610068', '50187813', '177443887', "2282477435", "2204060085", "2275299806","1447362645","331474338", "1284472953"];

		 		if ($redis->scard("influencers") == 0 ) {
		 		 	foreach ($influencers as $inf) {
					    $redis->sadd("influencers" , $inf);
					}
		 		}

	 			$influencer = $redis->spop("influencers");
	 		    $uinfo =  $ilink->getUsernameInfo($influencer);
	 		    echo $uinfo['user']['is_private'];
				while ($uinfo['user']['is_private'] == true) {
				 	$influencer = $redis->spop("influencers");
				 	$ilink->getUsernameInfo($influencer);
				 	$uinfo = $ilink->getUsernameInfo($influencer);
				 	sleep(4);
				}
	 			 

	 			$usfeedforcom = $ilink->getUserFeed($influencer, $maxid = null, $minTimestamp = null);
	 			
	 			if (isset($usfeedforcom['items'][0]['pk'])) {
	 			$medcom = $usfeedforcom['items'][0]['pk'];
	 		} elseif ($usfeedforcom['status'] == "fail" &&  $usfeedforcom['message'] == "checkpoint_required")  {
	  				$ilink->checkpointPhoneChallenge($phone, $usfeedforcom['checkpoint_url']); 
	  				$resp_code = readline("Command: ");
	           echo "\n".$resp_code;

	          $results = $ilink->checkpointCodeChallenge($resp_code, $usfeedforcom['checkpoint_url']);

	          echo var_export($results);

	 		} else {

	 			throw new InstagramException($usfeedforcom['message']."\n");
	          return;
	 		}

	            /////// COMMENT 
				$commentindexkeys = $redis->hkeys("comments_tovarka2");	//comments_adult	

				$availableComments = [];
				foreach ($commentindexkeys as $ind) {
				   if ($redis->sismember("comment_sent", $usernamelink."_".$ind ) != true  ) {
				   		array_push($availableComments, $ind); 
				   }
				}
	 			if ( empty($availableComments) == true ) {
	 				$availableComments = $commentindexkeys;
	 			}
	 			$commentindex = $availableComments[mt_rand(0, count($availableComments) - 1)]; 
	 			$commenttex = $redis->hget("comments_tovarka2", $commentindex);

				// $commenttex_ADULT = ["Guys who want to PLAY with me?? check out my profile!", "Guys who wants to make me COME?? check out my profile", "I will make all u WANT", "Wanna some dirty staff?? Check profile..", "Show my body for you for FREE! Check out profile"];
	 		// 	$commenttex = $commenttex_ADULT[mt_rand(0, count($commenttex_ADULT) - 1)];

			    //  MESSAGE 
				// $smiles =  ["\u{1F44D}", "\u{1F44C}", "\u{1F478}" ];  
				// $attention = ["\u{2728}", "\u{2757}", "\u{270C}", "\u{1F64B}", "\u{2714}"];
				$smiles =  ["\u{1F609}", "\u{1F61A}", "\u{1F618}" ];  
		 		$smil = $smiles[mt_rand(0, count($smiles) - 1)];
		 		// $att = $attention[mt_rand(0, count($smiles) - 1)];
		 		$hearts = ["\u{1F49D}","\u{1F49B}","\u{1F49C}","\u{1F49A}"];  
		 		$heart = $hearts[mt_rand(0, count($hearts) - 1)];
		 		$flag = "\u{1F1F8}";
		 		$mouth = "\u{1F444}";
		  		$messageFinal = "$mouth $mouth $mouth $commenttex $heart $heart $heart"; //$heart $heart $heart";
				$link = $ilink->comment($medcom, $messageFinal); 
			    if ($link['status']== "ok") { 
			    	echo "\ncomment to influencer sent!---|||||->".$influencer."\n";
			    	$redis->sadd("comment_sent", $usernamelink."_".$commentindex);
			    	$redis->sadd("comment_sentactor", $usernamelink);
			    	
				}
				elseif ($link['status']== "fail" && $link['message'] == "checkpoint_required")
				{
					 
					$ilink->checkpointPhoneChallenge($phone, $link['checkpoint_url']);

			 			 // $resp_code = trim(fgets(STDIN));

			 			 $resp_code = readline("Command: ");

			 			 echo "\n".$resp_code;

			 			$results = $ilink->checkpointCodeChallenge($resp_code, $link['checkpoint_url']);

			 			echo var_export($results);
				}
				else {

					$redis->sadd("disabled", "comment_".$usernamelink);
					echo "\ncomments not send";
				}

	}

	public  function funcrecur($ilink, $pkuser , $redis)
	{

		$time_in_day = 24*60*60;
		$posts_per_day = 700;  //27000
		$delay = $time_in_day / $posts_per_day;

	////HASHTAGS////////
		// while ($redis->scard("detection".$usernamelink) == 0) {
		// 	  // funcgeocoordparse($ilink, $redis);
		// 	if ($redis->sismember("hashtag_actor" , $usernamelink) != true) {
		// 	$hashtags = [ "follow4follow", "followforfollow" ];

	 // 		$availableHashtags = [];
	 // 		foreach ($hashtags as $ind) {
		// 	    if (	 $redis->lrange("$ind:max_id", -1, -1) != "0"  ) {
		// 	   		array_push($availableHashtags, $ind); 
		// 	    }
		// 	}
	 // 		if ( empty($availableHashtags) == true ) {
	 // 			$availableHashtags = $hashtags;
	 // 			$hashtag = $availableHashtags[mt_rand(0, count($availableHashtags) - 1)]; 
	 // 		} else {
	 // 			$hashtag = $availableHashtags[mt_rand(0, count($availableHashtags) - 1)];
		// 		$red = $redis->lrange("$hashtag:max_id", -1, -1);
	 // 		}
		// 	if(empty ($red)) {
		// 		try {
		// 			 $hashtagers = $ilink->getHashtagFeed($hashtag, $maxid = null);
		// 		} catch (Exception $e) {
		// 		    echo $e->getMessage();
		// 		}

		// 	} else {
		// 		try {
		// 			 $hashtagers = $ilink->getHashtagFeed($hashtag, $red[0]);
		// 		} catch (Exception $e) {
		// 		    echo $e->getMessage();
		// 		}
		// 	}
		//    $this->hashtagparse($hashtagers, $ilink, $redis, $hashtag);
		// }
		//    $redis->sadd("hashtag_actor", $usernamelink );

	 // }

	////ADULT////////// 	 

		 while ($redis->scard("detection".$this->username) == 0) {  
			  //  $this->funcgeocoordparse($ilink, $redis);
		 		echo $next_iteration_time = $this->add_time($delay);  
				sleep($next_iteration_time);
			
			// $influencers_RUS = [ "253477742", "240333138", "256489055", "190082554", "260958616", "241024950", "804080917", "404148826", "459946968", "1036771838", "1282684193", "268042440", "1457024717", "1190583665",  "217566587", "27133622", "243939213", "487569708","1394883667", "324942506", "3164294", "179302148", "7061024", "53029140",  "544300908",  "256293874", "604890697", "1286322852", "533244285", "181360417", "479888539", "25194884", "209835405", "1474275139", "313432062", "5697152", "209042133", "13338159", "196875629", "248748736", "7320858", "178170399", "173735863", "249609133",  "2665639", "540990470", "189857544", "203773727",  "25769240", "235258491",  "52869065", "22442174", "183084146",  "50918978","14589128", "24597242", "12496926", "510101416", "18070921", "440481453", "363632546", "195781248", "4960717", "5936478",  "25019328", "26023179", "209396541", "26023306",  "173623875", "19343908", "5510916", "3073135", "269508131",   "178926270",  "507001111", "295656006", "490055695", "1530569558",   "333052291", "601451280", "18114820",  "2030072568", "9009373", "265457536", "1100997240", "208909399",  "8541943", "336735088", "305007657", "408057861", "1750942627", "223469204", "733589668", "13115790" ,"311630651", "26468707", "466579064", "477239309", "1309665720", "194697262", "37568323", "6423886", "52922525", "8741343", "267685466", "281277133","197209513", "293418826", "307808258", "335952555", "237074561", "20717765", "174492640", "401062883","2153087871", "265535236" ,"371956863" ];

			 $influencers = ['2058338792', '2290970399', '887742497', '20283423', '1508113868', '1730743473', '2367312611', '190642982', '3185134640', '263425178', '630452793', '1730984940', '21760162', '903666490', '327139047', '13224318', "2282477435", "2204060085", "2275299806","1447362645","331474338", "1284472953"];

	 		$availableInf = [];
	 		foreach ($influencers as $ind) {
			    if (	 $redis->lrange("$ind:max_id", -1, -1) != null  ) {
			   		array_push($availableInf, $ind); 
			    }
			}
	 		if ( empty($availableInf) == true ) {
	 			$availableInf = $influencers;
	 			$influencer = $availableInf[mt_rand(0, count($availableInf) - 1)]; 
	 		} else {
	 			$influencer = $availableInf[mt_rand(0, count($availableInf) - 1)];
				$red = $redis->lrange("$influencer:max_id", -1, -1);
	 		}

			if(empty ($red)) {
				try {
					 $followers = $ilink->getUserFollowers($influencer, $maxid = null);
				} catch (Exception $e) {
				    echo $e->getMessage();
				}

			} else {
				try {
					 $followers = $ilink->getUserFollowers($influencer, $red[0]);
				} catch (Exception $e) {
				    echo $e->getMessage();
				}
			}
			 
		    $this->funcparse($followers, $ilink, $redis, $influencer);

	 }

	 if ($redis->scard("detection".$this->username) > 0 ) {
		$acmed = $redis->spop("detection".$this->username);
		if (strpos($acmed, ':') !== false) {
			$datapart = explode(":", $acmed);
		   	$actioner =  $datapart[0];
    		$medcom = $datapart[1];
		}
		else {
			$actioner =  $acmed ;
		}
		// 40 __>>>__ 700
		// if ($redis->sismember("disabled", "direct_".$this->username) != true ) {
		//   $this->functiondirectshare( $ilink, $actioner, $redis );//,$ad_media_id
		// }
		echo $next_iteration_time = $this->add_time($delay); //timer
		sleep($next_iteration_time);

		if ($medcom == "nonprivate") {

			$usfeed = $ilink->getUserFeed($actioner, $maxid = null, $minTimestamp = null);
			echo "\nfeed fecthed\n";
			if (isset($usfeed['items'][0]['pk'])) {
				$med = $usfeed['items'][0]['pk'];
				sleep(3);
				if ( $redis->sismember("liked".$this->username , $med) != true ) {
					$lres =$ilink->like($med);
					echo var_export($lres); //need to test res code
					if ($lres[1]['status'] == 'ok') {
						$redis->sadd("liked".$this->username, $med);
					} elseif ($lres[1]['status'] == 'fail' && isset($lres[1]['message']) && $lres[1]['message'] == 'login_required' ) {
						$ilink->login(true);
					} elseif ($lres[1]['status'] == 'fail' && isset($lres[1]['message']) && $lres[1]['message'] == 'checkpoint_required' ) {
						$ilink->checkpointPhoneChallenge($this->phone, $lres[1]['checkpoint_url']);
					    echo "\nVerification code sent! >>>>>\n";
					    $resp_code = "";
						while( ctype_digit($resp_code) != true) {
						  $resp_code = readline("Command: ");
						}
				 			$results = $ilink->checkpointCodeChallenge($resp_code, $lres[1]['checkpoint_url']);
				 			echo var_export($results);
					 	}
					else {
						echo var_export($lres);
					}

					echo $next_iteration_time = $this->add_time($delay); //timer
					sleep($next_iteration_time);

					$ilink->follow($actioner);

				}
			}	 
		}

		if ($medcom == "private") {

			if ($redis->sismember("followed".$this->username , $actioner) != true  &&  ($redis->scard("followed".$this->username) % 250!= 0  || $redis->scard("followed".$this->username) == 0 )) {
				
				$fres = $ilink->follow($actioner);
				if ($fres[1]['status'] == 'ok') {
				 	$redis->sadd("followed".$this->username, $actioner);
				} elseif ($fres[1]['status'] == 'fail' && isset($fres[1]['message']) && $fres[1]['message'] == 'login_required' ) {
				 	$ilink->login(true);
				} elseif ($fres[1]['status'] == 'fail' && isset($fres[1]['message']) && $fres[1]['message'] == 'checkpoint_required' ) {
					$ilink->checkpointPhoneChallenge($this->phone, $fres[1]['checkpoint_url']);
			        echo "\nVerification code sent! >>>>>\n";
	                $resp_code = "";
	 			    while( ctype_digit($resp_code) != true) {
					  	$resp_code = readline("Command: ");
					}
					echo "\n---->".$resp_code;
					$results = $ilink->checkpointCodeChallenge($resp_code, $fres[1]['checkpoint_url']);
					echo var_export($results);
				}
				else {
					 echo var_export($fres);
				}
				echo var_export($fres);
			}
			else {
				 return;
			}		
		}	
		/////
		$this->funcrecur( $ilink, $pkuser, $redis );
	}
}


	
	public  function f_rand($min=0,$max=1,$mul=100000){
	    if ($min>$max) return false;
	    return mt_rand($min*$mul,$max*$mul)/$mul;
	}

	public  function add_time($time) {
		return $time*0.8 + $time*0.3*$this->f_rand(0,1);
	}

	public function uniord($u) {
	  
	    $k = mb_convert_encoding($u, 'UCS-2LE', 'UTF-8');
	    $k1 = ord(substr($k, 0, 1));
	    $k2 = ord(substr($k, 1, 1));
	    return $k2 * 256 + $k1;
	}

	public  function is_arabic($str) {
		if(strlen($str) == 0) {
			return false;
		} else {
		    if(mb_detect_encoding($str) !== 'UTF-8') {
		        $str = mb_convert_encoding($str,mb_detect_encoding($str),'UTF-8');
		    }
		    preg_match_all('/.|\n/u', $str, $matches);
		    $chars = $matches[0];
		    $arabic_count = 0;
		    $latin_count = 0;
		    $total_count = 0;
		    foreach($chars as $char) {
		        //$pos = ord($char); we cant use that, its not binary safe 
		        $pos = $this->uniord($char);
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



	public  function funcparse($followers, $i, $redis, $influencer) 
	{
		// echo $followers['page_size'];
			$counter = 0;
			// while ($counter < 2) {  

				for($iter = 0; $iter < count($followers['users']); $iter++) { 
					//$followers['page_size']
			        // echo count($followers['users'])."\n";
			        // echo $followers['users'][$iter]['pk'];

						if ($followers['users'][$iter]['is_private'] == false) {

						  $txt=$followers['users'][$iter]['full_name'];
						  $re1='.*?';	# Non-greedy match on filler
						  $re2='((?:[a-z][a-z]+))';	# Word 1
						  $word1 = "";
						  if ($c=preg_match_all ("/".$re1.$re2."/is", $txt, $matches))
						  {
						      $word1=$matches[1][0];
						  }
					  
						$redis->sadd("detection".$this->username, $followers['users'][$iter]['pk'].":nonprivate");
							//sadd

						//.":".$word1);

						  // $usfeed = $i->getUserFeed($followers['users'][$iter]['pk'], $maxid = null, $minTimestamp = null);

						 // if (isset($usfeed['items'][0]['pk'])) {
							//     $med = $usfeed['items'][0]['pk'];
							//      $redis->sadd("detection".$GLOBALS["username"], $followers['users'][$iter]['pk'].":".$med );//.":".$word1);
							// } else {
							// 	 $redis->sadd("detection".$GLOBALS["username"], $followers['users'][$iter]['pk']);//.":".$word1);
							// }


							//     echo $med.":med\n";// use the same caption
							//     if (isset($usfeed['items'][0]['lat']) && isset($usfeed['items'][0]['lng'])) {
							// 		$lat = $usfeed['items'][0]['lat'];
							// 		$long = $usfeed['items'][0]['lng'];

		 				// 			$filterDate = strtotime('-3 month', time()); 

							// 		$data = array('lat'=> $lat,
						 //              'lng'=> $long,
						 //              'username'=> 'blackkorol'
						 //              );

							// 		$params = http_build_query($data);

							// 		$service_url = 'http://api.geonames.org/countryCodeJSON?'.$params;

							// 		// $service_url = 'http://scatter-otl.rhcloud.com/location?'.$params;

							// 		 // create curl resource 
							// 		$ch = curl_init(); 

							// 		// set url 
							// 		curl_setopt($ch, CURLOPT_URL, $service_url); 

							// 		//return the transfer as a string 
							// 		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

							// 		// $output contains the output string 
							// 		$output = curl_exec($ch); 
							// 		$js =  json_decode($output);
							// 		// echo $js->countryCode;
						 // 			$country = $js->countryCode;

							// 		// $key = "wowrussia";
							// 		$key = "detection";
							// 		if ($followers['users'][$iter]['has_anonymous_profile_picture'] == false && is_arabic($followers['users'][$iter]['full_name']) == false && isset($country) && ($country == "US" || $country == "CA" || $country == "AU" || $country == "GB" || $country == "NZ" || $country == "ZA" ) && $usfeed['items'][0]['taken_at'] > $filterDate &&  $usfeed['num_results'] > 1) {
							
							// 			  $txt=$followers['users'][$iter]['full_name'];
							// 			  $re1='.*?';	# Non-greedy match on filler
							// 			  $re2='((?:[a-z][a-z]+))';	# Word 1
							// 			  $word1 = "";
							// 			  if ($c=preg_match_all ("/".$re1.$re2."/is", $txt, $matches))
							// 			  {
							// 			      $word1=$matches[1][0];
							// 			  }
										  	 
							// 			$redis->sadd($key, $followers['users'][$iter]['pk'].":".$word1);
							  
						
							// 		}
							// 	} else {
							// 			echo "no geo:med\n";
									 
							// 		$key = "detection";
							// 		if ($followers['users'][$iter]['has_anonymous_profile_picture'] == false) {
							// 			  $txt=$followers['users'][$iter]['full_name'];
							// 			  $re1='.*?';	# Non-greedy match on filler
							// 			  $re2='((?:[a-z][a-z]+))';	# Word 1
							// 			  $word1 = "";
							// 			  if ($c=preg_match_all ("/".$re1.$re2."/is", $txt, $matches))
							// 			  {
							// 			      $word1=$matches[1][0];
							// 			  }
										  	 
							
							// 		     $redis->sadd($key, $followers['users'][$iter]['pk'].":".$word1);
							  
							//  	    	}
							//  	}
							// } else {
							// 	echo "no media yet:med\n";
							// }


						} else {
							// $key = "wowrussia";
							$key = "detection".$this->username;
							echo "private:med\n";
							// need test how to count?
							if ($followers['users'][$iter]['has_anonymous_profile_picture'] == false ) {
								 $txt=$followers['users'][$iter]['full_name'];
								  $re1='.*?';	# Non-greedy match on filler
								  $re2='((?:[a-z][a-z]+))';	# Word 1
								  $word1 = "";
								  if ($c=preg_match_all ("/".$re1.$re2."/is", $txt, $matches))
								  {
								      $word1=$matches[1][0];
								  }
									  	 

								$redis->sadd($key, $followers['users'][$iter]['pk'].":private");
								//.":".$word1);  sadd
							}
						}
					
					 
				}
						
				$tmpfollowers = $followers;
				 
	 
				sleep(10);
				if (isset($tmpfollowers['next_max_id'])) {
					$redis->rpush("$influencer:max_id",  $tmpfollowers['next_max_id']); 
					try {
					$followers = $i->getUserFollowers($influencer, $tmpfollowers['next_max_id'] ); 
					} catch (Exception $e) {
					    echo $e->getMessage();
					}
					 				
					$counter++;
				} else {
					$redis->rpush("$influencer:max_id", null);
					// break;
				}
				
				 sleep(7);
			// }
	}

	public  function hashtagparse($getl, $i, $redis, $hashtag)
	{

		//$getl = $i->getHashtagFeed($hashtag, $maxid = null);

		        $num_rank_results =0;
		        while ($num_rank_results < $getl['num_results']) {
		          if($getl['items'][$num_rank_results]['user']['has_anonymous_profile_picture'] == false) {
		             echo $getl['items'][$num_rank_results]['user']['pk'].">---user pk\n"; ///////
		              $redis->sadd("detection".$this->username, $getl['items'][$num_rank_results]['user']['pk']);

		          }
		          $num_rank_results++;
		        } 
		        sleep(1);

		        if ($getl['more_available'] ==true ) {
		          $next_next_max_id = $getl['next_max_id'];
		          $getnewl = $i->getHashtagFeed($hashtag, $next_next_max_id);

		        } else {

		          echo "------>NO more\n";
		        }

		        $countertrue = 0;
		        while (isset($getnewl['more_available']) && $getnewl['more_available'] ==true && $countertrue < 25) {  
		            $tmpgetnewl = $getnewl;

		            $num_results = 0;
		            while ($num_results < $getnewl['num_results']) {
		       
		            echo $getnewl['items'][$num_results]['user']['pk'].">---user pk\n";
		            
		             $redis->sadd("detection".$this->username, $getnewl['items'][$num_results]['user']['pk']);
		          
		             $num_results++;
		            }

		            sleep(1);
		            $getnewl = $i->getHashtagFeed( $hashtag, $tmpgetnewl['next_max_id']);

		            $redis->rpush($hashtag.":max_id",  $tmpgetnewl['next_max_id'] ); 

		            $countertrue++;
		      }
	}



	public  function funcgeocoordparse($i, $redis) 
	{
			$approxer = 10;
			 $a = [55.852745,37.415947];
			 $b = [55.651242,37.771637];
			if ($redis->scard($a[0].":".$b[0]) == 0) {

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
						while (isset($nnnames['items'][$itemsCount]) == true ) {
							 
						if (explode('.',$nnnames['items'][$itemsCount]['location']['lat'])[0]  == explode('.',sprintf( "%0.06f", ($a[0] + $m*$sq_a)))[0] && explode('.',$nnnames['items'][$itemsCount]['location']['lng'])[0]  == explode('.',sprintf( "%0.06f", ($a[1] + $n*$sq_a)))[0]) {
								 

							     	$redis->sadd($a[0].":".$b[0], $nnnames['items'][$itemsCount]['location']['pk']);

								}
							 	$itemsCount++;
							 }

							# puts n.to_s + "=" + m.to_s
			 			}
			 		 }
			 	}

				try { 
				    // $getl = $i->getLocationFeed( $nnnames['items'][0]['location']['pk']);

					$locpk = $redis->spop($a[0].":".$b[0]);
					$getl = $i->getLocationFeed($locpk);

					$num_rank_results =0;
					while ($num_rank_results < $getl['num_results']) {
						 echo $getl['items'][$num_rank_results]['user']['pk']."<----user\n";//['ranked_items']

						if($getl['items'][$num_rank_results]['user']['has_anonymous_profile_picture'] == false) 
						  {

						  $txt=$getl['items'][$num_rank_results]['user']['full_name'];
						 
					  	$re1='.*?';	# Non-greedy match on filler
						$re2='((?:[a-z][a-z]+))';	# Word 1
						$word1 = "";
						if ($c=preg_match_all ("/".$re1.$re2."/is", $txt, $matches))
						{
						  $word1=$matches[1][0];
						}
						 $redis->sadd("detection".$this->username, $getl['items'][$num_rank_results]['user']['pk']); // 
	 
						}

						///need add not runked items

						$num_rank_results++;
					}	
					
					sleep(7);

					if ($getl['more_available'] == true ) {
						$next_next_max_id = $getl['next_max_id'];
						$getnewl = $i->getLocationFeed( $locpk, $next_next_max_id);
					} else {

						echo "------>NO more\n";
					}
					

					$countertrue = 0;
					while (isset($getnewl['more_available']) && $getnewl['more_available'] ==true && $countertrue < 70) { // $countertrue < 4
							
						$tmpgetnewl = $getnewl;

						//parse users pk
						$num_results = 0;
						while ($num_results < $getnewl['num_results']) {
						 echo $getnewl['items'][$num_results]['user']['pk'];
							echo "<----user\n";

						// sleep(1);
						$foll = $i->getUserFollowings($getnewl['items'][$num_results]['user']['pk'], $maxid = null);
						echo $foll['users'][0]['pk']."<----following pk\n";

						for($iter = 0, $c = count($foll['users']); $iter < $c; $iter++) {  //ADD ITERATOR IN FOLLIWINGS

							 
						 

							 $redis->sadd("detection".$this->username, $foll['users'][$iter]['pk']);//.":".$word1
						}

						

						  if($getnewl['items'][$num_results]['user']['has_anonymous_profile_picture'] == false) 
						  {
							  
							 $redis->sadd("detection".$this->username, $getnewl['items'][$num_results]['user']['pk']);//.":".$word1
				

					     }
				

						 $num_results++;
						}

						sleep(7);
						$getnewl = $i->getLocationFeed( $locpk, $tmpgetnewl['next_max_id']);

						$redis->rpush($locpk.":geomax_id",  $tmpgetnewl['next_max_id'] ); 

						$countertrue++;
				     }

				} catch (Exception $e) {
				    echo $e->getMessage();
				}
			 sleep(6);
	}


	public function functiondirectshare($i, $message_recipient, $redis, $ad_media_id = null)
	{	 
		$smiles_list =  ["\u{1F60C}" ,"\u{1F60D}" , "\u{1F61A}"  ,"\u{1F618}", "\u{2764}"];
		$smiles_hi =  ["\u{26A1}", "\u{1F48B}","\u{1F609}", "\u{1F633}", "\u{1F60C}" , "\u{1F61A}"  ,"\u{1F618}", "\u{270C}", "\u{1F47B}", "\u{1F525}", "\u{1F607}", "\u{1F617}", "\u{1F619}", "\u{1F60E}", "\u{1F61C}", "\u{270B}",  "\u{1F60B}"];
		$smiles =  ["\u{1F609}", "\u{1F60D}" ];  
		$cursors = ["\u{261D}" , "\u{2B06}", "\u{2934}", "\u{1F53C}", "\u{1F51D}" ];  
		$cur = $cursors[mt_rand(0, count($cursors) - 1)];
		$smi = $smiles_list[mt_rand(0, count($smiles_list) - 1)];
		$smi_hi = $smiles_hi[mt_rand(0, count($smiles_hi) - 1)];
		$smil = $smiles[mt_rand(0, count($smiles) - 1)];
		$first_name_txt = explode(" ",$this->first_name);
		$hi_word = ["Hey! What's up? I am", "Hi! I am", "Hey there, I am"];
		$hiw = $hi_word[mt_rand(0, count($hi_word) - 1)];
		$smiles_hi =  ["\u{26A1}", "\u{1F60C}"   ,  "\u{270C}", "\u{1F47B}", "\u{1F525}", "\u{270B}"];
		$smi_hi = $smiles_hi[mt_rand(0, count($smiles_hi) - 1)];
		 
		$uname = $this->username;

	    $text = "$hiw $first_name_txt[0] 19 years old $smi_hi Let's have a HOT chat (snap, kik, dm) \u{1F4A6} CLICK link in profile \u{1F449} @$uname \u{1F448} for contacts! \u{1F446}\u{1F446}\u{1F446} my login there ".$uname."_96 $smil I am ONLINE and WAITING.. $cur";

	    echo $text;

		try {
	 
			// $message_recipient = "1009845355"; //4ewir   , "3299015045" array(

			// $answer = $i->direct_share($ad_media_id, $message_recipient, $text ); 
	  
			$answer = $i->direct_message($message_recipient, $text ); 
			 // echo var_export($answer);
			 
			
			 if ($answer['status']== "ok") {
			 	 echo "\n\n**SEND**\n\n";
				$redis->rpush("recieved",  $message_recipient); 
			} elseif ($answer['status']== "fail" && $answer['message'] == "checkpoint_required") {
				 
				$i->checkpointPhoneChallenge($this->phone, $answer['checkpoint_url']);
		    		 echo "\nVerification code sent! >>>>>\n";
		    		 $resp_code = readline("Command: ");
				 	echo "\n".$resp_code;
					$results = $i->checkpointCodeChallenge($resp_code, $answer['checkpoint_url']);

							echo var_export($results);

			 			 

			 			} else {

			 				// $redis->rpush("not_recieved",  $message_recipient);  // track not sended messages
			 				// //del this --> sleep
			 				$redis->sadd("disabled", "direct_".$username );
			 				// sleep(14400); // 4 hours sleep
			 			 	 echo "\n\ndirect NOT send\n\n";
			 			}

					} catch (Exception $e) {
					    echo $e->getMessage();
					}
	}
	  

	// 	$i->login();
	public function run() {   

			$redis = $this->worker->getConnection();
			$this->debug = true; 
			$line_inst = $redis->spop('line_inst');
			$this->password = explode("|", $line_inst)[0];  
			$this->email= 	explode("|", $line_inst)[1]; 
			$bioparse = explode("|", $line_inst)[2];  
			$captionparse = explode("|", $line_inst)[3]; 
			$this->first_name =  explode("|", $line_inst)[4]; 
			$this->phone = ""; 
			$url  = $redis->spop('links_t'); 
			$biography = str_replace( "_cur_down", "\u{1F447}" , str_replace ( "_kiss", "\u{1F48B}", str_replace("_smi_video", "🔞\u{1F4A6}", str_replace("_smi_hi", "\u{1F60D}", $bioparse)) ) ) ;
			$caption = str_replace( "_cur_up", "\u{1F446}\u{1F446}\u{1F446}" , str_replace ( "_nextlines", "\u{2029} \u{2029} \u{2029} \u{2029} \u{2029} \u{2029} \u{2029} ", str_replace("_smi_video", "\u{1F4A6}",   $captionparse ) ) );
			$gender = 2;

			$dir = '/Users/alex/dev/instagram/instapi/src/adult/';
			$this->proxy = null; 
			$this->username = "";
			$this->qs_stamp = "";
					
			while ( $redis->scard("proxy") > 0 || $this->proxy == null) 
			{
			  	
				// SDIFF "used_proxy" "black_proxy" used_proxy - black_proxy
				// SDIFFSTORE "proxy" "used_proxy" "black_proxy"

				if ($redis->scard("proxy") > 0) {
				$prox =  $redis->spop("proxy");	
			 	echo "\n******************------------>".$prox."<------------*********************\n";
			    // $prox[$p]."<-------------------------*********************\n";
				
				$redis->sadd("used_proxy", $prox);
				} else {
					$prox = null;
				}

				$r = new InstagramRegistration($prox, $this->debug);	 
			 // $DelFilePath =  $r->returnIGDataPath().'cookies.dat';
			 //        if (file_exists($DelFilePath)) { 
			 //           unlink ($DelFilePath);          //delete cookies.dat if exist

			 //           echo "\n*****---FILE cookies.dat DELETED!--****\n";
			 //        }
				$r->syncFeaturesRegister();
				// $r->fbRequestAppInstalled();
				// $r->fbRequest(); 

				$check = $r->checkEmail($this->email);
			    if (isset($check[1]['available']) && $check[1]['available'] == false) {
			    	$redis->sadd("blacklist_email",  $this->email);
				    break;
				}

				$outputs = $r->fetchHeaders();
				 if ($outputs[1]['status'] == 'ok') {
				 	if (isset( $outputs[1]['iterations']) && isset( $outputs[1]['size']) && isset($outputs[1]['edges']) && isset($outputs[1]['shift']) && isset($outputs[1]['header']) ) {

						$iterations = $outputs[1]['iterations'];
						$size = $outputs[1]['size']; 
						$edges= $outputs[1]['edges'];
						$shift = $outputs[1]['shift']; 
						$header = $outputs[1]['header'];
						exec("/Users/alex/Desktop/asm/Newfolder/qsta/quicksand $iterations $size $edges $shift $header", $qsstamper); 
						echo $qsstamper[0];	
						$qs_stamp = $qsstamper[0];
					}
					else
					{
						$qs_stamp = "";
					} 
				}	

				// $sres = $r->sendSignupSmsCode($GLOBALS["phone"]);
				// echo var_export($sres);
				// // sleep(10);
				// // $phone_email = 'iprogileqweqwe12dsfsdfsdfsdfsd@gmail.com';
				// // $emailpass = 'iprofilenumberthree';
				// $phone_email = 'iprofilenumberqweqweqweqweqweq@gmail.com';
				// $emailpass = 'iprofilenumber';
				// // $cod = $this->imap_reader( $phone_email , $emailpass);
				//  echo "\nVerification code sent! >>>>>\n";
			 	//  $cod = readline("Command: ");
			 	//  echo "\n>>> CODE PARSED: ".$cod."\n";
				//  $sval = $r->validateSignupSmsCode($cod, $GLOBALS["phone"]);
				//  echo var_export($sval);
			      

			    $sugger = $r->usernameSuggestions($this->email, $this->first_name);
			   	$this->username = $sugger[1]['suggestions'][0];
				$result = $r->createAccount($this->username, $this->password, $this->email, $this->qs_stamp, $this->first_name );
				 // $result = $r->createValidatedAccount($username, $cod,$GLOBALS["phone"], $GLOBALS["first_name"] , $password);

				$resToPrint =  var_export($result);
				echo $resToPrint;
				$findme = 'HTTP/1.1 200 OK';
				$pos = strpos($result[0], $findme);
			 
				  if (isset($result[1]['errors']) &&  isset($result[1]['errors']['email'][0]) && strpos($result[1]['errors']['email'][0], 'Another account is using') !== false) {
			    	echo 'Another account is using email: $email';
			    	$redis->sadd("blacklist_email",  $this->email);

			    	 $DelFilePath =  $r->returnIGDataPath().'cookies.dat';
			        if (file_exists($DelFilePath)) { 
			           unlink ($DelFilePath);          //delete cookies.dat if exist

			           echo "\n*****---FILE cookies.dat DELETED!--****\n";
			        }

			    	break;
				}

				if ($pos !== false && isset($result[1]["account_created"]) && ($result[1]["account_created"] == true)) {
				    
				    echo "PKKEY: ".$result[1]['created_user']['pk']."\n\n";
				    $pk = $result[1]['created_user']['pk'];
					echo "\nconnection_established\n";
					echo "\n\n PROX ---------->".$prox. "\n\n";
					$this->proxy = $prox;		 

					//need test WOULD IT BE BETTER TO COMBINE TWO CLASSES - NO NEED REQUEST BELOW
				    $i = new Instagram($this->username, $this->password, $this->proxy, $this->debug);
				    //$regUuid, $regDeviceId, $regPhoneId, $regPhoneUserAgent
					//set profile picture
					sleep(3);

					 
					$registered = $this->username.":".$this->password.":blackking:Name0123Space:".$this->proxy; //.$email." ".$first_name;
			      	file_put_contents("/Users/alex/dev/instagram/insta/logs/regDone.dat",$registered."\n", FILE_APPEND | LOCK_EX);  


			         $caption = str_replace( "_username" , explode(" ",$this->first_name)[0]  ,  $caption );  
			         $biography  = str_replace( "_username" ,explode(" ",$this->first_name)[0]."".explode(" ",$this->first_name)[1], $biography );


			     	$redis->sadd("registered", $registered);
			     	$redis->sadd("blacklist_email",  $this->email);
			     	$redis->sadd("black_proxy",  $this->proxy);
			 
					 // PHONE VERIFICATION WHEN CHANGE / ADD PHONE NUMBER
			     	 // $sendsms = $i->sendSmsCode($phone);
			     	 // echo var_export($sendsms);
			     	 // echo "\nVerification code sent! >>>>>\n";
			     	 // $code_verif = trim(fgets(STDIN));
			     	 // echo "\n".$code_verif."\n";
			     	 // $versms = $i->verifySmsCode($phone, $code_verif);
			     	 //  echo var_export($versms);

					$filesVideo = scandir($dir);
					$ava = true;
					$uploadCounter = 0;
					$filesVid = $this->shuffle_assoc($filesVideo);

					foreach ( $filesVid as $k => $value ) {

					    $ext = pathinfo($value, PATHINFO_EXTENSION);
					    if ($ext == "mp4") { 
							try {
							    $i->uploadVideo($dir.'/'.$value, $caption);  
							} catch (Exception $e) {
							    echo $e->getMessage();
							}
					    }
					    elseif ($ext == "jpg" && $ava == true ) {

					    	try {
					    		if ($redis->scard($value) >= 0 || $redis->sismember('picked', $value) != true) 
								{
									if ($redis->scard($value) == 0 ) {
									     $redis->sadd('picked', $value);
									    foreach (range(-12, 12) as $number) {
									        if ($number != 0)
									            $redis->sadd($value, $number);
									    }
									}
									$degrees = $redis->spop($value);
							        echo $degrees;
							    	$i->changeProfilePicture($dir.'/'.$value, $degrees);
								}
							} catch (Exception $e) {
							    echo $e->getMessage();
							}
							 
							$ava = false;

						} else {
					
							if ($uploadCounter == 2) { break; }
							try {
								if ($redis->scard($value) >= 0 || $redis->sismember('picked', $value) != true) 
								{
									
									if ($redis->scard($value) == 0 ) {
									     $redis->sadd('picked', $value);
									    foreach (range(-12, 12) as $number) {
									        if ($number != 0)
									            $redis->sadd($value, $number);
									    }
									}
							        $degrees = $redis->spop($value);
									echo $degrees;
							      
								 	$i->uploadPhoto($dir.'/'.$value, $caption = '', $upload_id = null, $customPreview = null , $location = null, $reel_flag = false, $degrees);   

								 	if ($uploadCounter == 1) {
								 		sleep(10);
								 		$i->uploadPhoto($dir.'/'.$value, $caption = '', $upload_id = null, $customPreview = null , $location = null, $reel_flag = true, $degrees);   

								 	}

								    $uploadCounter = $uploadCounter + 1;
								}
							} catch (Exception $e) {
							    echo $e->getMessage();
							}
							 sleep(10);
					    }
					}
					echo "video and photo downloaded!\n";
					$cured = $i->currentEdit();
					echo var_export($cured);
					sleep(4);
					$i->editProfile($url, $this->phone, $this->first_name, $biography, $this->email , $gender); 
					sleep(4); 

					// $fres = $i->setPrivateAccount();
					// if ($fres[1]['status'] == 'ok') {
					// 	echo "ok";
					// } elseif ($fres[1]['status'] == 'fail' && isset($fres[1]['message']) && $fres[1]['message'] == 'login_required' ) {
					//  	$i->login(true);
					// } elseif ($fres[1]['status'] == 'fail' && isset($fres[1]['message']) && $fres[1]['message'] == 'checkpoint_required' ) {
					// 	$i->checkpointPhoneChallenge($phone, $fres[1]['checkpoint_url']);
				 	//        echo "\nVerification code sent! >>>>>\n";
		 			// 	 	// $resp_code = trim(fgets(STDIN));
     				//  $resp_code = "";
		 			// 	    while( ctype_digit($resp_code) != true) {
					// 	 	// $line = readline("Command: ");
					// 	  	$resp_code = readline("Command: ");
					// 	}
					// 	echo "\n---->".$resp_code;
					// 	$results = $i->checkpointCodeChallenge($resp_code, $fres[1]['checkpoint_url']);
					// 	echo var_export($results);
					// }
					// else {
					// 	echo var_export($fres);
					// }

					$this->funcrecur($i, $pk , $redis ); 
					//////
				    break;
			    }
				sleep(3);
			}     
	   }

}

