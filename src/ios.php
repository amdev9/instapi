<?php

 
class InstaOS  extends Threaded
{
  protected $username;            // Instagram username
  protected $password;            // Instagram password
  protected $debug;               // Debug

  protected $proxy;
  protected $proxy_auth_credentials;
  
  protected $uuid;                // UUID
  protected $device_id;           // Device ID
  protected $username_id;         // Username ID
  protected $token;               // _csrftoken
  protected $isLoggedIn = false;  // Session status
  protected $rank_token;          // Rank token
  protected $IGDataPath;          // Data storage path
 
  protected $waterfall_id;
  protected $phone_id;

////
  protected $advertiser_id;
  protected $anon_id;
  protected $session_id;


public function run() {   
    
      $this->redis = $this->worker->getConnection();
      $this->debug = true;
      $IGDataPath = null;
      $this->UA = 'Instagram 9.6.0 (iPhone8,1; iPhone OS 9_3_1; en_US; en-US; scale=2.00; 750x1334) AppleWebKit/420+';
      
      $this->uuid = $this->generateUUID(true);
      $this->waterfall_id =  $this->generateUUID(true);

      ////
      $this->advertiser_id = $this->generateUUID(true);
      $this->anon_id = $this->generateUUID(true);
      $this->session_id = $this->generateUUID(true);
      ////

      // this data from redis
      $proxy_string = $this->redis->spop('proxy');
      $exploded_proxy = explode(":", $proxy_string);

      $this->proxy = $exploded_proxy[0].":".$exploded_proxy[1];  
      $this->proxy_auth_credentials = $exploded_proxy[2].":".$exploded_proxy[3];  
      echo  $exploded_proxy[0].":".$exploded_proxy[1];  
      echo  $exploded_proxy[2].":".$exploded_proxy[3];  

      $line_inst = $this->redis->spop('line_inst');
      $this->password = explode("|", $line_inst)[0];  
      $this->email = explode("|", $line_inst)[1]; 
      $this->full_name =  explode("|", $line_inst)[4]; 
      
      // $bioparse = explode("|", $line_inst)[2];  
      // $captionparse = explode("|", $line_inst)[3]; 
      // $this->phone = ""; 


      if (!is_null($IGDataPath)) {
          $this->IGDataPath = $IGDataPath;
      } else {
          $this->IGDataPath = __DIR__.DIRECTORY_SEPARATOR.'dataios'.DIRECTORY_SEPARATOR;
      }

      // $this->setUser($username, $password);


      $this->syncFeaturesRegister();
      $this->show_continue_as();

      $this->graphFb();
      $this->graphFb_activities_appinstall();
      $this->graphFb_activities_appevents();

      $this->check_email();
      $this->username_suggestions();
      $this->check_username();
      $result =  $this->create();
      if (isset($result[1]['errors'])) {
        echo "ERROR <<<<<<<<";
        return;
      }

      $this->sync();
      $this->ayml();

      $this->autocomplete_user_list();
      $this->direct_inbox();
      $this->ranked_recipients();
      $this->timeline();


      $this->inbox();
      $this->reels_tray();
      $this->discover_explore();
      $this->channels_home();

      $user_ids = ['12335461' ,'49742317']; 
      $removed_ids = $user_ids;
      $user_ids_new = ['230581164'];
      $res = $this->upload_photo('/Users/alex/Desktop/other/4.jpg', '', $user_ids); // return media id
      $media_id = $res['media']['pk'];
      $this->edit_photo_tag($media_id, $removed_ids, $user_ids_new);

      // $this->current_user_edit();
      // $site = "analiesecoleman.tumblr.com"; //$this->redis->spop('links_t');
      // $this->edit_profile($site);

      // $fs = $this->followers('2058338792');
      // for($iter = 0; $iter < count($fs[1]['users']); $iter++) { 
      //   $this->redis->sadd('detect', $fs[1]['users'][$iter]['pk'] );
      // } 
      // $fs_next = $this->followers('2058338792', $fs[1]['next_max_id']);
      // for($iter = 0; $iter < count($fs_next[1]['users']); $iter++) { 
      //   $this->redis->sadd('detect', $fs_next[1]['users'][$iter]['pk'] );
      // } 
      // $fs_next = $this->followers('2058338792', $fs_next[1]['next_max_id']);
      // for($iter = 0; $iter < count($fs_next[1]['users']); $iter++) { 
      //   $this->redis->sadd('detect', $fs_next[1]['users'][$iter]['pk'] );
      // } 

      // $this->funcrecur();
 }


 protected function buildBody($bodies, $boundary)
    {
        $body = '';
        foreach ($bodies as $b) {
            $body .= '--'.$boundary."\r\n";
            $body .= 'Content-Disposition: '.$b['type'].'; name="'.$b['name'].'"';
            if (isset($b['filename'])) {
                // $ext = pathinfo($b['filename'], PATHINFO_EXTENSION);
                $body .= '; filename="photo"';
            }
            if (isset($b['headers']) && is_array($b['headers'])) {
                foreach ($b['headers'] as $header) {
                    $body .= "\r\n".$header;
                }
            }

            $body .= "\r\n\r\n".$b['data']."\r\n";
        }
        $body .= '--'.$boundary.'--';

        return $body;
    }




public function edit_photo_tag($media_id, $removed_ids, $user_ids) {

    
 $result_string_removed = "";
    $result_string_added = "";


  $inter = 1;
  $del_y = 5.1;
  $del_x = 4.1;

  $interpol_x =  $inter / $del_x;
  $interpol_y =  $inter / $del_y;

 

  $y = 1;
  $counter = 1;
  foreach ($user_ids as $user_id ) {

    $x_pos = round($counter*$interpol_x,7);
  $y_pos = round($y*$interpol_y,7);
  echo "--\n";
    if ($counter % 4 == 0) {
      $counter = 0;
      $y = $y + 1;
    }
  // $y = $counter * $interpol;
  // echo $y."\n";
  // $x =  $counter * $interpol ;
  // echo $x."\n";
 
  // $x_pos = round($x *  $interpol, 7);
  // $y_pos = round($y *  $interpol, 7);


  $added_user_string = '{"user_id":"'. $user_id .'","position":['. $x_pos .','. $y_pos .']}'; 
  $result_string_added =  $result_string_added . ",".$added_user_string;
    $counter = $counter + 1;
  }
  $final_added_string = '"in":['. $result_string_added .']';
//  $final_string =  "{".$final_added_string."}";

   
    foreach ($removed_ids as $removed_user_id ) {
       $removed_user_string = '"'. $removed_user_id .'"'; 
       $result_string_removed =  $result_string_removed . ",".$removed_user_string;
    }

 

    $final_removed_string = '"removed":['.  $result_string_removed .']';
   
    $final_string =  "{".$final_removed_string.",".$final_added_string."}";

 // "usertags":"{\"removed\":[\"12335461\",\"49742317\"],\"in\":[{\"user_id\":\"230581164\",\"position\":[0.2374999970197678,0.3046875]}]}" 


 

    $data = json_encode([ 
      "_csrftoken"  => $this->token,
      "_uuid" => $this->uuid,//"F30F7D45-024B-478A-A1FC-75EC32B2F629",
      "_uid"  => $this->username_id, //"1009845355",
      "usertags"  =>"{\"removed\":[\"358954311\"],\"in\":[{\"user_id\":\"2243739473\",\"position\":[0.4234375059604645,0.2906250059604645]}]}"
    ]);

  $outputs = $this->request('https://i.instagram.com/api/v1/media/'.$media_id.'_'.$this->username_id.'/edit_media/', $this->generateSignature( $data ));

//   POST https://i.instagram.com/api/v1/media/1385227495502326628_1009845355/edit_media/ HTTP/1.1
// Host: i.instagram.com
// Accept: *
// Proxy-Connection: keep-alive
// X-IG-Connection-Type: WiFi
// Accept-Encoding: gzip, deflate
// Accept-Language: ru-RU;q=1
// Content-Type: application/x-www-form-urlencoded; charset=UTF-8
// Content-Length: 480
// User-Agent: Instagram 9.7.0 (iPhone6,1; iPhone OS 9_3_5; ru_RU; ru-RU; scale=2.00; 640x1136) AppleWebKit/420+
// Connection: keep-alive
// X-IG-Capabilities: 3wo=
// Cookie: csrftoken=69TaTIL4lXzNLNVOjZhjHopy7fAYzbDk; ds_user=4ewir; ds_user_id=1009845355; igfl=4ewir; is_starred_enabled=yes; mid=Vt9VQAAAAAFs7QCccW9eS1SurGzG; s_network=; sessionid=IGSC5e51443463901bb0a426f830d599bd2fd81a7ecc1cb98949ecbd20a58cf1a299%3AGNlw58jKM47wbjx3v9zWFZT6GPYRKHFW%3A%7B%22_token_ver%22%3A2%2C%22_auth_user_id%22%3A1009845355%2C%22_token%22%3A%221009845355%3AMiWMy7eZzqny2WDgpJZXTmdiNuPHVd3E%3A185e57a287881a4f98f67cbda30ac31a6227e788fc98a5b7c87b381bb6dda06b%22%2C%22asns%22%3A%7B%2295.73.84.168%22%3A25515%2C%22time%22%3A1479341168%7D%2C%22_auth_user_backend%22%3A%22accounts.backends.CaseInsensitiveModelBackend%22%2C%22last_refreshed%22%3A1479341167.836034%2C%22_platform%22%3A0%2C%22_auth_user_hash%22%3A%22%22%7D

 
}

 

