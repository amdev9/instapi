<?php



// print_r(      $lines);
//  print_r ($prox);

// $profileSetter = "1";
// $dir    = '/Users/alex/home/dev/rails/instagram/InstAPI/src/'.$profileSetter;
// $files1 = scandir($dir);
// // $files2 = scandir($dir, 1);

// // posts_per_day = 4
//  // self.posts_per_day = posts_per_day
//  //        if self.posts_per_day != 0:
//  //            self.post_delay = self.time_in_day / self.posts_per_day

// // add_time(post_delay)
// // return post_delay*0.9 + post_delay*0.2*random.random()

// // while true

// foreach ( $files1 as $key => $value ) {
    
//     $ext = pathinfo($value, PATHINFO_EXTENSION);
//     if ($ext == "jpg") {

//         echo $value."\n";
//     }

// }



// // $a = array (1, "next_max_id", "next_max_id2" =>  "b" );
// // $json =  var_export($a);

// // ['users'][0]['pk']
// // ['users'][0]['is_private']
// // ['users'][0]['has_anonymous_profile_picture']


// // /// RESULTS OF getUserFollowers
// $getUserFollowers = array (
//   'status' => 'ok',
//   'big_list' => true,
//   'users' => 
//   array (
//     0 => 
//     array (
//       'username' => 'man_zzz.30',
//       'has_anonymous_profile_picture' => false,
//       'profile_pic_url' => 'http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/10949077_876299559087559_288297091_a.jpg',
//       'full_name' => '',
//       'pk' => 1679934071,
//       'is_verified' => false,
//       'is_private' => true,
//     ),
//     1 => 
//     array (
//       'username' => 'ethem_khastal',
//       'has_anonymous_profile_picture' => false,
//       'profile_pic_url' => 'http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s150x150/12445853_834985299939803_283133197_a.jpg',
//       'full_name' => 'Etem Hastal',
//       'pk' => 3019198927,
//       'is_verified' => false,
//       'is_private' => false,
//     ),
//     2 => 
//     array (
//       'username' => 'lhjmrwnlmrywl',
//       'has_anonymous_profile_picture' => false,
//       'profile_pic_url' => 'http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s150x150/12093292_535034413333307_2134365177_a.jpg',
//       'full_name' => 'الحاج مروان المريول',
//       'pk' => 2645378774,
//       'is_verified' => false,
//       'is_private' => false,
// )),
//   'page_size' => 200,
//   'next_max_id' => 'AQD_VSOajr20qwiEFu1EOkWcdMkCd4waJsld7n9Cd9l92bafXbSFRSL3bj3onfVYNqUBtklnwRia-9y-kLnsSxGYRPcQxgemDA5QisjLxdLQnPACBQpj2ePEGt-TI32r4q8',
// );

  
  
// // for ($i = 0; $i < count($getUserFollowers['users']); ++$i ) {
// // 	echo $getUserFollowers['users'][$i]['pk']. "\n";
// // }

// for($i = 0, $c = count($getUserFollowers['users']); $i < $c; $i++)
//         var_dump($getUserFollowers['users'][$i]['pk']);

// ////////////// RESULTS OF getUserFeed 1 post

// ['items'][0]['pk']   -  latest media_id

// array (
//   'status' => 'ok',
//   'num_results' => 12,
//   'auto_load_more_enabled' => true,
//   'items' => 
//   array (
//     0 => 
//     array (
//       'taken_at' => 1464631349,
//       'pk' => 1261741665116545564,
//       'id' => '1261741665116545564_13226335',
//       'device_timestamp' => 1464631284,
//       'media_type' => 1,
//       'code' => 'BGCm1wDlOIc',
//       'client_cache_key' => 'MTI2MTc0MTY2NTExNjU0NTU2NA==.2',
//       'filter_type' => 114,
//       'image_versions2' => 
//       array (
//         'candidates' => 
//         array (
//           // 0 => 
//           // array (
//           //   'url' => 'http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/e35/13298276_1768752153369839_1270137232_n.jpg?se=7&ig_cache_key=MTI2MTc0MTY2NTExNjU0NTU2NA%3D%3D.2',
//           //   'width' => 1080,
//           //   'height' => 1298,
//           // ),
//           // 1 => 
//           // array (
//           //   'url' => 'http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/sh0.08/e35/p750x750/13298276_1768752153369839_1270137232_n.jpg?ig_cache_key=MTI2MTc0MTY2NTExNjU0NTU2NA%3D%3D.2',
//           //   'width' => 750,
//           //   'height' => 901,
        
//         ),
//       ),
//       'original_width' => 1080,
//       'original_height' => 1298,
//       'location' => 
//       array (
//         'external_source' => 'facebook_places',
//         'city' => '',
//         'name' => 'Summerburst Ullevi',
//         'facebook_places_id' => 200473116742411,
//         'address' => '',
//         'lat' => 57.703048435429999,
//         'pk' => 293185059,
//         'lng' => 11.98996533319,
//       ),
//       'lat' => 57.7030484354,
//       'lng' => 11.989965333200001,
//       'user' => 
//       array (
//         'username' => 'suzannesvanevik',
//         'has_anonymous_profile_picture' => false,
//         'is_unpublished' => false,
//         'profile_pic_url' => 'http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s150x150/12145429_927730610635383_1307205056_a.jpg',
//         'is_favorite' => false,
//         'full_name' => 'S U Z A N N E  S V A N E V I K',
//         'pk' => 13226335,
//         'is_verified' => false,
//         'is_private' => false,
//       ),
//       'organic_tracking_token' => 'eyJ2ZXJzaW9uIjo1LCJwYXlsb2FkIjp7ImlzX2FuYWx5dGljc190cmFja2VkIjpmYWxzZSwidXVpZCI6IjIwZTU0ODhhZTA2MjRiMDBhYWNjYjc4MDlhNDU2NzQwMTI2MTc0MTY2NTExNjU0NTU2NCIsInNlcnZlcl90b2tlbiI6IjE0NjU0NzgzMTUwMDZ8MTI2MTc0MTY2NTExNjU0NTU2NHwzMzE4ODA2OTQyfDBmNjYyNzUwYTdiZDFmZGQ5ZDhmNTEzYjczZjczZjkxMzdmMzdiNjI5MTRhZjdmNDAzNGMxYWM5ZjJjZWVkNTIifSwic2lnbmF0dXJlIjoiIn0=',
//       'like_count' => 3529,
//       'has_liked' => false,
//       'has_more_comments' => true,
//       'next_max_id' => 17848061371099354,
//       'max_num_visible_preview_comments' => 2,
//       'comments' => 
//       // array (
//       //   0 => 
//       //   array (
//       //     'status' => 'Active',
//       //     'user_id' => 13226335,
//       //     'created_at_utc' => 1464679709,
//       //     'created_at' => 1464679709,
//       //     'bit_flags' => 0,
//       //     'user' => 
//       //     array (
//       //       'username' => 'suzannesvanevik',
//       //       'profile_pic_url' => 'http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s150x150/12145429_927730610635383_1307205056_a.jpg',
//       //       'full_name' => 'S U Z A N N E  S V A N E V I K',
//       //       'pk' => 13226335,
//       //       'is_verified' => false,
//       //       'is_private' => false,
//       //     ),
//       //     'content_type' => 'comment',
//       //     'text' => '@amalieenilsen @borgevictoria ❤️😘',
//       //     'media_id' => 1261741665116545564,
//       //     'pk' => 17847952564099354,
//       //     'type' => 0,
//       //   ),
//       //   1 => 
//       //   array (
//       //     'status' => 'Active',
//       //     'user_id' => 371911901,
//       //     'created_at_utc' => 1465024175,
//       //     'created_at' => 1465024175,
//       //     'bit_flags' => 0,
//       //     'user' => 
//       //     array (
//       //       'username' => 'angelina_stay_fit',
//       //       'profile_pic_url' => 'http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s150x150/12237317_978292562212302_1381679108_a.jpg',
//       //       'full_name' => '💪💥 Mrs. ALPHA 🏆 󾓨➕󾓬',
//       //       'pk' => 371911901,
//       //       'is_verified' => false,
//       //       'is_private' => false,
//       //     ),
//       //     'content_type' => 'comment',
//       //     'text' => '💕🙇💪',
//       //     'media_id' => 1261741665116545564,
//       //     'pk' => 17848061371099354,
//       //     'type' => 0,
//       //   ),
//       // ),
//       'comment_count' => 15,
//       'caption' => 
// //       array (
// //         'status' => 'Active',
// //         'user_id' => 13226335,
// //         'created_at_utc' => 1464631360,
// //         'created_at' => 1464631360,
// //         'bit_flags' => 0,
// //         'user' => 
// //         array (
// //           'username' => 'suzannesvanevik',
// //           'has_anonymous_profile_picture' => false,
// //           'is_unpublished' => false,
// //           'profile_pic_url' => 'http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s150x150/12145429_927730610635383_1307205056_a.jpg',
// //           'is_favorite' => false,
// //           'full_name' => 'S U Z A N N E  S V A N E V I K',
// //           'pk' => 13226335,
// //           'is_verified' => false,
// //           'is_private' => false,
// //         ),
// //         'content_type' => 'comment',
// //         'text' => 'What a weekend!! ❤️🎶👫 🇸🇪 🎉 
// // #summerburst',
// //         'media_id' => 1261741665116545564,
// //         'pk' => 17847937411099354,
// //         'type' => 1,
// //       ),
//       'caption_is_edited' => true,
//       'usertags' => 
//       array (
//         'in' => 
//         array (
//           0 => 
//           array (
//             'position' => 
//             array (
//               0 => 0.28933333333333328,
//               1 => 0.52275249722530526,
//             ),
//             'user' => 
//             array (
//               'username' => 'alexanderhanseen',
//               'profile_pic_url' => 'http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/11325067_1458641184432380_1125557864_a.jpg',
//               'full_name' => 'A L E X A N D E R  H A N S E N',
//               'pk' => 143733623,
//               'is_verified' => false,
//               'is_private' => false,
//             ),
//           ),
//         ),
//       ),
//       'photo_of_you' => false,
//     ),
//   ),
//   'more_available' => true,
//   'next_max_id' => '1234210888711725980_13226335',
// )

 
////////////////////////////////////////////////////////////////////////////////////////
            //////////////////////////////////////////////////////////////////////
            ///////////////////////////////////////////////////////////////////////////



