<?php

require_once 'Constants.php';
require_once 'InstagramException.php';

class InstagramRegistration
{
    protected $debug;
    protected $IGDataPath;
    protected $username;
    protected $uuid;
    protected $proxy;
    protected $token;
    //
    protected $UA;
    protected $phone_id;
    protected $waterfall_id;
    protected $device_id;

    protected $fbTrackingId;

    public function __construct($proxy, $debug = false, $IGDataPath = null)
    {
        $this->proxy = $proxy;
        $this->debug = $debug;

        $this->uuid = $this->generateUUID(true);

         $this->phone_id = $this->generateUUID(true);

        $this->waterfall_id =  $this->generateUUID(true);
        $this->UA = $this->GenerateUserAgent();
        echo $this->UA."-------UA\n\n";

        $this->device_id = 'android-'.bin2hex(openssl_random_pseudo_bytes(8));
         

         $this->fbTrackingId = $this->generateUUID(true);

        if (!is_null($IGDataPath)) {
            $this->IGDataPath = $IGDataPath;
        } else {
            $this->IGDataPath = __DIR__.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR;
        }
    }

   


public function syncFeaturesRegister()
    {
 
      $data = json_encode([
        'id'            =>  $this->uuid,
        'experiments'   => Constants::EXPERIMENTS_REG,
      ]);

      $outputs = $this->request('qe/sync/', $this->generateSignature($data));
      preg_match('#Set-Cookie: csrftoken=([^;]+)#', $outputs[0], $matcht);
      $this->token = $matcht[1];

   
      echo var_export($outputs);  


        return $outputs;
    }



public function returnIGDataPath() 
{
  return $this->IGDataPath;
}

 

public function sendSignupSmsCode($phone) {

  $data = json_encode([
          'phone_id'   => $this->phone_id,
          'phone_number' => $phone,
          'guid' => $this->uuid,
          'device_id' => $this->device_id,
          'waterfall_id' => $this->waterfall_id,
      ]);

      $response =   $this->request('accounts/send_signup_sms_code/', $this->generateSignature($data));  


      preg_match('#Set-Cookie: csrftoken=([^;]+)#', $response[0], $matchresult);
     $this->token = $matchresult[1];

     return $response;
}
 

public function validateSignupSmsCode($verification_code, $phone) {

      $data = json_encode([
          'verification_code'   =>  $verification_code,
          'phone_number'   => $phone,        
          '_csrftoken' =>  $this->token,
          'guid' => $this->uuid,
          'device_id' => $this->device_id,
          'waterfall_id' => $this->waterfall_id,

      ]);

      $response =   $this->request('accounts/validate_signup_sms_code/', $this->generateSignature($data));  

     //  preg_match('#Set-Cookie: csrftoken=([^;]+)#', $response[0], $matchresult);
     // $this->token = $matchresult[1];

     return $response;
}


 


public function createValidatedAccount($username, $verification_code, $phone, $full_name , $password) {

      $data = json_encode([
          'allow_contacts_sync' => 'false',
          'verification_code'   =>  $verification_code,
          'phone_id'   => $this->phone_id,
          'phone_number'   => $phone,   
          '_csrftoken' =>  $this->token,
          'username' => $username,
          'first_name' => $full_name,
          'guid' => $this->uuid,
          'device_id' => $this->device_id,
          'force_sign_up_code' => "",
          'waterfall_id' => $this->waterfall_id,
          'qs_stamp' => "",
          'password' => $password,
      ]);

      $result =   $this->request('accounts/create_validated/', $this->generateSignature($data));  

      if (isset($result[1]['account_created']) && ($result[1]['account_created'] == true)) {
          $this->username_id = $result[1]['created_user']['pk'];
          file_put_contents($this->IGDataPath."$username-userId.dat", $this->username_id);
          preg_match('#Set-Cookie: csrftoken=([^;]+)#', $result[0], $match);
          $token = $match[1];
          $this->username = $username;
          file_put_contents($this->IGDataPath."$username-token.dat", $token);
        ///NEW///
            file_put_contents($this->IGDataPath.$this->username.'-uuid.dat', $this->uuid);
             file_put_contents($this->IGDataPath.$this->username.'-phoneid.dat', $this->phone_id);
              file_put_contents($this->IGDataPath.$this->username.'-deviceid.dat', $this->device_id);
               file_put_contents($this->IGDataPath.$this->username.'-waterfall.dat', $this->waterfall_id);
        ///////
          // copy($this->IGDataPath.'cookies.dat', $this->IGDataPath.'cookies2.dat'); //no need??
          rename($this->IGDataPath.'cookies.dat', $this->IGDataPath."$username-cookies.dat");  
          // rename($this->IGDataPath.'cookies2.dat', $this->IGDataPath.'cookies.dat'); //no need?
      }


     //  preg_match('#Set-Cookie: csrftoken=([^;]+)#', $response[0], $matchresult);
     // $this->token = $matchresult[1];

     return $result;

}



