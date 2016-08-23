<?php

require_once 'func.php';
require_once 'Constants.php';
require_once 'InstagramException.php';

class Instagram
{
  protected $username;            // Instagram username
  protected $password;            // Instagram password
  protected $debug;               // Debug
  protected $proxy;
  protected $uuid;                // UUID
  protected $device_id;           // Device ID
  protected $username_id;         // Username ID
  protected $token;               // _csrftoken
  protected $isLoggedIn = false;  // Session status
  protected $rank_token;          // Rank token
  protected $IGDataPath;          // Data storage path
 

  protected $phone_id;

  /**
   * Default class constructor.
   *
   * @param string $username
   *   Your Instagram username.
   * @param string $password
   *   Your Instagram password.
   * @param $debug
   *   Debug on or off, false by default.
   * @param $IGDataPath
   *  Default folder to store data, you can change it.
   */

  public function __construct($username, $password, $proxy ,  $debug = false, $IGDataPath = null)
  {
    //$genuuid, $gendeviceid , $genphoneid, $genphoneua = null,
      $this->debug = $debug;
    

      $this->UA = Constants::USER_AGENT;//= $genphoneua;

 $this->proxy = $proxy;
      if (!is_null($IGDataPath)) {
          $this->IGDataPath = $IGDataPath;
      } else {
          $this->IGDataPath = __DIR__.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR;
      }

      $this->setUser($username, $password);

  /////////////////////////////// for just created accounts ///////////////

      $this->syncFeatures();
      
      $this->autoCompleteUserList();
       
      $this->directRecentRecipients();
     
      $this->discoverAyml();
///////
        sleep(2);
    $this->timelineFeed(); //
     
    $this->getv2Inbox();    //
     
    $this->getRecentActivity();     //


  }

  /**
   * Set the user. Manage multiple accounts.
   *
   * @param string $username
   *   Your Instagram username.
   * @param string $password
   *   Your Instagram password.
   */
  public function setUser($username, $password)
  {
      $this->username = $username;
      $this->password = $password;


      // $this->uuid = $this->generateUUID(true);  

      if ((file_exists($this->IGDataPath."$this->username-cookies.dat")) && (file_exists($this->IGDataPath."$this->username-userId.dat"))
    && (file_exists($this->IGDataPath."$this->username-token.dat"))) {
          $this->isLoggedIn = true;
          $this->username_id = trim(file_get_contents($this->IGDataPath."$username-userId.dat"));
          //$this->rank_token = $this->username_id.'_'.$this->uuid;
          $this->rank_token = $this->username_id.'_'.$this->generateUUID(true);
          $this->token = trim(file_get_contents($this->IGDataPath."$username-token.dat"));

            $this->device_id =trim(file_get_contents($this->IGDataPath."$username-deviceid.dat"));
             // $gendeviceid; //$this->generateDeviceId(md5($username.$password));  
      $this->uuid = trim(file_get_contents($this->IGDataPath."$username-uuid.dat"));
      $this->phone_id = trim(file_get_contents($this->IGDataPath."$username-phoneid.dat"));
      

      }
  }



   public function currentEdit() {
    $outputs = $this->request('accounts/current_user/?edit=true', null);
    return $outputs;
   }


// signed_body=3f80bf65d1950d3a19fb2d680f992a04dfa9da6b68135a2fa4c03381cb964ce0.%7B%22
   // phone_number%22%3A%22%2B79260263988%22%2C%22
   // _csrftoken%22%3A%22hvo1oRG4LMGDeScVIuQacSLZnFNG2xP6%22%2C%22
   // _uid%22%3A%223592360965%22%2C%22
   // _uuid%22%3A%22ea57180e-3663-446a-9356-e5d103f729dc%22%7D
   // &ig_sig_key_version=4

   public function sendSmsCode($phone) {
          $data = json_encode([
        'phone_number'    =>  $phone, 
        '_csrftoken'  => $this->token,
         '_uid'       => $this->username_id,
        '_uuid'       => $this->uuid,
      ]);
        return $this->request('accounts/send_sms_code/',  $this->generateSignature($data))[1];
   }

// signed_body=7fcfdc871e84fdea11fc193fa1f7d96d6cc8260d6516aca0b08c1569898d1345.%7B%22
   // verification_code%22%3A%22630219%22%2C%22
   // phone_number%22%3A%22%2B79260263988%22%2C%22
   // _csrftoken%22%3A%22hvo1oRG4LMGDeScVIuQacSLZnFNG2xP6%22%2C%22
   // _uid%22%3A%223592360965%22%2C%22
   // _uuid%22%3A%22ea57180e-3663-446a-9356-e5d103f729dc%22%7D
   // &ig_sig_key_version=4

// %2B79260263988
   public function verifySmsCode($phone, $verification_code) {
      $data = json_encode([
        'verification_code' => $verification_code,
        'phone_number'    => $phone, 
        '_csrftoken'  => $this->token,
         '_uid'       => $this->username_id,
        '_uuid'       => $this->uuid,
      ]);
        return $this->request('accounts/verify_sms_code/', $this->generateSignature($data))[1];
   }


 public function checkpointPhoneChallenge($phone, $checkpoint_url) {
// 1
  // GET https://i.instagram.com/challenge/ HTTP/1.1
    $outputsget = $this->httprequest($checkpoint_url, null, true);  
    echo var_export($outputsget);
    sleep(5);
// 2
// POST https://i.instagram.com/challenge/ HTTP/1.1
  // csrfmiddlewaretoken=Xgmc5B2Mo5U3uNY43tdHQvv2WfjbAslO&phone_number=%2B79260263988
  $outputspostone = $this->httprequest($checkpoint_url,  "csrfmiddlewaretoken=".$this->token."&phone_number=".urlencode($phone), false);
    echo var_export($outputspostone) ;
      

 }

 public function checkpointCodeChallenge($resp_code, $checkpoint_url) {
  
 $outputspostfinal = $this->httprequest($checkpoint_url,   "csrfmiddlewaretoken=".$this->token."&response_code=".$resp_code, false);
 
return  $outputspostfinal;
 }

// for phone creator
 // POST https://i.instagram.com/api/v1/accounts/send_confirm_email/ HTTP/1.1
  // signed_body=9ef8ead4c19d54e133116403cb79fc9aceef7077b599a46180ae38bfe7f8aab7.%7B%22
 // _csrftoken%22%3A%220bphZAtkbrkYJ4Z9qa3jD3k3D3ZSVXRq%22%2C%22
 // send_source%22%3A%22%edit_profile%22%2C%22
 // _uid%22%3A%223594561427%22%2C%22
 // _uuid%22%3A%22ea57180e-3663-446a-9356-e5d103f729dc%22%2C%22
 // email%22%3A%22matveev.alexander.vladimir.ovi4%40gmail.com%22%7D
 // &ig_sig_key_version=4

public function sendConfirmEmail($email) {
 $data = json_encode([
        '_csrftoken'  => $this->token,
        'send_source' => "edit_profile",
         '_uid'       => $this->username_id,
        '_uuid'       => $this->uuid,
        'email'       => $email,
      ]);
        return $this->request('accounts/send_confirm_email/', $this->generateSignature($data))[1];
}