// $recipients = array("1009845355", "3299015045");
// if (!is_array($recipients)) {
//             $recipients = [$recipients];
//         }
//         $string = [];
//         foreach ($recipients as $recipient) {
//             $string[] = "\"$recipient\"";
//         }
//         $recipient_users = implode(',', $string);

// echo "[[$recipient_users]]";



// function uniord($u) {
//     // i just copied this function fron the php.net comments, but it should work fine!
//     $k = mb_convert_encoding($u, 'UCS-2LE', 'UTF-8');
//     $k1 = ord(substr($k, 0, 1));
//     $k2 = ord(substr($k, 1, 1));
//     return $k2 * 256 + $k1;
//  }
// function is_arabic($str) {
//   if(strlen($str) == 0) {
//     return false;
//   } else {

//       if(mb_detect_encoding($str) !== 'UTF-8') {
//           $str = mb_convert_encoding($str,mb_detect_encoding($str),'UTF-8');
//       }

      
//       $str = str_split($str); <- this function is not mb safe, it splits by bytes, not characters. we cannot use it
//       $str = preg_split('//u',$str); <- this function woulrd probably work fine but there was a bug reported in some php version so it pslits by bytes and not chars as well
      
//       preg_match_all('/.|\n/u', $str, $matches);
//       $chars = $matches[0];
//       $arabic_count = 0;
//       $latin_count = 0;
//       $total_count = 0;
//       foreach($chars as $char) {
//           //$pos = ord($char); we cant use that, its not binary safe 
//           $pos = uniord($char);
//           // echo $char ." --> ".$pos.PHP_EOL;

//           if($pos >= 1536 && $pos <= 1791) {
//               $arabic_count++;
//           } else if($pos > 123 && $pos < 123) {
//               $latin_count++;
//           }
//           $total_count++;
//       }
//       if(($arabic_count/$total_count) > 0.0001) {
//           // 60% arabic chars, its probably arabic
//           return true;
//       }
//       return false;
//   }
// }

// $sss  = 'asdaاasdasdasd';
// // echo $sss;


// $arabic = is_arabic($sss); 
// var_dump($arabic);



// echo '["0"]';


// $json = '{
//     "status": "ok",
//     "big_list": true,
//     "users": [{
//         "username": "asl.mert",
//         "has_anonymous_profile_picture": true,
//         "profile_pic_url": "http://scontent-lhr3-1.cdninstagram.com/t51.2885-19/11906329_960233084022564_1448528159_a.jpg",
//         "full_name": "Asl\u0131 Mert",
//         "pk": 3294959691,
//         "is_verified": false,
//         "is_private": false
//     },{
//         "username": "ali_mashaikhi",
//         "has_anonymous_profile_picture": false,
//         "profile_pic_url": "http://scontent-lhr3-1.cdninstagram.com/t51.2885-19/s150x150/13116539_277661979235903_421638637_a.jpg",
//         "full_name": "~\u00b0\u25cf( \u0639\u0644\u064a \u0622\u0625\u0644\u0645\u0640\u2665\u0328\u0325\u032c\u0329\u0634\u0622\u0625\u064a\u062e\u064a )\u25cf\u00b0~",
//         "pk": 1269703933,
//         "is_verified": false,
//         "is_private": false
//     }],
//     "page_size": 200,
//     "next_max_id": "AQDoABpB7cRzDcTsdQeb7JDFAw-v_muGDyD7ljq72ujH6-ejagHcg4wdtQvx2hUs9by4NIxcV_i8kMRy1mfScjvh18axrt12ww8QIdQCCt7sba21LUsBdKh2vUX4bZhO700"
//   }';

// $obj = json_decode($json);

// $next_max_id = $obj->{'next_max_id2'};

// echo $next_max_id;

// $array = array(0 => 100, "color" => "red");
// print_r(array_keys($array));

 
 
// $var = array_values($array);
 
//  echo array_pop($var);




// print_r($files1);
// print_r($files2);
 




// $handle = @fopen("/Users/alex/home/dev/rails/instagram/InstA/email_proxy/login_names", "r");
//  $lines=array();
// if ($handle) {
//     while (($buffer = fgets($handle, 4096)) !== false) {
//         // echo $buffer;


//     //add to array
//      $lines[]=trim($buffer);
 
//     }
//     if (!feof($handle)) {
//         echo "Error: unexpected fgets() fail\n";
//     }
//     fclose($handle);
// }
 
// // echo implode ("\n",$lines);



// $i = 0; 

// while ($i < count($lines)){
//     $pieces = explode(" ", $lines[$i]);
 
//     if ($pieces[0] == "vildenilsen"){
//         $outarray = array_slice($lines, $i + 1);
//          $GLOBALS["lines"] = $outarray;
//         // $file = '/Users/alex/home/dev/rails/instagram/InstA/logs/regDone.dat';
//         // $person = "hanneaas93\n";
//         // file_put_contents($file, $person, FILE_APPEND | LOCK_EX);  
//         file_put_contents("/Users/alex/home/dev/rails/instagram/InstA/email_proxy/login_names", "");
//         file_put_contents("/Users/alex/home/dev/rails/instagram/InstA/email_proxy/login_names", implode("\n",$outarray));
    


//         break;
//     }
//      echo $pieces[0]."\n";
//     $i  = $i + 1;

// }



 
// // $size = 640;
// $raw = true;
//  $file = "test.jpg";
//  list($width, $height) = getimagesize($file);
//  echo $width.'\n';
//  echo $height.'\n';

//     if ($width > $height) {
//         $y = 0;
//         $x = ($width - $height) / 2;
//         $smallestSide = $height;
//     } else {
//         $x = 0;
//         $y = ($height - $width) / 2;
//         $smallestSide = $width;
//     }

//     $image_p = imagecreatetruecolor($size, $size);
//     $image = imagecreatefromstring(file_get_contents($file));

//     imagecopyresampled($image_p, $image, 0, 0, $x, $y, $size, $size, $smallestSide, $smallestSide);
//     ob_start();
//     imagejpeg($image_p, null, 100);
//  $i = ob_get_contents();

//  ob_end_clean();

//     imagedestroy($image);
//     imagedestroy($image_p);
 
 
// imagejpeg(imagecreatefromstring($i), 'test_3.jpg');

 
        //error_reporting(E_ALL);

        // if( $ch = curl_init ())
        // {            
        //  curl_setopt ($ch, CURLOPT_URL, 'http://whatismyv6.com/'); 
        //  // curl_setopt ($ch, CURLOPT_TIMEOUT, 60); 
        //   curl_setopt($ch, CURLOPT_USERAGENT, 'Instagram 8.0.0 Android (18/4.3; 320dpi; 720x1280; Xiaomi; HM 1SW; armani; qcom; en_US)');
        //  curl_setopt ($ch, CURLOPT_PROXY, "104.156.229.189:30610"); 
        //  curl_setopt ($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); 
        // curl_setopt($ch, CURLOPT_VERBOSE, false);
        //  curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE); 
        //  curl_setopt ($ch, CURLOPT_FAILONERROR, true); 
        //  curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1); 
        //  curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'blackking:Name0123Space');
         
        //  $result = curl_exec($ch); 
        //  //print curl_errno ($ch); 
        //  //print $result; 
        //  echo $result;
        //  curl_close ($ch); 
        // } 
 // $romerPREDIS = '/Users/alex/home/dev/redis/predis/';
 // require $romerPREDIS.'autoload.php';


 //        Predis\Autoloader::register();

 //        $redis = new Predis\Client(array(
 //         "scheme" => "tcp",
 //         "host" => "127.0.0.1",
 //         "port" => 6379));


 //         $key = "names";


 
 //    while ( $redis->scard($key) > 0 ) {  
 //        $pieces = explode(" ",  $redis->spop($key));
 //        $check = $r->checkUsername($pieces[0]);
 //        if ($check['available'] == true) {
 //            $GLOBALS["username"] = $pieces[0];
 //            $GLOBALS["first_name"] = $pieces[1]." ".$pieces[2];
         
 //            break;
 //        }    

 
 //        sleep(1);
 //    } 
     


 //         $key = "proxy";
 
 //    while ( $redis->scard($key) > 0 ) {  
         
 //        echo $redis->spop($key). "\n";
 
 //        sleep(3);
 //    } 

