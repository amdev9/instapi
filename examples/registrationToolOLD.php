<?php

 

$romerINSTAPI = '/Users/alex/dev/instapi/';
$romerPREDIS = '/Users/alex/dev/redis/predis/';
$romerINSTA = '/Users/alex/dev/insta/';

require_once $romerINSTAPI.'src/InstagramRegistration.php';

require $romerINSTAPI.'src/Instagram.php';
require $romerPREDIS.'autoload.php';


Predis\Autoloader::register();

$redis = new Predis\Client(array(
		"scheme" => "tcp",
		"host" => "127.0.0.1",
		"port" => 6379));


function shuffle_assoc($list) { 
  if (!is_array($list)) return $list; 

  $keys = array_keys($list); 
  shuffle($keys); 
  $random = array(); 
  foreach ($keys as $key) { 
    $random[$key] = $list[$key]; 
  }
  return $random; 
} 

function functofollow($ilink, $usernamelink, $pkuser) {
	$tofollow = $GLOBALS["redis"]->smembers("followmebot");

	if ($GLOBALS["redis"]->scard("followedbybot_".$usernamelink) < 5 ) {

    foreach ($tofollow as $fol) {	 
    	if ($GLOBALS["redis"]->sismember("followedbybot", $usernamelink."".$fol ) != true && $fol != $pkuser ) {

	   		try {
		   		 $ilink->follow($fol);
		   		 $GLOBALS["redis"]->sadd("followedbybot", $usernamelink."".$fol);
		   		 
		   		 $GLOBALS["redis"]->sadd("followedbybot_".$usernamelink , $fol);

				} catch (Exception $e) {
		   		 echo $e->getMessage();
				}		
   			}
   			sleep(30);
   		}
	}	
}

function functocomment($ilink, $usernamelink) 
{

        $influencers = [ "253477742", "240333138", "256489055", "190082554", "260958616", "241024950", "804080917", "404148826", "459946968", "1036771838", "1282684193", "268042440", "1457024717", "1190583665",  "217566587", "27133622", "243939213", "487569708","1394883667", "324942506", "3164294", "179302148", "7061024", "53029140",  "544300908",  "256293874", "604890697", "1286322852", "533244285", "181360417", "479888539", "25194884", "209835405", "1474275139", "313432062", "5697152", "209042133", "13338159", "196875629", "248748736", "7320858", "178170399", "173735863", "249609133",  "2665639", "540990470", "189857544", "203773727",  "25769240", "235258491",  "52869065", "22442174", "183084146",  "50918978","14589128", "24597242", "12496926", "510101416", "18070921", "440481453", "363632546", "195781248", "4960717", "5936478",  "25019328", "26023179", "209396541", "26023306",  "173623875", "19343908", "5510916", "3073135", "269508131",   "178926270",  "507001111", "295656006", "490055695", "1530569558",   "333052291", "601451280", "18114820",  "2030072568", "9009373", "265457536", "1100997240", "208909399",  "8541943", "336735088", "305007657", "408057861", "1750942627", "223469204", "733589668", "13115790" ,"311630651", "26468707", "466579064", "477239309", "1309665720", "194697262", "37568323", "6423886", "8741343", "267685466", "281277133","197209513", "293418826", "307808258", "335952555", "237074561", "20717765", "174492640", "401062883","2153087871", "265535236" ,"371956863" ];
 
		// $influencers_ADULT = ['13224318', '327139047', '16494719', '271720365', '19351330', '7962893', '1672489480', '1507448263', '26257074', '22676717', '5211436', '465805681', '1475313335', '17240139', '24610068', '50187813', '177443887', "2282477435", "2204060085", "2275299806","1447362645","331474338", "1284472953"];

	 		if ($GLOBALS["redis"]->scard("influencers") == 0 ) {
	 		 	foreach ($influencers as $inf) {
				    $GLOBALS["redis"]->sadd("influencers" , $inf);
				}
	 		}

 			$influencer = $GLOBALS["redis"]->spop("influencers");
 		    $uinfo =  $ilink->getUsernameInfo($influencer);
 		    echo $uinfo['user']['is_private'];
			while ($uinfo['user']['is_private'] == true) {
			 	$influencer = $GLOBALS["redis"]->spop("influencers");
			 	$ilink->getUsernameInfo($influencer);
			 	$uinfo = $ilink->getUsernameInfo($influencer);
			 	sleep(4);
			}
 			 

 			$usfeedforcom = $ilink->getUserFeed($influencer, $maxid = null, $minTimestamp = null);
 			
 			if (isset($usfeedforcom['items'][0]['pk'])) {
 			$medcom = $usfeedforcom['items'][0]['pk'];
 		} elseif ($usfeedforcom['status'] == "fail" &&  $usfeedforcom['message'] == "checkpoint_required")  {


 				
 				//
  				$ilink->checkpointPhoneChallenge($GLOBALS["phone"], $usfeedforcom['checkpoint_url']); // where is sms

           // $resp_code = trim(fgets(STDIN)); // why not working?
  				$resp_code = readline("Command: ");
           echo "\n".$resp_code;

          $results = $ilink->checkpointCodeChallenge($resp_code, $usfeedforcom['checkpoint_url']);

          echo var_export($results);

 		} else {

 			throw new InstagramException($usfeedforcom['message']."\n");
          return;
 		}




            /////// COMMENT 
			$commentindexkeys = $GLOBALS["redis"]->hkeys("comments_tovarka2");	//comments_adult	

			$availableComments = [];
			foreach ($commentindexkeys as $ind) {
			   if ($GLOBALS["redis"]->sismember("comment_sent", $usernamelink."_".$ind ) != true  ) {
			   		array_push($availableComments, $ind); 
			   }
			}
 			if ( empty($availableComments) == true ) {
 				$availableComments = $commentindexkeys;
 			}
 			$commentindex = $availableComments[mt_rand(0, count($availableComments) - 1)]; 
 			$commenttex = $GLOBALS["redis"]->hget("comments_tovarka2", $commentindex);

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
		    	$GLOBALS["redis"]->sadd("comment_sent", $usernamelink."_".$commentindex);
		    	$GLOBALS["redis"]->sadd("comment_sentactor", $usernamelink);
		    	
			}
			elseif ($link['status']== "fail" && $link['message'] == "checkpoint_required")
			{
				 
				$ilink->checkpointPhoneChallenge($GLOBALS["phone"], $link['checkpoint_url']);

		 			 // $resp_code = trim(fgets(STDIN));

		 			 $resp_code = readline("Command: ");

		 			 echo "\n".$resp_code;

		 			$results = $ilink->checkpointCodeChallenge($resp_code, $link['checkpoint_url']);

		 			echo var_export($results);
			}
			else {

				$GLOBALS["redis"]->sadd("disabled", "comment_".$usernamelink);
				echo "\ncomments not send";
			}

}