  /**
   * Login to Instagram.
   *
   * @param bool $force
   *   Force login to Instagram, this will create a new session
   *
   * @return array
   *    Login data
   */
  public function login($force = false)
  {
      if (!$this->isLoggedIn || $force) {
          $fetch = $this->request('si/fetch_headers/?challenge_type=signup&guid='.str_replace('-', '', $this->uuid), null, true);
            //$this->generateUUID(false), null, true);
          preg_match('#Set-Cookie: csrftoken=([^;]+)#', $fetch[0], $token);

          $data = [
          'phone_id'            => $this->phone_id, //generateUUID(true),
          '_csrftoken'          => $token[0],
          'username'            => $this->username,
          'guid'                => $this->uuid,
          'device_id'           => $this->device_id,
          'password'            => $this->password,
          'login_attempt_count' => '0',
      ];

          $login = $this->request('accounts/login/', $this->generateSignature(json_encode($data)), true);

          if ($login[1]['status'] == 'fail') {
              throw new InstagramException($login[1]['message']);

              return;
          }

          $this->isLoggedIn = true;
          $this->username_id = $login[1]['logged_in_user']['pk'];
          file_put_contents($this->IGDataPath.$this->username.'-userId.dat', $this->username_id);
          // $this->rank_token = $this->username_id.'_'.$this->uuid;
          $this->rank_token = $this->username_id.'_'.$this->generateUUID(true);
          preg_match('#Set-Cookie: csrftoken=([^;]+)#', $login[0], $match);
          $this->token = $match[1];
          file_put_contents($this->IGDataPath.$this->username.'-token.dat', $this->token);

          $this->syncFeatures();
          $this->autoCompleteUserList();
          $this->timelineFeed();
          $this->getv2Inbox();
          $this->getRecentActivity();

          return $login[1];
      }

      $check = $this->timelineFeed();
      if(isset($check['message']) && $check['message'] == 'login_required')
      {
        $this->login(true);
      }
      $this->getv2Inbox();
      $this->getRecentActivity();
  }

    public function syncFeatures()
    {
      $data = json_encode([
        '_csrftoken'    => $this->token,
        'id'            => $this->username_id,
        '_uid'          => $this->username_id,
        '_uuid'         => $this->uuid,
        'experiments'   => Constants::EXPERIMENTS,
      ]);

        return $this->request('qe/sync/', $this->generateSignature($data))[1];
    }

    protected function autoCompleteUserList()
    {
        return $this->request('friendships/autocomplete_user_list/?followinfo=True&version=2')[1];//added /?followinfo=True&version=2  for ANDROID
    }

     protected function directRecentRecipients()
    {
        return $this->request('direct_share/recent_recipients/')[1];//added /?followinfo=True&version=2  for ANDROID
    }

     protected function discoverAyml()
    {
       $data = json_encode([
        'phone_id'    => $this->phone_id,
        'module'      => 'ayml_recommended_users',
        'in_signup'   => true,
        '_csrftoken'  => $this->token,
        '_uuid'       => $this->uuid,
        'num_media'   => 3
      ]);
        return $this->request('discover/ayml/', $data)[1]; 
    }


//ANDROID POST https://i.instagram.com/api/v1/discover/ayml/ HTTP/1.1
//   phone_id=913d5b20-c76a-42d9-8132-ece7432fb11c
// &module=ayml_recommended_users
// &in_signup=true
// &_csrftoken=QxwM1rDI5rb9tge8pfD85sUWZqy18sUq
// &_uuid=70079fbe-8663-4984-a564-f4e021f762de
// &num_media=3


// GET /api/v1/feed/timeline/?is_prefetch=0&phone_id=65188cf9-c788-4b51-b8c5-e2e9c7b98a03&battery_level=1&timezone_offset=10800&is_charging=0 HTTP/1.1


// GET /api/v1/feed/timeline/?phone_id=913d5b20-c76a-42d9-8132-ece7432fb11c&battery_level=45&timezone_offset=10800&is_charging=0 HTTP/1.1


    protected function timelineFeed()
    {

     
       return $this->request('feed/timeline/')[1];
      
    //   $endpoint = 'feed/timeline/?is_prefetch=0&phone_id='.$this->phone_id.'&battery_level=14&timezone_offset=10800&is_charging=0';

    //    $headers = [
    //     'Connection: close',
    //     'Accept: */*',
    //     'Content-type: application/x-www-form-urlencoded; charset=UTF-8',
    //     'Cookie2: $Version=1',
    //     'Accept-Language: en-US',
    //     'X-Google-AD-ID: '.$this->generateUUID(true),
    //     'X-DEVICE-ID: '.$this->generateUUID(true), 
    //     'X-IG-INSTALLED-APPS: eyIxIjowLCIyIjowfQ==',
    //     'X-IG-Connection-Type: WIFI',
    //     'X-IG-Capabilities: 3QI=',

    // ];

    //     $ch = curl_init();

    //     curl_setopt($ch, CURLOPT_URL, Constants::API_URL.$endpoint);
    //     curl_setopt($ch, CURLOPT_USERAGENT, $this->UA);//Constants::USER_AGENT);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    //     curl_setopt($ch, CURLOPT_HEADER, true);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //     curl_setopt($ch, CURLOPT_VERBOSE, false);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    //     curl_setopt($ch, CURLOPT_COOKIEFILE, $this->IGDataPath."$this->username-cookies.dat");
    //     curl_setopt($ch, CURLOPT_COOKIEJAR, $this->IGDataPath."$this->username-cookies.dat");
    //       curl_setopt($ch, CURLOPT_PROXY, $this->proxy ); 
    //     curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); 
    //     curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'blackking:Name0123Space');


    //     // if ($post) {
    //     //     curl_setopt($ch, CURLOPT_POST, true);
    //     //     curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    //     // }

    //     $resp = curl_exec($ch);
    //     $header_len = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    //     $header = substr($resp, 0, $header_len);
    //     $body = substr($resp, $header_len);

    //     curl_close($ch);

    //     if ($this->debug) {
    //         echo "REQUEST: $endpoint\n";
            
    //         echo "RESPONSE: $body\n\n";
    //     }

    //     return [$header, json_decode($body, true)];
    }

    protected function megaphoneLog()
    {
        return $this->request('megaphone/log/')[1];
    }

  /**
     * Pending Inbox
     *
     * @return array
     *   Pending Inbox Data
     */
    public function getPendingInbox()
    {
        $pendingInbox = $this->request('direct_v2/pending_inbox/?')[1];
        if ($pendingInbox['status'] != 'ok') {
            throw new InstagramException($pendingInbox['message']."\n");
            return;
        }
        return $pendingInbox;
    }


    /**
     * Explore Tab
     *
     * @return array
     *   Explore data
     */
    public function explore()
    {
        return $this->request('discover/explore/?')[1];
    }

    protected function expose()
    {
        $data = json_encode([
        '_uuid'        => $this->uuid,
        '_uid'         => $this->username_id,
        'id'           => $this->username_id,
        '_csrftoken'   => $this->token,
        'experiment'   => 'ig_android_profile_contextual_feed',
    ]);

        $this->request('qe/expose/', $this->generateSignature($data))[1];
    }

  /**
   * Login to Instagram.
   *
   * @return bool
   *    Returns true if logged out correctly
   */
  public function logout()
  {
      $logout = $this->request('accounts/logout/');

      if ($logout == 'ok') {
          return true;
      } else {
          return false;
      }
  }