$username = "tester123";
exec("/usr/local/bin/send-telegram.sh '$username --> fail to send message'  /dev/null 2>/dev/null &");

//  /dev/null 2>/dev/null &



// # array (
// #   'status' => 'ok',
// #   'user' => 
// #   array (
// #     'username' => 'suzannesvanevik',
// #     'usertags_count' => 1115,
// #     'has_anonymous_profile_picture' => false,
// #     'media_count' => 1022,
// #     'hd_profile_pic_versions' => 
// #     array (
// #       0 => 
// #       array (
// #         'url' => 'http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s320x320/12145429_927730610635383_1307205056_a.jpg',
// #         'width' => 320,
// #         'height' => 320,
// #       ),
// #       1 => 
// #       array (
// #         'url' => 'http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s640x640/12145429_927730610635383_1307205056_a.jpg',
// #         'width' => 640,
// #         'height' => 640,
// #       ),
// #     ),
// #     'following_count' => 368,
// #     'is_business' => false,
// #     'auto_expand_chaining' => false,
// #     'has_chaining' => true,
// #     'geo_media_count' => 249,
// #     'profile_pic_url' => 'http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s150x150/12145429_927730610635383_1307205056_a.jpg',
// #     'is_favorite' => false,
// #
// # Performance is beauty 🎀
// # Bergen Performance Center 🏋🏽
// # 📩 suzannesvanevik@gmail.com 
// # LIVE • LOVE • LIFT',
// #     'full_name' => 'S U Z A N N E  S V A N E V I K',
// #     'follower_count' => 216756,
// #     'pk' => 13226335,
// #     'hd_profile_pic_url_info' => 
// #     array (
// #       'url' => 'http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/12145429_927730610635383_1307205056_a.jpg',
// #       'width' => 948,
// #       'height' => 948,
// #     ),
// #     'is_private' => false,
// #     'external_url' => '',
// #   ),
// # )




//  http://blackking:Name0123Space@104.156.229.189:30616<-------------------------*********************
// REQUEST: users/check_username/
// DATA: ig_sig_key_version=4&signed_body=2591634f599f9da2c10883099cb6bad2a9f91631d1d27ed5d524af2bb5c619d6.%7B%22_uuid%22%3A%22cdb4f438-03b6-41dc-a946-f97ef4bfd914%22%2C%22username%22%3A%22rachelgross93%22%2C%22_csrftoken%22%3A%22missing%22%7D
// RESPONSE: {"username": "rachelgross93", "available": true, "status": "ok"}

// REQUEST: accounts/create/
// DATA: ig_sig_key_version=4&signed_body=6f48270960e52f106335bfcad228f3882af6977ab8e9d4ad4cbad7e3a41ef6c7.%7B%22phone_id%22%3A%22cdb4f438-03b6-41dc-a946-f97ef4bfd914%22%2C%22_csrftoken%22%3A%22missing%22%2C%22username%22%3A%22rachelgross93%22%2C%22first_name%22%3A%22%22%2C%22guid%22%3A%22cdb4f438-03b6-41dc-a946-f97ef4bfd914%22%2C%22device_id%22%3A%22android-684d3b0ea933702%22%2C%22email%22%3A%22igroma.yneedyouqwe12awqweqwqqer%40gmail.com%22%2C%22force_sign_up_code%22%3A%22%22%2C%22qs_stamp%22%3A%22%22%2C%22password%22%3A%22FJSD24P7%22%7D
// RESPONSE: {"status": "ok", "created_user": {"username": "rachelgross93", "has_anonymous_profile_picture": true, "nux_private_first_page": false, "profile_pic_url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/11906329_960233084022564_1448528159_a.jpg", "full_name": "", "pk": 3410235335, "hd_profile_pic_url_info": {"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/11906329_960233084022564_1448528159_a.jpg", "width": 150, "height": 150}, "nux_private_enabled": false, "is_private": false}, "account_created": true}

// array (
//   0 => 'HTTP/1.0 200 Connection established

// HTTP/1.1 200 OK
// Content-Language: en
// Expires: Sat, 01 Jan 2000 00:00:00 GMT
// Vary: Cookie, Accept-Language, Accept-Encoding
// Pragma: no-cache
// Cache-Control: private, no-cache, no-store, must-revalidate
// Date: Mon, 13 Jun 2016 18:38:07 GMT
// Content-Type: application/json
// Set-Cookie: csrftoken=142b2baeff1753a5d5b7494d3da5d67b; expires=Mon, 12-Jun-2017 18:38:07 GMT; Max-Age=31449600; Path=/
// Set-Cookie: s_network=; expires=Mon, 13-Jun-2016 19:38:07 GMT; Max-Age=3600; Path=/
// Set-Cookie: sessionid=IGSC213d97dea1e335afdd26eebeea5d27c06bd04b203a2666559e0fbd3811672460%3AY3DUkKuiYVE58jTSubPYpQQ19o1uB8ti%3A%7B%22_token_ver%22%3A2%2C%22_auth_user_id%22%3A3410235335%2C%22_token%22%3A%223410235335%3ATCNJ6sbGK1zaryilk8CayaG2bzDJTcxq%3A68c1ab84c86626fb7274bb6ce38aabf1fe795d3e1d34ddf0f13706971e17d276%22%2C%22asns%22%3A%7B%222001%3A19f0%3Aac00%3Ae9%3A66c7%3A10a5%3Abb95%3Afb13%22%3A20473%2C%22time%22%3A1465843087%7D%2C%22_auth_user_backend%22%3A%22accounts.backends.CaseInsensitiveModelBackend%22%2C%22last_refreshed%22%3A1465843087.853234%2C%22_platform%22%3A1%7D; expires=Sun, 11-Sep-2016 18:38:07 GMT; httponly; Max-Age=7776000; Path=/
// Set-Cookie: ds_user_id=3410235335; expires=Sun, 11-Sep-2016 18:38:07 GMT; Max-Age=7776000; Path=/
// Connection: keep-alive
// Content-Length: 524

// ',
//   1 => 
//   array (
//     'status' => 'ok',
//     'created_user' => 
//     array (
//       'username' => 'rachelgross93',
//       'has_anonymous_profile_picture' => true,
//       'nux_private_first_page' => false,
//       'profile_pic_url' => 'http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/11906329_960233084022564_1448528159_a.jpg',
//       'full_name' => '',
//       'pk' => 3410235335,
//       'hd_profile_pic_url_info' => 
//       array (
//         'url' => 'http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/11906329_960233084022564_1448528159_a.jpg',
//         'width' => 150,
//         'height' => 150,
//       ),
//       'nux_private_enabled' => false,
//       'is_private' => false,
//     ),
//     'account_created' => true,
//   ),
// )
// connection_established


//  PROX ---------->http://blackking:Name0123Space@104.156.229.189:30616


//  _proxy_------>http://blackking:Name0123Space@104.156.229.189:30616
// * Hostname 104.156.229.189 was found in DNS cache
// *   Trying 104.156.229.189...
// * Connected to 104.156.229.189 (104.156.229.189) port 30616 (#0)
// * Establish HTTP proxy tunnel to i.instagram.com:443
// * Proxy auth using Basic with user 'blackking'
// > CONNECT i.instagram.com:443 HTTP/1.1
// Host: i.instagram.com:443
// Proxy-Authorization: Basic YmxhY2traW5nOk5hbWUwMTIzU3BhY2U=
// User-Agent: Instagram 8.0.0 Android (18/4.3; 320dpi; 720x1280; Xiaomi; HM 1SW; armani; qcom; en_US)
// Proxy-Connection: Keep-Alive

// < HTTP/1.0 200 Connection established
// < 
// * Proxy replied OK to CONNECT request
// * TLS 1.2 connection using TLS_ECDHE_RSA_WITH_AES_128_GCM_SHA256
// * Server certificate: *.instagram.com
// * Server certificate: DigiCert SHA2 High Assurance Server CA
// * Server certificate: DigiCert High Assurance EV Root CA
// > POST /api/v1/accounts/change_profile_picture/ HTTP/1.1
// Host: i.instagram.com
// User-Agent: Instagram 8.0.0 Android (18/4.3; 320dpi; 720x1280; Xiaomi; HM 1SW; armani; qcom; en_US)
// Cookie: csrftoken=142b2baeff1753a5d5b7494d3da5d67b; ds_user_id=3410235335; mid=V179PgABAAHXbGPAOatlHiFb8foB; s_network=; sessionid=IGSC213d97dea1e335afdd26eebeea5d27c06bd04b203a2666559e0fbd3811672460%3AY3DUkKuiYVE58jTSubPYpQQ19o1uB8ti%3A%7B%22_token_ver%22%3A2%2C%22_auth_user_id%22%3A3410235335%2C%22_token%22%3A%223410235335%3ATCNJ6sbGK1zaryilk8CayaG2bzDJTcxq%3A68c1ab84c86626fb7274bb6ce38aabf1fe795d3e1d34ddf0f13706971e17d276%22%2C%22asns%22%3A%7B%222001%3A19f0%3Aac00%3Ae9%3A66c7%3A10a5%3Abb95%3Afb13%22%3A20473%2C%22time%22%3A1465843087%7D%2C%22_auth_user_backend%22%3A%22accounts.backends.CaseInsensitiveModelBackend%22%2C%22last_refreshed%22%3A1465843087.853234%2C%22_platform%22%3A1%7D
// Proxy-Connection: keep-alive
// Connection: keep-alive
// Accept: */*
// Content-type: multipart/form-data; boundary=18cd1d45-104f-4ec6-866b-8ad25a00b483
// Accept-Language: en-en
// Accept-Encoding: gzip, deflate
// Content-Length: 71741
// Expect: 100-continue

