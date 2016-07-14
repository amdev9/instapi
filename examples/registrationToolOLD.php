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

	if ($GLOBALS["redis"]->scard("followedbybot_".$usernamelink) < 10 ) {

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

function functocomment($ilink, $usernamelink,$pktocom) { 


//, $pktocom = null

	// try {
 //   		 $outputinfo = $ilink->getSelfUsernameInfo();
   		 
 //   		 $GLOBALS["followercount"] = $outputinfo['user']['follower_count'];
 //   		 $outputres = var_export($outputinfo);
	//   	 echo $outputres;	 
	// 	} catch (Exception $e) {
	// 	  echo $e->getMessage();
	// 	}		
//$GLOBALS["redis"]->sismember("comment_sent", $usernamelink) != true
	// if ($GLOBALS["followercount"] > 0 ) {


if ($pktocom) {
		$usfeedforcom = $ilink->getUserFeed($pktocom, $maxid = null, $minTimestamp = null);
		$medcom = $usfeedforcom['items'][0]['pk'];
		 
		try {	
			$lres =$ilink->like($medcom);
			echo var_export($lres); //need to test res code
		} catch (Exception $e) {
		    echo $e->getMessage();
		}
		sleep(6);

		$smiles_list =  ["\u{1F60C}" ,"\u{1F60D}" , "\u{1F61A}"  ,"\u{1F618}", "\u{2764}", "\u{1F64C}"];
		$smiles_hi =  ["\u{26A1}", "\u{1F48B}","\u{1F609}", "\u{1F633}", "\u{1F60C}" , "\u{1F61A}"  ,"\u{1F618}", "\u{270C}", "\u{1F47B}", "\u{1F525}", "\u{1F607}", "\u{1F617}", "\u{1F619}", "\u{1F60E}", "\u{1F61C}", "\u{270B}",  "\u{1F60B}"];
		 $smiles =  ["\u{1F609}", "\u{1F60C}" ];  
		$cursors = ["\u{261D}" , "\u{2B06}", "\u{2934}", "\u{1F53C}", "\u{1F51D}" ];  
	    $cur = $cursors[mt_rand(0, count($cursors) - 1)];
	    $smi = $smiles_list[mt_rand(0, count($smiles_list) - 1)];
	    $smi_hi = $smiles_hi[mt_rand(0, count($smiles_hi) - 1)];
	    $smil = $smiles[mt_rand(0, count($smiles) - 1)];
		$first_name_txt = explode(" ",$GLOBALS["first_name"]);
		$hi_word = ["Hey! What's up? I am", "Hi! I am", "Hey there, I am"];
 		$hiw = $hi_word[mt_rand(0, count($hi_word) - 1)];

		//$commenttex = "$hiw $first_name_txt[0] $smi_hi  Do you wanna play with me? $smil $smi";
 		$commenttex = "Hi!";
              

		$link = $ilink->comment($medcom, $commenttex); 
			if ($link['status']== "ok") { 
					echo "\ncomment sent!\n";
			} else {

				$GLOBALS["redis"]->sadd("disabled", "comment_".$usernamelink); 

			}

		} else {

	 
		$influencers = ["253477742", "240333138", "7061024", "217566587", "267685466", "256489055", "299207425", "256293874", "305007657", "544300908", "27133622", "223469204", "26468707", "190082554", "766088051", "377126836", "311630651", "22442174", "5510916", "260958616", "241024950", "804080917", "13115790",  "18070921", "265457536", "22288455", "243725081"];
		 
//"20829767", bershka?
 	// 	foreach ($influencers as $influencer) {					 
		// 	$usfeedforcom = $ilink->getUserFeed($influencer, $maxid = null, $minTimestamp = null);
		// 	$medcom = $usfeedforcom['items'][0]['pk'];
			// if ($GLOBALS["redis"]->lrange("infpost_$influencer", -1,-1) != $medcom) {
			// 	$GLOBALS["redis"]->rpush("infpost_$influencer",  $medcom); 
			// }
 	// 		sleep(10);
		// }

 		try {
 			///need test
 			$availableINF = [];
 			foreach ($influencers as $influencer) {
			   if ($GLOBALS["redis"]->sismember("comment_inf_sent", $usernamelink."_".$influencer) != true  ) {
			   		array_push($availableINF, $influencer); 
			   }
			}
			if (empty($availableINF)){
				$availableINF = $influencers;
			}

		 	///

 			$influencer = $availableINF[mt_rand(0, count($availableINF) - 1)];
 			$usfeedforcom = $ilink->getUserFeed($influencer, $maxid = null, $minTimestamp = null);
 			$medcom = $usfeedforcom['items'][0]['pk'];
 			if ($GLOBALS["redis"]->lrange("infpost_$influencer", -1,-1) != $medcom) {
				$GLOBALS["redis"]->rpush("infpost_$influencer",  $medcom); 
			}

			$commentindexkeys = $GLOBALS["redis"]->hkeys("comments");		 // get  index of comment here
			$availableComments = [];
			foreach ($commentindexkeys as $ind) {
			   if ($GLOBALS["redis"]->sismember("comment_sent", $usernamelink."_".$ind ) != true  ) {
			   		array_push($availableComments, $ind); 
			   }
			}

			

			// while ( $GLOBALS["redis"]->sismember("comment_sent", $usernamelink."_".$commentindex) == true) {
			// 	//."_".$influencer
			// 	$influencer = $influencers[mt_rand(0, count($influencers) - 1)];
			// 	$commentindexkeys = $GLOBALS["redis"]->hkeys("comments");
			// 	$commentindex = $commentindexkeys[mt_rand(0, count($commentindexkeys) - 1)]; 
			// }

 			if (  empty($availableComments) == false ) {

 				$commentindex = $availableComments[mt_rand(0, count($availableComments) - 1)]; // make it RANDOM

 				//."_".$influencer
 				$mediatocomment = $GLOBALS["redis"]->lrange("infpost_$influencer", -1, -1)[0];
				$commenttex = $GLOBALS["redis"]->hget("comments", $commentindex);// change get from hash by commentindex
 	 
				 
				// $commenttex =  str_replace("@__blackmask__", "\u{1F4A5}@__blackmask__\u{1F4A5}", $commenttex);
 

				$smiles =  ["\u{1F44D}", "\u{1F44C}", "\u{1F478}" ];  
				$attention = ["\u{2728}", "\u{2757}", "\u{270C}", "\u{1F64B}", "\u{2714}"];
	     		$smil = $smiles[mt_rand(0, count($smiles) - 1)];
	     		$att = $attention[mt_rand(0, count($smiles) - 1)];
	     		$heart = "\u{1F49B} \u{1F49A} \u{1F49C} \u{1F49D}"; //colurful hearts      

      		   	// $hiw = $commenttex[mt_rand(0, count($commenttex) - 1)];
	      		$messageFinal = "$heart $att $commenttex $smil $heart";


			    $link = $ilink->comment($mediatocomment, $messageFinal); 


		    if ($link['status']== "ok") { 
		    	echo "\ncomment to influencer sent!---|||||->".$influencer."\n";
		    	$GLOBALS["redis"]->sadd("comment_sent", $usernamelink."_".$commentindex);//."_".
		    	$GLOBALS["redis"]->sadd("comment_inf_sent", $usernamelink."_".$influencer);
			}
			else 
			{
				echo "\ncomments disabled";
				$GLOBALS["redis"]->sadd("disabled", "comment_".$usernamelink );
			}
		}

			// add status
		} catch (Exception $e) {
		    echo $e->getMessage();
		}
	}
}

function funcrecur($ilink, $usernamelink, $pkuser, $ad_media_id,  $counter)
 {


	$time_in_day = 24*60*60;
	$posts_per_day = 500; 		//  direct 500->50    700->34
	$delay = $time_in_day / $posts_per_day;
 
	if ($GLOBALS["redis"]->scard("foractionF") == 0)
	{
	    funcgeocoordparse($ilink, $GLOBALS["redis"]);
	}
	// /functofollow($ilink, $usernamelink, $pkuser);	 
 	
 	sleep(6);
	

			// like combine with comment
	if 	($GLOBALS["redis"]->scard("foractionF") > 0 ) {
	$actioner = $GLOBALS["redis"]->spop("foractionF");
	 
	try {	
		$fres = $ilink->follow($actioner);
		echo var_export($fres); //need to test res code

	} catch (Exception $e) {
	    echo $e->getMessage();
	}

	if ($GLOBALS["redis"]->sismember("disabled", "comment_".$usernamelink) != true) {
		functocomment($ilink, $usernamelink, null); //$actioner);       	
	} 
	// else { //need fix to check if private or not
	// 	$usfeedforcom = $ilink->getUserFeed($actioner, $maxid = null, $minTimestamp = null);
	// 	$medcom = $usfeedforcom['items'][0]['pk'];
	// 	try {	
	// 		$lres =$ilink->like($medcom);
	// 		echo var_export($lres); //need to test res code
	// 	} catch (Exception $e) {
	// 	    echo $e->getMessage();
	// 	}
	// 	sleep(6);

	// }

	// else {

	// 	$counter--;
	// }

	// if ($counter==0) {

	// 	$ilink->logout();
	// 	return; 
	// }


	
	
	if ($GLOBALS["redis"]->sismember("disabled", "direct_".$usernamelink) != true) {
	   functiondirectshare($usernamelink, $actioner, $ilink, $ad_media_id);
	}
	 
  }
	 
	echo $next_iteration_time = add_time($delay); //timer
	sleep($next_iteration_time);
	
if ($GLOBALS["redis"]->sismember("disabled", "comment_".$usernamelink) == true && $GLOBALS["redis"]->sismember("disabled", "direct_".$usernamelink) == true) {

			$ilink->logout();
			return;
	}
	

	funcrecur($ilink, $usernamelink, $pkuser , $ad_media_id , $counter);

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
			 				
			$counter++;
			sleep(6);
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

		 $a = [56.073183, 36.826896];
		 $b = [55.435435, 38.502311];

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
					// echo $getl['items'][$num_rank_results]['user']['pk']."<----user\n";//['ranked_items']

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
					$re2='((?:[а-яa-z][a-яa-z]+))';	# Word 1
					$word1 = "";
					if ($c=preg_match_all ("/".$re1.$re2."/is", $txt, $matches))
					{
					  $word1=$matches[1][0];
					}


					

					 $redis->sadd("detection", $getl['items'][$num_rank_results]['user']['pk'].":".$word1);

					// $redis->sadd("userpk".$a[0].":".$b[0], $getl['items'][$num_rank_results]['user']['pk'] );
					}

					///need add not runked items

					$num_rank_results++;
				}	
				// $lc = var_export($getl);
				// echo $lc;

				sleep(7);

				if ($getl['more_available'] ==true ) {
					$next_next_max_id = $getl['next_max_id'];
					$getnewl = $i->getLocationFeed( $locpk, $next_next_max_id);
				} else {

					echo "------>NO more\n";
				}
				

				$countertrue = 0;
				while (isset($getnewl['more_available']) && $getnewl['more_available'] ==true) { // $countertrue < 4
						
					$tmpgetnewl = $getnewl;

					//parse users pk
					$num_results = 0;
					while ($num_results < $getnewl['num_results']) {
					 // echo $getnewl['items'][$num_results]['user']['pk'].
						echo "<----user\n";

					// sleep(1);
					$foll = $i->getUserFollowings($getnewl['items'][$num_results]['user']['pk'], $maxid = null);
					echo $foll['users'][0]['pk']."<----following pk\n";

					for($iter = 0, $c = count($foll['users']); $iter < $c; $iter++) {

						  $txt=$foll['users'][$iter]['full_name'];
						  $re1='.*?';	# Non-greedy match on filler
						  $re2='((?:[a-z][a-z]+))';	# Word 1
						  $word1 = "";
						  if ($c=preg_match_all ("/".$re1.$re2."/is", $txt, $matches))
						  {
						      $word1=$matches[1][0];
						  }

						 $redis->sadd("detection", $foll['users'][$iter]['pk'].":".$word1);
					}

					

					  if($getnewl['items'][$num_results]['user']['has_anonymous_profile_picture'] == false) 
					  {
					  	// $getnewl['items'][$num_results]['user']['is_private'] == false
					    // $usfeed['items'][0]['taken_at'] > $filterDate &&  $usfeed['num_results'] > 9
						

					  $txt=$getnewl['items'][$num_results]['user']['full_name'];
					  $re1='.*?';	# Non-greedy match on filler
					  $re2='((?:[a-z][a-z]+))';	# Word 1
					  $word1 = "";
					  if ($c=preg_match_all ("/".$re1.$re2."/is", $txt, $matches))
					  {
					      $word1=$matches[1][0];
					  }



					 $redis->sadd("detection", $getnewl['items'][$num_results]['user']['pk'].":".$word1);
		

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


function functiondirectshare($username, $message_recipient, $i,$ad_media_id)
{	 


				// $ad_media_list  = [ ];
				
		  //   	$ad_media_id = $ad_media_list[mt_rand(0, count($ad_media_list) - 1)];
				
				// $followlike  = $redis->spop($key);   
			 //    $resarr = explode(":",$followlike);
				// $message_recipient = $resarr[0];

  	 
  		// return user ID 

				// $smiles_list =  ["\u{1F60C}" ,"\u{1F60D}" , "\u{1F61A}"  ,"\u{1F618}", "\u{2764}", "\u{1F64C}"];
				// $smiles_hi =  ["\u{26A1}", "\u{1F48B}","\u{1F609}", "\u{1F633}", "\u{1F60C}" , "\u{1F61A}"  ,"\u{1F618}", "\u{270C}", "\u{1F47B}", "\u{1F525}", "\u{1F607}", "\u{1F617}", "\u{1F619}", "\u{1F60E}", "\u{1F61C}", "\u{270B}",  "\u{1F60B}"];
				//  $smiles =  ["\u{1F609}", "\u{1F60C}" ];  
				// $cursors = ["\u{261D}" , "\u{2B06}", "\u{2934}", "\u{1F53C}", "\u{1F51D}" ];  
			 //    $cur = $cursors[mt_rand(0, count($cursors) - 1)];
			 //    $smi = $smiles_list[mt_rand(0, count($smiles_list) - 1)];
			 //    $smi_hi = $smiles_hi[mt_rand(0, count($smiles_hi) - 1)];
			 //    $smil = $smiles[mt_rand(0, count($smiles) - 1)];
				// $first_name_txt = explode(" ",$GLOBALS["first_name"]);
				// $hi_word = ["Hey! What's up? I am", "Hi! I am", "Hey there, I am"];
		 	// 	$hiw = $hi_word[mt_rand(0, count($hi_word) - 1)];

				// $text = "$hiw $first_name_txt[0] $smi_hi Follow this awesome profile with naughty girls @livecamshowtvonline $smil $smi $cur $cur $cur";
			     
  		  $smiles_hi =  ["\u{26A1}", "\u{1F60C}"   ,  "\u{270C}", "\u{1F47B}", "\u{1F525}", "\u{1F60E}", "\u{270B}"];
          $smi_hi = $smiles_hi[mt_rand(0, count($smiles_hi) - 1)];

	$text = "Добрый день! $smi_hi\u{2029}\u{2757} Попробуйте признанную во всём мире органическую маску для лица @__blackmask__ \u{2757}\u{2029}\u{2753} Почему тысячи девушек выбирают Black Mask? \u{1F4AD}\u{2029}\u{2705} Потому что наша маска:\u{2029}\u{1F539} оказывает успокаивающее действие на раздраженную и воспаленную кожу;\u{2029}\u{1F539} разглаживает морщинки,возрастные складки, выравнивает текстуру кожи;\u{2029}\u{1F539} делает контур лица более четким;\u{2029}\u{1F539} улучшает цвет лица;\u{2029}\u{1F539} поглощает токсины,устраняет с поверхности эпидермиса мертвые клетки; борется с акне и прыщами\u{2029}\u{1F539} делает практически незаметными пигментные пятна различного происхождения \u{1F64C}\u{2029}\u{1F33F} При этом, маска полностью натуральная  \u{2029}\u{2705}ГАРАНТИРОВАННЫЙ РЕЗУЛЬТАТ В ТЕЧЕНИЕ 2-Х НЕДЕЛЬ! УСПЕЙ ЗАКАЗАТЬ СЕГОДНЯ ПО АКЦИИ!\u{2029}\u{27A1} Активная ссылка и подробности акции в описании профиля \u{27A1}\u{2029}\u{1F449} @__blackmask__  \u{1F448}\u{2029}\u{1F449} @__blackmask__  \u{1F448}\u{2029}\u{1F449} @__blackmask__  \u{1F448}";

              
				try {
				//    $dirsh =  $i->direct_share("1244961383516529243", "1009845355", "hi) thats coool!!"); //send to one user
				//$i->direct_share("1244961383516529243", array("1009845355", "3299015045"), "hi! thats woow!");  
		 			

		 			// $message_recipient = '1009845355'; 4ewir
		 			$answer = $i->direct_share($ad_media_id, $message_recipient, $text ); 

		 			 // $i->direct_share($ad_media_id, "1009845355", $text );    
		 			 echo "\n\n**SEND**\n\n";
		 			 if ($answer == "ok") {
		 				$GLOBALS["redis"]->rpush("recieved",  $message_recipient); 
		 			} else {

		 				$GLOBALS["redis"]->rpush("not_recieved",  $message_recipient);  // track not sended messages
		 				//del this --> sleep
		 				$GLOBALS["redis"]->sadd("disabled", "direct_".$username );
		 				// sleep(14400); // 4 hours sleep
		 			 
		 			}

				} catch (Exception $e) {
				    echo $e->getMessage();
				}
	 
}

// NOTE: THIS IS A CLI TOOL
/// DEBUG MODE ///
 
$debug = true;//usual true

$password = $argv[1]; 
$email= $argv[2]; 
$url  = $argv[3]; 
$biography = $argv[4];///."\u{1F4A6}"."\u{1F447}"."\u{1F447}";    
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
 

$proxy = "";
$username = "";
$first_name = "";
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
		 // exec("/root/qsta/quicksand $iterations $size $edges $shift $header", $qsstamper);
		
		echo $qsstamper[0];	
		$GLOBALS["qs_stamp"] = $qsstamper[0];
		 
	}	
      
    sleep(4);  
    $pieces = explode(" ", $redis->spop("names"));
    $sugger = $r->usernameSuggestions($email,$pieces[1]." ".$pieces[2] );
   	$GLOBALS["username"] = $sugger['suggestions'][0];
	$GLOBALS["first_name"] = $pieces[1]." ".$pieces[2];

	 
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
	 
	
	  sleep(4);  
	$result = $r->createAccount($username, $password, $email, $qs_stamp, $GLOBALS["first_name"] );

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
		$regPhoneUserAgent = $r->returnPhoneUA();

		//need test WOULD IT BE BETTER TO COMBINE TWO CLASSES - NO NEED REQUEST BELOW
		$i = new Instagram($username, $password, $proxy, $regUuid, $regDeviceId, $regPhoneId, $regPhoneUserAgent , $debug );
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
		
		// funcgeocoordparse($i, $redis);  // geo coordinates with gender done
 
		 

/////////////////////////////////////////////
	 


		$checkIfTematic = preg_replace('/[^0-9]/', '', $profileSetter);
		if ($checkIfTematic == '') {

			$time_in_day_T = 24*60*60;
			$posts_per_day_T = 3; 		//  direct 500->50    700->34
			$delay_T = $time_in_day_T / $posts_per_day_T;

				
	 		while(true) {
	 			$files1 = scandir($dir);

				foreach ( $files1 as $k => $value ) {
				    $ext = pathinfo($value, PATHINFO_EXTENSION);
				    if ($ext == "jpg") {

				    	echo $value."\n";

						try {
						    $i->uploadPhoto($dir.'/'.$value, $caption); // use the same caption
						} catch (Exception $e) {
						    echo $e->getMessage();
						}
				    	echo "photo downloaded!\n";
				    	if (!file_exists($dir.'/uploaded')) {
	   						mkdir($dir.'/uploaded', 0777, true);
						}
						
						// unlink($dir.'/'.$value);
						rename($dir.'/'.$value, $dir.'/uploaded/'.$value);
				    	// sleep(60);
						sleep(add_time($delay_T));
				    }  
				}
				sleep(30);
				echo "iteration cycle\n";
			}
			
		} else {
			//////// NON THEMATIC ////////

		$files1 = scandir($dir);
		foreach ( $files1 as $k => $value ) {
		    $ext = pathinfo($value, PATHINFO_EXTENSION);
		    if ($ext == "jpg") {
				try {
				    $i->uploadPhoto($dir.'/'.$value, $caption); // use the same caption
				} catch (Exception $e) {
				    echo $e->getMessage();
				}

				sleep(10);
		    }
		}

		echo "photo downloaded!\n";

		// $feedres = $i->getSelfUserFeed();
		// $ad_media_id  = $feedres['items'][0]['pk'];
		$usname = $i->searchUsername("__blackmask__"); 
		$iduser = $usname['user']['pk'];
		$feedres = $i->getUserFeed($iduser, $maxid = null, $minTimestamp = null);
		$ad_media_id = $feedres['items'][mt_rand(0,1)]['pk']; 
 
		$logoutCounter = 20;

		 // setting up private account
		try {
		    $i->setPrivateAccount();
		} catch (Exception $e) {
		    echo $e->getMessage();
		}
		 sleep(6);
	 

		funcrecur($i, $username, $pk, $ad_media_id, $logoutCounter  ); 
		 

	}

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
	sleep(6);
}     
   