    /**
     * Upload photo to Instagram.
     *
     * @param string $photo
     *                        Path to your photo
     * @param string $caption
     *                        Caption to be included in your photo.
     *
     * @return array
     *               Upload data
     */
    public function uploadPhoto($photo, $caption = null, $upload_id = null)
    {
        $_prefix = 'IMG';
        $image = $photo;
        $output = 'output.jpg';
        $_image = $image;
        list($_width, $_height) = getimagesize($image);
        $_output = $output;
        $_tmp = $_prefix.rand();
        copy($_image, $_tmp);

        $colors_list = ['a', 'b', 'c', 'd', 'e', 'f', '1', '2' ,'3','4', '5', '6', '7', '9'];
        $fe_list = ['F', 'E'];
        $firstcol = $colors_list[mt_rand(0, count($colors_list) - 1)]; 
        $secondcol = $colors_list[mt_rand(0, count($colors_list) - 1)]; 
        $thirdcol = $colors_list[mt_rand(0, count($colors_list) - 1)]; 

        $fe1 = $fe_list[mt_rand(0, count($fe_list) - 1)];
        $fe2 = $fe_list[mt_rand(0, count($fe_list) - 1)];
        $fe3 = $fe_list[mt_rand(0, count($fe_list) - 1)];

        $color  = '#'.$fe1.$firstcol.$fe2.$secondcol.$fe3.$thirdcol; // F or E
        echo  $color;
        $input = $_tmp;
        $width = 1;

        $command = "convert $input -bordercolor $color -border {$width}x{$width} $input";
        $command = str_replace(array("\n", "'"), array('', '"'), $command);
        $command = escapeshellcmd($command);
        exec($command);

        rename($_tmp, $_output);

        ///NEED TEST
        // $fileToUpload1 = imagecreatefromjpeg($photo);
        // $imgdata = getimagesize($photo);
        // $width = $imgdata[0];
        // $height = $imgdata[1];
        // $pix_w=mt_rand(20, $width - 10);
        // $pix_h=mt_rand(20, $height - 10);
        // // echo $pix_w." ".$pix_h;
        // $rgb = imagecolorallocate($fileToUpload1, 255, 0, 0); 
        // // $rgb = imagecolorat($fileToUpload1, $pix_w-10,$pix_h-10);
        // // $red = imagecolorallocate($gd, 255, 0, 0); 
        // imagesetpixel($fileToUpload1, $pix_w , $pix_h, $rgb);
        // ob_start();
        // imagejpeg($fileToUpload1);
        // $fileToUpload =  ob_get_contents();
        // ob_end_clean();
        // ////

        
        $endpoint = Constants::API_URL.'upload/photo/';
        $boundary = $this->uuid;

        if (!is_null($upload_id)) {
            $fileToUpload = createVideoIcon($photo);
        } else {
            $upload_id = number_format(round(microtime(true) * 1000), 0, '', '');
             $fileToUpload = file_get_contents($output);
        }

        $bodies = [
            [
                'type' => 'form-data',
                'name' => 'upload_id',
                'data' => $upload_id,
            ],
            [
                'type' => 'form-data',
                'name' => '_uuid',
                'data' => $this->uuid,
            ],
            [
                'type' => 'form-data',
                'name' => '_csrftoken',
                'data' => $this->token,
            ],
            [
                'type' => 'form-data',
                'name' => 'image_compression',
              'data'   => '{"lib_name":"jt","lib_version":"1.3.0","quality":"70"}',
            ],
            [
                'type'     => 'form-data',
                'name'     => 'photo',
                'data'     => $fileToUpload,
                'filename' => 'pending_media_'.number_format(round(microtime(true) * 1000), 0, '', '').'.jpg',
                'headers'  => [
          'Content-Transfer-Encoding: binary',
                    'Content-type: application/octet-stream',
                ],
            ],
        ];

        $data = $this->buildBody($bodies, $boundary);
        $headers = [
                'Connection: close',
                'Accept: */*',
                'Content-type: multipart/form-data; boundary='.$boundary,
        'Content-Length: '.strlen($data),
        'Cookie2: $Version=1',
        'Accept-Language: en-US',
        'Accept-Encoding: gzip',
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

        curl_setopt($ch, CURLOPT_PROXY, $this->proxy ); 
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); 
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'blackking:Name0123Space');

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

        $configure = $this->configure($upload['upload_id'], $photo, $caption);
        $this->expose();

        return $configure;
    }