// < HTTP/1.1 100 Continue
// < Date: Mon, 13 Jun 2016 18:38:09 GMT
// * We are completely uploaded and fine
// < HTTP/1.1 200 OK
// < Server: nginx
// < Date: Mon, 13 Jun 2016 18:38:10 GMT
// < Content-Type: application/json
// < Content-Language: en
// < Content-Encoding: gzip
// < Expires: Sat, 01 Jan 2000 00:00:00 GMT
// < Vary: Cookie, Accept-Language, Accept-Encoding
// < Pragma: no-cache
// < Cache-Control: private, no-cache, no-store, must-revalidate
// * Replaced cookie csrftoken="142b2baeff1753a5d5b7494d3da5d67b" for domain i.instagram.com, path /, expire 1497292691
// < Set-Cookie: csrftoken=142b2baeff1753a5d5b7494d3da5d67b; expires=Mon, 12-Jun-2017 18:38:10 GMT; Max-Age=31449600; Path=/
// * Replaced cookie s_network="" for domain i.instagram.com, path /, expire 1465846691
// < Set-Cookie: s_network=; expires=Mon, 13-Jun-2016 19:38:10 GMT; Max-Age=3600; Path=/
// * Replaced cookie ds_user_id="3410235335" for domain i.instagram.com, path /, expire 1473619091
// < Set-Cookie: ds_user_id=3410235335; expires=Sun, 11-Sep-2016 18:38:10 GMT; Max-Age=7776000; Path=/
// < Connection: keep-alive
// < Content-Length: 321
// < 
// * Connection #0 to host 104.156.229.189 left intact
// {"_uuid":"18cd1d45-104f-4ec6-866b-8ad25a00b483","_uid":"3410235335","_csrftoken":"142b2baeff1753a5d5b7494d3da5d67b","external_url":"","phone_number":"","username":"rachelgross93","first_name":"Rachel Gross","biography":"Love or s _ x? ^^","email":"igroma.yneedyouqwe12awqweqwqqer@gmail.com","gender":2}REQUEST: accounts/edit_profile/
// DATA: ig_sig_key_version=4&signed_body=6218c57cf6f753796fa49e8c48ae8b45196f3aac8b833c6aabb28b559ba6750c.{"_uuid":"18cd1d45-104f-4ec6-866b-8ad25a00b483","_uid":"3410235335","_csrftoken":"142b2baeff1753a5d5b7494d3da5d67b","external_url":"","phone_number":"","username":"rachelgross93","first_name":"Rachel Gross","biography":"Love or s _ x? ^^","email":"igroma.yneedyouqwe12awqweqwqqer@gmail.com","gender":2}
// RESPONSE: {"status": "ok", "user": {"username": "rachelgross93", "phone_number": "", "has_anonymous_profile_picture": false, "hd_profile_pic_versions": [{"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s320x320/13413450_1761784037401767_952894660_a.jpg", "width": 320, "height": 320}], "gender": 2, "birthday": null, "profile_pic_url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s150x150/13413450_1761784037401767_952894660_a.jpg", "profile_pic_id": "1271906489581519467_3410235335", "biography": "Love or s _ x? ^^", "full_name": "Rachel Gross", "pk": 3410235335, "hd_profile_pic_url_info": {"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/13413450_1761784037401767_952894660_a.jpg", "width": 478, "height": 478}, "email": "igroma.yneedyouqwe12awqweqwqqer@gmail.com", "is_private": false, "external_url": ""}}

// * Hostname 104.156.229.189 was found in DNS cache
// *   Trying 104.156.229.189...
// * Connected to 104.156.229.189 (104.156.229.189) port 30616 (#0)
// * Establish HTTP proxy tunnel to i.instagram.com:443
// * Proxy auth using Basic with user 'blackking'
// > CONNECT i.instagram.com:443 HTTP/1.1
// Host: i.instagram.com:443
// Proxy-Authorization: Basic YmxhY2traW5nOk5hbWUwMTIzU3BhY2U=
// User-Agent: Instagram 8.0.0 Android (18/4.3; 320dpi; 720x1280; Xiaomi; HM 1SW; armani; qcom; en_US)
// Proxy-Connection: Keep-Alive

// < HTTP/1.0 200 Connection established
// < 
// * Proxy replied OK to CONNECT request
// * TLS 1.2 connection using TLS_ECDHE_RSA_WITH_AES_128_GCM_SHA256
// * Server certificate: *.instagram.com
// * Server certificate: DigiCert SHA2 High Assurance Server CA
// * Server certificate: DigiCert High Assurance EV Root CA
// > POST /api/v1/upload/photo/ HTTP/1.1
// Host: i.instagram.com
// User-Agent: Instagram 8.0.0 Android (18/4.3; 320dpi; 720x1280; Xiaomi; HM 1SW; armani; qcom; en_US)
// Cookie: csrftoken=142b2baeff1753a5d5b7494d3da5d67b; ds_user_id=3410235335; mid=V179PgABAAHXbGPAOatlHiFb8foB; s_network=; sessionid=IGSC213d97dea1e335afdd26eebeea5d27c06bd04b203a2666559e0fbd3811672460%3AY3DUkKuiYVE58jTSubPYpQQ19o1uB8ti%3A%7B%22_token_ver%22%3A2%2C%22_auth_user_id%22%3A3410235335%2C%22_token%22%3A%223410235335%3ATCNJ6sbGK1zaryilk8CayaG2bzDJTcxq%3A68c1ab84c86626fb7274bb6ce38aabf1fe795d3e1d34ddf0f13706971e17d276%22%2C%22asns%22%3A%7B%222001%3A19f0%3Aac00%3Ae9%3A66c7%3A10a5%3Abb95%3Afb13%22%3A20473%2C%22time%22%3A1465843087%7D%2C%22_auth_user_backend%22%3A%22accounts.backends.CaseInsensitiveModelBackend%22%2C%22last_refreshed%22%3A1465843087.853234%2C%22_platform%22%3A1%7D
// Connection: close
// Accept: */*
// Content-type: multipart/form-data; boundary=18cd1d45-104f-4ec6-866b-8ad25a00b483
// Content-Length: 71874
// Cookie2: $Version=1
// Accept-Language: en-US
// Accept-Encoding: gzip
// Expect: 100-continue

// < HTTP/1.1 100 Continue
// < Date: Mon, 13 Jun 2016 18:38:25 GMT
// * We are completely uploaded and fine
// < HTTP/1.1 200 OK
// < Server: nginx
// < Date: Mon, 13 Jun 2016 18:38:26 GMT
// < Content-Type: application/json
// < Content-Language: en
// < Expires: Sat, 01 Jan 2000 00:00:00 GMT
// < Vary: Cookie, Accept-Language
// < Pragma: no-cache
// < Cache-Control: private, no-cache, no-store, must-revalidate
// * Replaced cookie csrftoken="142b2baeff1753a5d5b7494d3da5d67b" for domain i.instagram.com, path /, expire 1497292706
// < Set-Cookie: csrftoken=142b2baeff1753a5d5b7494d3da5d67b; expires=Mon, 12-Jun-2017 18:38:26 GMT; Max-Age=31449600; Path=/
// * Replaced cookie ds_user_id="3410235335" for domain i.instagram.com, path /, expire 1473619106
// < Set-Cookie: ds_user_id=3410235335; expires=Sun, 11-Sep-2016 18:38:26 GMT; Max-Age=7776000; Path=/
// < Connection: close
// < Content-Length: 46
// < 
// * Closing connection 0
// RESPONSE: {"status": "ok", "upload_id": "1465843104098"}