function funcrecur($ilink, $usernamelink, $pkuser)
{

	$time_in_day = 24*60*60;
	$posts_per_day = 1000;  //27000
	$delay = $time_in_day / $posts_per_day;


////HASHTAGS////////

	// while ($GLOBALS["redis"]->scard("detection".$usernamelink) == 0) {
	// 	  // funcgeocoordparse($ilink, $GLOBALS["redis"]);
	// 	if ($GLOBALS["redis"]->sismember("hashtag_actor" , $usernamelink) != true) {
	// 	$hashtags = [ "follow4follow", "followforfollow" ];

 // 		$availableHashtags = [];
 // 		foreach ($hashtags as $ind) {
	// 	    if (	 $GLOBALS["redis"]->lrange("$ind:max_id", -1, -1) != "0"  ) {
	// 	   		array_push($availableHashtags, $ind); 
	// 	    }
	// 	}
 // 		if ( empty($availableHashtags) == true ) {
 // 			$availableHashtags = $hashtags;
 // 			$hashtag = $availableHashtags[mt_rand(0, count($availableHashtags) - 1)]; 
 // 		} else {
 // 			$hashtag = $availableHashtags[mt_rand(0, count($availableHashtags) - 1)];
	// 		$red = $GLOBALS["redis"]->lrange("$hashtag:max_id", -1, -1);
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
	//    hashtagparse($hashtagers, $ilink, $GLOBALS["redis"], $hashtag);
	// }
	//    $GLOBALS["redis"]->sadd("hashtag_actor", $usernamelink );

 // }

////ADULT////////// 	 

	 while ($GLOBALS["redis"]->scard("detection".$usernamelink) == 0) {  
		  // funcgeocoordparse($ilink, $GLOBALS["redis"]);
	 		echo $next_iteration_time = add_time($delay);  
			sleep($next_iteration_time);
		
		// $influencers = [ "253477742", "240333138", "256489055", "190082554", "260958616", "241024950", "804080917", "404148826", "459946968", "1036771838", "1282684193", "268042440", "1457024717", "1190583665",  "217566587", "27133622", "243939213", "487569708","1394883667", "324942506", "3164294", "179302148", "7061024", "53029140",  "544300908",  "256293874", "604890697", "1286322852", "533244285", "181360417", "479888539", "25194884", "209835405", "1474275139", "313432062", "5697152", "209042133", "13338159", "196875629", "248748736", "7320858", "178170399", "173735863", "249609133",  "2665639", "540990470", "189857544", "203773727",  "25769240", "235258491",  "52869065", "22442174", "183084146",  "50918978","14589128", "24597242", "12496926", "510101416", "18070921", "440481453", "363632546", "195781248", "4960717", "5936478",  "25019328", "26023179", "209396541", "26023306",  "173623875", "19343908", "5510916", "3073135", "269508131",   "178926270",  "507001111", "295656006", "490055695", "1530569558",   "333052291", "601451280", "18114820",  "2030072568", "9009373", "265457536", "1100997240", "208909399",  "8541943", "336735088", "305007657", "408057861", "1750942627", "223469204", "733589668", "13115790" ,"311630651", "26468707", "466579064", "477239309", "1309665720", "194697262", "37568323", "6423886", "52922525", "8741343", "267685466", "281277133","197209513", "293418826", "307808258", "335952555", "237074561", "20717765", "174492640", "401062883","2153087871", "265535236" ,"371956863" ];

		 $influencers = ['2058338792', '2290970399', '887742497', '20283423', '1508113868', '1730743473', '2367312611', '190642982', '3185134640', '263425178', '630452793', '1730984940', '21760162', '903666490', '327139047', '13224318', "2282477435", "2204060085", "2275299806","1447362645","331474338", "1284472953"];

 		$availableInf = [];
 		foreach ($influencers as $ind) {
		    if (	 $GLOBALS["redis"]->lrange("$ind:max_id", -1, -1) != null  ) {
		   		array_push($availableInf, $ind); 
		    }
		}
 		if ( empty($availableInf) == true ) {
 			$availableInf = $influencers;
 			$influencer = $availableInf[mt_rand(0, count($availableInf) - 1)]; 
 		} else {
 			$influencer = $availableInf[mt_rand(0, count($availableInf) - 1)];
			$red = $GLOBALS["redis"]->lrange("$influencer:max_id", -1, -1);
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
		 
	    funcparse($followers, $ilink, $GLOBALS["redis"], $influencer);

 }

////////////////

 	// $actioner = $GLOBALS["redis"]->spop("detection");

 	
 	// functofollow($ilink, $usernamelink, $actioner);	 
////.......//////////

	// if ($GLOBALS["redis"]->sismember("comment_sentactor" , $usernamelink) != true) {
	//  	  for($t = 0; $t < 9; $t++) {  //expressive spam 12 OK no sleep
	// 		if ($GLOBALS["redis"]->sismember("disabled", "comment_".$usernamelink) != true) {
	// 			functocomment($ilink, $usernamelink);   
	// 			sleep(30);
	// 			//$timetosleep = add_time($delay*10);      	
	// 		 	//sleep($timetosleep);
	// 		}
	// 	}
	// }
	 //$GLOBALS["redis"]->sadd("track", "comment".$usernamelink."_".date("Y-m-d_H:i:s"));


	// // if ($GLOBALS["redis"]->scard("detection") == 0) {
	// // 	    funcgeocoordparse($ilink, $GLOBALS["redis"]);
	// 	   //   $timetosleep = add_time($delay);      	
	//  		 // sleep($timetosleep);	 
	// // }		 
	 
	  if ($GLOBALS["redis"]->scard("detection".$usernamelink) > 0 ) {
		

		    // for($t = 0; $t < 51; $t++) {  //TOVARKA

		  //   	if 	($GLOBALS["redis"]->scard("detection") == 0 ) {
				//     	funcgeocoordparse($ilink, $GLOBALS["redis"]);
				// }

	  			$acmed = $GLOBALS["redis"]->spop("detection".$usernamelink);

				if (strpos($acmed, ':') !== false) {
					$datapart = explode(":", $acmed);
				   	$actioner =  $datapart[0];
		    		$medcom = $datapart[1];
				}
				else 
				{
					$actioner =  $acmed ;
				}
		    

		    	          // 	if ($GLOBALS["redis"]->sismember("disabled", "direct_".$usernamelink) != true && $GLOBALS["redis"]->scard("detection".$usernamelink) % 31 == 0 ) {
			  		     // 		 functiondirectshare($usernamelink, $ilink, $actioner ,$ad_media_id);
					     // }
			   	

				  
					echo $next_iteration_time = add_time($delay); //timer
			    	sleep($next_iteration_time);

					// if ($medcom == "nonprivate") {
					
					// 	 $usfeed = $ilink->getUserFeed($actioner, $maxid = null, $minTimestamp = null);
					// 	 echo "\nfeed fecthed\n";
					
					//   if (isset($usfeed['items'][0]['pk'])) {
					// 	  $med = $usfeed['items'][0]['pk'];
					// 	  sleep(2);


					//  if ( $GLOBALS["redis"]->sismember("liked".$usernamelink , $med) != true ) {
					// 			$lres =$ilink->like($med);
					// 			echo var_export($lres); //need to test res code
							 

					// 		if ($lres[1]['status'] == 'ok') {
					//  		$GLOBALS["redis"]->sadd("liked".$usernamelink, $med);
					//  	} elseif ($lres[1]['status'] == 'fail' && isset($lres[1]['message']) && $lres[1]['message'] == 'login_required' ) {
					//  		$ilink->login(true);
					//  	} elseif ($lres[1]['status'] == 'fail' && isset($lres[1]['message']) && $lres[1]['message'] == 'checkpoint_required' ) {
					// 		 		$ilink->checkpointPhoneChallenge($GLOBALS["phone"], $lres[1]['checkpoint_url']);
				 //                     echo "\nVerification code sent! >>>>>\n";
					// 	 			 // $resp_code = trim(fgets(STDIN));
				 //                      $resp_code = "";
					// 	 			   while( ctype_digit($resp_code) != true) {
					// 					 // $line = readline("Command: ");
					// 					  $resp_code = readline("Command: ");
					// 					}

																 			

					// 	 			 echo "\n---->".$resp_code;

					// 	 			$results = $ilink->checkpointCodeChallenge($resp_code, $lres[1]['checkpoint_url']);

					// 	 			echo var_export($results);
					// 		 	}

					// 		 	else {
					// 		 			echo var_export($lres);

					// 		 	}
						 
					// 	}
					// 	}
					// 	 sleep(2);
					// }

			    // if ($medcom == "private") {
			    	// echo $next_iteration_time = add_time($delay); //timer
			    	// sleep($next_iteration_time);
					// &&  $GLOBALS["redis"]->scard("followed".$usernamelink) < 1590
			 
				if ($GLOBALS["redis"]->sismember("followed".$usernamelink , $actioner) != true  &&  ($GLOBALS["redis"]->scard("followed".$usernamelink) % 15!= 0  || $GLOBALS["redis"]->scard("followed".$usernamelink) == 0 )) {
					
					$fres = $ilink->follow($actioner);
					if ($fres[1]['status'] == 'ok') {
					 	$GLOBALS["redis"]->sadd("followed".$usernamelink, $actioner);
					} elseif ($fres[1]['status'] == 'fail' && isset($fres[1]['message']) && $fres[1]['message'] == 'login_required' ) {
					 	$ilink->login(true);
					} elseif ($fres[1]['status'] == 'fail' && isset($fres[1]['message']) && $fres[1]['message'] == 'checkpoint_required' ) {
						$ilink->checkpointPhoneChallenge($GLOBALS["phone"], $fres[1]['checkpoint_url']);
				        echo "\nVerification code sent! >>>>>\n";
		 			 	// $resp_code = trim(fgets(STDIN));
                        $resp_code = "";
		 			    while( ctype_digit($resp_code) != true) {
						 	// $line = readline("Command: ");
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

						// $ilink->logout();
						// echo "\nlogout success";
						// return;
						// echo "\n\nELSE --<<<  \n\n";
						//works
					 	 // $ilink = new Instagram($usernamelink, $GLOBALS["password"], $GLOBALS["proxy"], true );

					
						// $ilink->login();
						// sleep(2);
						// $cured = $ilink->currentEdit();
						// echo var_export($cured);
						// sleep(4);
						// $ilink->editProfile($GLOBALS["url"], "" , $GLOBALS["first_name"], $GLOBALS["biography"], $GLOBALS["email"], $GLOBALS["gender"]);
						$cured = $ilink->currentEdit();
					    echo var_export($cured);

					   	$email =  $cured[1]['user']['email'];
					   	$first_name =  $cured[1]['user']['full_name'];

					    $GLOBALS["biography"]  = str_replace( "_username" ,explode(" ",$first_name )[0]."".explode(" ",	$first_name )[1], $GLOBALS["biography"] );
						 
						sleep(4);
						$ilink->editProfile($GLOBALS["url"], "" , $first_name, $GLOBALS["biography"], $email, $GLOBALS["gender"]);
						sleep(4);

						return;
						// sleep(14400);//*60*20);
						// $ilink = new Instagram($usernamelink, $GLOBALS["password"], $GLOBALS["proxy"], true );
						// $ilink->login();
						// sleep(3);
						// $cured = $ilink->currentEdit();
						// echo var_export($cured);
						// sleep(4);
						// $ilink->editProfile("", "", $GLOBALS["first_name"], "" , $GLOBALS["email"], $GLOBALS["gender"]);
						// sleep(4);
						// $usname = $ilink->searchUsername($usernamelink);; 
						// $pk = $usname['user']['pk'];
						// sleep(4);
						// $GLOBALS["redis"]->sadd("followed".$usernamelink, $actioner);
						// funcrecur($ilink, $usernamelink, $pk  ); 


					}

					  
					
						
	}
					 
						
	funcrecur($ilink, $usernamelink, $pkuser  );


 
	
}
 
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



function funcparse($followers, $i, $redis, $influencer) 
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
				     //change to list . follow from top to bottom
					$redis->sadd("detection".$GLOBALS["username"], $followers['users'][$iter]['pk'].":nonprivate");
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
						$key = "detection".$GLOBALS["username"];
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


function hashtagparse($getl, $i, $redis, $hashtag)
{

	//$getl = $i->getHashtagFeed($hashtag, $maxid = null);

	        $num_rank_results =0;
	        while ($num_rank_results < $getl['num_results']) {
	          if($getl['items'][$num_rank_results]['user']['has_anonymous_profile_picture'] == false) {
	             echo $getl['items'][$num_rank_results]['user']['pk'].">---user pk\n"; ///////
	              $redis->sadd("detection".$GLOBALS["username"], $getl['items'][$num_rank_results]['user']['pk']);

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
	            
	             $redis->sadd("detection".$GLOBALS["username"], $getnewl['items'][$num_results]['user']['pk']);
	          
	             $num_results++;
	            }

	            sleep(1);
	            $getnewl = $i->getHashtagFeed( $hashtag, $tmpgetnewl['next_max_id']);

	            $redis->rpush($hashtag.":max_id",  $tmpgetnewl['next_max_id'] ); 

	            $countertrue++;
	      }
}



function funcgeocoordparse($i, $redis) 
{

		// PARSE PK BY LOCATION
		// $lat = '56.759945';
		// $long =  '37.1314441';
		// $nnnames = $i->locationParser($lat, $long);//return venues[0..n][name] -> searchLocation(/\) -> getLocationFeed( $locationdata['items'][0]['location']['pk']);
		//  echo "\n\n".$nnnames['venues'][0]['name'];
		//  echo "\n\n".$nnnames['venues'][1]['name'];

		$approxer = 10;//10
		 
		// "45.147617:44.741903"
		 //sent pol USA
		 // $a = [45.147617,-93.535346];
		 // $b = [44.741903,-92.903632];
		 $a = [55.852745,37.415947];
		 $b = [55.651242,37.771637];

		 // $a = [56.073183, 36.826896];
		 // $b = [55.435435, 38.502311];

		if ($redis->scard($a[0].":".$b[0]) == 0) {


		// $a =  [55.880088, 37.368901];
		// $b =  [55.608911, 37.917495];

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

	
		// $nnnames = $i->searchLocation('55.706440','37.577896');
 		// $loc = var_export($nnnames);
		// echo $loc."\n\n";

		// $aaaa = 0;
		// while ($aaaa < 1) { //$redis->scard("$a[0].":".$b[0]") > 0


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
					  // $re1='.*?';	# Non-greedy match on filler
					  // $re2='((?:[a-z][a-z]+))';	# Word 1
					  // $word1 = "";
					  // if ($c=preg_match_all ("/".$re1.$re2."/is", $txt, $matches))
					  // {
					  //     $word1=$matches[1][0];
					  // }
				  	$re1='.*?';	# Non-greedy match on filler
					$re2='((?:[a-z][a-z]+))';	# Word 1
					$word1 = "";
					if ($c=preg_match_all ("/".$re1.$re2."/is", $txt, $matches))
					{
					  $word1=$matches[1][0];
					}


					

					 $redis->sadd("detection".$GLOBALS["username"], $getl['items'][$num_rank_results]['user']['pk']); //.":".$word1

					// $redis->sadd("userpk".$a[0].":".$b[0], $getl['items'][$num_rank_results]['user']['pk'] );
					}

					///need add not runked items

					$num_rank_results++;
				}	
				// $lc = var_export($getl);
				// echo $lc;

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

						  // $txt=$foll['users'][$iter]['full_name'];
						  // $re1='.*?';	# Non-greedy match on filler
						  // $re2='((?:[a-z][a-z]+))';	# Word 1
						  // $word1 = "";
						  // if ($c=preg_match_all ("/".$re1.$re2."/is", $txt, $matches))
						  // {
						  //     $word1=$matches[1][0];
						  // }

						 $redis->sadd("detection".$GLOBALS["username"], $foll['users'][$iter]['pk']);//.":".$word1
					}

					

					  if($getnewl['items'][$num_results]['user']['has_anonymous_profile_picture'] == false) 
					  {
						  	// $getnewl['items'][$num_results]['user']['is_private'] == false
						    // $usfeed['items'][0]['taken_at'] > $filterDate &&  $usfeed['num_results'] > 9
							

						  // $txt=$getnewl['items'][$num_results]['user']['full_name'];
						  // $re1='.*?';	# Non-greedy match on filler
						  // $re2='((?:[a-z][a-z]+))';	# Word 1
						  // $word1 = "";
						  // if ($c=preg_match_all ("/".$re1.$re2."/is", $txt, $matches))
						  // {
						  //     $word1=$matches[1][0];
						  // }



						 $redis->sadd("detection".$GLOBALS["username"], $getnewl['items'][$num_results]['user']['pk']);//.":".$word1
			

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


function functiondirectshare($username, $i, $message_recipient, $ad_media_id)
{	 


				// $ad_media_list  = [ ];
				
		  //   	$ad_media_id = $ad_media_list[mt_rand(0, count($ad_media_list) - 1)];
				
				// $followlike  = $redis->spop($key);   
			 //    $resarr = explode(":",$followlike);
				// $message_recipient = $resarr[0];

  	 
  		// return user ID 

				$smiles_list =  ["\u{1F60C}" ,"\u{1F60D}" , "\u{1F61A}"  ,"\u{1F618}", "\u{2764}"];
			    $smiles_hi =  ["\u{26A1}", "\u{1F48B}","\u{1F609}", "\u{1F633}", "\u{1F60C}" , "\u{1F61A}"  ,"\u{1F618}", "\u{270C}", "\u{1F47B}", "\u{1F525}", "\u{1F607}", "\u{1F617}", "\u{1F619}", "\u{1F60E}", "\u{1F61C}", "\u{270B}",  "\u{1F60B}"];
				  $smiles =  ["\u{1F609}", "\u{1F60D}" ];  
				 $cursors = ["\u{261D}" , "\u{2B06}", "\u{2934}", "\u{1F53C}", "\u{1F51D}" ];  
			     $cur = $cursors[mt_rand(0, count($cursors) - 1)];
			     $smi = $smiles_list[mt_rand(0, count($smiles_list) - 1)];
			    $smi_hi = $smiles_hi[mt_rand(0, count($smiles_hi) - 1)];
			 $smil = $smiles[mt_rand(0, count($smiles) - 1)];
				$first_name_txt = explode(" ",$GLOBALS["first_name"]);
				 $hi_word = ["Hey! What's up? I am", "Hi! I am", "Hey there, I am"];
		 	 	$hiw = $hi_word[mt_rand(0, count($hi_word) - 1)];

				// $text = "$hiw $first_name_txt[0] $smi_hi Follow this awesome profile with naughty girls @livecamshowtvonline $smil $smi $cur $cur $cur";
			     
  		  $smiles_hi =  ["\u{26A1}", "\u{1F60C}"   ,  "\u{270C}", "\u{1F47B}", "\u{1F525}", "\u{270B}"];
          $smi_hi = $smiles_hi[mt_rand(0, count($smiles_hi) - 1)];
//$smi_hi
           $uname = $GLOBALS["username"];
          //////TOVARKA
	// $text = "Добрый день! $smi_hi \u{2029}\u{2757} Попробуйте признанную во всём мире органическую маску для лица @__blackmask__ \u{2757}\u{2029}\u{2753} Почему тысячи девушек выбирают Black Mask? \u{1F4AD}\u{2029}\u{2705} Потому что наша маска:\u{2029}\u{1F539} оказывает успокаивающее действие на раздраженную и воспаленную кожу;\u{2029}\u{1F539} разглаживает морщинки,возрастные складки, выравнивает текстуру кожи;\u{2029}\u{1F539} делает контур лица более четким;\u{2029}\u{1F539} улучшает цвет лица;\u{2029}\u{1F539} поглощает токсины,устраняет с поверхности эпидермиса мертвые клетки; борется с акне и прыщами\u{2029}\u{1F539} делает практически незаметными пигментные пятна различного происхождения \u{1F64C}\u{2029}\u{1F33F} При этом, маска полностью натуральная  \u{2029}\u{2705} Активная ссылка и подробности акции в описании профиля \u{27A1}\u{2029}\u{1F449} @__blackmask__  \u{1F448}\u{2029}\u{1F449} @__blackmask__  \u{1F448}\u{2029}\u{1F449} @__blackmask__  \u{1F448}";

	// $text = "Добрый день! $smi_hi \u{2029}\u{2757} CREST 3D WHITE - ТОЛЬКО САМОЕ ЛУЧШЕЕ, ДЛЯ ВАШЕЙ УЛЫБКИ \u{1F604} \u{1F444} \u{1F44D} \u{2029} Самая выгодная цена в России на оригинальную продукцию Crest 3D White из США \u{2029} Все товары сертифицированные в РФ! \u{2029} \u{1F680} Доставка по всей России! \u{2029} Оформляйте заказы на нашем сайте\u{2029}\u{2705} Активная ссылка и подробности акции в описании профиля \u{27A1}\u{2029}\u{1F449} @3dwhite.RUS  \u{1F448}\u{2029}\u{1F449} @3dwhite.RUS  \u{1F448}\u{2029}\u{1F449} @3dwhite.RUS \u{1F448}";


              //ADULT
         
         $text = "$hiw $first_name_txt[0] 19 years old $smi_hi Let's have a HOT chat (snap, kik, dm) \u{1F4A6} CLICK link in profile \u{1F449} @$uname \u{1F448} for contacts! \u{1F446}\u{1F446}\u{1F446} my login there $uname_96 $smil I am ONLINE and WAITING.. $cur";


 

				try {
				//    $dirsh =  $i->direct_share("1244961383516529243", "1009845355", "hi) thats coool!!"); //send to one user
				//$i->direct_share("1244961383516529243", array("1009845355", "3299015045"), "hi! thats woow!");  
		 			

//15 spop foractionF
					// $message_recipient = [];
				 //    for($it = 0; $it < 5; $it++) 
				 //   	{ 
					//     array_push($message_recipient, $GLOBALS["redis"]->spop("foractionF") ); 
					// }
					// $message_recipient = $GLOBALS["redis"]->spop("foractionF");
		 			// $message_recipient = array("1009845355", "3299015045"); //4ewir
		 			$answer = $i->direct_share($ad_media_id, $message_recipient, $text ); 

		 			 // $i->direct_share($ad_media_id, "1009845355", $text );    
		 			
		 			 if ($answer['status']== "ok") {
		 			 	 echo "\n\n**SEND**\n\n";
		 				$GLOBALS["redis"]->rpush("recieved",  $message_recipient); 
		 			} elseif ($answer['status']== "fail" && $answer['message'] == "checkpoint_required") {
		 				 
		 			$i->checkpointPhoneChallenge($GLOBALS["phone"], $answer['checkpoint_url']);
                     echo "\nVerification code sent! >>>>>\n";
		 			 // $resp_code = trim(fgets(STDIN));
		 			 $resp_code = readline("Command: ");

		 			 echo "\n".$resp_code;

		 			$results = $i->checkpointCodeChallenge($resp_code, $answer['checkpoint_url']);

		 			echo var_export($results);

		 				 // $sendsms = $i->sendSmsCode($GLOBALS["phone"]);
				    //  	 echo var_export($sendsms);
				    //  	 echo "\nVerification code sent! >>>>>\n";
				    //  	 $code_verif = trim(fgets(STDIN));
				    //  	 echo "\n".$code_verif."\n";
				    //  	 $versms = $i->verifySmsCode($GLOBALS["phone"], $code_verif);
				    //  	  echo var_export($versms);

		 			} else {

		 				// $GLOBALS["redis"]->rpush("not_recieved",  $message_recipient);  // track not sended messages
		 				// //del this --> sleep
		 				$GLOBALS["redis"]->sadd("disabled", "direct_".$username );
		 				// sleep(14400); // 4 hours sleep
		 			 	 echo "\n\ndirect NOT send\n\n";
		 			}

				} catch (Exception $e) {
				    echo $e->getMessage();
				}
}



if (count($argv) == 6 ) {


	$debug = true; 

	$userstring = $redis->spop("tologin");
	$userarray = explode ( " ", $userstring  ) ; 
	$username =  $userarray[0];
	$password =  $userarray[1];

	 
	$url  = $argv[3]; 
	$biography = str_replace( "_cur_down", "\u{1F447}" , str_replace ( "_kiss", "\u{1F48B}", str_replace("_smi_video", "🔞\u{1F4A6}", str_replace("_smi_hi", "\u{1F60D}", $argv[4])) ) ) ;
	$caption = str_replace( "_cur_up", "\u{1F446}\u{1F446}\u{1F446}" , str_replace ( "_nextlines", "\u{2029} \u{2029} \u{2029} \u{2029} \u{2029} \u{2029} \u{2029} ", str_replace("_smi_video", "\u{1F4A6}",   $argv[5] ) ) );
	 
	$gender = 2;
	 
	$dir = $romerINSTAPI.'src/adult/';

	 
	$proxy =  $redis->spop("proxy");	

	$i = new Instagram($username, $password, $proxy, $debug );

	$i->login();
	 sleep(15);

	$filesVideo = scandir($dir);
		$ava = true;
		$uploadCounter = 0;
		$filesVid = shuffle_assoc($filesVideo);

		foreach ( $filesVid as $k => $value ) {

		    $ext = pathinfo($value, PATHINFO_EXTENSION);
		    if ($ext == "mp4") { 
				try {
				    $i->uploadVideo($dir.'/'.$value, $caption);  
				} catch (Exception $e) {
				    echo $e->getMessage();
				}

				sleep(10);
		    }
		    elseif ($ext == "jpg" && $ava == true ) {

		    	try {
		    		if ($GLOBALS["redis"]->scard($value) >= 0 || $GLOBALS["redis"]->sismember('picked', $value) != true) 
					{
						
						if ($GLOBALS["redis"]->scard($value) == 0 ) {
						     $GLOBALS["redis"]->sadd('picked', $value);
						    foreach (range(-12, 12) as $number) {
						        if ($number != 0)
						            $GLOBALS["redis"]->sadd($value, $number);
						    }
						}
						$degrees = $GLOBALS["redis"]->spop($value);
				        echo $degrees;
				    	$i->changeProfilePicture($dir.'/'.$value, $degrees);
					}
				} catch (Exception $e) {
				    echo $e->getMessage();
				}
				sleep(10);
				$ava = false;

			} else {
				if ($uploadCounter == 2) { break; }
				try {
					if ($GLOBALS["redis"]->scard($value) >= 0 || $GLOBALS["redis"]->sismember('picked', $value) != true) 
					{
						
						if ($GLOBALS["redis"]->scard($value) == 0 ) {
						     $GLOBALS["redis"]->sadd('picked', $value);
						    foreach (range(-12, 12) as $number) {
						        if ($number != 0)
						            $GLOBALS["redis"]->sadd($value, $number);
						    }
						}
				        $degrees = $GLOBALS["redis"]->spop($value);
						echo $degrees;
				      
					    $i->uploadPhoto($dir.'/'.$value, $caption, null , $degrees);  
					    $uploadCounter = $uploadCounter + 1;
					}
				} catch (Exception $e) {
				    echo $e->getMessage();
				}
				sleep(30);
		    }
		}

		echo "video and photo downloaded!\n"; 

	// $cured = $i->currentEdit();
 //    echo var_export($cured);

 //   	$email =  $cured[1]['user']['email'];
 //   	$first_name =  $cured[1]['user']['full_name'];

 //    $GLOBALS["biography"]  = str_replace( "_username" ,explode(" ",$GLOBALS["first_name"])[0]."".explode(" ",$GLOBALS["first_name"])[1], $GLOBALS["biography"] );
	 
	// sleep(4);
	// $i->editProfile($GLOBALS["url"], "" , $GLOBALS["first_name"], $GLOBALS["biography"], $GLOBALS["email"], $GLOBALS["gender"]);
	// sleep(4);

	  
  	$logined = $proxy." ".$username." ".$password;//." ".$email;
  	$redis->sadd("successlogin", $logined);	


	 
		sleep(5);
	// $i->setPublicAccount();
		$i->setPrivateAccount();
	sleep(5);

   $usname = $i->searchUsername($username);; 
	$pk = $usname['user']['pk'];

     funcrecur($i, $username, $pk  ); 

}  else {


/// DEBUG MODE ///
$debug = true; 

$password = $argv[1]; 
$email= $argv[2]; 
$url  = $argv[3]; 
$biography = str_replace( "_cur_down", "\u{1F447}" , str_replace ( "_kiss", "\u{1F48B}", str_replace("_smi_video", "🔞\u{1F4A6}", str_replace("_smi_hi", "\u{1F60D}", $argv[4])) ) ) ;
$caption = str_replace( "_cur_up", "\u{1F446}\u{1F446}\u{1F446}" , str_replace ( "_nextlines", "\u{2029} \u{2029} \u{2029} \u{2029} \u{2029} \u{2029} \u{2029} ", str_replace("_smi_video", "\u{1F4A6}",   $argv[5] ) ) );
$first_name =  $argv[6];
$gender = 2;
 
$dir = $romerINSTAPI.'src/adult/';
 

$proxy = "";
$username = "";
$qs_stamp = "";

 

while ( $redis->scard("proxy") > 0 ) 
{
  	
	// SDIFF "used_proxy" "black_proxy" used_proxy - black_proxy
	// SDIFFSTORE "proxy" "used_proxy" "black_proxy"
	$prox =  $redis->spop("proxy");	
 	echo "\n******************------------>".$prox."<------------*********************\n";
    // $prox[$p]."<-------------------------*********************\n";
	
	$redis->sadd("used_proxy", $prox);

	$r = new InstagramRegistration($prox, $debug);
	 
 // $DelFilePath =  $r->returnIGDataPath().'cookies.dat';
 //        if (file_exists($DelFilePath)) { 
 //           unlink ($DelFilePath);          //delete cookies.dat if exist

 //           echo "\n*****---FILE cookies.dat DELETED!--****\n";
 //        }
        

	$qesyncreg = $r->syncFeaturesRegister();

	 

	$check = $r->checkEmail($email);
    if (isset($check[1]['available']) && $check[1]['available'] == false) {
    	$redis->sadd("blacklist_email",  $email);
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
			$GLOBALS["qs_stamp"] = $qsstamper[0];

		}
		else
		{
			$GLOBALS["qs_stamp"] = "";
		}
		 
	}	
	 
 
	// $sres = $r->sendSignupSmsCode($GLOBALS["phone"]);
	// echo var_export($sres);
	//  echo "\nVerification code sent! >>>>>\n";
	//  //add code for sms service
 //     	 // while ($redis->scard("code") < 1) {
 //     	 // 		sleep(3);
 //     	 // 		exec("python /Users/alex/home/dev/rails/instagram/scrapping/gamm/decodesms.py", $runned);
 //     	 // }
 //     	 // $cod = $redis->spop("code");
 //     	 $cod = readline("Command: ");
 //     	 echo "\n".$cod."\n";
     	 
 
	//  $sval = $r->validateSignupSmsCode($cod, $GLOBALS["phone"]);
	//  echo var_export($sval);
 //      sleep(10);
   
	 
    $sugger = $r->usernameSuggestions($email,$first_name );
   	$GLOBALS["username"] = $sugger[1]['suggestions'][0];
	$GLOBALS["first_name"] = $first_name;


	 
 //    while ( $redis->scard("names") > 0 ) {  
 //    	$pieces = explode(" ",  $redis->spop("names"));
 //        $check = $r->checkUsername($pieces[0] );
	  
	//     if ($check['available'] == true) {
	//     	$GLOBALS["username"] = $pieces[0];
	//     	$GLOBALS["first_name"] = $pieces[1]." ".$pieces[2];

	//         break;
	//     }     
	//     sleep(3);
	// } 
	 

 
	$result = $r->createAccount($username, $password, $email, $qs_stamp, $GLOBALS["first_name"] );
	 // $result = $r->createValidatedAccount($username, $cod,$GLOBALS["phone"], $GLOBALS["first_name"] , $password);


	$resToPrint =  var_export($result);
	echo $resToPrint;
	$findme = 'HTTP/1.1 200 OK';
	$pos = strpos($result[0], $findme);
 
	  if (isset($result[1]['errors']) &&  isset($result[1]['errors']['email'][0]) && strpos($result[1]['errors']['email'][0], 'Another account is using') !== false) {
    	echo 'Another account is using email: $email';
    	$redis->sadd("blacklist_email",  $email);


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
		$GLOBALS["proxy"] = $prox;		 
		$debug = true; // false FOR VPS  
 
		//need test WOULD IT BE BETTER TO COMBINE TWO CLASSES - NO NEED REQUEST BELOW
	    $i = new Instagram($username, $password, $proxy, $debug);
	    //$regUuid, $regDeviceId, $regPhoneId, $regPhoneUserAgent
		//set profile picture
		sleep(3);

		 
		$registered = $proxy." ".$username." ".$email." ".$password." ".$first_name;
      	file_put_contents($romerINSTA."logs/regDone.dat",$registered."\n", FILE_APPEND | LOCK_EX);  
         $caption = str_replace( "_username" , explode(" ",$first_name)[0]  ,  $caption );  

     	$redis->sadd("registered", $registered);
     	$redis->sadd("blacklist_email",  $email);
     	$redis->sadd("black_proxy",  $proxy);
 
		 // PHONE VERIFICATION WHEN CHANGE / ADD PHONE NUMBER
     	 // $sendsms = $i->sendSmsCode($phone);
     	 // echo var_export($sendsms);
     	 // echo "\nVerification code sent! >>>>>\n";
     	 // $code_verif = trim(fgets(STDIN));
     	 // echo "\n".$code_verif."\n";
     	 // $versms = $i->verifySmsCode($phone, $code_verif);
     	 //  echo var_export($versms);

		  
		 $GLOBALS["biography"]  = str_replace( "_username" ,explode(" ",$GLOBALS["first_name"])[0]."".explode(" ",$GLOBALS["first_name"])[1], $GLOBALS["biography"] );


// 		try {
// 		   $prres =  $i->setPrivateAccount();
// 		   echo  var_export($prres);
// 		} catch (Exception $e) {
// 		    echo $e->getMessage();
// 		}
// 		sleep(6);
 
	 
		$filesVideo = scandir($dir);
		$ava = true;
		$uploadCounter = 0;
		$filesVid = shuffle_assoc($filesVideo);

		foreach ( $filesVid as $k => $value ) {

		    $ext = pathinfo($value, PATHINFO_EXTENSION);
		    if ($ext == "mp4") { 
				try {
				    $i->uploadVideo($dir.'/'.$value, $caption);  
				} catch (Exception $e) {
				    echo $e->getMessage();
				}

				sleep(10);
		    }
		    elseif ($ext == "jpg" && $ava == true ) {

		    	try {
		    		if ($GLOBALS["redis"]->scard($value) >= 0 || $GLOBALS["redis"]->sismember('picked', $value) != true) 
					{
						
						if ($GLOBALS["redis"]->scard($value) == 0 ) {
						     $GLOBALS["redis"]->sadd('picked', $value);
						    foreach (range(-12, 12) as $number) {
						        if ($number != 0)
						            $GLOBALS["redis"]->sadd($value, $number);
						    }
						}
						$degrees = $GLOBALS["redis"]->spop($value);
				        echo $degrees;
				    	$i->changeProfilePicture($dir.'/'.$value, $degrees);
					}
				} catch (Exception $e) {
				    echo $e->getMessage();
				}
				sleep(10);
				$ava = false;

			} else {
				if ($uploadCounter == 2) { break; }
				try {
					if ($GLOBALS["redis"]->scard($value) >= 0 || $GLOBALS["redis"]->sismember('picked', $value) != true) 
					{
						
						if ($GLOBALS["redis"]->scard($value) == 0 ) {
						     $GLOBALS["redis"]->sadd('picked', $value);
						    foreach (range(-12, 12) as $number) {
						        if ($number != 0)
						            $GLOBALS["redis"]->sadd($value, $number);
						    }
						}
				        $degrees = $GLOBALS["redis"]->spop($value);
						echo $degrees;
				      
					    $i->uploadPhoto($dir.'/'.$value, $caption, null , $degrees);  
					    $uploadCounter = $uploadCounter + 1;
					}
				} catch (Exception $e) {
				    echo $e->getMessage();
				}
				sleep(30);
		    }
		}

		echo "video and photo downloaded!\n";

		// $cured = $i->currentEdit();
		// echo var_export($cured);
		// sleep(4);
		// $i->editProfile($GLOBALS["url"], "" , $GLOBALS["first_name"], $GLOBALS["biography"], $GLOBALS["email"], $GLOBALS["gender"]);
		// sleep(4);

		try {
		    $i->setPrivateAccount();
		} catch (Exception $e) {
		    echo $e->getMessage();
		}

		
		sleep(6);

		funcrecur($i, $username, $pk  ); 
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	// }

		// check if 
		
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
		// 	$iduser = $usname['user']['pk'];
		// 	$resusname =  var_export($usname);
		// 	echo "girlshothere--->".$iduser."\n\n";
		  
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
	    // 		// echo date('m/d/Y', $usfeed['items'][0]['taken_at']);
	    // 		// $filterDate = strtotime('-3 month', time()); 
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
    // $mediaId = $redis->spop($key = "media"); 		// media id from redis
	// 	   	$i->like("1270615353921552313");
	// 	} catch (Exception $e) {
	// 	    echo $e->getMessage();
	// 	}
	// 	sleep(6);	

/////////////////////////////////////////////////////

// 		////////////////////////
// 		//WHILE PAGE SIZE < 200

// 		//USA 
		

		
// // ///////////////////////////// DIRECT SHARE MAX 15 people in group  4ewir: 1009845355 ; blac.kkorol: 3299015045
		
	// 	$time_in_day = 24*60*60;
	// 	$posts_per_day = 200; 		// 300 - 60?   400 ->60  500->50    700->34
	// 	$delay = $time_in_day / $posts_per_day;
	// 	$next_iteration_time = time() + $delay; 

		

	// 	// $outarray = array_slice($prox, $p+1);
	// 	// $GLOBALS["proxy_list"] = $outarray;
	// 	// file_put_contents($romerINSTA."email_proxy/proxy_list", "");
	// 	// file_put_contents($romerINSTA."email_proxy/proxy_list", implode("\n",$outarray));
 //     	$key = "adultus";
	// 	while (true) {
	// 			 if ($redis->scard($key) == 0)
	// 			{
	// 			 funcparse($followers, $i, $redis, $influencer);

	// 			 //funcgeoparse add need test

	// 			}	
  			
	// 			if (time() >  $next_iteration_time) {

			 
			 
	// $ad_media_list  = ["1277470816705363477", "1277466307392355679", "1277436633060654628", "1277425043150126380", "1277422432296549618", "1276704501912747284", "1276702167556078800", "1276701053179837627", "1276700215979981984", "1276699612360916114"];
				
	// 	    	$ad_media_id = $ad_media_list[mt_rand(0, count($ad_media_list) - 1)];
				
	// 			$followlike  = $redis->spop($key);   
	// 		    $resarr = explode(":",$followlike);
	// 			$message_recipient = $resarr[0];


	// 			try {	
	// 				$fres = $i->follow($resarr[0]);
	// 				echo var_export($fres); //need to test res code

	// 			} catch (Exception $e) {
	// 			    echo $e->getMessage();
	// 			}
	// 			sleep(6);
	// 			try {	
	// 				$lres =$i->like($resarr[1]);
	// 				echo var_export($lres); //need to test res code
	// 			} catch (Exception $e) {
	// 			    echo $e->getMessage();
	// 			}
	// 			sleep(6);

 //  						   //check if message_recipient is NULL!!!!!!!!!!!!
  	 
 //  		// return user ID 



	// 			$smiles_list =  ["\u{1F60C}" ,"\u{1F60D}" , "\u{1F61A}"  ,"\u{1F618}", "\u{2764}", "\u{1F64C}"];
	// 			$smiles_hi =  ["\u{26A1}", "\u{1F48B}","\u{1F609}", "\u{1F633}", "\u{1F60C}" , "\u{1F61A}"  ,"\u{1F618}", "\u{270C}", "\u{1F47B}", "\u{1F525}", "\u{1F607}", "\u{1F617}", "\u{1F619}", "\u{1F60E}", "\u{1F61C}", "\u{270B}",  "\u{1F60B}"];
	// 			 $smiles =  ["\u{1F609}", "\u{1F60C}" ];  
	// 			$cursors = ["\u{261D}" , "\u{2B06}", "\u{2934}", "\u{1F53C}", "\u{1F51D}" ];  
	// 		    $cur = $cursors[mt_rand(0, count($cursors) - 1)];
	// 		    $smi = $smiles_list[mt_rand(0, count($smiles_list) - 1)];
	// 		    $smi_hi = $smiles_hi[mt_rand(0, count($smiles_hi) - 1)];
	// 		    $smil = $smiles[mt_rand(0, count($smiles) - 1)];
	// 			$first_name_txt = explode(" ",$first_name);
	// 			$hi_word = ["Hey! What's up? I am", "Hi! I am", "Hey there, I am"];
	// 	 		$hiw = $hi_word[mt_rand(0, count($hi_word) - 1)];

	// 			$text = "$hiw $first_name_txt[0] $smi_hi  Do you wanna play with me? $smil  I'm online here @girlshothere                @girlshothere                @girlshothere $smi $cur $cur $cur";

              
	// 			try {
	// 			//    $dirsh =  $i->direct_share("1244961383516529243", "1009845355", "hi) thats coool!!"); //send to one user
	// 			//$i->direct_share("1244961383516529243", array("1009845355", "3299015045"), "hi! thats woow!");  
		 			
	// 	 			$answer = $i->direct_share($ad_media_id, $message_recipient, $text ); 

	// 	 			 // $i->direct_share($ad_media_id, "1009845355", $text );    
	// 	 			 echo "\n\n**SEND**\n\n";
	// 	 			 if ($answer == "ok") {
	// 	 			$redis->rpush("recieved",  $message_recipient); 
	// 	 			} else {

	// 	 				$redis->rpush("not_recieved",  $message_recipient);  // track not sended messages
	// 	 				//del this --> sleep
	// 	 				sleep(14400); // 4 hours sleep
		 			 
	// 	 			}

	// 			} catch (Exception $e) {
	// 			    echo $e->getMessage();
	// 			}


	// 			$next_iteration_time = timer($delay);
			
	// 			}	
			 

	// 		sleep(2);
		
	// 	 }

	
	     break;
    }
	 sleep(3);
}     
   
   }