// media/configure_to_reel/  Instagram Stories

    public function uploadVideo($video, $caption = null)
    {
        $videoData = file_get_contents($video);

        $endpoint = Constants::API_URL.'upload/video/';
        $boundary = $this->uuid;
        $upload_id = round(microtime(true) * 1000);
        $bodies = [
          [
              'type' => 'form-data',
              'name' => 'upload_id',
              'data' => $upload_id,
          ],
          [
              'type' => 'form-data',
              'name' => '_csrftoken',
              'data' => $this->token,
          ],
          [
              'type'   => 'form-data',
              'name'   => 'media_type',
              'data'   => '2',
          ],
          [
              'type' => 'form-data',
              'name' => '_uuid',
              'data' => $this->uuid,
          ],
      ];

        $data = $this->buildBody($bodies, $boundary);
        $headers = [
          'Connection: keep-alive',
          'Accept: */*',
          'Host: i.instagram.com',
          'Content-type: multipart/form-data; boundary='.$boundary,
          'Accept-Language: en-en',
      ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->UA);//Constants::USER_AGENT);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->IGDataPath."$this->username-cookies.dat");
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->IGDataPath."$this->username-cookies.dat");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
         curl_setopt($ch, CURLOPT_PROXY, $this->proxy ); 
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); 
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'blackking:Name0123Space');


        $resp = curl_exec($ch);
        $header_len = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

        $body = json_decode(substr($resp, $header_len), true);

        $uploadUrl = $body['video_upload_urls'][3]['url'];
        $job = $body['video_upload_urls'][3]['job'];

        $request_size = floor(strlen($videoData) / 4);

        $lastRequestExtra = (strlen($videoData) - ($request_size * 4));

        for ($a = 0; $a <= 3; $a++) {
            $start = ($a * $request_size);
            $end = ($a + 1) * $request_size + ($a == 3 ? $lastRequestExtra : 0);

            $headers = [
              'Connection: keep-alive',
              'Accept: */*',
              'Host: upload.instagram.com',
              'Cookie2: $Version=1',
              'Accept-Encoding: gzip, deflate',
              'Content-Type: application/octet-stream',
              'Session-ID: '.$upload_id,
              'Accept-Language: en-en',
              'Content-Disposition: attachment; filename="video.mov"',
              'Content-Length: '.($end - $start),
              'Content-Range: '.'bytes '.$start.'-'.($end - 1).'/'.strlen($videoData),
              'job: '.$job,
          ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $uploadUrl);
            curl_setopt($ch, CURLOPT_USERAGENT, $this->UA);//Constants::USER_AGENT);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_VERBOSE, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $this->IGDataPath."$this->username-cookies.dat");
            curl_setopt($ch, CURLOPT_COOKIEJAR, $this->IGDataPath."$this->username-cookies.dat");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, substr($videoData, $start, $end));
             curl_setopt($ch, CURLOPT_PROXY, $this->proxy ); 
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); 
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'blackking:Name0123Space');



            $result = curl_exec($ch);
            $header_len = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $body = substr($result, $header_len);
            $array[] = [$body];
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

        $configure = $this->configureVideo($upload_id, $video, $caption);
        $this->expose();

        return $configure;
    }

    public function direct_share($media_id, $recipients, $text = null)
    {
        if (!is_array($recipients)) {
            $recipients = [$recipients];
        }

        $string = [];
        foreach ($recipients as $recipient) {
            $string[] = "\"$recipient\"";
        }

        $recipient_users = implode(',', $string);

        $endpoint = Constants::API_URL.'direct_v2/threads/broadcast/media_share/?media_type=photo';
        $boundary = $this->uuid;
        $bodies = [
            [
                'type' => 'form-data',
                'name' => 'media_id',
                'data' => $media_id,
            ],
            [
                'type' => 'form-data',
                'name' => 'recipient_users',
                'data' => "[[$recipient_users]]",
            ],
            [
                'type' => 'form-data',
                'name' => 'client_context',
                'data' => $this->uuid,
            ],
            [
                'type' => 'form-data',
                'name' => 'thread_ids',
                'data' => '["0"]',
            ],
            [
                'type' => 'form-data',
                'name' => 'text',
                'data' => is_null($text) ? '' : $text,
            ],
        ];

        $data = $this->buildBody($bodies, $boundary);
        $headers = [
                'Proxy-Connection: keep-alive',
                'Connection: keep-alive',
                'Accept: */*',
                'Content-type: multipart/form-data; boundary='.$boundary,
                'Accept-Language: en-en',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->UA);//Constants::USER_AGENT);
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
         curl_setopt($ch, CURLOPT_PROXY, $this->proxy ); 
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); 
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'blackking:Name0123Space');



        $resp = curl_exec($ch);
        $header_len = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($resp, 0, $header_len);
        $upload = json_decode(substr($resp, $header_len), true);

        curl_close($ch);

         
        if ($this->debug) {
            echo 'RESPONSE: '.substr($resp, $header_len)."\n\n";
        }

        
         // $respres = var_export($upload);
         // echo $respres;

         return $upload;
    }


 /**
     * Direct Thread Data
     *
     * @param string $threadId
     *   Thread Id
     *
     * @return array
     *   Direct Thread Data
     */
    public function directThread($threadId)
    {
        $directThread = $this->request("direct_v2/threads/$threadId/?")[1];
        if ($directThread['status'] != 'ok') {
            throw new InstagramException($directThread['message']."\n");
            return;
        }
        return $directThread;
    }
    /**
     * Direct Thread Action
     *
     * @param string $threadId
     *   Thread Id
     *
     * @param string $threadAction
     *   Thread Action 'approve' OR 'decline' OR 'block'
     *
     * @return array
     *   Direct Thread Action Data
     */
    public function directThreadAction($threadId, $threadAction)
    {
        $data = json_encode([
          '_uuid'      => $this->uuid,
          '_uid'       => $this->username_id,
          '_csrftoken' => $this->token,
        ]);
        return $this->request("direct_v2/threads/$threadId/$threadAction/", $this->generateSignature($data))[1];
    }

    
    protected function configureVideo($upload_id, $video, $caption = '')
    {
        $this->uploadPhoto($video, $caption, $upload_id);

        $size = getimagesize($video)[0];

        $post = json_encode([
        'upload_id'          => $upload_id,
        'source_type'        => '3',
        'poster_frame_index' => 0,
        'length'             => 0.00,
        'audio_muted'        => false,
        'filter_type'        => '0',
        'video_result'       => 'deprecated',
        'clips'              => [
          'length'           => getSeconds($video),
          'source_type'      => '3',
          'camera_position'  => 'back',
        ],
        'extra' => [
          'source_width'  => 960,
          'source_height' => 1280,
        ],
        'device' => [
          'manufacturer'    => 'Xiaomi',
          'model'           => 'HM 1SW',
          'android_version' => 18,
          'android_release' => '4.3',
        ],
        '_csrftoken'  => $this->token,
        '_uuid'       => $this->uuid,
        '_uid'        => $this->username_id,
        'caption'     => $caption,
     ]);

        $post = str_replace('"length":0', '"length":0.00', $post);

        return $this->request('media/configure/?video=1', $this->generateSignature($post))[1];
    }

    protected function configure($upload_id, $photo, $caption = '')
    {
        $size = getimagesize($photo)[0];

        $post = json_encode([
        'upload_id'          => $upload_id,
        'camera_model'       => 'HM1S',
        'source_type'        => 3,
        'date_time_original' => date('Y:m:d H:i:s'),
        'camera_make'        => 'XIAOMI',
        'edits'              => [
          'crop_original_size' => [$size, $size],
          'crop_zoom'          => 1.3333334,
          'crop_center'        => [0.0, -0.0],
        ],
        'extra' => [
          'source_width'  => $size,
          'source_height' => $size,
        ],
        'device' => [
          'manufacturer'    => 'Xiaomi',
          'model'           => 'HM 1SW',
          'android_version' => 18,
          'android_release' => '4.3',
        ],
        '_csrftoken'  => $this->token,
        '_uuid'       => $this->uuid,
        '_uid'        => $this->username_id,
        'caption'     => $caption,
     ]);

        $post = str_replace('"crop_center":[0,0]', '"crop_center":[0.0,-0.0]', $post);

        return $this->request('media/configure/', $this->generateSignature($post))[1];
    }

  /**
   * Edit media.
   *
   * @param string $mediaId
   *   Media id
   * @param string $captionText
   *   Caption text
   *
   * @return array
   *   edit media data
   */
  public function editMedia($mediaId, $captionText = '')
  {
      $data = json_encode([
        '_uuid'          => $this->uuid,
        '_uid'           => $this->username_id,
        '_csrftoken'     => $this->token,
        'caption_text'   => $captionText,
    ]);

      return $this->request("media/$mediaId/edit_media/", $this->generateSignature($data))[1];
  }

  /**
   * Remove yourself from a tagged media.
   *
   * @param string $mediaId
   *   Media id
   *
   * @return array
   *   edit media data
   */
  public function removeSelftag($mediaId)
  {
      $data = json_encode([
        '_uuid'          => $this->uuid,
        '_uid'           => $this->username_id,
        '_csrftoken'     => $this->token,
    ]);

      return $this->request("usertags/$mediaId/remove/", $this->generateSignature($data))[1];
  }

  /**
   * Delete photo or video.
   *
   * @param string $mediaId
   *   Media id
   *
   * @return array
   *   delete request data
   */
  public function mediaInfo($mediaId)
  {
      $data = json_encode([
        '_uuid'      => $this->uuid,
        '_uid'       => $this->username_id,
        '_csrftoken' => $this->token,
        'media_id'   => $mediaId,
    ]);

      return $this->request("media/$mediaId/info/", $this->generateSignature($data))[1];
  }

  /**
   * Delete photo or video.
   *
   * @param string $mediaId
   *   Media id
   *
   * @return array
   *   delete request data
   */
  public function deleteMedia($mediaId)
  {
      $data = json_encode([
        '_uuid'      => $this->uuid,
        '_uid'       => $this->username_id,
        '_csrftoken' => $this->token,
        'media_id'   => $mediaId,
    ]);

      return $this->request("media/$mediaId/delete/", $this->generateSignature($data))[1];
  }

  /**
   * Comment media.
   *
   * @param string $mediaId
   *   Media id
   * @param string $commentText
   *   Comment Text
   *
   * @return array
   *   comment media data
   */
  public function comment($mediaId, $commentText)
  {
      $data = json_encode([
        '_uuid'          => $this->uuid,
        '_uid'           => $this->username_id,
        '_csrftoken'     => $this->token,
        'comment_text'   => $commentText,
    ]);

      return $this->request("media/$mediaId/comment/", $this->generateSignature($data))[1];
  }

  /**
   * Delete Comment.
   *
   * @param string $mediaId
   *   Media ID
   * @param string $commentId
   *   Comment ID
   *
   * @return array
   *   Delete comment data
   */
  public function deleteComment($mediaId, $commentId)
  {
      $data = json_encode([
        '_uuid'          => $this->uuid,
        '_uid'           => $this->username_id,
        '_csrftoken'     => $this->token,
        'caption_text'   => $captionText,
    ]);

      return $this->request("media/$mediaId/comment/$commentId/delete/", $this->generateSignature($data))[1];
  }


  /**
   * Delete Comment Bulk
   *
   * @param string $mediaId
   *   Media id
   *
   * @param string $commentIds
   *   List of comments to delete
   *
   * @return array
   *   Delete Comment Bulk Data
   */
  public function deleteCommentsBulk($mediaId, $commentIds)
  {
      if (!is_array($commentIds)) {
          $commentIds = [$commentIds];
      }
      $string = [];
      foreach ($commentIds as $commentId) {
          $string[] = "$commentId";
      }
      $comment_ids_to_delete = implode(',', $string);
      $data = json_encode([
        '_uuid'      => $this->uuid,
        '_uid'       => $this->username_id,
        '_csrftoken' => $this->token,
        'comment_ids_to_delete' => $comment_ids_to_delete,
      ]);
      return $this->http->request("media/$mediaId/comment/bulk_delete/", SignatureUtils::generateSignature($data))[1];
  }

  /**
   * Sets account to public.
   *
   * @param string $photo
   *   Path to photo
   */
  public function changeProfilePicture($photo)
  {
        $_prefix = 'IMG';
        $image = $photo;
        $output = 'output.jpg';
        $_image = $image;
        list($_width, $_height) = getimagesize($image);
        $_output = $output;
        $_tmp = $_prefix.rand();
        copy($_image, $_tmp);

        $colors_list = ['a', 'b', 'c', 'd', 'e', 'f', '1', '2' ,'3','4', '5', '6', '7', '9'];
        $fe_list = ['F', 'E'];
        $firstcol = $colors_list[mt_rand(0, count($colors_list) - 1)]; 
        $secondcol = $colors_list[mt_rand(0, count($colors_list) - 1)]; 
        $thirdcol = $colors_list[mt_rand(0, count($colors_list) - 1)]; 

        $fe1 = $fe_list[mt_rand(0, count($fe_list) - 1)];
        $fe2 = $fe_list[mt_rand(0, count($fe_list) - 1)];
        $fe3 = $fe_list[mt_rand(0, count($fe_list) - 1)];

        $color  = '#'.$fe1.$firstcol.$fe2.$secondcol.$fe3.$thirdcol; // F or E
        echo  $color;
        $input = $_tmp;
        $width = 1;

        $command = "convert $input -bordercolor $color -border {$width}x{$width} $input";
        $command = str_replace(array("\n", "'"), array('', '"'), $command);
        $command = escapeshellcmd($command);
        exec($command);

        rename($_tmp, $_output);
      //
     ///NEED TEST
        // $fileToUpload1 = imagecreatefromjpeg($photo);
        // $imgdata = getimagesize($photo);
        // $width = $imgdata[0];
        // $height = $imgdata[1];
        // $pix_w=mt_rand(20, $width);
        // $pix_h=mt_rand(20, $height);
        // // echo $pix_w." ".$pix_h;
        // $rgb = imagecolorallocate($fileToUpload1, 0, 0, 0); 
        // // $rgb = imagecolorat($fileToUpload1, $pix_w-10,$pix_h-10);
        // // $red = imagecolorallocate($gd, 255, 0, 0); 
        // imagesetpixel($fileToUpload1, $pix_w , $pix_h, $rgb);
        // ob_start();
        // imagejpeg($fileToUpload1);
        // $fileToUpload =  ob_get_contents();
        // ob_end_clean();
        // ////

      if (is_null($photo)) {
          echo "Photo not valid\n\n";

          return;
      }

      $uData = json_encode([
      '_csrftoken' => $this->token,
      '_uuid'      => $this->uuid,
      '_uid'       => $this->username_id,
    ]);

      $endpoint = Constants::API_URL.'accounts/change_profile_picture/';
      $boundary = $this->uuid;
      $bodies = [
      [
        'type' => 'form-data',
        'name' => 'ig_sig_key_version',
        'data' => Constants::SIG_KEY_VERSION,
      ],
      [
        'type' => 'form-data',
        'name' => 'signed_body',
        'data' => hash_hmac('sha256', $uData, Constants::IG_SIG_KEY).$uData,
      ],
      [
        'type'     => 'form-data',
        'name'     => 'profile_pic',
        'data'     =>  file_get_contents($output),
        // $fileToUpload,
        //
        'filename' => 'profile_pic',
        'headers'  => [
          'Content-type: application/octet-stream',
          'Content-Transfer-Encoding: binary',
        ],
      ],
    ];

      $data = $this->buildBody($bodies, $boundary);
      $headers = [
        'Proxy-Connection: keep-alive',
        'Connection: keep-alive',
        'Accept: */*',
        'Content-type: multipart/form-data; boundary='.$boundary,
        'Accept-Language: en-en',
        'Accept-Encoding: gzip, deflate',
    ];

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $endpoint);
      curl_setopt($ch, CURLOPT_USERAGENT, $this->UA); //Constants::USER_AGENT);
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
      curl_setopt($ch, CURLOPT_PROXY, $this->proxy ); 
      curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); 
      curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'blackking:Name0123Space');


      $resp = curl_exec($ch);
      $header_len = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
      $header = substr($resp, 0, $header_len);
      $upload = json_decode(substr($resp, $header_len), true);

      curl_close($ch);
  }

  /**
   * Remove profile picture.
   *
   * @return array
   *   status request data
   */
  public function removeProfilePicture()
  {
      $data = json_encode([
        '_uuid'      => $this->uuid,
        '_uid'       => $this->username_id,
        '_csrftoken' => $this->token,
    ]);

      return $this->request('accounts/remove_profile_picture/', $this->generateSignature($data))[1];
  }

  /**
   * Sets account to private.
   *
   * @return array
   *   status request data
   */
  public function setPrivateAccount()
  {
      $data = json_encode([
        '_uuid'      => $this->uuid,
        '_uid'       => $this->username_id,
        '_csrftoken' => $this->token,
    ]);

      return $this->request('accounts/set_private/', $this->generateSignature($data));
  }

  /**
   * Sets account to public.
   *
   * @return array
   *   status request data
   */
  public function setPublicAccount()
  {
      $data = json_encode([
        '_uuid'      => $this->uuid,
        '_uid'       => $this->username_id,
        '_csrftoken' => $this->token,
    ]);

      return $this->request('accounts/set_public/', $this->generateSignature($data))[1];
  }

  /**
   * Get personal profile data.
   *
   * @return array
   *   profile data
   */
  public function getProfileData()
  {
      $data = json_encode([
        '_uuid'      => $this->uuid,
        '_uid'       => $this->username_id,
        '_csrftoken' => $this->token,
    ]);

      return $this->request('accounts/current_user/?edit=true', $this->generateSignature($data))[1];
  }

  /**
   * Edit profile.
   *
   * @param string $url
   *   Url - website. "" for nothing
   * @param string $phone
   *   Phone number. "" for nothing
   * @param string $first_name
   *   Name. "" for nothing
   * @param string $email
   *   Email. Required.
   * @param int $gender
   *   Gender. male = 1 , female = 0
   *
   * @return array
   *   edit profile data
   */
  public function editProfile($url, $phone, $first_name, $biography, $email, $gender)
  {
      $data = json_encode([
        '_uuid'         => $this->uuid,
        '_uid'          => $this->username_id,
        '_csrftoken'    => $this->token,
        'external_url'  => $url,
        'phone_number'  => $phone,
        'username'      => $this->username,
        'first_name'    => $first_name,
        'biography'     => $biography,
        'email'         => $email,
        'gender'        => $gender,
    ]);
      echo $data;
      return $this->request('accounts/edit_profile/', $this->generateSignature($data))[1];
  }

  /**
   * Get username info.
   *
   * @param string $usernameId
   *   Username id
   *
   * @return array
   *   Username data
   */
  public function getUsernameInfo($usernameId)
  {
      return $this->request("users/$usernameId/info/")[1];
  }

  /**
   * Get self username info.
   *
   * @return array
   *   Username data
   */
  public function getSelfUsernameInfo()
  {
      return $this->getUsernameInfo($this->username_id);
  }

  /**
   * Get recent activity.
   *
   * @return array
   *   Recent activity data
   */
  public function getRecentActivity()
  {
      $activity = $this->request('news/inbox/?')[1];

      if ($activity['status'] != 'ok') {
          throw new InstagramException($activity['message']."\n");

          return;
      }

      return $activity;
  }

  /**
   * Get recent activity from accounts followed.
   *
   * @return array
   *   Recent activity data of follows
   */
  public function getFollowingRecentActivity()
  {
      $activity = $this->request('news/?')[1];

      if ($activity['status'] != 'ok') {
          throw new InstagramException($activity['message']."\n");

          return;
      }

      return $activity;
  }

  /**
   * I dont know this yet.
   *
   * @return array
   *   v2 inbox data
   */
  public function getv2Inbox()
  {
      $inbox = $this->request('direct_v2/inbox/?')[1];

      if ($inbox['status'] != 'ok') {
          throw new InstagramException($inbox['message']."\n");

          return;
      }

      return $inbox;
  }

  /**
   * Get user tags.
   *
   * @param string $usernameId
   *
   * @return array
   *   user tags data
   */
  public function getUserTags($usernameId)
  {
      $tags = $this->request("usertags/$usernameId/feed/?rank_token=$this->rank_token&ranked_content=true&")[1];

      if ($tags['status'] != 'ok') {
          throw new InstagramException($tags['message']."\n");

          return;
      }

      return $tags;
  }

  /**
   * Get self user tags.
   *
   * @return array
   *   self user tags data
   */
  public function getSelfUserTags()
  {
      return $this->getUserTags($this->username_id);
  }

  /**
   * Get tagged media.
   *
   * @param string $tag
   *
   * @return array
   */
  public function tagFeed($tag)
  {
      $userFeed = $this->request("feed/tag/$tag/?rank_token=$this->rank_token&ranked_content=true&")[1];

      if ($userFeed['status'] != 'ok') {
          throw new InstagramException($userFeed['message']."\n");

          return;
      }

      return $userFeed;
  }

  /**
   * Get media likers.
   *
   * @param string $mediaId
   *
   * @return array
   */
  public function getMediaLikers($mediaId)
  {
      $likers = $this->request("media/$mediaId/likers/?")[1];
      if ($likers['status'] != 'ok') {
          throw new InstagramException($likers['message']."\n");

          return;
      }

      return $likers;
  }

  /**
   * Get user locations media.
   *
   * @param string $usernameId
   *   Username id
   *
   * @return array
   *   Geo Media data
   */
  public function getGeoMedia($usernameId)
  {
      $locations = $this->request("maps/user/$usernameId/")[1];

      if ($locations['status'] != 'ok') {
          throw new InstagramException($locations['message']."\n");

          return;
      }

      return $locations;
  }

  /**
   * Get self user locations media.
   *
   * @return array
   *   Geo Media data
   */
  public function getSelfGeoMedia()
  {
      return $this->getGeoMedia($this->username_id);
  }

  /**
   * facebook user search.
   *
   * @param string $query
   *
   * @return array
   *   query data
   */
  public function fbUserSearch($query)
  {
      $query = rawurlencode($query);
      $query = $this->request("fbsearch/topsearch/?context=blended&query=$query&rank_token=$this->rank_token")[1];

      if ($query['status'] != 'ok') {
          throw new InstagramException($query['message']."\n");

          return;
      }

      return $query;
  }

  /**
   * Search users.
   *
   * @param string $query
   *
   * @return array
   *   query data
   */
  public function searchUsers($query)
  {
      $query = $this->request('users/search/?ig_sig_key_version='.Constants::SIG_KEY_VERSION."&is_typeahead=true&query=$query&rank_token=$this->rank_token")[1];

      if ($query['status'] != 'ok') {
          throw new InstagramException($query['message']."\n");

          return;
      }

      return $query;
  }

    /**
   * Search exact username
   *
   * @param string usernameName username as STRING not an id
   *
   * @return array
   *   query data
   *
   */
  public function searchUsername($usernameName)
  {
      $query = $this->request("users/$usernameName/usernameinfo/")[1];

      if ($query['status'] != 'ok') {
          throw new InstagramException($query['message']."\n");

          return;
      }

      return $query;
  }

  /**
   * Search users using addres book.
   *
   * @param array $contacts
   *
   * @return array
   *   query data
   */
  public function syncFromAdressBook($contacts)
  {
      $data = 'contacts='.json_encode($contacts, true);

      return $this->request('address_book/link/?include=extra_display_name,thumbnails', $data)[1];
  }

  /**
   * Search tags.
   *
   * @param string $query
   *
   * @return array
   *   query data
   */
  public function searchTags($query)
  {
      $query = $this->request("tags/search/?is_typeahead=true&q=$query&rank_token=$this->rank_token")[1];

      if ($query['status'] != 'ok') {
          throw new InstagramException($query['message']."\n");

          return;
      }

      return $query;
  }

  /**
   * Get timeline data.
   *
   * @return array
   *   timeline data
   */
   public function getTimeline($maxid = null)
  {
      $timeline = $this->request(
          "feed/timeline/?rank_token=$this->rank_token&ranked_content=true"
          .(!is_null($maxid) ? "&max_id=".$maxid : '')
      )[1];
      if ($timeline['status'] != 'ok') {
          throw new InstagramException($timeline['message']."\n");
          return;
      }
      return $timeline;
  }

   /**
       * Get user feed.
       * @param string $usernameId
       *    Username id
       * @param null $maxid
       *    Max Id
       * @param null $minTimestamp
       *    Min timestamp
       * @return array User feed data
       *    User feed data
       * @throws InstagramException
       */
  public function getUserFeed($usernameId, $maxid = null, $minTimestamp = null)
  {
      $userFeed = $this->request(
          "feed/user/$usernameId/?rank_token=$this->rank_token"
          .(!is_null($maxid) ? "&max_id=".$maxid : '')
          .(!is_null($minTimestamp) ? "&min_timestamp=".$minTimestamp : '')
          ."&ranked_content=true"
      )[1];
       
      // elseif ($userFeed['status'] != 'ok') {
      //     throw new InstagramException($userFeed['message']."\n");
      //     return;
      // }
      return $userFeed;
  }

  /**
   * Get hashtag feed.
   *
   * @param string $hashtagString
   *    Hashtag string, not including the #
   *
   * @return array
   *   Hashtag feed data
   */
  public function getHashtagFeed($hashtagString, $maxid = null)
  {
      if (is_null($maxid)) {
          $endpoint = "feed/tag/$hashtagString/?rank_token=$this->rank_token&ranked_content=true&";
      } else {
          $endpoint = "feed/tag/$hashtagString/?max_id=".$maxid."&rank_token=$this->rank_token&ranked_content=true&";
      }

      $hashtagFeed = $this->request($endpoint)[1];

      if ($hashtagFeed['status'] != 'ok') {
          throw new InstagramException($hashtagFeed['message']."\n");

          return;
      }

      return $hashtagFeed;
  }





  /**

  signed_body=3f9153ee63d3395151babb5028821b08758a0827c36adfc57402218105614587.%7B%22_csrftoken%22%3A%22IjKRj5NGejIAQNSqrmvjWNyziJYNRKCd%22%2C%22email%22%3A%22mat.veev.alexander.vladimirovi4%40gmail.com%22%2C%22qe_id%22%3A%22ea57180e-3663-446a-9356-e5d103f729dc%22%2C%22waterfall_id%22%3A%22ed596800-1f15-40b0-ad4d-42cd41017dc7%22%7D&ig_sig_key_version=4
 
   */

   
  public function locationParser($latitude, $longitude)
  {   
      $timestamp = 1329426118000; //with miliseconds //need test
        $locationParser = $this->request('location_search?latitude='.$latitude.'&timestamp='.$timestamp.'&longitude='.$longitude.'&rank_token='.$this->rank_token, null)[1];
 
      if ($locationParser['status'] != 'ok') {
          throw new InstagramException($locationParser['message']."\n");

          return;
      }
      return $locationParser;
  }

 //GET https://i.instagram.com/api/v1/fbsearch/places/?lat=55.706440&lng=37.577896&timezone_offset=10800 HTTP/1.1

 public function searchLocation($latitude, $longitude)
  {   

      $locationParser = $this->request('fbsearch/places/?lat='.$latitude.'&lng='.$longitude.'&timezone_offset=10800')[1];
      if ($locationParser['status'] != 'ok' && $locationParser['message'] =="checkpoint_required" ) {

      
        $this->checkpointPhoneChallenge($GLOBALS["phone"], $locationParser['checkpoint_url']); // where is sms

           // $resp_code = trim(fgets(STDIN)); // why not working?
          $resp_code = readline("Command: ");
           echo "\n".$resp_code;

          $results = $this->checkpointCodeChallenge($resp_code, $locationParser['checkpoint_url']);

          echo var_export($results);



          } else {

          throw new InstagramException($locationParser['message']."\n");
         return;
      }
      return $locationParser;
  }