  public function checkEmail($email)
  {
     
      // _csrftoken%22%3A%22hzJ1omdP00EUaTItOVQWSuTtxOnAhofJ%22%2C%22
      // email%22%3A%22b.l.a.ck.koro.l%40gmail.com%22%2C%22
      // qe_id%22%3A%22ea57180e-3663-446a-9356-e5d103f729dc%22%2C%22
      // waterfall_id%22%3A%2235c54e09-c815-41c3-8fb2-ef480e82a62f%22%7D

       
          // $this->token = trim(file_get_contents($this->IGDataPath."token.dat"));
          $data = json_encode([
              '_csrftoken'   =>  $this->token,     
              'email'   => $email,
              'qe_id'   => $this->uuid,        
              'waterfall_id' => $this->waterfall_id, 
          ]);
     

      $response =   $this->request('users/check_email/', $this->generateSignature($data));//[1];
      echo var_export($response);  
     
      preg_match('#Set-Cookie: csrftoken=([^;]+)#', $response[0], $matcht);
      $this->token = $matcht[1];
 
 
     return $response;
  }

  public function checkUsername($username)
  {
    
      //need test
    //expires time do not need ? ADD _csrstoken
    $data = json_encode([
          'username'   => $username,
          'qe_id'   => $this->uuid,        
          'waterfall_id' => $this->waterfall_id,
          '_csrftoken' => $this->token, 
      ]);

      $response =   $this->request('users/check_username/', $this->generateSignature($data))[1];  

     //  preg_match('#Set-Cookie: csrftoken=([^;]+)#', $response[0], $matchresult);
     // $this->token = $matchresult[1];

     return $response;


      // $data = json_encode([           
      //     '_uuid'      => $this->uuid,          ///SNIFFER do not need  
      //     'username'   => $username,
      //     '_csrftoken' => $this->token, //before 'missing',    ///SNIFFER do not need
      // ]);

      //  return  $this->request('users/check_username/', $this->generateSignature($data))[1];
        
  }


