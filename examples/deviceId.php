<?php 
function SendRequest($url, $post, $data, $userAgent, $cookies) {
    $ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://i.instagram.com/api/v1/'.$url);
	curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

	if($post) {
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	}
		
	if($cookies) {
		curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt');			
	} else {
		curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
	}
		
	$response = curl_exec($ch);
	$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
		
	return [
                'code' => $http, 
                'response' => $response,
            ];
}

function GenerateGuid() { // same method  generateUUID --- generate phone id
	return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', 
			mt_rand(0, 65535), 
			mt_rand(0, 65535), 
			mt_rand(0, 65535), 
			mt_rand(16384, 20479), 
			mt_rand(32768, 49151), 
			mt_rand(0, 65535), 
			mt_rand(0, 65535), 
			mt_rand(0, 65535));
}

function GenerateUserAgent() {	
	$resolutions = ['720x1280', '320x480', '480x800', '1024x768', '1280x720', '768x1024', '480x320'];
	$versions = ['GT-N7000', 'SM-N9000', 'GT-I9220', 'GT-I9100'];
	$dpis = ['120', '160', '320', '240'];
	 


	$ver = $versions[array_rand($versions)];
	$dpi = $dpis[array_rand($dpis)];
	$res = $resolutions[array_rand($resolutions)];
	
	// return 'Instagram 4.'.mt_rand(1,2).'.'.mt_rand(0,2).' Android ('.mt_rand(10,11).'/'.mt_rand(1,3).'.'.mt_rand(3,5).'.'.mt_rand(0,5).'; '.$dpi.'; '.$res.'; samsung; '.$ver.'; '.$ver.'; smdkc210; en_US)';

	return 'Instagram 8.2.0'.' Android ('.mt_rand(10,11).'/'.mt_rand(1,3).'.'.mt_rand(3,5).'.'.mt_rand(0,5).'; '.$dpi.'; '.$res.'; samsung; '.$ver.'; '.$ver.'; smdkc210; en_US)';
}

function GenerateSignature($data)

  {
	// return hash_hmac('sha256', $data, 'b4a23f5e39b5929e0666ac5de94c89d1618a2916');

	return hash_hmac('sha256', $data, '55e91155636eaa89ba5ed619eb4645a4daf1103f2161dbfe6fd94d5ea7716095');
}

function GetPostData($filename) {
	if(!$filename) {
		echo "The image doesn't exist ".$filename;
	} else {
		$data = [
                    'device_timestamp' => time(), 
					'photo' => '@'.$filename
                ];
		return $data;
	}
}

function generateDeviceId($seed)
    {

      // //old
      //   // Neutralize username/password -> device correlation
        $volatile_seed = filemtime(__DIR__);
        // $volatile_seed = time();
        return 'android-'.substr(md5($seed.$volatile_seed), 16);

 

}


// Set the username and password of the account that you wish to post a photo to
$username = 'ameliagagnon93';
$password = '35OJOIQ';

// Set the path to the file that you wish to post.
// This must be jpeg format and it must be a perfect square
$filename = '/Users/alex/Desktop/Stairs-clock-portrait.jpg';

// Set the caption for the photo
$caption = "Mmm";

// Define the user agent
$agent = GenerateUserAgent();

// Define the GuID
$guid = GenerateGuid();

// Set the devide ID
$device_id = "android-".$guid;
// $device_id = generateDeviceId(md5($username.$password));

/* LOG IN */
// You must be logged in to the account that you wish to post a photo too
// Set all of the parameters in the string, and then sign it with their API key using SHA-256
$data = '{"device_id":"'.$device_id.'","guid":"'.$guid.'","username":"'.$username.'","password":"'.$password.'","Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"}';
$sig = GenerateSignature($data);
$data = 'signed_body='.$sig.'.'.urlencode($data).'&ig_sig_key_version=4';
$login = SendRequest('accounts/login/', true, $data, $agent, false);


$logex = var_export($login);
echo $logex;


echo $login['response'];

// if(strpos($login['response'], "Sorry, an error occurred while processing this request.")) {
//     echo "Request failed, there's a chance that this proxy/ip is blocked";
// } else {			
// 	if($login['code'] != 200) {
// 		echo "Error while trying to login";
// 	} else {			
// 		// Decode the array that is returned
// 		$obj = @json_decode($login['response'], true);

// 		if(empty($obj)) {
// 			echo "Could not decode the response: ".$body;
// 		} else {
// 		    // Post the picture
// 		    $data = GetPostData($filename);
// 		    $post = SendRequest('media/upload/', true, $data, $agent, true);	
							
// 		    if($post['code'] != 200) {
// 			    echo "Error while trying to post the image";
// 		    } else {
// 		        // Decode the response 
// 			    $obj = @json_decode($post['response'], true);

// 			    if(empty($obj)) {
// 				    echo "Could not decode the response";
// 			    } else {
// 				    $status = $obj['status'];

// 				    if($status == 'ok') {
//                         // Remove and line breaks from the caption
// 					    $caption = preg_replace("/\r|\n/", "", $caption);

// 					    $media_id = $obj['media_id'];
// 					    $device_id = "android-".$guid;
// 					    $data = '{"device_id":"'.$device_id.'","guid":"'.$guid.'","media_id":"'.$media_id.'","caption":"'.trim($caption).'","device_timestamp":"'.time().'","source_type":"5","filter_type":"0","extra":"{}","Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"}';	
// 					    $sig = GenerateSignature($data);
// 					    $new_data = 'signed_body='.$sig.'.'.urlencode($data).'&ig_sig_key_version=4';

//                         // Now, configure the photo
//                         $conf = SendRequest('media/configure/', true, $new_data, $agent, true);
									
// 					    if($conf['code'] != 200) {
// 							echo "Error while trying to configure the image";
// 					    } else {
// 						    if(strpos($conf['response'], "login_required")) {
// 							    echo "You are not logged in. There's a chance that the account is banned";
// 						    } else {
// 							    $obj = @json_decode($conf['response'], true);

// 							    $txt = $conf['response'];
// 							    $vartxt = var_export($txt);
// 							    echo $vartxt;
// 							    $status = $obj['status'];

// 							    if($status != 'fail') {
// 								    echo "Success";
// 							    } else {
// 								    echo 'Fail';
// 							    }
// 						    }
// 					    }
// 				    } else {
// 					    echo "Status isn't okay";
// 				    }
// 			    }
// 		    }
// 	    }
//     }
// }