    // $dir.'/'.$value, $caption = '', $upload_id = null, $customPreview = null , $location = null, $reel_flag = true, $degrees 


public function upload_photo($photo, $caption = '', $user_ids, $upload_id = null) {



       
        $endpoint = Constants::API_URL.'upload/photo/';
        $boundary = $this->uuid;

        $upload_id = number_format(round(microtime(true) * 1000), 0, '', '');
        $fileToUpload = file_get_contents($photo);
 
        $bodies = [
            [
                'type' => 'form-data',
                'name' => '_csrftoken',
                'data' => $this->token,
            ],
            [
                'type' => 'form-data',
                'name' => 'image_compression',
                'data' => '{"lib_version":"1290.110000","lib_name":"uikit","quality":45}',
            ],
            [
                'type' => 'form-data',
                'name' => '_uuid',
                'data' => $this->uuid,
            ],
            [
                'type' => 'form-data',
                'name' => 'upload_id',
                'data' => $upload_id,
            ],
            [
                'type'     => 'form-data',
                'name'     => 'photo',
                'data'     => $fileToUpload,
                'filename' => 'photo',
                'headers'  => [
                    'Content-Type: image/jpeg',
                    'Content-Transfer-Encoding: binary',
                ],
            ],
        ];

        $data = $this->buildBody($bodies, $boundary);

        $headers = [
            'Accept: *',
            'Connection: keep-alive',
            'Content-type: multipart/form-data; boundary='.$boundary,
            'Content-Length: '.strlen($data),
            'Cookie2: $Version=1',
            'Accept-Language: en-US',
            'Accept-Encoding: gzip, deflate',
            'X-IG-Connection-Type: WiFi',
            'X-IG-Capabilities: 3wo=',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->UA);// Constants::USER_AGENT);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, $this->debug);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->IGDataPath."$this->username-cookies.dat");
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->IGDataPath."$this->username-cookies.dat");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
        
        if ( $this->proxy != null) {
            curl_setopt($ch, CURLOPT_PROXY, $this->proxy ); 
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); 
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxy_auth_credentials );
        }

        $resp = curl_exec($ch);
        $header_len = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($resp, 0, $header_len);
        $upload = json_decode(substr($resp, $header_len), true);

        curl_close($ch);

        if ($upload['status'] == 'fail') {
            throw new InstagramException($upload['message']);

            return;
        }

        if ($this->debug) {
            echo 'RESPONSE: '.substr($resp, $header_len)."\n\n";
        }

        
       $configure = $this->media_configure($upload['upload_id'], $photo, $caption, $user_ids);
           

        // $this->expose();

        return $configure;


// POST https://i.instagram.com/api/v1/upload/photo/ HTTP/1.1
// Host: i.instagram.com
// Accept: *
// Proxy-Connection: keep-alive
// X-IG-Connection-Type: WiFi
// Accept-Encoding: gzip, deflate
// Accept-Language: ru-RU;q=1
// Content-Type: multipart/form-data; boundary=3156D799-CD14-4B1B-B5C9-992CDE05D2E7
// Content-Length: 181530
// User-Agent: Instagram 9.7.0 (iPhone6,1; iPhone OS 9_3_5; ru_RU; ru-RU; scale=2.00; 640x1136) AppleWebKit/420+
// Connection: keep-alive
// X-IG-Capabilities: 3wo=
// Cookie: csrftoken=69TaTIL4lXzNLNVOjZhjHopy7fAYzbDk; ds_user=4ewir; ds_user_id=1009845355; igfl=4ewir; is_starred_enabled=yes; mid=Vt9VQAAAAAFs7QCccW9eS1SurGzG; s_network=; sessionid=IGSCed40e4e15a0ada346d42b437a06bd6593fec35e30108424a6a6b11fc6485bc8d%3AGZUlFRrlFb4z4fwYIZwNgh7lIhVDbAyn%3A%7B%22_token_ver%22%3A2%2C%22_auth_user_id%22%3A1009845355%2C%22_token%22%3A%221009845355%3AMiWMy7eZzqny2WDgpJZXTmdiNuPHVd3E%3A185e57a287881a4f98f67cbda30ac31a6227e788fc98a5b7c87b381bb6dda06b%22%2C%22asns%22%3A%7B%22162.243.254.101%22%3A62567%2C%22time%22%3A1479191736%7D%2C%22_auth_user_backend%22%3A%22accounts.backends.CaseInsensitiveModelBackend%22%2C%22last_refreshed%22%3A1479191720.065686%2C%22_platform%22%3A0%2C%22_auth_user_hash%22%3A%22%22%7D

// --3156D799-CD14-4B1B-B5C9-992CDE05D2E7
// Content-Disposition: form-data; name="_csrftoken"

// 69TaTIL4lXzNLNVOjZhjHopy7fAYzbDk
// --3156D799-CD14-4B1B-B5C9-992CDE05D2E7
// Content-Disposition: form-data; name="image_compression"

// {"lib_version":"1290.110000","lib_name":"uikit","quality":45}
// --3156D799-CD14-4B1B-B5C9-992CDE05D2E7
// Content-Disposition: form-data; name="_uuid"

// F30F7D45-024B-478A-A1FC-75EC32B2F629
// --3156D799-CD14-4B1B-B5C9-992CDE05D2E7
// Content-Disposition: form-data; name="upload_id"

// 1479258235
// --3156D799-CD14-4B1B-B5C9-992CDE05D2E7
// Content-Disposition: form-data; name="photo"; filename="photo"
// Content-Type: image/jpeg
// Content-Transfer-Encoding: binary

// /* 

// --3156D799-CD14-4B1B-B5C9-992CDE05D2E7--

}

