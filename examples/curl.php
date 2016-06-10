<?php

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

$sss  = 'asdaاasdasdasd';
// echo $sss;


$arabic = is_arabic($sss); 
var_dump($arabic);



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

 // 
 //        //error_reporting(E_ALL);

 //        if( $ch = curl_init ())
 //        {            
 //         curl_setopt ($ch, CURLOPT_URL, 'http://google.com'); 
 //         curl_setopt ($ch, CURLOPT_TIMEOUT, 60); 
 //         curl_setopt ($ch, CURLOPT_PROXY, "45.55.178.19:5013"); 
 //         curl_setopt ($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); 
 //         curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE); 
 //         curl_setopt ($ch, CURLOPT_FAILONERROR, true); 
 //         curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1); 
 //         curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'blackking:Name0123Space');
         
 //         $result = curl_exec($ch); 
 //         //print curl_errno ($ch); 
 //         //print $result; 
 //         echo $result;
 //         curl_close ($ch); 
 //        } 
 // 