  public function fetchHeaders()
  {
    $outputs = $this->request('si/fetch_headers/?guid='.str_replace('-', '', $this->uuid).'&challenge_type=signup', null);
     

      preg_match('#Set-Cookie: csrftoken=([^;]+)#', $outputs[0], $matcht);
      $this->token = $matcht[1];

      echo var_export($outputs);
    return $outputs;
    
  }

public function usernameSuggestions($email ,$full_name) //not use for now
  {

    $data = json_encode([
      '_csrftoken'   => $this->token,
      'name'         => $full_name,                     //need fix to name
      'email'        => $email,
      'waterfall_id' => $this->waterfall_id,    
      ]);

      echo "\nPOST DATA: ".$this->generateSignature($data)."\n";

     $response =   $this->request('accounts/username_suggestions/', $this->generateSignature($data));//[1];
echo var_export( $response);



  preg_match('#Set-Cookie: csrftoken=([^;]+)#', $response[0], $matcht);
      $this->token = $matcht[1];
      

     return $response;
    
  }

 
  /**
   * Register account.
   *
   * @param string $username
   * @param string $password
   * @param string $email
   *
   * @return array
   *   Registration data
   */
  public function createAccount($username, $password, $email, $qs_stamp, $full_name)
  {

      $data = json_encode([
          'allow_contacts_sync' => 'false',
          'phone_id'           => $this->phone_id,
          '_csrftoken'         => $this->token,  
          'username'           => $username,
          'first_name'         => $full_name,           
          'guid'               => $this->uuid,
          'device_id'          => $this->device_id,
          'email'              => $email,
          'force_sign_up_code' => "",
          'waterfall_id'       => $this->waterfall_id,
          'qs_stamp'           => "",//$qs_stamp, 
          'password'           => $password,
      ]);


      echo "\nPOST DATA: ".$this->generateSignature($data)."\n";

      $result = $this->request('accounts/create/', $this->generateSignature($data));
     
      
      if (isset($result[1]['account_created']) && ($result[1]['account_created'] == true)) {
          $this->username_id = $result[1]['created_user']['pk'];
          file_put_contents($this->IGDataPath."$username-userId.dat", $this->username_id);
          preg_match('#Set-Cookie: csrftoken=([^;]+)#', $result[0], $match);
          $token = $match[1];
          $this->username = $username;
          file_put_contents($this->IGDataPath."$username-token.dat", $token);
           ///NEW///
            file_put_contents($this->IGDataPath.$this->username.'-uuid.dat', $this->uuid);
             file_put_contents($this->IGDataPath.$this->username.'-phoneid.dat', $this->phone_id);
              file_put_contents($this->IGDataPath.$this->username.'-deviceid.dat', $this->device_id);
        ///////
          // copy($this->IGDataPath.'cookies.dat', $this->IGDataPath.'cookies2.dat'); //no need??
          rename($this->IGDataPath.'cookies.dat', $this->IGDataPath."$username-cookies.dat");  
          // rename($this->IGDataPath.'cookies2.dat', $this->IGDataPath.'cookies.dat'); //no need?
      }

echo var_export($result);
      return $result;
  }

   public function generateSignature($data)
    {
        $hash = hash_hmac('sha256', $data, Constants::IG_SIG_KEY);

        return 'ig_sig_key_version='.Constants::SIG_KEY_VERSION.'&signed_body='.$hash.'.'.urlencode($data);
    }



    public function GenerateUserAgent() {  
      // NEED TEST
      // $csvfile = __DIR__.'/devices.csv';
      // $file_handle = fopen($csvfile, 'r');
      // $line_of_text = [];
      // while (!feof($file_handle)) {
      //     $line_of_text[] = fgetcsv($file_handle, 1024);
      // }
      // $deviceData = explode(';', $line_of_text[mt_rand(0, 11867)][0]);
      // fclose($file_handle);
      // return sprintf('Instagram 9.3.0 Android (18/4.3; 320dpi; 720x1280; %s; %s; %s; qcom; en_US)',  $deviceData[0], $deviceData[1], $deviceData[2]);


      return 'Instagram 9.3.0 Android (18/4.3; 320dpi; 720x1280; Xiaomi; HM 1SW; armani; qcom; en_US)';


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

      // //need test
      //    $uuid =  sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', 
      // mt_rand(0, 65535), 
      // mt_rand(0, 65535), 
      // mt_rand(0, 65535), 
      // mt_rand(16384, 20479), 
      // mt_rand(32768, 49151), 
      // mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
  

        return $type ? $uuid : str_replace('-', '', $uuid);
    }


      public function buildBodyFb($bodies, $boundary)
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



    public function fbRequestAppInstalled() 
    {
 

      $post = "anon_id=XZ".$this->fbTrackingId."&event=MOBILE_APP_INSTALL&application_package_name=com.instagram.android&application_tracking_enabled=1";
$endpoint = "https://graph.facebook.com/v2.3/124024574287414/activities";

     $headers = [
      'Host: graph.facebook.com',
      'Connection: keep-alive',
      'Content-Length: '.strlen($post),
      'Accept-Language: en-US', 
      'Content-type: application/x-www-form-urlencoded; charset=UTF-8',
      'Accept-Encoding: gzip, deflate',
       
     ];

     
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->UA ); //Constants::USER_AGENT); //// 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, true);//true 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); //need test
        //new
        curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
        // new
        curl_setopt($ch, CURLOPT_VERBOSE, false);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  //need test added
         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  //need test added