public function media_configure($upload_id, $photo, $caption = '', $user_ids) {

 $result_string_added = "";


  $inter = 1;
  $del_y = 5.1;
  $del_x = 4.1;

  $interpol_x =  $inter / $del_x;
  $interpol_y =  $inter / $del_y;

 

  $y = 1;
  $counter = 1;
  foreach ($user_ids as $user_id ) {

    $x_pos = round($counter*$interpol_x,7);
  $y_pos = round($y*$interpol_y,7);
  echo "--\n";
    if ($counter % 4 == 0) {
      $counter = 0;
      $y = $y + 1;
    }
  // $y = $counter * $interpol;
  // echo $y."\n";
  // $x =  $counter * $interpol ;
  // echo $x."\n";
 
  // $x_pos = round($x *  $interpol, 7);
  // $y_pos = round($y *  $interpol, 7);


  $added_user_string = '{"user_id":"'. $user_id .'","position":['. $x_pos .','. $y_pos .']}'; 
  $result_string_added =  $result_string_added . ",".$added_user_string;
    $counter = $counter + 1;
  }
  $final_added_string = '"in":['. $result_string_added .']';
  $final_string =  "{".$final_added_string."}";



  $size = getimagesize($photo)[0];

  $post = [
    /////
    "caption" => "Hi, I am a cool photo", //"date_time_digitized"=> "2016:10:31 14:13:06",  // => 
    /////
    "_csrftoken" => $this->token, //"69TaTIL4lXzNLNVOjZhjHopy7fAYzbDk",
    "client_timestamp" =>  "\"".time()."\"", //"1479258271",

    "edits" => 
    [ 
       "crop_zoom" => 1,
       "crop_center" => [0,0],
       "crop_original_size"=> [$size, $size],
       "filter_strength" => 1,
    ],

     "_uuid" => $this->uuid,
     "_uid" => "\"".$this->username_id."\"",
     "scene_type" => 1,
     "camera_position" => "back",
     "source_type" => 0,
     "disable_comments"=> false,
     "waterfall_id"=> $this->waterfall_id,
     "scene_capture_type"=> "standard",
      "software"  =>  "9.3.5",
      "geotag_enabled" => false,
      "upload_id" => $upload_id,
   ////
     //"date_time_original" =>  "2016:10:31 14:13:06", // => empty
   ////
      "usertags" => "{\"in\":[{\"user_id\":\"1383321789\",\"position\":[0.490625,0.540625]},{\"user_id\":\"253691521\",\"position\":[0.5828125,0.7578125]}]}" //$final_string,
      //
      
  ];


 // signed_body=e02e8d74c26b8700988a72bd0b61e628c71a0bf8e28e35d8117ab360035d9db2.{"caption":"Hi, I am a cool photo","_csrftoken":"JBZIFFlTXify9z7FuUG215EwDYEM6xmN","client_timestamp":"\"1479416144\"","edits":{"crop_zoom":1.0,"crop_center":[0.0,0.0],"crop_original_size":[1080,1080],"filter_strength":1},"_uuid":"408b7e48-d6d6-4561-b2d2-4b8208d30256","_uid":"\"4167348408\"","scene_type":1,"camera_position":"back","source_type":0,"disable_comments":false,"waterfall_id":"aedad0cc-d1f1-4961-9c31-616ba4bf0f22","scene_capture_type":"standard","software":"9.3.5","geotag_enabled":false,"upload_id":"1479416141995","usertags":"{\"in\":[{\"user_id\":\"1383321789\",\"position\":[0.490625,0.540625]},{\"user_id\":\"253691521\",\"position\":[0.5828125,0.7578125]}]}"}&ig_sig_key_version=5



        $post = json_encode($post);
        $post = str_replace('"crop_center":[0,0]', '"crop_center":[0.0,0.0]', $post);
        $post = str_replace('"crop_zoom":1', '"crop_zoom":1.0', $post);
        // $post = str_replace('"crop_original_size":'."[$size,$size]", '"crop_original_size":'."[$size.0,$size.0]", $post);

        return $this->request('https://i.instagram.com/api/v1/media/configure/?', $this->generateSignature($post))[1];

//     POST https://i.instagram.com/api/v1/media/configure/? HTTP/1.1
// Host: i.instagram.com
// Accept: *
// Proxy-Connection: keep-alive
// X-IG-Connection-Type: WiFi
// Accept-Encoding: gzip, deflate
// Accept-Language: ru-RU;q=1
// Content-Type: application/x-www-form-urlencoded; charset=UTF-8
// Content-Length: 1084
// User-Agent: Instagram 9.7.0 (iPhone6,1; iPhone OS 9_3_5; ru_RU; ru-RU; scale=2.00; 640x1136) AppleWebKit/420+
// Connection: keep-alive
// X-IG-Capabilities: 3wo=
// Cookie: csrftoken=69TaTIL4lXzNLNVOjZhjHopy7fAYzbDk; ds_user=4ewir; ds_user_id=1009845355; igfl=4ewir; is_starred_enabled=yes; mid=Vt9VQAAAAAFs7QCccW9eS1SurGzG; s_network=; sessionid=IGSCed40e4e15a0ada346d42b437a06bd6593fec35e30108424a6a6b11fc6485bc8d%3AGZUlFRrlFb4z4fwYIZwNgh7lIhVDbAyn%3A%7B%22_token_ver%22%3A2%2C%22_auth_user_id%22%3A1009845355%2C%22_token%22%3A%221009845355%3AMiWMy7eZzqny2WDgpJZXTmdiNuPHVd3E%3A185e57a287881a4f98f67cbda30ac31a6227e788fc98a5b7c87b381bb6dda06b%22%2C%22asns%22%3A%7B%22162.243.254.101%22%3A62567%2C%22time%22%3A1479191736%7D%2C%22_auth_user_backend%22%3A%22accounts.backends.CaseInsensitiveModelBackend%22%2C%22last_refreshed%22%3A1479191720.065686%2C%22_platform%22%3A0%2C%22_auth_user_hash%22%3A%22%22%7D

// signed_body=6f6013aabf8ca7b73238fe558138a13f583afff47207e2961802b66b51e49d6a.
// {
//   "date_time_digitized":"2016:10:31 14:13:06",
//   "_csrftoken":"69TaTIL4lXzNLNVOjZhjHopy7fAYzbDk",
//   "client_timestamp":"1479258271",
//   "edits":
//      {
//       "crop_zoom":1.333333333333333,
//      "crop_center":[0,0.0007812499999999556],
//      "crop_original_size":[2448,3264],
//      "filter_strength":1
//    },
//    "_uuid":"F30F7D45-024B-478A-A1FC-75EC32B2F629",
//    "_uid":"1009845355",
//    "scene_type":1,
//    "camera_position":"back",
//    "source_type":0,
//    "disable_comments":false,
//    "waterfall_id":"6d565f010734405db17af85855da23d7",
//    "scene_capture_type":"standard",
    // "software":"9.3.5",
//    "geotag_enabled":false,
    // "upload_id":1479258235,
//    "date_time_original":"2016:10:31 14:13:06",
//    "usertags":"{\"in\":[{\"user_id\":\"20283423\",\"position\":[0.590625,0.534375]}]}"
//  }&ig_sig_key_version=5


// signed_body=025f5b3273f0fe6f4965bd0b87e55e9410a7c121188d552ea900b66b0c2a0ae2.{
//   "caption":"Hi, I am a cool photo",
//   "_csrftoken":"W3YJUITCa7wxivmyX5hCC8439e6k3PMp",
//   "client_timestamp":1479349218,
//   "edits":{"crop_zoom":1.0,"crop_center":[0.0,0.0],"crop_original_size":[1080.0,1080.0],"filter_strength":1},"_uuid":"ff79ff57-f7fa-4b79-9a13-5bfd1c5ed508","_uid":4163655889,"scene_type":1,"camera_position":"back","source_type":0,"disable_comments":false,
//   "waterfall_id":"ed5f8b2f-cc1f-4d61-9d50-2210caad669f","scene_capture_type":"standard",
//   "software":"9.3.6",
//   "geotag_enabled":false,"upload_id":"1479349215745","usertags":"{\"in\":[{\"user_id\":\"1383321789\",\"position\":[0.490625,0.540625]},{\"user_id\":\"253691521\",\"position\":[0.5828125,0.7578125]}]}"}&ig_sig_key_version=5

 


}
public function funcrecur()
{ 
    $time_in_day = 24*60*60;
    $posts_per_day = 4900;   
    $delay = $time_in_day / $posts_per_day;
    

    //  /* */
    //  $iter = 0;
    //  while ($iter < 20) {


    //  if ($this->redis->scard('detect') > 20) { 
    //     $act_array = array();
    //     for ($i = 0; $i < 20; $i++) {
    //       $actioner = $this->redis->spop('detect');
    //       array_push($act_array , $actioner);
    //     }
    //  }
    //  $this->upload_photo($photo, $act_array);
    //  $iter =+ 1;
    // }


    // if ($this->redis->scard('detect') > 20) { 
    //     $act_array = array();
    //     for ($i = 0; $i < 20; $i++) {
    //       $actioner = $this->redis->spop('detect');
    //       array_push($act_array , $actioner);
    //     }
    //  }
    //  $remove_ids = $this->method_to_fetch_all_posts();
    //  $this->edit_photo_tag($photo, $remove_ids, $act_array);



    while ($this->redis->scard('detect') > 0) { 

        $actioner = $this->redis->spop('detect');
        if ($this->redis->sismember("follow".$this->username , $actioner) != true) {
            $this->follow($actioner);
        }
        echo $next_iteration_time = $this->add_time($delay);  
        sleep($next_iteration_time);
        $this->funcrecur();
    }
}


public  function f_rand($min=0,$max=1,$mul=100000){
    if ($min>$max) return false;
    return mt_rand($min*$mul,$max*$mul)/$mul;
}

public  function add_time($time) {
  return $time*0.8 + $time*0.3*$this->f_rand(0,1);
}




public function search_in_tags($query) {
  
    $outputs = $this->request('https://i.instagram.com/api/v1/users/search/?rank_token='.$this->username_id.'_'.$this->generateUUID(true).'&query='.$query);   
    return $outputs;


  // GET https://i.instagram.com/api/v1/users/search/?rank_token=1009845355_C84096E3-C829-4EDF-A29C-72788580E456&query=abbyleebrazil HTTP/1.1
  // Host: i.instagram.com
  // X-IG-Capabilities: 3wo=
  // Cookie: csrftoken=69TaTIL4lXzNLNVOjZhjHopy7fAYzbDk; ds_user=4ewir; ds_user_id=1009845355; igfl=4ewir; is_starred_enabled=yes; mid=Vt9VQAAAAAFs7QCccW9eS1SurGzG; s_network=; sessionid=IGSCed40e4e15a0ada346d42b437a06bd6593fec35e30108424a6a6b11fc6485bc8d%3AGZUlFRrlFb4z4fwYIZwNgh7lIhVDbAyn%3A%7B%22_token_ver%22%3A2%2C%22_auth_user_id%22%3A1009845355%2C%22_token%22%3A%221009845355%3AMiWMy7eZzqny2WDgpJZXTmdiNuPHVd3E%3A185e57a287881a4f98f67cbda30ac31a6227e788fc98a5b7c87b381bb6dda06b%22%2C%22asns%22%3A%7B%22162.243.254.101%22%3A62567%2C%22time%22%3A1479191736%7D%2C%22_auth_user_backend%22%3A%22accounts.backends.CaseInsensitiveModelBackend%22%2C%22last_refreshed%22%3A1479191720.065686%2C%22_platform%22%3A0%2C%22_auth_user_hash%22%3A%22%22%7D
  // Connection: keep-alive
  // Proxy-Connection: keep-alive
  // Accept: */*
  // User-Agent: Instagram 9.7.0 (iPhone6,1; iPhone OS 9_3_5; ru_RU; ru-RU; scale=2.00; 640x1136) AppleWebKit/420+
  // Accept-Language: ru-RU;q=1
  // Accept-Encoding: gzip, deflate
  // X-IG-Connection-Type: WiFi


// response

// HTTP/1.1 200 OK
// Content-Language: ru
// Expires: Sat, 01 Jan 2000 00:00:00 GMT
// Vary: Cookie, Accept-Language, Accept-Encoding
// Pragma: no-cache
// Cache-Control: private, no-cache, no-store, must-revalidate
// Date: Wed, 16 Nov 2016 01:04:20 GMT
// Content-Type: application/json
// Set-Cookie: csrftoken=69TaTIL4lXzNLNVOjZhjHopy7fAYzbDk; expires=Wed, 15-Nov-2017 01:04:20 GMT; Max-Age=31449600; Path=/; secure
// Set-Cookie: ds_user_id=1009845355; expires=Tue, 14-Feb-2017 01:04:20 GMT; Max-Age=7776000; Path=/
// Connection: keep-alive
// Content-Length: 1254

// {"has_more": false, "status": "ok", "num_results": 2, "users": [{"username": "abbyleebrazil", "has_anonymous_profile_picture": false, "byline": "\u041f\u043e\u0434\u043f\u0438\u0441\u0447\u0438\u043a\u0438: 99.3k", "friendship_status": {"following": false, "incoming_request": false, "outgoing_request": false, "is_private": true}, "unseen_count": 1, "mutual_followers_count": 0.0, "profile_pic_url": "http://scontent.cdninstagram.com/t51.2885-19/10522181_1482018448704140_1608371148_a.jpg", "full_name": "Abby Lee Brazil\ud83c\udde7\ud83c\uddf7\ud83c\udde7\ud83c\uddf7", "follower_count": 99372, "pk": 20283423, "is_verified": false, "is_private": true}, {"username": "abbyleebrazil_", "has_anonymous_profile_picture": false, "byline": "\u041f\u043e\u0434\u043f\u0438\u0441\u0447\u0438\u043a\u0438: 6", "friendship_status": {"following": false, "incoming_request": false, "outgoing_request": false, "is_private": false}, "unseen_count": 0, "mutual_followers_count": 0.0, "profile_pic_url": "http://scontent.cdninstagram.com/t51.2885-19/s150x150/13671758_314011902282967_1832289642_a.jpg", "profile_pic_id": "1317868330849423099_3487698959", "full_name": "\u5976\u7eff", "follower_count": 6, "pk": 3487698959, "is_verified": false, "is_private": false}]}

}