//////////
  /**
   * Get locations.
   *
   * @param string $query
   *    search query
   *
   * @return array
   *   Location location data
   */

  public function searchLocationByQuery($query)
  {

      // $query = rawurlencode($query);
      $endpoint = "fbsearch/places/?rank_token=$this->rank_token&query=".$query;

      $locationFeed = $this->request($endpoint)[1];

      if ($locationFeed['status'] != 'ok') {
          throw new InstagramException($locationFeed['message']."\n");

          return;
      }

      return $locationFeed;
  }

  /**
   * Get location feed.
   *
   * @param string $locationId
   *    location id
   *
   * @return array
   *   Location feed data

   GET https://i.instagram.com/api/v1/feed/location/214426443/?max_id=J0HV3qjmQAAAF0HV3VpSQAAAFpALAA%253D%253D  
   
   */
  public function getLocationFeed($locationId, $maxid = null)
  {
      if (is_null($maxid)) {
          $endpoint = "feed/location/$locationId/?rank_token=$this->rank_token&ranked_content=true&";
      } else {
          $endpoint = "feed/location/$locationId/?max_id=".$maxid."&rank_token=$this->rank_token&ranked_content=true&";
      }

      $locationFeed = $this->request($endpoint)[1];

      if (  $locationFeed['status'] == "fail" && $locationFeed['message'] == "checkpoint_required" ) { 

           

          
        $this->checkpointPhoneChallenge($GLOBALS["phone"], $locationFeed['checkpoint_url']); // where is sms

           // $resp_code = trim(fgets(STDIN)); // why not working?
          $resp_code = readline("Command: ");
           echo "\n".$resp_code;

          $results = $this->checkpointCodeChallenge($resp_code, $locationFeed['checkpoint_url']);

          echo var_export($results);


      }
      elseif ( $locationFeed['status'] != "ok"  ) {
           throw new InstagramException($locationFeed['message']."\n");

          // echo  var_export($locationFeed);
           return;
     } 


      return $locationFeed;
  }

  /**
   * Get self user feed.
   *
   * @return array
   *   User feed data
   */
  public function getSelfUserFeed()
  {
      return $this->getUserFeed($this->username_id);
  }

  /**
   * Get popular feed.
   *
   * @return array
   *   popular feed data
   */
  public function getPopularFeed()
  {
      $popularFeed = $this->request("feed/popular/?people_teaser_supported=1&rank_token=$this->rank_token&ranked_content=true&")[1];

      if ($popularFeed['status'] != 'ok') {
          throw new InstagramException($popularFeed['message']."\n");

          return;
      }

      return $popularFeed;
  }

   /**
    * Get user followings.
    *
    * @param string $usernameId
    *   Username id
    *
    * @return array
    *   followers data
    */

   public function getUserFollowings($usernameId, $maxid = null)
   {
       $userFolResult = $this->request("friendships/$usernameId/following/?max_id=$maxid&ig_sig_key_version=".Constants::SIG_KEY_VERSION."&rank_token=$this->rank_token")[1];

       if ($userFolResult['status'] == "fail"  && $userFolResult['message'] == "checkpoint_required" )
       {
              
             $this->checkpointPhoneChallenge($GLOBALS["phone"], $userFolResult['checkpoint_url']); // where is sms

           // $resp_code = trim(fgets(STDIN)); // why not working?
          $resp_code = readline("Command: ");
           echo "\n".$resp_code;

          $results = $this->checkpointCodeChallenge($resp_code, $userFolResult['checkpoint_url']);

          echo var_export($results);


       }
       elseif ($userFolResult['status'] != 'ok') {
            throw new InstagramException($popularFeed['message']."\n");
          return;
        } 
        return $userFolResult;
   }

  /**
   * Get user followers.
   *
   * @param string $usernameId
   *   Username id
   *
   * @return array
   *   followers data
   */
  public function getUserFollowers($usernameId, $maxid = null)
  {
    // need fix when null
    //?max_id=$maxid&
    //need test ---> delete after followers/
      $userFollowers = $this->request("friendships/$usernameId/followers/".(!is_null($maxid) ? "?max_id=".$maxid : ''))[1]; //."&rank_token=$this->rank_token"
//."ig_sig_key_version=".Constants::SIG_KEY_VERSION 
// $userFollowers = $this->request("friendships/$usernameId/followers/".(!is_null($maxid) ? "?max_id=".$maxid."&" : '?')."ig_sig_key_version=".Constants::SIG_KEY_VERSION."&rank_token=$this->rank_token")[1];

       if ($userFollowers['status'] != 'ok' && $userFollowers['message'] =="checkpoint_required" ) {

                      $this->checkpointPhoneChallenge($GLOBALS["phone"], $userFollowers['checkpoint_url']);
                             echo "\nVerification code sent! >>>>>\n";
                
                              $resp_code = "";
                     while( ctype_digit($resp_code) != true) { 
                      $resp_code = readline("Command: ");
                    }
                   echo "\n---->".$resp_code;

                  $results = $this->checkpointCodeChallenge($resp_code, $userFollowers['checkpoint_url']);

                  echo var_export($results);



          } else {

            echo "good\n";
              //echo $userFollowers;
          //throw new InstagramException($userFollowers['message']."\n");
         //return;
      }
      return $userFollowers;

  }

  /**
   * Get self user followers.
   *
   * @return array
   *   followers data
   */
  public function getSelfUserFollowers()
  {
      return $this->getUserFollowers($this->username_id);
  }

  /**
   * Get self users we are following.
   *
   * @return array
   *   users we are following data
   */
  public function getSelfUsersFollowing()
  {
      return $this->request('friendships/following/?ig_sig_key_version='.Constants::SIG_KEY_VERSION."&rank_token=$this->rank_token")[1];
  }

  /**
   * Like photo or video.
   *
   * @param string $mediaId
   *   Media id
   *
   * @return array
   *   status request
   */
  public function like($mediaId)
  {
      $data = json_encode([
        'module_name' => "feed_timeline",
        'media_id'   => $mediaId."_".$this->username_id,
        '_csrftoken' => $this->token,
        '_uid'       => $this->username_id,
        '_uuid'      => $this->uuid,
        
    ]);

      return $this->request("media/".$mediaId."_".$this->username_id."/like/", $this->generateSignature($data));//[1]
  }

  /**
   * Unlike photo or video.
   *
   * @param string $mediaId
   *   Media id
   *
   * @return array
   *   status request
   */
  public function unlike($mediaId)
  {
      $data = json_encode([
        '_uuid'      => $this->uuid,
        '_uid'       => $this->username_id,
        '_csrftoken' => $this->token,
        'media_id'   => $mediaId,
    ]);

      return $this->request("media/$mediaId/unlike/", $this->generateSignature($data))[1];
  }

  /**
   * Get media comments.
   *
   * @param string $mediaId
   *   Media id
   *
   * @return array
   *   Media comments data
   */
  public function getMediaComments($mediaId)
  {
      return $this->request("media/$mediaId/comments/?")[1];
  }

  /**
   * Set name and phone (Optional).
   *
   * @param string $name
   * @param string $phone
   *
   * @return array
   *   Set status data
   */
  public function setNameAndPhone($name = '', $phone = '')
  {
      $data = json_encode([
        '_uuid'         => $this->uuid,
        '_uid'          => $this->username_id,
        'first_name'    => $name,
        'phone_number'  => $phone,
        '_csrftoken'    => $this->token,
    ]);

      return $this->request('accounts/set_phone_and_name/', $this->generateSignature($data))[1];
  }

  /**
   * Get direct share.
   *
   * @return array
   *   Direct share data
   */
  public function getDirectShare()
  {
      return $this->request('direct_share/inbox/?')[1];
  }

  /**
   * Backups all your uploaded photos :).
   */
  public function backup()
  {
      $myUploads = $this->getSelfUserFeed();
      foreach ($myUploads['items'] as $item) {
          if (!is_dir($this->IGDataPath.'backup/'."$this->username-".date('Y-m-d'))) {
              mkdir($this->IGDataPath.'backup/'."$this->username-".date('Y-m-d'));
          }
          file_put_contents($this->IGDataPath.'backup/'."$this->username-".date('Y-m-d').'/'.$item['id'].'.jpg',
      file_get_contents($item['image_versions2']['candidates'][0]['url']));
      }
  }

  /**
   * Follow.
   *
   * @param string $userId
   *
   * @return array
   *   Friendship status data
   signed_body=fe3f4a50c6ee13ee74299df6661e5d259e6f3508b7db3490f9a5c090e155c971.%7B%22
   _csrftoken%22%3A%22hvo1oRG4LMGDeScVIuQacSLZnFNG2xP6%22%2C%22user_id%22%3A%2225025320%22%2C%22_uid%22%3A%223592360965%22%2C%22_uuid%22%3A%22ea57180e-3663-446a-9356-e5d103f729dc%22%7D&ig_sig_key_version=4

   */
  public function follow($userId)
  {
      $data = json_encode([
        '_uuid'      => $this->uuid,
        '_uid'       => $this->username_id,
        'user_id'    => $userId,
        '_csrftoken' => $this->token,
    ]);

      return $this->request("friendships/create/$userId/", $this->generateSignature($data));
  }

  /**
   * Unfollow.
   *
   * @param string $userId
   *
   * @return array
   *   Friendship status data
   */
  public function unfollow($userId)
  {
      $data = json_encode([
        '_uuid'      => $this->uuid,
        '_uid'       => $this->username_id,
        'user_id'    => $userId,
        '_csrftoken' => $this->token,
    ]);

      return $this->request("friendships/destroy/$userId/", $this->generateSignature($data))[1];
  }

  /**
   * Block.
   *
   * @param string $userId
   *
   * @return array
   *   Friendship status data
   */
  public function block($userId)
  {
      $data = json_encode([
        '_uuid'      => $this->uuid,
        '_uid'       => $this->username_id,
        'user_id'    => $userId,
        '_csrftoken' => $this->token,
    ]);

      return $this->request("friendships/block/$userId/", $this->generateSignature($data))[1];
  }

  /**
   * Unblock.
   *
   * @param string $userId
   *
   * @return array
   *   Friendship status data
   */
  public function unblock($userId)
  {
      $data = json_encode([
        '_uuid'      => $this->uuid,
        '_uid'       => $this->username_id,
        'user_id'    => $userId,
        '_csrftoken' => $this->token,
    ]);

      return $this->request("friendships/unblock/$userId/", $this->generateSignature($data))[1];
  }


  /**
   * Show User Friendship.
   *
   * @param string $userId
   *
   * @return array
   *   Friendship relationship data
   */
  public function userFriendship($userId)
  {
      $data = json_encode([
        '_uuid'      => $this->uuid,
        '_uid'       => $this->username_id,
        'user_id'    => $userId,
        '_csrftoken' => $this->token,
    ]);
      return $this->request("friendships/show/$userId/", $this->generateSignature($data))[1];
  }


  /**
   * Get liked media.
   *
   * @return array
   *   Liked media data
   */
  public function getLikedMedia()
  {
      return $this->request('feed/liked/?')[1];
  }

    public function generateSignature($data)
    {
        $hash = hash_hmac('sha256', $data, Constants::IG_SIG_KEY);

        return 'ig_sig_key_version='.Constants::SIG_KEY_VERSION.'&signed_body='.$hash.'.'.urlencode($data);
    }

    public function generateDeviceId($seed)
    {

      // //old
      //   // Neutralize username/password -> device correlation
        $volatile_seed = filemtime(__DIR__);
        // $volatile_seed = time();
        return 'android-'.substr(md5($seed.$volatile_seed), 16);

 



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


      //need test
      //    $uuid =  sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', 
      // mt_rand(0, 65535), 
      // mt_rand(0, 65535), 
      // mt_rand(0, 65535), 
      // mt_rand(16384, 20479), 
      // mt_rand(32768, 49151), 
      // mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));

        return $type ? $uuid : str_replace('-', '', $uuid);
    }

    protected function buildBody($bodies, $boundary)
    {
        $body = '';
        foreach ($bodies as $b) {
            $body .= '--'.$boundary."\r\n";
            $body .= 'Content-Disposition: '.$b['type'].'; name="'.$b['name'].'"';
            if (isset($b['filename'])) {
                $ext = pathinfo($b['filename'], PATHINFO_EXTENSION);
                $body .= '; filename="'.'pending_media_'.number_format(round(microtime(true) * 1000), 0, '', '').'.'.$ext.'"';
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


    protected function httprequest($endpoint, $post, $headerChoose)
    { 
      if ($headerChoose == false) {
      $headers = [
      'Host: i.instagram.com',
      'Connection: keep-alive',
      'Content-Length:'.strlen($post),
      'Cache-Control: max-age=0',
      'Origin: https://i.instagram.com',
      'Accept-Language: en-US', 
      'Accept: */*',
      'Content-Type: application/x-www-form-urlencoded',
      'Cookie2: $Version=1',
     ];

     //  'Accept-Charset: utf-8, iso-8859-1, utf-16, *;q=0.7',
     
   } else {

     $headers = [
      'Host: i.instagram.com',
      'Connection: keep-alive',
      'Content-Length:'.strlen($post),
      'Accept: */*',
      'Accept-Language: en-US', 
      'Cookie2: $Version=1',        
     ];

}

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $endpoint); //"https://i.instagram.com/".
        // curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->UA ); //Constants::USER_AGENT); //// 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($headerChoose == false) {
         curl_setopt($ch, CURLOPT_REFERER , 'https://i.instagram.com/challenge/');
        }
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, true);//true 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); //need test
        //new
        curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
          curl_setopt($ch, CURLOPT_AUTOREFERER, true); 
        // new

        curl_setopt($ch, CURLOPT_VERBOSE, false);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  //need test added
         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  //need test added

        curl_setopt($ch, CURLOPT_PROXY, $this->proxy ); 
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); 
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'blackking:Name0123Space');


        // if (file_exists($this->IGDataPath."$this->username-cookies.dat")) {
            curl_setopt($ch, CURLOPT_COOKIEFILE, $this->IGDataPath."$this->username-cookies.dat");
            curl_setopt($ch, CURLOPT_COOKIEJAR, $this->IGDataPath."$this->username-cookies.dat");
        // } else {
            // curl_setopt($ch, CURLOPT_COOKIEFILE, $this->IGDataPath.'cookies.dat'); //need fix $this->device_id
            // curl_setopt($ch, CURLOPT_COOKIEJAR, $this->IGDataPath.'cookies.dat');   //need fix $this->device_id
        // }

        if ($post) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }


       // $information = curl_getinfo($ch);
       // echo var_export( $information);


        $resp = curl_exec($ch);
        $header_len = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($resp, 0, $header_len);
        $body = substr($resp, $header_len);

        curl_close($ch);

        if ($this->debug) {
            echo "REQUEST: $endpoint\n";
            if (!is_null($post)) {
                if (!is_array($post)) {
                    echo "DATA: $post\n";
                }
            }
            echo "RESPONSE: $body\n\n";
        }

        return [$header, json_decode($body, true)];
    }


    protected function request($endpoint, $post = null, $login = false)
    {
        if (!$this->isLoggedIn && !$login) {
            throw new InstagramException("Not logged in\n");

            return;
        }

        $headers = [
        'Connection: close',
        'Accept: */*',
        'Content-type: application/x-www-form-urlencoded; charset=UTF-8',
        'Cookie2: $Version=1',
        'Accept-Language: en-US',
    ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, Constants::API_URL.$endpoint);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->UA);//Constants::USER_AGENT);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->IGDataPath."$this->username-cookies.dat");
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->IGDataPath."$this->username-cookies.dat");
          curl_setopt($ch, CURLOPT_PROXY, $this->proxy ); 
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); 
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'blackking:Name0123Space');


        if ($post) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }

        $resp = curl_exec($ch);
        $header_len = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($resp, 0, $header_len);
        $body = substr($resp, $header_len);

        curl_close($ch);

        if ($this->debug) {
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