         if ( $this->proxy != null) {
          curl_setopt($ch, CURLOPT_PROXY, $this->proxy ); 
          curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); 
          curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'blackking:Name0123Space');
        }

        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
       


        
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
    // POST https://graph.facebook.com/v2.3/124024574287414/activities HTTP/1.1
 
    public function fbRequest()
    {

      $endpoint = 'https://graph.facebook.com/v2.3/124024574287414/activities';
      
      $boundary = 'F4Xd30I2Ginw6fMkwVpbqP3i39LAxq'; //a-c - e

      $bodies = [
          [
              'type' => 'form-data',
              'name' => 'custom_events_file',
              'filename' => 'custom_events_file',
              'headers'  => [
                  'Content-Type: application/json',
                  'Content-Transfer-Encoding: binary',
              ],
              'data' => json_encode([
                '_appVersion'  =>  '9.2.0', 
                '_logTime'     =>   time(),        //1472240105 , // replace with timestamp
                '_eventName'   =>  'fb_mobile_activate_app',
              ]),   
          ],
          [
              'type' => 'form-data',
              'name' => 'format',
              'data' => 'json',
          ],
          [
              'type' => 'form-data',
              'name' => 'anon_id',
              'data' => "XZ".$this->fbTrackingId,
          ],
          [
              'type' => 'form-data',
              'name' => 'event',
              'data' => 'CUSTOM_APP_EVENTS',
          ],
          [
              'type' => 'form-data',
              'name' => 'application_package_name',
              'data' => 'com.instagram.android',   
          ],
          [
              'type' => 'form-data',
              'name' => 'application_tracking_enabled',
              'data' => '1',   
          ],
      ];

        $data = $this->buildBodyFb($bodies, $boundary);
        
        $headers = [
          'Host: graph.facebook.com',
          'Connection: keep-alive',
          'Content-Length: '.strlen($data),
          'Accept-Language: en-US', 
          'Accept-Encoding: gzip, deflate',
          'Content-Type: multipart/form-data; boundary='.$boundary,  
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

        curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
        // curl_setopt($ch, CURLOPT_COOKIEFILE, $this->IGDataPath."$this->username-cookies.dat");
        // curl_setopt($ch, CURLOPT_COOKIEJAR, $this->IGDataPath."$this->username-cookies.dat");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        if ( $this->proxy != null) {
            curl_setopt($ch, CURLOPT_PROXY, $this->proxy ); 
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); 
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'blackking:Name0123Space');
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



    public function request($endpoint, $post = null)
    {
      
 

   $headers = [
        'Connection: close',
        'Accept: */*',
        'X-IG-Capabilities: 3Q4=',
        'X-IG-Connection-Type: WIFI',
        'Content-type: application/x-www-form-urlencoded; charset=UTF-8',
        'Cookie2: $Version=1',
        'Accept-Language: en-US',
    ];


     // $headers = [
     //  'Host: i.instagram.com',
     //  'Connection: keep-alive',
     //  'Content-Length: '.strlen($post),
     //  'X-IG-Connection-Type: WIFI',
     //  'X-IG-Capabilities: 3QI=',
     //  'Accept-Language: en-US', 
     //  'Accept-Encoding: gzip, deflate',
     //  'Content-type: application/x-www-form-urlencoded; charset=UTF-8',
     //  'Cookie2: $Version=1',
                 
     // ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, Constants::API_URL.$endpoint);
        //// curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->UA ); //Constants::USER_AGENT); //// 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, true);//true 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); //need test
        //new
        // curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
        // new
        curl_setopt($ch, CURLOPT_VERBOSE, false);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  //need test added
         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  //need test added

         if ( $this->proxy != null) {
          curl_setopt($ch, CURLOPT_PROXY, $this->proxy ); 
          curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); 
          curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'blackking:Name0123Space');
        }

        if (file_exists($this->IGDataPath."$this->username-cookies.dat")) {
            curl_setopt($ch, CURLOPT_COOKIEFILE, $this->IGDataPath."$this->username-cookies.dat");
            curl_setopt($ch, CURLOPT_COOKIEJAR, $this->IGDataPath."$this->username-cookies.dat");
        } else {
            curl_setopt($ch, CURLOPT_COOKIEFILE, $this->IGDataPath.'cookies.dat');  
            curl_setopt($ch, CURLOPT_COOKIEJAR, $this->IGDataPath.'cookies.dat');      
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
}