public function follow($user_id)
{
 
    $data = json_encode([
      "_csrftoken"  =>  $this->token,
      "_uuid" =>   $this->uuid,
      "_uid"  =>    $this->username_id,
      "user_id" =>   $user_id,
    ]);
    $outputs = $this->request('https://i.instagram.com/api/v1/friendships/create/'.$user_id.'/', $this->generateSignature( $data ));
    if ($outputs[1]['status'] == 'ok') {
      $this->redis->sadd('follow'.$this->username, $user_id);
    }
    else {
      return;
    }
    return $outputs;
}

public function followers($user_id, $max_id = null)
{
    $outputs = $this->request('https://i.instagram.com/api/v1/friendships/'.$user_id.'/followers/'.(!is_null($max_id) ? '?max_id='.$max_id : '?rank_token='.$this->username_id.'_'.$this->generateUUID(true) ) );
    return $outputs;
}

public function  current_user_edit()
{
    $outputs = $this->request('https://i.instagram.com/api/v1/accounts/current_user/?edit=true');
    return $outputs;
}

public function  edit_profile($website)
{
   $data = json_encode([
        "gender" => "3",
        "_csrftoken" => $this->token,
        "_uuid" => $this->uuid,
        "_uid"=> $this->username_id,
        "external_url"=> $website,
        "username"=> $this->username,
        "email"=> $this->email,
        "phone_number"=>  "",
        "biography"=> "",
        "first_name"=> $this->full_name,
    ]);

     $outputs = $this->request('https://i.instagram.com/api/v1/accounts/edit_profile/', $this->generateSignature($data));
    return $outputs;
}
 

   public function syncFeaturesRegister()
    {

     $data = json_encode([
       "id" =>  $this->uuid, //"F2CD7326-EA40-44F8-9FC3-71A0A5E1F55B",  
       "experiments" => "ig_ios_link_ci_in_reg_test,ig_ios_email_phone_switcher_universe,ig_ios_registration_robo_call_time,ig_ios_continue_as_2_universe,ig_ios_ci_checkbox_in_reg_test,ig_ios_reg_redesign,ig_ios_reg_flow_status_bar,ig_ios_one_click_login_tab_design_universe,ig_ios_password_less_registration_universe,ig_ios_iconless_contactpoint,ig_ios_universal_link_login,ig_ios_reg_filled_button_universe,ig_nonfb_sso_universe,enable_nux_language,ig_ios_iconless_confirmation,ig_ios_use_family_device_id_universe,ig_ios_one_click_login_universe_2,ig_ios_one_password_extension,ig_ios_new_fb_signup_universe,ig_ios_iconless_username",
     ]);
     
      $outputs = $this->request('https://i.instagram.com/api/v1/qe/sync/', $this->generateSignature($data) );
  
      // preg_match('#Set-Cookie: csrftoken=([^;]+)#', $outputs[0], $matcht);
      // $this->token = $matcht[1];
      // echo var_export($outputs);  


        return $outputs;
    }




// POST https://i.instagram.com/api/v1/fb/show_continue_as/ HTTP/1.1
// Host: i.instagram.com
// Content-Type: application/x-www-form-urlencoded; charset=UTF-8
// Accept: *
// Accept-Encoding: gzip, deflate
// Connection: keep-alive
// Proxy-Connection: keep-alive
// X-IG-Capabilities: 3wo=
// User-Agent: Instagram 9.5.2 (iPhone8,1; iPhone OS 9_3_1; ru_RU; en-US; scale=2.00; 750x1334) AppleWebKit/420+
// Accept-Language: en-US;q=1
// Content-Length: 158
// X-IG-Connection-Type: WiFi-Fallback

// signed_body=6d2d1d44bb7f58a6bb7d0ebfa15f19d2d50f0fba355c1b0906220afc8a4911d2.%7B%22phone_id%22%3A%22%22%2C%22screen%22%3A%22landing%22%7D&ig_sig_key_version=5


  public  function show_continue_as()
    {

      // $data =  'signed_body=6d2d1d44bb7f58a6bb7d0ebfa15f19d2d50f0fba355c1b0906220afc8a4911d2.%7B%22phone_id%22%3A%22%22%2C%22screen%22%3A%22landing%22%7D&ig_sig_key_version=5';


     $data =  json_encode([
       "phone_id"=> "",
       "screen"=> "landing"
     ]);

     $outputs = $this->request('https://i.instagram.com/api/v1/fb/show_continue_as/', $this->generateSignature($data) );

      preg_match('#Set-Cookie: csrftoken=([^;]+)#', $outputs[0], $matcht);
      $this->token = $matcht[1];
      // echo var_export($outputs);  


        return $outputs;
    }


// POST https://i.instagram.com/api/v1/users/check_email/ HTTP/1.1
// Host: i.instagram.com
// Accept: *
// Proxy-Connection: keep-alive
// X-IG-Connection-Type: WiFi
// Accept-Encoding: gzip, deflate
// Accept-Language: en-US;q=1
// Content-Type: application/x-www-form-urlencoded; charset=UTF-8
// Content-Length: 290
// User-Agent: Instagram 9.5.2 (iPhone8,1; iPhone OS 9_3_1; ru_RU; en-US; scale=2.00; 750x1334) AppleWebKit/420+
// Connection: keep-alive
// X-IG-Capabilities: 3wo=
// Cookie: csrftoken=h0rtCU9uwNd4CAojcO61cVEPUl4HbIGs; mid=WATprwAAAAFg3XoGK03ZryWXvhJs

// signed_body=21ebd1aaef2dc91204b3ff702d1599317060de732a117403637ad99e2588d250.%7B%22email%22%3A%22matveev.alexander.v.l.a.d.imit.ovi4%40gmail.com%22%2C%22qe_id%22%3A%22F2CD7326-EA40-44F8-9FC3-71A0A5E1F55B%22%2C%22_csrftoken%22%3A%22h0rtCU9uwNd4CAojcO61cVEPUl4HbIGs%22%7D&ig_sig_key_version=5



public function check_email()
{

  // $data =  'signed_body=21ebd1aaef2dc91204b3ff702d1599317060de732a117403637ad99e2588d250.%7B%22email%22%3A%22matveev.alexander.v.l.a.d.imit.ovi4%40gmail.com%22%2C%22qe_id%22%3A%22F2CD7326-EA40-44F8-9FC3-71A0A5E1F55B%22%2C%22_csrftoken%22%3A%22h0rtCU9uwNd4CAojcO61cVEPUl4HbIGs%22%7D&ig_sig_key_version=5';

    $data = json_encode([
      "email" => $this->email , //"matveev.a.lexander.v.l.a.d.imit.ovi4@gmail.com",
      "qe_id" => $this->uuid, //"F2CD7326-EA40-44F8-9FC3-71A0A5E1F55B",
      "_csrftoken" => $this->token, //"h0rtCU9uwNd4CAojcO61cVEPUl4HbIGs"
    ]);

    $outputs = $this->request('https://i.instagram.com/api/v1/users/check_email/', $this->generateSignature($data) );

  // preg_match('#Set-Cookie: csrftoken=([^;]+)#', $outputs[0], $matcht);
  // $this->token = $matcht[1];
  // echo var_export($outputs);  

    return $outputs;
}


// POST https://i.instagram.com/api/v1/accounts/username_suggestions/ HTTP/1.1
// Host: i.instagram.com
// Accept: *
// Proxy-Connection: keep-alive
// X-IG-Connection-Type: WiFi
// Accept-Encoding: gzip, deflate
// Accept-Language: en-US;q=1
// Content-Type: application/x-www-form-urlencoded; charset=UTF-8
// Content-Length: 260
// User-Agent: Instagram 9.5.2 (iPhone8,1; iPhone OS 9_3_1; ru_RU; en-US; scale=2.00; 750x1334) AppleWebKit/420+
// Connection: keep-alive
// X-IG-Capabilities: 3wo=
// Cookie: csrftoken=h0rtCU9uwNd4CAojcO61cVEPUl4HbIGs; mid=WATprwAAAAFg3XoGK03ZryWXvhJs

// signed_body=91c63e53bc961edae0e4054e1e0671ecdda20f43ee1e9f964893de043819bbe0.%7B%22name%22%3A%22Hanna%20Belford%22%2C%22waterfall_id%22%3A%2217988db1d11b4a1283ae288c339df454%22%2C%22_csrftoken%22%3A%22h0rtCU9uwNd4CAojcO61cVEPUl4HbIGs%22%7D&ig_sig_key_version=5



