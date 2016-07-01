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
    protected $UA;


    public function __construct($proxy, $debug = false, $IGDataPath = null)
    {
        $this->proxy = $proxy;
        $this->debug = $debug;
        $this->uuid = $this->generateUUID(true);
        $this->UA = $this->GenerateUserAgent();

        if (!is_null($IGDataPath)) {
            $this->IGDataPath = $IGDataPath;
        } else {
            $this->IGDataPath = __DIR__.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR;
        }
    }

  /**
   * Checks if the username is already taken (exists).
   *
   * @param string $username
   *
   * @return array
   *   Username availability data
   */


  public function checkEmail($email)
  {
    
      $data = json_encode([
          '_uuid'      => $this->uuid,      ///SNIFFER do not need  
          'email'   => $email,
          '_csrftoken' => $this->token, //before 'missing',   ///SNIFFER do not need  
      ]);

      return  $this->request('users/check_email/', $this->generateSignature($data))[1];    
  }

  public function checkUsername($username)
  {
    
      $data = json_encode([           
          '_uuid'      => $this->uuid,          ///SNIFFER do not need  
          'username'   => $username,
          '_csrftoken' => $this->token, //before 'missing',    ///SNIFFER do not need
      ]);

       return  $this->request('users/check_username/', $this->generateSignature($data))[1];
        
  }


  public function fetchHeaders()
  {

    //   return  $this->request('si/fetch_headers/?challenge_type=signup&guid='.$this->generateUUID(false), null);
    // return  $this->request('si/fetch_headers/?challenge_type=signup&guid='.str_replace('-', '', $this->uuid), null);
    $outputs = $this->request('si/fetch_headers/?challenge_type=signup&guid='.str_replace('-', '', $this->uuid), null);
    preg_match('#Set-Cookie: csrftoken=([^;]+)#', $outputs[0], $matcht);
   $this->token = $matcht[1];
      
    return $outputs;
    

  }



// IPHONE FIRST REQUEST
// POST https://i.instagram.com/api/v1/qe/sync/ HTTP/1.1

// signed_body=86006ef8ada949e385c53d42268f16ebcf35838720fa72b158ea8b5188edb8ea.{
// "id":"F30F7D45-024B-478A-A1FC-75EC32B2F629",
// "experiments":"ig_ios_one_click_login_universe_2,ig_ios_disk_analytics,ig_ios_one_click_login_tab_design_universe,ig_ios_registration_phone_default_universe,ig_ios_analytics_compress_file,ig_ios_multiple_accounts_badging_universe,ig_ios_whiteout_kill_switch,ig_ios_password_less_registration_universe,ig_ios_use_family_device_id_universe,ig_ios_one_password_extension,enable_nux_language,ig_nonfb_sso_universe,ig_ios_branding_refresh,ig_ios_registration_robo_call_time,ig_ios_whiteout_dogfooding,ig_ios_white_camera_dogfooding_universe"}
// &ig_sig_key_version=5


//IPHONE CHECK MAIL https://i.instagram.com/api/v1/users/check_email/ 
// signed_body=e8c24cf5e1300e7246354e9acfee53759e3f2bebca34febd1ee098fc4a191c9b.{
// "email":"blackkor.ol@gmail.com",
// "qe_id":"F30F7D45-024B-478A-A1FC-75EC32B2F629",
// "_csrftoken":"b6a1980012719e40f632959733aa70a5"}
// &ig_sig_key_version=5


// IPHONE CREATE ACC
// signed_body=0e4c38cbd5d74f75fecf0f1263ab1479023bb9e894d6c23c233d94581f822468.{
// "email":"blackkor.ol@gmail.com",
// "username":"blackkor.ol",
// "password":"qweqwe123",
// "device_id": "F30F7D45-024B-478A-A1FC-75EC32B2F629",
// "_csrftoken": "b6a1980012719e40f632959733aa70a5",
// "waterfall_id": "aab6e73e80dc43bf84dba0acb734de72"} //waterfall_id = UUID.randomUUID().toString(); //without '-'
// &ig_sig_key_version=5


