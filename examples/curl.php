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


$json = '{
    "status": "ok",
    "big_list": true,
    "users": [{
        "username": "asl.mert",
        "has_anonymous_profile_picture": true,
        "profile_pic_url": "http://scontent-lhr3-1.cdninstagram.com/t51.2885-19/11906329_960233084022564_1448528159_a.jpg",
        "full_name": "Asl\u0131 Mert",
        "pk": 3294959691,
        "is_verified": false,
        "is_private": false
    },{
        "username": "ali_mashaikhi",
        "has_anonymous_profile_picture": false,
        "profile_pic_url": "http://scontent-lhr3-1.cdninstagram.com/t51.2885-19/s150x150/13116539_277661979235903_421638637_a.jpg",
        "full_name": "~\u00b0\u25cf( \u0639\u0644\u064a \u0622\u0625\u0644\u0645\u0640\u2665\u0328\u0325\u032c\u0329\u0634\u0622\u0625\u064a\u062e\u064a )\u25cf\u00b0~",
        "pk": 1269703933,
        "is_verified": false,
        "is_private": false
    }],
    "page_size": 200,
    "next_max_id": "AQDoABpB7cRzDcTsdQeb7JDFAw-v_muGDyD7ljq72ujH6-ejagHcg4wdtQvx2hUs9by4NIxcV_i8kMRy1mfScjvh18axrt12ww8QIdQCCt7sba21LUsBdKh2vUX4bZhO700"
  }';

$obj = json_decode($json);

$next_max_id = $obj->{'next_max_id'};

echo $next_max_id;

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