public function username_suggestions()
{

  // $data =  'signed_body=91c63e53bc961edae0e4054e1e0671ecdda20f43ee1e9f964893de043819bbe0.%7B%22name%22%3A%22Hanna%20Belford%22%2C%22waterfall_id%22%3A%2217988db1d11b4a1283ae288c339df454%22%2C%22_csrftoken%22%3A%22h0rtCU9uwNd4CAojcO61cVEPUl4HbIGs%22%7D&ig_sig_key_version=5';

  $data = json_encode([
   
     "name"=> $this->full_name, //"Hanna Belford",
     "waterfall_id"=> $this->waterfall_id,//"17988db1d11b4a1283ae288c339df454",
     "_csrftoken"=>  $this->token,//"h0rtCU9uwNd4CAojcO61cVEPUl4HbIGs" 

    ]);

  $outputs = $this->request('https://i.instagram.com/api/v1/accounts/username_suggestions/', $this->generateSignature($data));


  $this->username = $outputs[1]['suggestions'][0];

  // preg_match('#Set-Cookie: csrftoken=([^;]+)#', $outputs[0], $matcht);
  // $this->token = $matcht[1];
  // echo var_export($outputs);  

    return $outputs;
}


// POST https://i.instagram.com/api/v1/users/check_username/ HTTP/1.1
// Host: i.instagram.com
// Accept: */*
// Proxy-Connection: keep-alive
// X-IG-Connection-Type: WiFi
// Accept-Encoding: gzip, deflate
// Accept-Language: en-US;q=1
// Content-Type: application/x-www-form-urlencoded; charset=UTF-8
// Content-Length: 199
// User-Agent: Instagram 9.5.2 (iPhone8,1; iPhone OS 9_3_1; ru_RU; en-US; scale=2.00; 750x1334) AppleWebKit/420+
// Connection: keep-alive
// X-IG-Capabilities: 3wo=
// Cookie: csrftoken=h0rtCU9uwNd4CAojcO61cVEPUl4HbIGs; mid=WATprwAAAAFg3XoGK03ZryWXvhJs

// signed_body=0a8ab4311555dde3da733e30aa625d72278881574c6b4592259f2ac295ebfa1f.%7B%22username%22%3A%22belfordhanna%22%2C%22_csrftoken%22%3A%22h0rtCU9uwNd4CAojcO61cVEPUl4HbIGs%22%7D&ig_sig_key_version=5


public function check_username()
{
 
  // $data =  'signed_body=0a8ab4311555dde3da733e30aa625d72278881574c6b4592259f2ac295ebfa1f.%7B%22username%22%3A%22belfordhanna%22%2C%22_csrftoken%22%3A%22h0rtCU9uwNd4CAojcO61cVEPUl4HbIGs%22%7D&ig_sig_key_version=5';

$data = json_encode([

      "username"=> $this->username, //"belfordhanna",
      "_csrftoken"=> $this->token, //"h0rtCU9uwNd4CAojcO61cVEPUl4HbIGs"

  ]);
  $outputs = $this->request('https://i.instagram.com/api/v1/users/check_username/', $this->generateSignature($data));

  // preg_match('#Set-Cookie: csrftoken=([^;]+)#', $outputs[0], $matcht);
  // $this->token = $matcht[1];
  // echo var_export($outputs);  

    return $outputs;
}


// POST https://i.instagram.com/api/v1/accounts/create/ HTTP/1.1
// Host: i.instagram.com
// Accept: */*
// Proxy-Connection: keep-alive
// X-IG-Connection-Type: WiFi
// Accept-Encoding: gzip, deflate
// Accept-Language: en-US;q=1
// Content-Type: application/x-www-form-urlencoded; charset=UTF-8
// Content-Length: 472
// User-Agent: Instagram 9.5.2 (iPhone8,1; iPhone OS 9_3_1; ru_RU; en-US; scale=2.00; 750x1334) AppleWebKit/420+
// Connection: keep-alive
// X-IG-Capabilities: 3wo=
// Cookie: csrftoken=h0rtCU9uwNd4CAojcO61cVEPUl4HbIGs; mid=WATprwAAAAFg3XoGK03ZryWXvhJs

// signed_body=1df4671b8226d552474999160d881214ca8144cbedb73518e1003fe5379b2718.%7B%22first_name%22%3A%22Hanna%20Belford%22%2C%22password%22%3A%22qweqwe123%22%2C%22waterfall_id%22%3A%2217988db1d11b4a1283ae288c339df454%22%2C%22device_id%22%3A%22F2CD7326-EA40-44F8-9FC3-71A0A5E1F55B%22%2C%22email%22%3A%22matveev.alexander.v.l.a.d.imit.ovi4%40gmail.com%22%2C%22username%22%3A%22belfordhanna%22%2C%22_csrftoken%22%3A%22h0rtCU9uwNd4CAojcO61cVEPUl4HbIGs%22%7D&ig_sig_key_version=5


public function create()
{

 
  // $data =  'signed_body=1df4671b8226d552474999160d881214ca8144cbedb73518e1003fe5379b2718.%7B%22first_name%22%3A%22Hanna%20Belford%22%2C%22password%22%3A%22qweqwe123%22%2C%22waterfall_id%22%3A%2217988db1d11b4a1283ae288c339df454%22%2C%22device_id%22%3A%22F2CD7326-EA40-44F8-9FC3-71A0A5E1F55B%22%2C%22email%22%3A%22matveev.alexander.v.l.a.d.imit.ovi4%40gmail.com%22%2C%22username%22%3A%22belfordhanna%22%2C%22_csrftoken%22%3A%22h0rtCU9uwNd4CAojcO61cVEPUl4HbIGs%22%7D&ig_sig_key_version=5';


  $data = json_encode([

     "first_name" => $this->full_name, //"Hanna Belford",
     "password" => $this->password, //"qweqwe123",
     "waterfall_id" => $this->waterfall_id, //"17988db1d11b4a1283ae288c339df454",
     "device_id" => $this->uuid, //"F2CD7326-EA40-44F8-9FC3-71A0A5E1F55B",
     "email"=>  $this->email, //"matveev.a.lexander.v.l.a.d.imit.ovi4@gmail.com",
     "username"=> $this->username, //"belfordhanna",
     "_csrftoken"=> $this->token, //"h0rtCU9uwNd4CAojcO61cVEPUl4HbIGs"

    ]);
  $outputs = $this->request('https://i.instagram.com/api/v1/accounts/create/', $this->generateSignature($data));

    $this->username_id = $outputs[1]['created_user']['pk'];
  // preg_match('#Set-Cookie: csrftoken=([^;]+)#', $outputs[0], $matcht);
  // $this->token = $matcht[1];
  // echo var_export($outputs);  

     rename($this->IGDataPath.'cookies.dat', $this->IGDataPath."$this->username-cookies.dat"); 
    return $outputs;
}


 

  public function sync()
{
  $data = json_encode([
      "_csrftoken"=>  $this->token, ///"ZcsBlgJVBdnESnAEUMBuWuy2W2vAwQRZ",
      "id"=> $this->username_id, /// == uid from set cookie
      "_uuid"=> $this->uuid, //"F2CD7326-EA40-44F8-9FC3-71A0A5E1F55B",
      "experiments"=>"ig_direct_message_service,ig_boomerang_entry,ig_ios_react_native_universe_kill_switch,ig_ios_nscache_replacement,ig_ios_ad_pbia_profile_tap_universe,ig_feed_seen_state_universe,ig_ios_webview_dismiss,instagram_ios_resumable_upload_sc,ig_ios_direct_sqlite,ig_video_copyright_whitelist_qe,ig_ios_main_feed_headers_universe,ig_creation_growth_holdout,ig_ios_redirect_change_phone_universe,ig_ios_business_conversion_flow_universe,ig_ios_discover_people_icon_universe,ig_ios_upload_post_model,ig_ios_ads_holdout_universe,ig_ios_video_target_view_dealloc,ig_ios_follow_button_redesign,ig_ios_autoupdater_force_manual_update,ig_ios_disable_comment_option_public_universe,ig_ios_deeplinking_2,ig_ios_video_should_play_before_cover_photo_loaded,ig_ios_ad_intent_to_highlight_universe,ig_ios_share_screen_caption_universe,ig_ios_comment_thread_show_keyboard,ig_ios_explore_ui_universe,ig_ios_contextual_feed_refactor_universe,ig_ios_disable_comment_option_universe,ig_ios_aymf_feed_unit_nudge_universe,ig_ios_search_null_state_hiding,ig_ios_upload_progress,ig_ios_react_native_universe,ig_ios_video_edit_default_to_trim,ig_ios_comment_redesign,ig_ios_new_business_endpoint,ig_ios_direct_typing_indicator_receiver,ig_explore_channel_home_universe,ig_ios_grid_video_icon,ig_ios_dynamic_text,ig_ios_feed_nudging_universe,ig_ios_external_sticky_share_universe,ig_ios_new_logging_universe,ig_ios_default_multi_select,ig_ios_video_asset_dealloc_delay,ig_ios_ad_holdout_16h2m1_universe,ig_ios_profile_prefetch_universe,ig_show_promote_button_in_feed,ig_ios_watch_browse_universe,ig_ios_replace_username_with_fullname_aymf_universe,instant_activity_badge_universe,ig_ios_app_group_testing,ig_ios_2fac,ig_ios_feed_ufi_redesign,ig_ios_default_to_non_square_asset,ig_ios_high_res_upload,ig_ios_search_tab_back_to_explore,ig_ios_universal_link_2_universe,ig_ios_video_cache_policy,ig_ios_translation_universe,ig_ios_immersive_viewer,ig_ios_new_discover_people_page_universe,ig_ios_boomerang_disable_video_icon,ig_ios_video_corrected_viewport_logging,ig_ios_search_preview_media,ig_ios_listkit_universe,ig_ios_media_service_universe,ig_ios_blocked_list,ig_ios_chaining_see_all_v2_universe,ig_ios_album_video_upload_params,ig_ios_stories_at_mentions,ig_ios_follow_in_story_viewer_universe,ig_ios_creation_lazy_tabs,ig_ios_video_fnf_player,ig_ios_creation_always_kill_camera_session,ig_direct_launch_app_ads,ig_ios_media_picker_non_sticky_universe,ig_ios_direct_raven,ig_video_use_sve_universe,ig_ios_django_endpoint_for_insights_universe,ig_ios_insta_video_universe,ig_ios_manual_updater_background_downloading,ig_ios_ad_sponsored_label_universe,ig_ios_activity_feed_new_people_feed_universe,ig_ios_multiclip,ig_ios_feed_zoom,ig_ios_stories_change_font,ig_ios_direct_new_thread_view_rewrite,ig_ios_video_time_indicator_universe,ig_ios_view_count_decouple_likes_universe,ig_comments_holdout_universe,ig_ios_new_hon_logging_universe,ig_ios_profile_photo_as_media,ig_ios_stories_persistent_your_story,ig_ios_inline_gallery,ig_ios_album_viewer_prefetch_universe,ig_ios_rn_photos_of_you,ig_ios_profile_link_browser_universe,ig_ios_feed_refactor_universe,ig_ios_whatsapp_share_universe,ig_ios_search_recent_searches,ig_ios_cinematic_camera_stabilization,ig_ios_ad_holdout_16m5_universe,ig_ios_follows_you_badge_universe,ig_ios_aymf_pagination_universe,ig_video_max_duration_qe_preuniverse,ig_longcat_aspect_ratio_range,ig_ios_su_activity_feed,ig_ios_video_playback_bandwidth_threshold,ig_ios_ad_comment_cta_universe,ig_ios_video_stitching_universe,ig_ios_share_screen_refactor_universe,ig_ios_reorder_share_sheet_universe,ig_ios_add_profile_nux_universe,ig_ios_new_story_pill_universe,ig_ios_post_to_feed_from_direct_universe,ig_typeahead_search_ranking_universe,ig_ios_feed_pjpeg,ig_ios_direct_disable_swipe_to_inbox,ig_ios_activity_feed_refactor_universe,ig_ios_extra_dialog_for_skip,ig_feed_holdout_universe,ig_ios_stories_mute,ig_ios_social_context,ig_ios_direct_main_inbox_donot_clear_count,ig_ios_usertag_feed_refactor_universe,ig_ios_direct_typing_indicator_send,ig_ios_stories_afterboom_universe,ig_ios_new_follow_list_universe,ig_ios_share_screen_tagging_universe,ig_search_ios_universe,ig_ios_explore_loading_universe,ig_ios_streaming_video_cache_universe,ig_ios_profile,ig_ios_redirect_change_email,ig_organic_insights_base,ig_ios_invite_in_nux_universe,ig_ios_business_promotion,ig_ios_handoff,ig_ios_video_caption_universe,ig_ios_show_animation_teaser_for_aymf_unit_universe,ig_ios_feed_pagination_universe,ig_ios_draw_dm_story_universe,ig_show_su_in_following_list,ig_react_native_promote,ig_ios_video_upload_params,ig_ios_video_recording_timer_universe,ig_ios_feed_send_battery_info_universe,ig_checkpoint_rn_flow_universe,ig_ios_main_feed_refactor_universe_2,ig_ios_new_fb_list,ig_ios_search_null_state,ig_ios_draw_use_gpu,ig_ios_share_on_screenshot_universe,ig_ios_zoom_gesture_recognition_enabled,ig_ios_push_notification_prepromt_content,ig_ios_scroll_perf_metric,ig_ios_video_offset_for_playback_universe,ig_upload_retry_experiment_universe,ig_ios_force_cold_start_after_qe_update,ig_ios_discover_people_3d_touch_universe,ig_ios_fb_token_delay_universe,ig_ios_tagging_prefetch_universe",
      
      "_uid"=> $this->username_id,

    ]);
 
   $outputs = $this->request('https://i.instagram.com/api/v1/qe/sync/', $this->generateSignature($data));

  // preg_match('#Set-Cookie: csrftoken=([^;]+)#', $outputs[0], $matcht);
  // $this->token = $matcht[1];
  // echo var_export($outputs);  

    return $outputs;
}


 
  public function ayml()
  {
    $data = "_csrftoken=".$this->token."&_uuid=".$this->uuid."&paginate=true&module=explore_people&num_media=3";
    
   
     $outputs = $this->request('https://i.instagram.com/api/v1/discover/ayml/', $data);

    // preg_match('#Set-Cookie: csrftoken=([^;]+)#', $outputs[0], $matcht);
    // $this->token = $matcht[1];
    // echo var_export($outputs);  

      return $outputs;
  }
   