// REQUEST: media/configure/
// DATA: ig_sig_key_version=4&signed_body=980fdbed59eca567b2a4baebacccd3ceab95d33cd4ca068f4727e32bda4a9046.{"upload_id":"1465843104098","camera_model":"HM1S","source_type":3,"date_time_original":"2016:06:13 18:38:26","camera_make":"XIAOMI","edits":{"crop_original_size":[478,478],"crop_zoom":1.3333334,"crop_center":[0,-0]},"extra":{"source_width":478,"source_height":478},"device":{"manufacturer":"Xiaomi","model":"HM 1SW","android_version":18,"android_release":"4.3"},"_csrftoken":"142b2baeff1753a5d5b7494d3da5d67b","_uuid":"18cd1d45-104f-4ec6-866b-8ad25a00b483","_uid":"3410235335","caption":"Wow) Do you like?"}
// RESPONSE: {"status": "ok", "media": {"taken_at": 1465843107, "pk": 1271906630426247792, "id": "1271906630426247792_3410235335", "device_timestamp": 1465843104098, "media_type": 1, "code": "BGmuFduBUJw", "client_cache_key": "MTI3MTkwNjYzMDQyNjI0Nzc5Mg==.2", "filter_type": 0, "image_versions2": {"candidates": [{"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/e35/13398414_1028322283910971_527592875_n.jpg?ig_cache_key=MTI3MTkwNjYzMDQyNjI0Nzc5Mg%3D%3D.2", "width": 478, "height": 478}, {"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/s320x320/e35/13398414_1028322283910971_527592875_n.jpg?ig_cache_key=MTI3MTkwNjYzMDQyNjI0Nzc5Mg%3D%3D.2", "width": 320, "height": 320}, {"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/s240x240/e35/13398414_1028322283910971_527592875_n.jpg?ig_cache_key=MTI3MTkwNjYzMDQyNjI0Nzc5Mg%3D%3D.2", "width": 240, "height": 240}, {"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/s150x150/e35/13398414_1028322283910971_527592875_n.jpg?ig_cache_key=MTI3MTkwNjYzMDQyNjI0Nzc5Mg%3D%3D.2", "width": 150, "height": 150}]}, "original_width": 478, "original_height": 478, "user": {"username": "rachelgross93", "has_anonymous_profile_picture": false, "is_unpublished": false, "profile_pic_url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s150x150/13413450_1761784037401767_952894660_a.jpg", "full_name": "Rachel Gross", "pk": 3410235335, "is_private": false}, "organic_tracking_token": "eyJ2ZXJzaW9uIjo1LCJwYXlsb2FkIjp7ImlzX2FuYWx5dGljc190cmFja2VkIjpmYWxzZSwidXVpZCI6IjJmMDEzMGFmZDlkNDQxNTRhMTY1YWFjY2ZhNGZiNDIyMTI3MTkwNjYzMDQyNjI0Nzc5MiIsInNlcnZlcl90b2tlbiI6IjE0NjU4NDMxMDc4NTd8MTI3MTkwNjYzMDQyNjI0Nzc5MnwzNDEwMjM1MzM1fDE0M2EzOTYyMWQ3OTY1OGYyNmQyZDExYTRkN2VmODljZGRlMzcwMWE0OTBhMmU1M2FkYTA3NjdhZWYyNmQ5OTgifSwic2lnbmF0dXJlIjoiIn0=", "has_liked": false, "has_more_comments": false, "max_num_visible_preview_comments": 4, "comments": [], "comment_count": 0, "caption": {"status": "Active", "user_id": 3410235335, "created_at_utc": 1465843107, "created_at": 1465843107, "bit_flags": 0, "user": {"username": "rachelgross93", "has_anonymous_profile_picture": false, "is_unpublished": false, "profile_pic_url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s150x150/13413450_1761784037401767_952894660_a.jpg", "full_name": "Rachel Gross", "pk": 3410235335, "is_private": false}, "content_type": "comment", "text": "Wow) Do you like?", "media_id": 1271906630426247792, "pk": 17848237786089336, "type": 1}, "caption_is_edited": false, "photo_of_you": false}, "upload_id": "1465843104098"}

// REQUEST: qe/expose/
// DATA: ig_sig_key_version=4&signed_body=1c7bbac2cfe40c8e9af68bf79d9a379d1e872f8f0422bb8253f669a3ed718ca3.{"_uuid":"18cd1d45-104f-4ec6-866b-8ad25a00b483","_uid":"3410235335","id":"3410235335","_csrftoken":"142b2baeff1753a5d5b7494d3da5d67b","experiment":"ig_android_profile_contextual_feed"}
// RESPONSE: {"status": "ok"}

// * Hostname 104.156.229.189 was found in DNS cache
// *   Trying 104.156.229.189...
// * Connected to 104.156.229.189 (104.156.229.189) port 30616 (#0)
// * Establish HTTP proxy tunnel to i.instagram.com:443
// * Proxy auth using Basic with user 'blackking'
// > CONNECT i.instagram.com:443 HTTP/1.1
// Host: i.instagram.com:443
// Proxy-Authorization: Basic YmxhY2traW5nOk5hbWUwMTIzU3BhY2U=
// User-Agent: Instagram 8.0.0 Android (18/4.3; 320dpi; 720x1280; Xiaomi; HM 1SW; armani; qcom; en_US)
// Proxy-Connection: Keep-Alive

// < HTTP/1.0 200 Connection established
// < 
// * Proxy replied OK to CONNECT request
// * TLS 1.2 connection using TLS_ECDHE_RSA_WITH_AES_128_GCM_SHA256
// * Server certificate: *.instagram.com
// * Server certificate: DigiCert SHA2 High Assurance Server CA
// * Server certificate: DigiCert High Assurance EV Root CA
// > POST /api/v1/upload/photo/ HTTP/1.1
// Host: i.instagram.com
// User-Agent: Instagram 8.0.0 Android (18/4.3; 320dpi; 720x1280; Xiaomi; HM 1SW; armani; qcom; en_US)
// Cookie: csrftoken=142b2baeff1753a5d5b7494d3da5d67b; ds_user_id=3410235335; mid=V179PgABAAHXbGPAOatlHiFb8foB; s_network=; sessionid=IGSC213d97dea1e335afdd26eebeea5d27c06bd04b203a2666559e0fbd3811672460%3AY3DUkKuiYVE58jTSubPYpQQ19o1uB8ti%3A%7B%22_token_ver%22%3A2%2C%22_auth_user_id%22%3A3410235335%2C%22_token%22%3A%223410235335%3ATCNJ6sbGK1zaryilk8CayaG2bzDJTcxq%3A68c1ab84c86626fb7274bb6ce38aabf1fe795d3e1d34ddf0f13706971e17d276%22%2C%22asns%22%3A%7B%222001%3A19f0%3Aac00%3Ae9%3A66c7%3A10a5%3Abb95%3Afb13%22%3A20473%2C%22time%22%3A1465843087%7D%2C%22_auth_user_backend%22%3A%22accounts.backends.CaseInsensitiveModelBackend%22%2C%22last_refreshed%22%3A1465843087.853234%2C%22_platform%22%3A1%7D
// Connection: close
// Accept: *
// Content-type: multipart/form-data; boundary=18cd1d45-104f-4ec6-866b-8ad25a00b483
// Content-Length: 66594
// Cookie2: $Version=1
// Accept-Language: en-US
// Accept-Encoding: gzip
// Expect: 100-continue

// < HTTP/1.1 100 Continue
// < Date: Mon, 13 Jun 2016 18:38:40 GMT
// * We are completely uploaded and fine
// < HTTP/1.1 200 OK
// < Server: nginx
// < Date: Mon, 13 Jun 2016 18:38:41 GMT
// < Content-Type: application/json
// < Content-Language: en
// < Expires: Sat, 01 Jan 2000 00:00:00 GMT
// < Vary: Cookie, Accept-Language
// < Pragma: no-cache
// < Cache-Control: private, no-cache, no-store, must-revalidate
// * Replaced cookie csrftoken="142b2baeff1753a5d5b7494d3da5d67b" for domain i.instagram.com, path /, expire 1497292722
// < Set-Cookie: csrftoken=142b2baeff1753a5d5b7494d3da5d67b; expires=Mon, 12-Jun-2017 18:38:41 GMT; Max-Age=31449600; Path=/
// * Replaced cookie ds_user_id="3410235335" for domain i.instagram.com, path /, expire 1473619122
// < Set-Cookie: ds_user_id=3410235335; expires=Sun, 11-Sep-2016 18:38:41 GMT; Max-Age=7776000; Path=/
// < Connection: close
// < Content-Length: 46
// < 
// * Closing connection 0
// RESPONSE: {"status": "ok", "upload_id": "1465843119469"}