// WINDOWS PHONE CHECK USERNAME POST https://i.instagram.com/api/v1/users/check_username/ HTTP/1.1
// signed_body=c5bc1d54a43ff4359a510529888f51f9293ca482e8a053071c216efe0986e837.{
// "username":"anna+ja"
// }&ig_sig_key_version=99


 // WINDOWS PHONE CREATE ACC
 // signed_body=ac77bce16de7243d77f22d5d5ca32bc6571cdf6c2b319a9d480ca090e65abd55.{
 // "email":"black.korol@gmail.com",
 // "username": "annasuperkool",
 // "password":"qweqwe123",
 // "device_id":"android-c7188bae-8663-4345-b784-81efc751457f",
 // "guid":"c7188bae-8663-4345-b784-81efc751457f",
 // "first_name":null}
 // &ig_sig_key_version=99
    
  //WINDOWS PHONE NEXT GET https://i.instagram.com/api/v1/friendships/autocomplete_user_list/ HTTP/1.1
  //WINDOWS PHONE NEXT  PUSH REGISTER POST https://i.instagram.com/api/v1/push/register/ HTTP/1.1
  //   device_type=windowsphone
  // &device_token=http://a.notify.live.net/u/1/hk2/H2QAAADVoJHgwXvZZBGVm_Px9jwM_0sESg-S_R-MNFog8YUs9te_ZYCbyofMKcqiTb0ntnVP3oFRT5xtel3AotWAVQH306nNK14sGT3vRbXxPkVAvYRamzCVpDIyoJxDBF0SJSQ/d2luZG93c3Bob25lZGVmYXVsdA/JqEiMiB_c0KrShYRILIa6g/dZckeawzYM_7TCIRZWQgmcdlp7g

  // WINDOWS PHONE EDIT POST https://i.instagram.com/api/v1/accounts/edit_profile/ HTTP/1.1
  //   signed_body=9905916104527319e4115acde851bb74803d8f00134a416d113542c86577678c.{
  // "gender":"3",
  // "username":"annasuperkool",
  // "first_name":"",
  // "phone_number":"",
  // "email":"black.korol@gmail.com",
  // "external_url":"",
  // "biography":""}
  // &ig_sig_key_version=99


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
  public function createAccount($username, $password, $email, $qs_stamp)
  {
      $data = json_encode([
          'phone_id'           => $this->uuid,
          '_csrftoken'         => $this->token, //'missing', //
          'username'           => $username,
          'first_name'         => '',
          'guid'               => $this->uuid,
          // 'device_id'          => 'android-'.str_split(md5(mt_rand(1000, 9999)), 17)[mt_rand(0, 1)],  //worked but too many already registered
          'device_id'          => 'android-'.$this->generateUUID(true), //need test
          // 'device_id'          => 'android-'.$this->uuid,
          'email'              => $email,
          'force_sign_up_code' => '',
          'qs_stamp'           => $qs_stamp, //before ''
          'password'           => $password,
      ]);

      $result = $this->request('accounts/create/', $this->generateSignature($data));
      if (isset($result[1]['account_created']) && ($result[1]['account_created'] == true)) {
          $this->username_id = $result[1]['created_user']['pk'];
          file_put_contents($this->IGDataPath."$username-userId.dat", $this->username_id);
          preg_match('#Set-Cookie: csrftoken=([^;]+)#', $result[0], $match);
          $token = $match[1];
          $this->username = $username;
          file_put_contents($this->IGDataPath."$username-token.dat", $token);
          rename($this->IGDataPath.'cookies.dat', $this->IGDataPath."$username-cookies.dat");
      }

      return $result;
  }

    public function generateSignature($data)
    {
        $hash = hash_hmac('sha256', $data, Constants::IG_SIG_KEY);

        return 'ig_sig_key_version='.Constants::SIG_KEY_VERSION.'&signed_body='.$hash.'.'.urlencode($data);
    }


    public function GenerateUserAgent() {  
          $resolutions = ['720x1280', '320x480', '480x800', '1024x768', '1280x720', '768x1024', '480x320'];
          $versions = ['GT-N7000', 'SM-N9000', 'GT-I9220', 'GT-I9100'];
          $dpis = ['120', '160', '320', '240'];
           
          $ver = $versions[array_rand($versions)];
          $dpi = $dpis[array_rand($dpis)];
          $res = $resolutions[array_rand($resolutions)];
          
          // return 'Instagram 4.'.mt_rand(1,2).'.'.mt_rand(0,2).' Android ('.mt_rand(10,11).'/'.mt_rand(1,3).'.'.mt_rand(3,5).'.'.mt_rand(0,5).'; '.$dpi.'; '.$res.'; samsung; '.$ver.'; '.$ver.'; smdkc210; en_US)';

          return 'Instagram 8.2.0'.' Android ('.mt_rand(10,11).'/'.mt_rand(1,3).'.'.mt_rand(3,5).'.'.mt_rand(0,5).'; '.$dpi.'; '.$res.'; samsung; '.$ver.'; '.$ver.'; smdkc210; en_US)';
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

    public function request($endpoint, $post = null)
    {

        
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, Constants::API_URL.$endpoint);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->UA ); // Constants::USER_AGENT);
      
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt($ch, CURLOPT_PROXY, $this->proxy ); 
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); 
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'blackking:Name0123Space');


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