public function direct_inbox()
{
  $outputs = $this->request('https://i.instagram.com/api/v1/direct_v2/inbox/');
  return $outputs;
}

public function ranked_recipients()
{
  $outputs = $this->request('https://i.instagram.com/api/v1/direct_v2/ranked_recipients/?mode=reshare&show_threads=true');
  return $outputs;
}
 
public function inbox()
{
    
     $outputs = $this->request('https://i.instagram.com/api/v1/news/inbox/?activity_module=all');
    return $outputs;
}

 public function reels_tray()
{
    
  $outputs = $this->request('https://i.instagram.com/api/v1/feed/reels_tray/?tray_session_id='.$this->generateUUID(false) );  
     //1ae5839959534712b3ffd12aa1a2cb6d');
    return $outputs;
}

public function discover_explore()
{
     $rand_speed = mt_rand(5,40);
     $outputs = $this->request('https://i.instagram.com/api/v1/discover/explore/?is_on_wifi=true&network_transfer_rate='.$rand_speed.'.99&is_prefetch=true&session_id='.$this->username_id.'_'.$this->generateUUID(true).'&timezone_offset=-18000');  /// fix for transfer rate
    return $outputs;
}

public function channels_home()
{
    $outputs = $this->request('https://i.instagram.com/api/v1/discover/channels_home/');  /// fix for transfer rate
    return $outputs;
}


public function users_info()
{
    $outputs = $this->request('https://i.instagram.com/api/v1/users/'.$this->username_id.'/info/');   
    return $outputs;
}
 
public function reels_media()
{

  $data = json_encode([
      "_csrftoken"=> $this->token,
      "_uuid"=> $this->uuid,
      "_uid"=> $this->username_id,
      "user_ids"=>'["'.$this->username_id.'"]',
    ]);
    $outputs = $this->request('https://i.instagram.com/api/v1/feed/reels_media/', $this->generateSignature($data));
    return $outputs;
}
  


public function  notifications_badge()
{
  $data = "_csrftoken=".$this->token."&_uuid=".$this->uuid."&user_ids=4050134364&device_id=".$this->uuid;
    $outputs = $this->request('https://i.instagram.com/api/v1/notifications/badge/', $data);
    return $outputs;
}
  


public function notifications_badge_get()
{
   
    $outputs = $this->request('https://i.instagram.com/api/v1/notifications/badge/');
    return $outputs;
}
  

protected function buildBodyFb($bodies, $boundary)
    {
        $body = '';
        foreach ($bodies as $b) {
            $body .= '--'.$boundary."\r\n";
            $body .= 'Content-Disposition: '.$b['type'].'; name="'.$b['name'].'"';
            if (isset($b['filename'])) {
                
                $body .= '; filename="'.$b['filename'].'"';

                // $ext = pathinfo($b['filename'], PATHINFO_EXTENSION);
                // 'pending_media_'.number_format(round(microtime(true) * 1000), 0, '', '').'.'.$ext.'"';
            }

            if (isset($b['headers']) && is_array($b['headers'])) {
                foreach ($b['headers'] as $header) {
                    $body .= "\r\n".$header;
                }
            }

            $body .= "\r\n\r\n".$b['data']."\r\n";
        }
        $body .= '--'.$boundary.'--';

        return $body;
    }