// REQUEST: media/configure/
// DATA: ig_sig_key_version=4&signed_body=f8f96a7ba3d42537dd2fee5093756ff21963ad9bf8d1bbeeb2b549557b38efc6.{"upload_id":"1465843119469","camera_model":"HM1S","source_type":3,"date_time_original":"2016:06:13 18:38:42","camera_make":"XIAOMI","edits":{"crop_original_size":[640,640],"crop_zoom":1.3333334,"crop_center":[0,-0]},"extra":{"source_width":640,"source_height":640},"device":{"manufacturer":"Xiaomi","model":"HM 1SW","android_version":18,"android_release":"4.3"},"_csrftoken":"142b2baeff1753a5d5b7494d3da5d67b","_uuid":"18cd1d45-104f-4ec6-866b-8ad25a00b483","_uid":"3410235335","caption":"Wow) Do you like?"}
// RESPONSE: {"status": "ok", "media": {"taken_at": 1465843122, "pk": 1271906759015219829, "id": "1271906759015219829_3410235335", "device_timestamp": 1465843119469, "media_type": 1, "code": "BGmuHVehUJ1", "client_cache_key": "MTI3MTkwNjc1OTAxNTIxOTgyOQ==.2", "filter_type": 0, "image_versions2": {"candidates": [{"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/e35/13298018_109203629506060_398026500_n.jpg?ig_cache_key=MTI3MTkwNjc1OTAxNTIxOTgyOQ%3D%3D.2", "width": 640, "height": 640}, {"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/s480x480/e35/13298018_109203629506060_398026500_n.jpg?ig_cache_key=MTI3MTkwNjc1OTAxNTIxOTgyOQ%3D%3D.2", "width": 480, "height": 480}, {"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/s320x320/e35/13298018_109203629506060_398026500_n.jpg?ig_cache_key=MTI3MTkwNjc1OTAxNTIxOTgyOQ%3D%3D.2", "width": 320, "height": 320}, {"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/s240x240/e35/13298018_109203629506060_398026500_n.jpg?ig_cache_key=MTI3MTkwNjc1OTAxNTIxOTgyOQ%3D%3D.2", "width": 240, "height": 240}, {"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/s150x150/e35/13298018_109203629506060_398026500_n.jpg?ig_cache_key=MTI3MTkwNjc1OTAxNTIxOTgyOQ%3D%3D.2", "width": 150, "height": 150}]}, "original_width": 640, "original_height": 640, "user": {"username": "rachelgross93", "has_anonymous_profile_picture": false, "is_unpublished": false, "profile_pic_url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s150x150/13413450_1761784037401767_952894660_a.jpg", "full_name": "Rachel Gross", "pk": 3410235335, "is_private": false}, "organic_tracking_token": "eyJ2ZXJzaW9uIjo1LCJwYXlsb2FkIjp7ImlzX2FuYWx5dGljc190cmFja2VkIjpmYWxzZSwidXVpZCI6ImZiMmE3YWE3YWUxZjQ4ZGM5NjM0OWQ2MzFiYjZmN2UwMTI3MTkwNjc1OTAxNTIxOTgyOSIsInNlcnZlcl90b2tlbiI6IjE0NjU4NDMxMjMyMjJ8MTI3MTkwNjc1OTAxNTIxOTgyOXwzNDEwMjM1MzM1fGMxMDI5ZTQ5YTQ2ZjcxYjhiMzM5MWNiZjk3YTU2ZTgyNGI4MmVkMWRkNjBkNjZhYWNjNTYxNDNkNWUxYTJjMWQifSwic2lnbmF0dXJlIjoiIn0=", "has_liked": false, "has_more_comments": false, "max_num_visible_preview_comments": 4, "comments": [], "comment_count": 0, "caption": {"status": "Active", "user_id": 3410235335, "created_at_utc": 1465843123, "created_at": 1465843123, "bit_flags": 0, "user": {"username": "rachelgross93", "has_anonymous_profile_picture": false, "is_unpublished": false, "profile_pic_url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s150x150/13413450_1761784037401767_952894660_a.jpg", "full_name": "Rachel Gross", "pk": 3410235335, "is_private": false}, "content_type": "comment", "text": "Wow) Do you like?", "media_id": 1271906759015219829, "pk": 17848451701109682, "type": 1}, "caption_is_edited": false, "photo_of_you": false}, "upload_id": "1465843119469"}

// REQUEST: qe/expose/
// DATA: ig_sig_key_version=4&signed_body=1c7bbac2cfe40c8e9af68bf79d9a379d1e872f8f0422bb8253f669a3ed718ca3.{"_uuid":"18cd1d45-104f-4ec6-866b-8ad25a00b483","_uid":"3410235335","id":"3410235335","_csrftoken":"142b2baeff1753a5d5b7494d3da5d67b","experiment":"ig_android_profile_contextual_feed"}
// RESPONSE: {"status": "ok"}

// * Hostname 104.156.229.189 was found in DNS cache
// *   Trying 104.156.229.189...
// * Connected to 104.156.229.189 (104.156.229.189) port 30616 (#0)
// * Establish HTTP proxy tunnel to i.instagram.com:443
// * Proxy auth using Basic with user 'blackking'
// > CONNECT i.instagram.com:443 HTTP/1.1
// Host: i.instagram.com:443
// Proxy-Authorization: Basic YmxhY2traW5nOk5hbWUwMTIzU3BhY2U=
// User-Agent: Instagram 8.0.0 Android (18/4.3; 320dpi; 720x1280; Xiaomi; HM 1SW; armani; qcom; en_US)
// Proxy-Connection: Keep-Alive

// < HTTP/1.0 200 Connection established
// < 
// * Proxy replied OK to CONNECT request
// * TLS 1.2 connection using TLS_ECDHE_RSA_WITH_AES_128_GCM_SHA256
// * Server certificate: *.instagram.com
// * Server certificate: DigiCert SHA2 High Assurance Server CA
// * Server certificate: DigiCert High Assurance EV Root CA
// > POST /api/v1/upload/photo/ HTTP/1.1
// Host: i.instagram.com
// User-Agent: Instagram 8.0.0 Android (18/4.3; 320dpi; 720x1280; Xiaomi; HM 1SW; armani; qcom; en_US)
// Cookie: csrftoken=142b2baeff1753a5d5b7494d3da5d67b; ds_user_id=3410235335; mid=V179PgABAAHXbGPAOatlHiFb8foB; s_network=; sessionid=IGSC213d97dea1e335afdd26eebeea5d27c06bd04b203a2666559e0fbd3811672460%3AY3DUkKuiYVE58jTSubPYpQQ19o1uB8ti%3A%7B%22_token_ver%22%3A2%2C%22_auth_user_id%22%3A3410235335%2C%22_token%22%3A%223410235335%3ATCNJ6sbGK1zaryilk8CayaG2bzDJTcxq%3A68c1ab84c86626fb7274bb6ce38aabf1fe795d3e1d34ddf0f13706971e17d276%22%2C%22asns%22%3A%7B%222001%3A19f0%3Aac00%3Ae9%3A66c7%3A10a5%3Abb95%3Afb13%22%3A20473%2C%22time%22%3A1465843087%7D%2C%22_auth_user_backend%22%3A%22accounts.backends.CaseInsensitiveModelBackend%22%2C%22last_refreshed%22%3A1465843087.853234%2C%22_platform%22%3A1%7D
// Connection: close
// Accept: *
// Content-type: multipart/form-data; boundary=18cd1d45-104f-4ec6-866b-8ad25a00b483
// Content-Length: 126541
// Cookie2: $Version=1
// Accept-Language: en-US
// Accept-Encoding: gzip
// Expect: 100-continue

// < HTTP/1.1 100 Continue
// < Date: Mon, 13 Jun 2016 18:38:56 GMT
// * We are completely uploaded and fine
// < HTTP/1.1 200 OK
// < Server: nginx
// < Date: Mon, 13 Jun 2016 18:38:59 GMT
// < Content-Type: application/json
// < Content-Language: en
// < Expires: Sat, 01 Jan 2000 00:00:00 GMT
// < Vary: Cookie, Accept-Language
// < Pragma: no-cache
// < Cache-Control: private, no-cache, no-store, must-revalidate
// * Replaced cookie csrftoken="142b2baeff1753a5d5b7494d3da5d67b" for domain i.instagram.com, path /, expire 1497292739
// < Set-Cookie: csrftoken=142b2baeff1753a5d5b7494d3da5d67b; expires=Mon, 12-Jun-2017 18:38:59 GMT; Max-Age=31449600; Path=/
// * Replaced cookie ds_user_id="3410235335" for domain i.instagram.com, path /, expire 1473619139
// < Set-Cookie: ds_user_id=3410235335; expires=Sun, 11-Sep-2016 18:38:59 GMT; Max-Age=7776000; Path=/
// < Connection: close
// < Content-Length: 46
// < 
// * Closing connection 0
// RESPONSE: {"status": "ok", "upload_id": "1465843134667"}