public function graphFb() {

 $endpoint = 'https://graph.facebook.com/v2.7';

//   POST https://graph.facebook.com/v2.7 HTTP/1.1
// Host: graph.facebook.com
// Content-Type: multipart/form-data; boundary=3i2ndDfv2rTHiSisAbouNdArYfORhtTPEefj3q2f
// Connection: keep-alive
// Proxy-Connection: keep-alive
// Accept: *
// User-Agent: FBiOSSDK.4.14.0
// Accept-Language: ru
// Accept-Encoding: gzip, deflate
// Content-Length: 1081

// --3i2ndDfv2rTHiSisAbouNdArYfORhtTPEefj3q2f
// Content-Disposition: form-data; name="batch_app_id"

// 124024574287414
// --3i2ndDfv2rTHiSisAbouNdArYfORhtTPEefj3q2f
// Content-Disposition: form-data; name="batch"

// [{"relative_url":"124024574287414?fields=app_events_feature_bitmask%2Cname%2Cdefault_share_mode%2Cios_dialog_configs%2Cios_sdk_dialog_flows.os_version%289.3.1%29%2Cios_sdk_error_categories%2Csupports_implicit_sdk_logging%2Cgdpv4_nux_enabled%2Cgdpv4_nux_content%2Cios_supports_native_proxy_auth_flow%2Cios_supports_system_auth%2Capp_events_session_timeout&format=json&include_headers=false&sdk=ios","method":"GET"},{"relative_url":"124024574287414?fields=app_events_feature_bitmask%2Cname%2Cdefault_share_mode%2Cios_dialog_configs%2Cios_sdk_dialog_flows.os_version%289.3.1%29%2Cios_sdk_error_categories%2Csupports_implicit_sdk_logging%2Cgdpv4_nux_enabled%2Cgdpv4_nux_content%2Cios_supports_native_proxy_auth_flow%2Cios_supports_system_auth%2Capp_events_session_timeout&format=json&include_headers=false&sdk=ios","method":"GET"}]
// --3i2ndDfv2rTHiSisAbouNdArYfORhtTPEefj3q2f


     $boundary = '3i2ndDfv2rTHiSisAbouNdArYfORhtTPEefj3q2f'; //a-c

      $bodies = [
          [
              'type' => 'form-data',
              'name' => 'batch_app_id',
              'data' => '124024574287414',
          ],
          [
              'type' => 'form-data',
              'name' => 'batch',
              'data' => '[{"relative_url":"124024574287414?fields=app_events_feature_bitmask%2Cname%2Cdefault_share_mode%2Cios_dialog_configs%2Cios_sdk_dialog_flows.os_version%289.3.1%29%2Cios_sdk_error_categories%2Csupports_implicit_sdk_logging%2Cgdpv4_nux_enabled%2Cgdpv4_nux_content%2Cios_supports_native_proxy_auth_flow%2Cios_supports_system_auth%2Capp_events_session_timeout&format=json&include_headers=false&sdk=ios","method":"GET"},{"relative_url":"124024574287414?fields=app_events_feature_bitmask%2Cname%2Cdefault_share_mode%2Cios_dialog_configs%2Cios_sdk_dialog_flows.os_version%289.3.1%29%2Cios_sdk_error_categories%2Csupports_implicit_sdk_logging%2Cgdpv4_nux_enabled%2Cgdpv4_nux_content%2Cios_supports_native_proxy_auth_flow%2Cios_supports_system_auth%2Capp_events_session_timeout&format=json&include_headers=false&sdk=ios","method":"GET"}]',
          ],
        ];


        $data = $this->buildBodyFb($bodies, $boundary);
        
        $headers = [
          'Host: graph.facebook.com',
          'Connection: keep-alive',
          'Proxy-Connection: keep-alive',
          'Accept: *',
          'Content-Length: '.strlen($data),
          'Accept-Language: en', 
          'Accept-Encoding: gzip, deflate',
          'Content-Type: multipart/form-data; boundary='.$boundary,  

        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_USERAGENT, 'FBiOSSDK.4.14.0'); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, $this->debug);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
        // curl_setopt($ch, CURLOPT_COOKIEFILE, $this->IGDataPath."$this->username-cookies.dat");
        // curl_setopt($ch, CURLOPT_COOKIEJAR, $this->IGDataPath."$this->username-cookies.dat");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        if ( $this->proxy != null) {
          curl_setopt($ch, CURLOPT_PROXY, $this->proxy ); 
          curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); 
          curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxy_auth_credentials);
        }
        $resp = curl_exec($ch);
        $header_len = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($resp, 0, $header_len);
        $upload = json_decode(substr($resp, $header_len), true);

        curl_close($ch);

        // if ($upload['success'] == 'false') {
        //     throw new InstagramException($upload['message']);

        //     return;
        // }

        if ($this->debug) {
            echo 'RESPONSE: '.substr($resp, $header_len)."\n\n";
        }
 
        return [$header, $upload];
    }


//////2////

public function graphFb_activities_appinstall() {
 

  $endpoint = 'https://graph.facebook.com/v2.7/124024574287414/activities?'.rawurldecode(
  'advertiser_id='.$this->advertiser_id.'&advertiser_tracking_enabled=1'.
  '&anon_id=XZ'.$this->anon_id.
  '&application_tracking_enabled=1&event=MOBILE_APP_INSTALL'.
  '&extinfo=["i2","com.burbn.instagram","41483633","9.6.0","9.3.1","iPhone8,1","en_US","GMT-5","AT&T",375,667,"2.00",2,12,11,"America/Atikokan"]'.
  '&format=json'.
  '&include_headers=false'.
  '&sdk=ios'.
 '&url_schemes=["fb124024574287414","instagram","instagram-capture","fsq+kylm3gjcbtswk4rambrt4uyzq1dqcoc0n2hyjgcvbcbe54rj+post"]'
  );

     $boundary = '3i2ndDfv2rTHiSisAbouNdArYfORhtTPEefj3q2f'; 

      $bodies = [
          [
              'type' => 'form-data',
              'name' => 'format',
              'data' => 'json',
          ],
          [
              'type' => 'form-data',
              'name' => 'anon_id',
              'data' => 'XZ'.$this->anon_id,
          ],
          [
              'type' => 'form-data',
              'name' => 'application_tracking_enabled',
              'data' => '1',
          ],
          [
              'type' => 'form-data',
              'name' => 'extinfo',
              'data' => '["i2","com.burbn.instagram","41483633","9.6.0","9.3.1","iPhone8,1","en_US","GMT-5","AT&T",375,667,"2.00",2,12,11,"America/Atikokan"]',
          ],
           [
              'type' => 'form-data',
              'name' => 'event',
              'data' => 'MOBILE_APP_INSTALL',
          ],
          [
              'type' => 'form-data',
              'name' => 'advertiser_id',
              'data' => $this->advertiser_id, //'9AA0EE34-845C-4793-8830-0D3F354A474B',
                          
          ],
          [
              'type' => 'form-data',
              'name' => 'advertiser_tracking_enabled',
              'data' => '1',
          ],
          [
              'type' => 'form-data',
              'name' => 'include_headers',
              'data' => 'false',
          ],
           [
              'type' => 'form-data',
              'name' => 'sdk',
              'data' => 'ios',
          ],
          [
              'type' => 'form-data',
              'name' => 'url_schemes',
              'data' => '["fb124024574287414","instagram","instagram-capture","fsq+kylm3gjcbtswk4rambrt4uyzq1dqcoc0n2hyjgcvbcbe54rj+post"]',
          ],
        ];


        $data = $this->buildBodyFb($bodies, $boundary);
        
        $headers = [
          'Host: graph.facebook.com',
          'Connection: keep-alive',
          'Proxy-Connection: keep-alive',
          'Accept: *',
          'Content-Length: '.strlen($data),
          'Accept-Language: en', 
          'Accept-Encoding: gzip, deflate',
          'Content-Type: multipart/form-data; boundary='.$boundary,  

        ];

    $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_USERAGENT, 'FBiOSSDK.4.14.0'); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, $this->debug);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
        // curl_setopt($ch, CURLOPT_COOKIEFILE, $this->IGDataPath."$this->username-cookies.dat");
        // curl_setopt($ch, CURLOPT_COOKIEJAR, $this->IGDataPath."$this->username-cookies.dat");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        if ( $this->proxy != null) {
          curl_setopt($ch, CURLOPT_PROXY, $this->proxy ); 
          curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); 
          curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxy_auth_credentials);
        }
        $resp = curl_exec($ch);
        $header_len = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($resp, 0, $header_len);
        $upload = json_decode(substr($resp, $header_len), true);

        curl_close($ch);

        // if ($upload['success'] == 'false') {
        //     throw new InstagramException($upload['message']);

        //     return;
        // }

        if ($this->debug) {
            echo 'RESPONSE: '.substr($resp, $header_len)."\n\n";
        }
 
        return [$header, $upload];
}

///////3//////