// REQUEST: media/configure/
// DATA: ig_sig_key_version=4&signed_body=d57eb1c9485a7732a7c85cf130199d2f5d7db01cb98714f70aa4b8656a90474e.{"upload_id":"1465843134667","camera_model":"HM1S","source_type":3,"date_time_original":"2016:06:13 18:38:59","camera_make":"XIAOMI","edits":{"crop_original_size":[400,400],"crop_zoom":1.3333334,"crop_center":[0,-0]},"extra":{"source_width":400,"source_height":400},"device":{"manufacturer":"Xiaomi","model":"HM 1SW","android_version":18,"android_release":"4.3"},"_csrftoken":"142b2baeff1753a5d5b7494d3da5d67b","_uuid":"18cd1d45-104f-4ec6-866b-8ad25a00b483","_uid":"3410235335","caption":"Wow) Do you like?"}
// RESPONSE: {"status": "ok", "media": {"taken_at": 1465843141, "pk": 1271906914867167866, "id": "1271906914867167866_3410235335", "device_timestamp": 1465843134667, "media_type": 1, "code": "BGmuJmoBUJ6", "client_cache_key": "MTI3MTkwNjkxNDg2NzE2Nzg2Ng==.2", "filter_type": 0, "image_versions2": {"candidates": [{"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/e35/13391108_542813085925277_1367422999_n.jpg?ig_cache_key=MTI3MTkwNjkxNDg2NzE2Nzg2Ng%3D%3D.2", "width": 400, "height": 400}, {"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/s320x320/e35/13391108_542813085925277_1367422999_n.jpg?ig_cache_key=MTI3MTkwNjkxNDg2NzE2Nzg2Ng%3D%3D.2", "width": 320, "height": 320}, {"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/s240x240/e35/13391108_542813085925277_1367422999_n.jpg?ig_cache_key=MTI3MTkwNjkxNDg2NzE2Nzg2Ng%3D%3D.2", "width": 240, "height": 240}, {"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/s150x150/e35/13391108_542813085925277_1367422999_n.jpg?ig_cache_key=MTI3MTkwNjkxNDg2NzE2Nzg2Ng%3D%3D.2", "width": 150, "height": 150}]}, "original_width": 400, "original_height": 400, "user": {"username": "rachelgross93", "has_anonymous_profile_picture": false, "is_unpublished": false, "profile_pic_url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s150x150/13413450_1761784037401767_952894660_a.jpg", "full_name": "Rachel Gross", "pk": 3410235335, "is_private": false}, "organic_tracking_token": "eyJ2ZXJzaW9uIjo1LCJwYXlsb2FkIjp7ImlzX2FuYWx5dGljc190cmFja2VkIjpmYWxzZSwidXVpZCI6IjQ2ZTAzOTI5NTQxODQ4YjZiOGY4OWYyYWNjOGNkNWU2MTI3MTkwNjkxNDg2NzE2Nzg2NiIsInNlcnZlcl90b2tlbiI6IjE0NjU4NDMxNDE3OTh8MTI3MTkwNjkxNDg2NzE2Nzg2NnwzNDEwMjM1MzM1fGVhNjNlM2UyN2MxMDE2MWYyNzJjZjIwNjI2YmUwNzUyMTFhY2Y1ZDY3ZDliMzQ2NGI1YWJmM2Y1OTgzODdhMjkifSwic2lnbmF0dXJlIjoiIn0=", "has_liked": false, "has_more_comments": false, "max_num_visible_preview_comments": 4, "comments": [], "comment_count": 0, "caption": {"status": "Active", "user_id": 3410235335, "created_at_utc": 1465843141, "created_at": 1465843141, "bit_flags": 0, "user": {"username": "rachelgross93", "has_anonymous_profile_picture": false, "is_unpublished": false, "profile_pic_url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s150x150/13413450_1761784037401767_952894660_a.jpg", "full_name": "Rachel Gross", "pk": 3410235335, "is_private": false}, "content_type": "comment", "text": "Wow) Do you like?", "media_id": 1271906914867167866, "pk": 17848255651112833, "type": 1}, "caption_is_edited": false, "photo_of_you": false}, "upload_id": "1465843134667"}

// REQUEST: qe/expose/
// DATA: ig_sig_key_version=4&signed_body=1c7bbac2cfe40c8e9af68bf79d9a379d1e872f8f0422bb8253f669a3ed718ca3.{"_uuid":"18cd1d45-104f-4ec6-866b-8ad25a00b483","_uid":"3410235335","id":"3410235335","_csrftoken":"142b2baeff1753a5d5b7494d3da5d67b","experiment":"ig_android_profile_contextual_feed"}
// RESPONSE: {"status": "ok"}

// * Hostname 104.156.229.189 was found in DNS cache
// *   Trying 104.156.229.189...
// * Connected to 104.156.229.189 (104.156.229.189) port 30616 (#0)
// * Establish HTTP proxy tunnel to i.instagram.com:443
// * Proxy auth using Basic with user 'blackking'
// > CONNECT i.instagram.com:443 HTTP/1.1
// Host: i.instagram.com:443
// Proxy-Authorization: Basic YmxhY2traW5nOk5hbWUwMTIzU3BhY2U=
// User-Agent: Instagram 8.0.0 Android (18/4.3; 320dpi; 720x1280; Xiaomi; HM 1SW; armani; qcom; en_US)
// Proxy-Connection: Keep-Alive

// < HTTP/1.0 200 Connection established
// < 
// * Proxy replied OK to CONNECT request
// * TLS 1.2 connection using TLS_ECDHE_RSA_WITH_AES_128_GCM_SHA256
// * Server certificate: *.instagram.com
// * Server certificate: DigiCert SHA2 High Assurance Server CA
// * Server certificate: DigiCert High Assurance EV Root CA
// > POST /api/v1/upload/photo/ HTTP/1.1
// Host: i.instagram.com
// User-Agent: Instagram 8.0.0 Android (18/4.3; 320dpi; 720x1280; Xiaomi; HM 1SW; armani; qcom; en_US)
// Cookie: csrftoken=142b2baeff1753a5d5b7494d3da5d67b; ds_user_id=3410235335; mid=V179PgABAAHXbGPAOatlHiFb8foB; s_network=; sessionid=IGSC213d97dea1e335afdd26eebeea5d27c06bd04b203a2666559e0fbd3811672460%3AY3DUkKuiYVE58jTSubPYpQQ19o1uB8ti%3A%7B%22_token_ver%22%3A2%2C%22_auth_user_id%22%3A3410235335%2C%22_token%22%3A%223410235335%3ATCNJ6sbGK1zaryilk8CayaG2bzDJTcxq%3A68c1ab84c86626fb7274bb6ce38aabf1fe795d3e1d34ddf0f13706971e17d276%22%2C%22asns%22%3A%7B%222001%3A19f0%3Aac00%3Ae9%3A66c7%3A10a5%3Abb95%3Afb13%22%3A20473%2C%22time%22%3A1465843087%7D%2C%22_auth_user_backend%22%3A%22accounts.backends.CaseInsensitiveModelBackend%22%2C%22last_refreshed%22%3A1465843087.853234%2C%22_platform%22%3A1%7D
// Connection: close
// Accept: 
// Content-type: multipart/form-data; boundary=18cd1d45-104f-4ec6-866b-8ad25a00b483
// Content-Length: 121921
// Cookie2: $Version=1
// Accept-Language: en-US
// Accept-Encoding: gzip
// Expect: 100-continue

// < HTTP/1.1 100 Continue
// < Date: Mon, 13 Jun 2016 18:39:14 GMT
// * We are completely uploaded and fine
// < HTTP/1.1 200 OK
// < Server: nginx
// < Date: Mon, 13 Jun 2016 18:39:16 GMT
// < Content-Type: application/json
// < Content-Language: en
// < Expires: Sat, 01 Jan 2000 00:00:00 GMT
// < Vary: Cookie, Accept-Language
// < Pragma: no-cache
// < Cache-Control: private, no-cache, no-store, must-revalidate
// * Replaced cookie csrftoken="142b2baeff1753a5d5b7494d3da5d67b" for domain i.instagram.com, path /, expire 1497292756
// < Set-Cookie: csrftoken=142b2baeff1753a5d5b7494d3da5d67b; expires=Mon, 12-Jun-2017 18:39:16 GMT; Max-Age=31449600; Path=/
// * Replaced cookie ds_user_id="3410235335" for domain i.instagram.com, path /, expire 1473619156
// < Set-Cookie: ds_user_id=3410235335; expires=Sun, 11-Sep-2016 18:39:16 GMT; Max-Age=7776000; Path=/
// < Connection: close
// < Content-Length: 46
// < 
// * Closing connection 0
// RESPONSE: {"status": "ok", "upload_id": "1465843153567"}

// REQUEST: media/configure/
// DATA: ig_sig_key_version=4&signed_body=a89629f07b20ac32505a9a796f77a6455cdf7190ff0a20c1a6d2fe31631cca45.{"upload_id":"1465843153567","camera_model":"HM1S","source_type":3,"date_time_original":"2016:06:13 18:39:16","camera_make":"XIAOMI","edits":{"crop_original_size":[500,500],"crop_zoom":1.3333334,"crop_center":[0,-0]},"extra":{"source_width":500,"source_height":500},"device":{"manufacturer":"Xiaomi","model":"HM 1SW","android_version":18,"android_release":"4.3"},"_csrftoken":"142b2baeff1753a5d5b7494d3da5d67b","_uuid":"18cd1d45-104f-4ec6-866b-8ad25a00b483","_uid":"3410235335","caption":"Wow) Do you like?"}
// RESPONSE: {"status": "ok", "media": {"taken_at": 1465843157, "pk": 1271907048816460415, "id": "1271907048816460415_3410235335", "device_timestamp": 1465843153567, "media_type": 1, "code": "BGmuLjYBUJ_", "client_cache_key": "MTI3MTkwNzA0ODgxNjQ2MDQxNQ==.2", "filter_type": 0, "image_versions2": {"candidates": [{"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/e35/13388473_1737742199828813_1818836340_n.jpg?ig_cache_key=MTI3MTkwNzA0ODgxNjQ2MDQxNQ%3D%3D.2", "width": 500, "height": 500}, {"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/s320x320/e35/13388473_1737742199828813_1818836340_n.jpg?ig_cache_key=MTI3MTkwNzA0ODgxNjQ2MDQxNQ%3D%3D.2", "width": 320, "height": 320}, {"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/s240x240/e35/13388473_1737742199828813_1818836340_n.jpg?ig_cache_key=MTI3MTkwNzA0ODgxNjQ2MDQxNQ%3D%3D.2", "width": 240, "height": 240}, {"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/s150x150/e35/13388473_1737742199828813_1818836340_n.jpg?ig_cache_key=MTI3MTkwNzA0ODgxNjQ2MDQxNQ%3D%3D.2", "width": 150, "height": 150}]}, "original_width": 500, "original_height": 500, "user": {"username": "rachelgross93", "has_anonymous_profile_picture": false, "is_unpublished": false, "profile_pic_url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s150x150/13413450_1761784037401767_952894660_a.jpg", "full_name": "Rachel Gross", "pk": 3410235335, "is_private": false}, "organic_tracking_token": "eyJ2ZXJzaW9uIjo1LCJwYXlsb2FkIjp7ImlzX2FuYWx5dGljc190cmFja2VkIjpmYWxzZSwidXVpZCI6IjRhMGQzMmQ5YjU5OTQ5YTlhYWI2NjBmNjhiN2E1MTZkMTI3MTkwNzA0ODgxNjQ2MDQxNSIsInNlcnZlcl90b2tlbiI6IjE0NjU4NDMxNTc3OTB8MTI3MTkwNzA0ODgxNjQ2MDQxNXwzNDEwMjM1MzM1fGIzYzAzMGI3MjMyOWJmNzY2N2E0ZWIxZTc0ZGZkY2M1M2Y4ZjUxNDBlYjljNzRmM2Y0YjNlYjg0ZmRkZjhiNjkifSwic2lnbmF0dXJlIjoiIn0=", "has_liked": false, "has_more_comments": false, "max_num_visible_preview_comments": 4, "comments": [], "comment_count": 0, "caption": {"status": "Active", "user_id": 3410235335, "created_at_utc": 1465843157, "created_at": 1465843157, "bit_flags": 0, "user": {"username": "rachelgross93", "has_anonymous_profile_picture": false, "is_unpublished": false, "profile_pic_url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s150x150/13413450_1761784037401767_952894660_a.jpg", "full_name": "Rachel Gross", "pk": 3410235335, "is_private": false}, "content_type": "comment", "text": "Wow) Do you like?", "media_id": 1271907048816460415, "pk": 17858342170018747, "type": 1}, "caption_is_edited": false, "photo_of_you": false}, "upload_id": "1465843153567"}

// REQUEST: qe/expose/
// DATA: ig_sig_key_version=4&signed_body=1c7bbac2cfe40c8e9af68bf79d9a379d1e872f8f0422bb8253f669a3ed718ca3.{"_uuid":"18cd1d45-104f-4ec6-866b-8ad25a00b483","_uid":"3410235335","id":"3410235335","_csrftoken":"142b2baeff1753a5d5b7494d3da5d67b","experiment":"ig_android_profile_contextual_feed"}
// RESPONSE: {"status": "ok"}

// photo downloaded!
// REQUEST: accounts/set_private/
// DATA: ig_sig_key_version=4&signed_body=a60e3841ee9bf82f1af585793e7a54da1b6884cdf33dc14d89b64f72b45e6eda.{"_uuid":"18cd1d45-104f-4ec6-866b-8ad25a00b483","_uid":"3410235335","_csrftoken":"142b2baeff1753a5d5b7494d3da5d67b"}
// RESPONSE: {"status": "ok", "user": {"username": "rachelgross93", "has_anonymous_profile_picture": false, "profile_pic_url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s150x150/13413450_1761784037401767_952894660_a.jpg", "biography": "Love or s _ x? ^^", "full_name": "Rachel Gross", "pk": 3410235335, "is_private": true, "external_url": ""}}

// * Hostname in DNS cache was stale, zapped
// *   Trying 104.156.229.189...
// * Connected to 104.156.229.189 (104.156.229.189) port 30616 (#0)
// * Establish HTTP proxy tunnel to i.instagram.com:443
// * Proxy auth using Basic with user 'blackking'
// > CONNECT i.instagram.com:443 HTTP/1.1
// Host: i.instagram.com:443
// Proxy-Authorization: Basic YmxhY2traW5nOk5hbWUwMTIzU3BhY2U=
// User-Agent: Instagram 8.0.0 Android (18/4.3; 320dpi; 720x1280; Xiaomi; HM 1SW; armani; qcom; en_US)
// Proxy-Connection: Keep-Alive

// < HTTP/1.0 200 Connection established
// < 
// * Proxy replied OK to CONNECT request
// * TLS 1.2 connection using TLS_ECDHE_RSA_WITH_AES_128_GCM_SHA256
// * Server certificate: *.instagram.com
// * Server certificate: DigiCert SHA2 High Assurance Server CA
// * Server certificate: DigiCert High Assurance EV Root CA
// > POST /api/v1/direct_v2/threads/broadcast/media_share/?media_type=photo HTTP/1.1
// Host: i.instagram.com
// User-Agent: Instagram 8.0.0 Android (18/4.3; 320dpi; 720x1280; Xiaomi; HM 1SW; armani; qcom; en_US)
// Cookie: csrftoken=142b2baeff1753a5d5b7494d3da5d67b; ds_user_id=3410235335; mid=V179PgABAAHXbGPAOatlHiFb8foB; s_network=; sessionid=IGSC213d97dea1e335afdd26eebeea5d27c06bd04b203a2666559e0fbd3811672460%3AY3DUkKuiYVE58jTSubPYpQQ19o1uB8ti%3A%7B%22_token_ver%22%3A2%2C%22_auth_user_id%22%3A3410235335%2C%22_token%22%3A%223410235335%3ATCNJ6sbGK1zaryilk8CayaG2bzDJTcxq%3A68c1ab84c86626fb7274bb6ce38aabf1fe795d3e1d34ddf0f13706971e17d276%22%2C%22asns%22%3A%7B%222001%3A19f0%3Aac00%3Ae9%3A66c7%3A10a5%3Abb95%3Afb13%22%3A20473%2C%22time%22%3A1465843087%7D%2C%22_auth_user_backend%22%3A%22accounts.backends.CaseInsensitiveModelBackend%22%2C%22last_refreshed%22%3A1465843087.853234%2C%22_platform%22%3A1%7D
// Proxy-Connection: keep-alive
// Connection: keep-alive
// Accept: *
// Content-type: multipart/form-data; boundary=18cd1d45-104f-4ec6-866b-8ad25a00b483
// Accept-Language: en-en
// Content-Length: 750


// $first_name = "asd as";
//     $smiles_list =  ["\u{1F60C}" ,"\u{1F60D}" , "\u{1F61A}"  ,"\u{1F618}", "\u{2764}", "\u{1F64C}"];
//                 $smiles_hi =  ["\u{26A1}", "\u{1F48B}","\u{1F609}", "\u{1F633}", "\u{1F60C}" , "\u{1F61A}"  ,"\u{1F618}", "\u{270C}", "\u{1F47B}", "\u{1F525}", "\u{1F607}", "\u{1F617}", "\u{1F619}", "\u{1F60E}", "\u{1F61C}", "\u{270B}",  "\u{1F60B}"];
//                 $smiles =  ["\u{1F609}", "\u{1F60C}", "\u{1F46B}" ];    
//                 $cursors = ["\u{261D}" , "\u{2B06}", "\u{2934}", "\u{1F53C}", "\u{1F51D}" ];  
//                 $cur = $cursors[mt_rand(0, count($cursors) - 1)];
//                 $smi = $smiles_list[mt_rand(0, count($smiles_list) - 1)];
//                 $smi_hi = $smiles_hi[mt_rand(0, count($smiles_hi) - 1)];
//                 $smil = $smiles[mt_rand(0, count($smiles) - 1)];
//                 $first_name_txt = explode(" ",$first_name);
//                 $hi_word = ["Hey! What's up? I am", "Hi! I am", "Hey there, I am"];
//                 $hiw = $hi_word[mt_rand(0, count($hi_word) - 1)];

//              echo   $text = "$hiw $first_name_txt[0] $smi_hi  I am searching for a partner $smil  Please, S_I_G_N U_P by аddrеss in @kupit_nike profile $cur $cur $cur and write me there $smi";


 //        curl_setopt($ch, CURLOPT_URL, Constants::API_URL.$endpoint);
 //        curl_setopt($ch, CURLOPT_USERAGENT, Constants::USER_AGENT);
 //        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 //         curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
 //        curl_setopt($ch, CURLOPT_HEADER, true);
 //        curl_setopt($ch, CURLOPT_VERBOSE, false);
 //        curl_setopt($ch, CURLOPT_PROXY, $this->proxy ); 
 //        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); 
 //        curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'blackking:Name0123Space');


 // // 