public function graphFb_activities_appevents() 
{


  $endpoint = 'https://graph.facebook.com/v2.7/124024574287414/activities?'.rawurldecode(
  'advertiser_id='.$this->advertiser_id.'&advertiser_tracking_enabled=1'.
  '&anon_id=XZ'.$this->anon_id.
  '&application_tracking_enabled=1&event=CUSTOM_APP_EVENTS'.
  '&extinfo=["i2","com.burbn.instagram","41483633","9.6.0","9.3.1","iPhone8,1","en_US","GMT-5","AT&T",375,667,"2.00",2,12,11,"America/Atikokan"]'.
  '&format=json'.
  '&include_headers=false'.
  '&sdk=ios'.
 '&url_schemes=["fb124024574287414","instagram","instagram-capture","fsq+kylm3gjcbtswk4rambrt4uyzq1dqcoc0n2hyjgcvbcbe54rj+post"]'
  );



     $boundary = '3i2ndDfv2rTHiSisAbouNdArYfORhtTPEefj3q2f'; 

      $bodies = [
          [
              'type' => 'form-data',
              'name' => 'custom_events_file',
              'filename' => 'custom_events_file',
              'headers'  => [
                  'Content-Type: content/unknown',   
              ],
              'data' => '[{"_ui":"no_ui","_eventName":"fb_mobile_activate_app","_logTime":'.time().',"_session_id":"'.$this->session_id.'","fb_mobile_launch_source":"Unclassified"}]',   // FIX to session_id to random UUID 24E504EA-4510-4F88-83AC-AB2E833B6B46

          ],

          [
              'type' => 'form-data',
              'name' => 'anon_id',
              'data' => 'XZ'.$this->anon_id,
          ],
          [
              'type' => 'form-data',
              'name' => 'application_tracking_enabled',
              'data' => '1',
          ],
          [
              'type' => 'form-data',
              'name' => 'extinfo',
              'data' => '["i2","com.burbn.instagram","41483633","9.6.0","9.3.1","iPhone8,1","en_US","GMT-5","AT&T",375,667,"2.00",2,12,11,"America/Atikokan"]',
          ],
           [
              'type' => 'form-data',
              'name' => 'event',
              'data' => 'CUSTOM_APP_EVENTS',
          ],
          [
              'type' => 'form-data',
              'name' => 'advertiser_id',
              'data' => $this->advertiser_id ,//'9AA0EE34-845C-4793-8830-0D3F354A474B',
          ],
          [
              'type' => 'form-data',
              'name' => 'advertiser_tracking_enabled',
              'data' => '1',
          ],
          [
              'type' => 'form-data',
              'name' => 'include_headers',
              'data' => 'false',
          ],
           [
              'type' => 'form-data',
              'name' => 'sdk',
              'data' => 'ios',
          ],
          [
              'type' => 'form-data',
              'name' => 'url_schemes',
              'data' => '["fb124024574287414","instagram","instagram-capture","fsq+kylm3gjcbtswk4rambrt4uyzq1dqcoc0n2hyjgcvbcbe54rj+post"]',
          ],
        ];

        $data = $this->buildBodyFb($bodies, $boundary);
        
        $headers = [
          'Host: graph.facebook.com',
          'Connection: keep-alive',
          'Proxy-Connection: keep-alive',
          'Accept: *',
          'Content-Length: '.strlen($data),
          'Accept-Language: en', 
          'Accept-Encoding: gzip, deflate',
          'Content-Type: multipart/form-data; boundary='.$boundary,  

        ];

    $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_USERAGENT, 'FBiOSSDK.4.14.0'); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, $this->debug);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
        // curl_setopt($ch, CURLOPT_COOKIEFILE, $this->IGDataPath."$this->username-cookies.dat");
        // curl_setopt($ch, CURLOPT_COOKIEJAR, $this->IGDataPath."$this->username-cookies.dat");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        if ( $this->proxy != null) {
          curl_setopt($ch, CURLOPT_PROXY, $this->proxy ); 
          curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); 
          curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxy_auth_credentials);
        }
        $resp = curl_exec($ch);
        $header_len = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($resp, 0, $header_len);
        $upload = json_decode(substr($resp, $header_len), true);

        curl_close($ch);

        // if ($upload['success'] == 'false') {
        //     throw new InstagramException($upload['message']);

        //     return;
        // }

        if ($this->debug) {
            echo 'RESPONSE: '.substr($resp, $header_len)."\n\n";
        }
 
        return [$header, $upload];
}


public function timeline()
{ 

  $endpoint = 'https://i.instagram.com/api/v1/feed/timeline/?unseen_posts=&recovered_from_crash=1&seen_posts=&is_prefetch=0&timezone_offset=-18000';

    $headers = [
        'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
        'Accept: *',
        'Accept-Encoding: gzip, deflate',
        'X-IDFA: '.$this->advertiser_id,   /// -> facebook adveriser id'
        'X-Ads-Opt-Out: 0',
        'X-FB: 0',
        'X-DEVICE-ID: '.$this->uuid,  /// -> uuid 
        'Connection: keep-alive',
        'Proxy-Connection: keep-alive',
        'X-IG-Capabilities: 3wo=',
        'Accept-Language: en-US;q=1',
        'X-IG-Connection-Type: WiFi',
        'Cookie2: $Version=1',
        'X-IG-INSTALLED-APPS: eyIxIjowLCIyIjowfQ==', /// -> check if the same for devices
    ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->UA);  // 9 5
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

          curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");

        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);


        if (file_exists($this->IGDataPath."$this->username-cookies.dat")) {
            curl_setopt($ch, CURLOPT_COOKIEFILE, $this->IGDataPath."$this->username-cookies.dat");
            curl_setopt($ch, CURLOPT_COOKIEJAR, $this->IGDataPath."$this->username-cookies.dat");
        } else {
            curl_setopt($ch, CURLOPT_COOKIEFILE, $this->IGDataPath.'cookies.dat');  
            curl_setopt($ch, CURLOPT_COOKIEJAR, $this->IGDataPath.'cookies.dat');      
        }


         if ( $this->proxy != null) {
          curl_setopt($ch, CURLOPT_PROXY, $this->proxy ); 
          curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); 
          curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxy_auth_credentials);
        }

        

        $resp = curl_exec($ch);
        $header_len = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($resp, 0, $header_len);
        $body = substr($resp, $header_len);
        $upload = json_decode(substr($resp, $header_len), true);

        curl_close($ch);

        if ($this->debug) {
            echo "REQUEST: $endpoint\n";
            echo 'RESPONSE: '.substr($resp, $header_len)."\n\n";
        }

        return [$header, $upload];

}


  public function autocomplete_user_list()
  {
    
     $outputs = $this->request('https://i.instagram.com/api/v1/friendships/autocomplete_user_list/?version=2');

   //  GET https://i.instagram.com/api/v1/friendships/autocomplete_user_list/?version=2 HTTP/1.1
  // Host: i.instagram.com
  // X-IG-Capabilities: 3wo=
  // Cookie: csrftoken=ZcsBlgJVBdnESnAEUMBuWuy2W2vAwQRZ; ds_user_id=4050134364; mid=WATprwAAAAFg3XoGK03ZryWXvhJs; s_network=; sessionid=IGSC66cf8f8c5da55856662424dd8207ecdb44820e4a92d744132029951ed222570d%3AxB1GJdpcuewZSQgPxGpJbNALz3SXj8vd%3A%7B%22_token_ver%22%3A2%2C%22_auth_user_id%22%3A4050134364%2C%22_token%22%3A%224050134364%3AjASZsutTjkcaDyLDvHI8FQojv7nkLtkk%3A64b954b6b30319c845822728b604e02a96a17358a5787e752f5483944b41e135%22%2C%22asns%22%3A%7B%2295.73.175.251%22%3A25515%2C%22time%22%3A1476717052%7D%2C%22_auth_user_backend%22%3A%22accounts.backends.CaseInsensitiveModelBackend%22%2C%22last_refreshed%22%3A1476717052.30863%2C%22_platform%22%3A0%2C%22_auth_user_hash%22%3A%22%22%7D
  // Connection: keep-alive
  // Proxy-Connection: keep-alive
  // Accept: *
  // User-Agent: Instagram 9.5.2 (iPhone8,1; iPhone OS 9_3_1; ru_RU; en-US; scale=2.00; 750x1334) AppleWebKit/420+
  // Accept-Language: en-US;q=1
  // Accept-Encoding: gzip, deflate
  // X-IG-Connection-Type: WiFi


      return $outputs;
  }
   

  public function generateUUID($type)
  {
      $uuid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
      mt_rand(0, 0xffff), mt_rand(0, 0xffff),
      mt_rand(0, 0xffff),
      mt_rand(0, 0x0fff) | 0x4000,
      mt_rand(0, 0x3fff) | 0x8000,
      mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
      );
      return $type ? $uuid : strtoupper(str_replace('-', '', $uuid) ) ;  /// fixed to upper
  }



  public function generateSignature($data)
   {

        $hash = hash_hmac('sha256', $data, '3fdf001eb50248d8a666e0b5986c92aadae919e390b3c79d473cd1e2a14029a8');  
              // 9.6                            
        // 952 'ebbf19d239c4b2cff2df4b51cc626ffdad6fe27b5a7b39bd6e7e41b72f54c1f2'
        // echo "\n".($hash)."\n";
        
        return 'signed_body='.$hash.'.'.urlencode($data).'&ig_sig_key_version=5';
    }

 
  public function request($endpoint, $post = null, $login = false)
  {

      if ($endpoint == 'https://i.instagram.com/api/v1/qe/sync/' || $endpoint == 'https://i.instagram.com/api/v1/fb/show_continue_as/' ) { 
          $headers = [
          		'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
          		'Accept: */*',
          		'Accept-Encoding: gzip, deflate',
          		'Connection: keep-alive',
          		'Proxy-Connection: keep-alive',
          		'X-IG-Capabilities: 3wo=',
          		'Accept-Language: en-US;q=1',
          		'X-IG-Connection-Type: WiFi-Fallback',
          		'Cookie2: $Version=1',
          ];
      } else {
         $headers = [
              'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
              'Accept: */*',
              'Accept-Encoding: gzip, deflate',
              'Connection: keep-alive',
              'Proxy-Connection: keep-alive',
              'X-IG-Capabilities: 3wo=',
              'Accept-Language: en-US;q=1',
              'X-IG-Connection-Type: WiFi',
              'Cookie2: $Version=1',
          ];
      }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->UA);  // 9 5
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

          curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");

        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);


         if (file_exists($this->IGDataPath."$this->username-cookies.dat")) {
            curl_setopt($ch, CURLOPT_COOKIEFILE, $this->IGDataPath."$this->username-cookies.dat");
            curl_setopt($ch, CURLOPT_COOKIEJAR, $this->IGDataPath."$this->username-cookies.dat");
        } else {
            curl_setopt($ch, CURLOPT_COOKIEFILE, $this->IGDataPath.'cookies.dat');  
            curl_setopt($ch, CURLOPT_COOKIEJAR, $this->IGDataPath.'cookies.dat');      
        }

        if ( $this->proxy != null) {
            curl_setopt($ch, CURLOPT_PROXY, $this->proxy ); 
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); 
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxy_auth_credentials);
        }

        if ($post) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }

        $resp = curl_exec($ch);
        $header_len = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($resp, 0, $header_len);
        $body = substr($resp, $header_len);

        curl_close($ch);

        if (true) {
            echo "REQUEST: $endpoint\n";
            if (!is_null($post)) {
                if (!is_array($post)) {
                    echo 'DATA: '.urldecode($post)."\n";
                }
            }
            echo "RESPONSE: $body\n\n";
        }

        return [$header, json_decode($body, true)];
    }


}
