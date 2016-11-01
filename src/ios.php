<?php

// POST https://i.instagram.com/api/v1/qe/sync/ HTTP/1.1
// Host: i.instagram.com
// Content-Type: application/x-www-form-urlencoded; charset=UTF-8
// Accept: */*
// Accept-Encoding: gzip, deflate
// Connection: keep-alive
// Proxy-Connection: keep-alive
// X-IG-Capabilities: 3wo=
// User-Agent: Instagram 9.5.2 (iPhone8,1; iPhone OS 9_3_1; ru_RU; ru-RU; scale=2.00; 750x1334) AppleWebKit/420+
// Accept-Language: ru-RU;q=1
// Content-Length: 834
// X-IG-Connection-Type: WiFi-Fallback

// signed_body=88777998bb9b354a5e8882906247af04a84dca8930e055d1384a4d09e7dc32fc.%7B%22id%22%3A%22F2CD7326-EA40-44F8-9FC3-71A0A5E1F55B%22%2C%22experiments%22%3A%22ig_ios_link_ci_in_reg_test%2Cig_ios_email_phone_switcher_universe%2Cig_ios_registration_robo_call_time%2Cig_ios_continue_as_2_universe%2Cig_ios_ci_checkbox_in_reg_test%2Cig_ios_reg_redesign%2Cig_ios_reg_flow_status_bar%2Cig_ios_one_click_login_tab_design_universe%2Cig_ios_password_less_registration_universe%2Cig_ios_iconless_contactpoint%2Cig_ios_universal_link_login%2Cig_ios_reg_filled_button_universe%2Cig_nonfb_sso_universe%2Cenable_nux_language%2Cig_ios_iconless_confirmation%2Cig_ios_use_family_device_id_universe%2Cig_ios_one_click_login_universe_2%2Cig_ios_one_password_extension%2Cig_ios_new_fb_signup_universe%2Cig_ios_iconless_username%22%7D&ig_sig_key_version=5



   function syncFeaturesRegister()
    {


 // $data = json_encode([
 //        '_csrftoken'  => $this->token,
 //        'send_source' => "edit_profile",
 //         '_uid'       => $this->username_id,
 //        '_uuid'       => $this->uuid,
 //        'email'       => $email,
 //      ]);

// signed_body=88777998bb9b354a5e8882906247af04a84dca8930e055d1384a4d09e7dc32fc.
     $data = json_encode([
       "id" => "F2CD7326-EA40-44F8-9FC3-71A0A5E1F55B", //"f2cd7326-ea40-44f8-9fc3-71a0a5e1f55b",
       "experiments" => "ig_ios_link_ci_in_reg_test,ig_ios_email_phone_switcher_universe,ig_ios_registration_robo_call_time,ig_ios_continue_as_2_universe,ig_ios_ci_checkbox_in_reg_test,ig_ios_reg_redesign,ig_ios_reg_flow_status_bar,ig_ios_one_click_login_tab_design_universe,ig_ios_password_less_registration_universe,ig_ios_iconless_contactpoint,ig_ios_universal_link_login,ig_ios_reg_filled_button_universe,ig_nonfb_sso_universe,enable_nux_language,ig_ios_iconless_confirmation,ig_ios_use_family_device_id_universe,ig_ios_one_click_login_universe_2,ig_ios_one_password_extension,ig_ios_new_fb_signup_universe,ig_ios_iconless_username",
     ]);
     //   // &ig_sig_key_version=5


      // $data =  'signed_body=88777998bb9b354a5e8882906247af04a84dca8930e055d1384a4d09e7dc32fc.%7B%22id%22%3A%22F2CD7326-EA40-44F8-9FC3-71A0A5E1F55B%22%2C%22experiments%22%3A%22ig_ios_link_ci_in_reg_test%2Cig_ios_email_phone_switcher_universe%2Cig_ios_registration_robo_call_time%2Cig_ios_continue_as_2_universe%2Cig_ios_ci_checkbox_in_reg_test%2Cig_ios_reg_redesign%2Cig_ios_reg_flow_status_bar%2Cig_ios_one_click_login_tab_design_universe%2Cig_ios_password_less_registration_universe%2Cig_ios_iconless_contactpoint%2Cig_ios_universal_link_login%2Cig_ios_reg_filled_button_universe%2Cig_nonfb_sso_universe%2Cenable_nux_language%2Cig_ios_iconless_confirmation%2Cig_ios_use_family_device_id_universe%2Cig_ios_one_click_login_universe_2%2Cig_ios_one_password_extension%2Cig_ios_new_fb_signup_universe%2Cig_ios_iconless_username%22%7D&ig_sig_key_version=5';


     // generateSignature($data);

      $outputs = request('https://i.instagram.com/api/v1/qe/sync/', generateSignature($data) );
  
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
// User-Agent: Instagram 9.5.2 (iPhone8,1; iPhone OS 9_3_1; ru_RU; ru-RU; scale=2.00; 750x1334) AppleWebKit/420+
// Accept-Language: ru-RU;q=1
// Content-Length: 158
// X-IG-Connection-Type: WiFi-Fallback

// signed_body=6d2d1d44bb7f58a6bb7d0ebfa15f19d2d50f0fba355c1b0906220afc8a4911d2.%7B%22phone_id%22%3A%22%22%2C%22screen%22%3A%22landing%22%7D&ig_sig_key_version=5


   function show_continue_as()
    {

      // $data =  'signed_body=6d2d1d44bb7f58a6bb7d0ebfa15f19d2d50f0fba355c1b0906220afc8a4911d2.%7B%22phone_id%22%3A%22%22%2C%22screen%22%3A%22landing%22%7D&ig_sig_key_version=5';


     $data =  json_encode([
       "phone_id"=> "",
       "screen"=> "landing"
     ]);

     $outputs = request('https://i.instagram.com/api/v1/fb/show_continue_as/', generateSignature($data) );

      // preg_match('#Set-Cookie: csrftoken=([^;]+)#', $outputs[0], $matcht);
      // $this->token = $matcht[1];
      // echo var_export($outputs);  


        return $outputs;
    }


// POST https://i.instagram.com/api/v1/users/check_email/ HTTP/1.1
// Host: i.instagram.com
// Accept: */*
// Proxy-Connection: keep-alive
// X-IG-Connection-Type: WiFi
// Accept-Encoding: gzip, deflate
// Accept-Language: ru-RU;q=1
// Content-Type: application/x-www-form-urlencoded; charset=UTF-8
// Content-Length: 290
// User-Agent: Instagram 9.5.2 (iPhone8,1; iPhone OS 9_3_1; ru_RU; ru-RU; scale=2.00; 750x1334) AppleWebKit/420+
// Connection: keep-alive
// X-IG-Capabilities: 3wo=
// Cookie: csrftoken=h0rtCU9uwNd4CAojcO61cVEPUl4HbIGs; mid=WATprwAAAAFg3XoGK03ZryWXvhJs

// signed_body=21ebd1aaef2dc91204b3ff702d1599317060de732a117403637ad99e2588d250.%7B%22email%22%3A%22matveev.alexander.v.l.a.d.imit.ovi4%40gmail.com%22%2C%22qe_id%22%3A%22F2CD7326-EA40-44F8-9FC3-71A0A5E1F55B%22%2C%22_csrftoken%22%3A%22h0rtCU9uwNd4CAojcO61cVEPUl4HbIGs%22%7D&ig_sig_key_version=5



function check_email()
{

  // $data =  'signed_body=21ebd1aaef2dc91204b3ff702d1599317060de732a117403637ad99e2588d250.%7B%22email%22%3A%22matveev.alexander.v.l.a.d.imit.ovi4%40gmail.com%22%2C%22qe_id%22%3A%22F2CD7326-EA40-44F8-9FC3-71A0A5E1F55B%22%2C%22_csrftoken%22%3A%22h0rtCU9uwNd4CAojcO61cVEPUl4HbIGs%22%7D&ig_sig_key_version=5';

    $data = json_encode([
      "email" => "matveev.a.lexander.v.l.a.d.imit.ovi4@gmail.com",
      "qe_id" => "F2CD7326-EA40-44F8-9FC3-71A0A5E1F55B",
      "_csrftoken" => "h0rtCU9uwNd4CAojcO61cVEPUl4HbIGs"
    ]);

    $outputs = request('https://i.instagram.com/api/v1/users/check_email/', generateSignature($data) );

  // preg_match('#Set-Cookie: csrftoken=([^;]+)#', $outputs[0], $matcht);
  // $this->token = $matcht[1];
  // echo var_export($outputs);  

    return $outputs;
}


// POST https://i.instagram.com/api/v1/accounts/username_suggestions/ HTTP/1.1
// Host: i.instagram.com
// Accept: */*
// Proxy-Connection: keep-alive
// X-IG-Connection-Type: WiFi
// Accept-Encoding: gzip, deflate
// Accept-Language: ru-RU;q=1
// Content-Type: application/x-www-form-urlencoded; charset=UTF-8
// Content-Length: 260
// User-Agent: Instagram 9.5.2 (iPhone8,1; iPhone OS 9_3_1; ru_RU; ru-RU; scale=2.00; 750x1334) AppleWebKit/420+
// Connection: keep-alive
// X-IG-Capabilities: 3wo=
// Cookie: csrftoken=h0rtCU9uwNd4CAojcO61cVEPUl4HbIGs; mid=WATprwAAAAFg3XoGK03ZryWXvhJs

// signed_body=91c63e53bc961edae0e4054e1e0671ecdda20f43ee1e9f964893de043819bbe0.%7B%22name%22%3A%22Hanna%20Belford%22%2C%22waterfall_id%22%3A%2217988db1d11b4a1283ae288c339df454%22%2C%22_csrftoken%22%3A%22h0rtCU9uwNd4CAojcO61cVEPUl4HbIGs%22%7D&ig_sig_key_version=5



function username_suggestions()
{

  // $data =  'signed_body=91c63e53bc961edae0e4054e1e0671ecdda20f43ee1e9f964893de043819bbe0.%7B%22name%22%3A%22Hanna%20Belford%22%2C%22waterfall_id%22%3A%2217988db1d11b4a1283ae288c339df454%22%2C%22_csrftoken%22%3A%22h0rtCU9uwNd4CAojcO61cVEPUl4HbIGs%22%7D&ig_sig_key_version=5';

  $data = json_encode([
   
     "name"=>"Hanna Belford",
     "waterfall_id"=>"17988db1d11b4a1283ae288c339df454",
     "_csrftoken"=>"h0rtCU9uwNd4CAojcO61cVEPUl4HbIGs" 

    ]);

  $outputs = request('https://i.instagram.com/api/v1/accounts/username_suggestions/', generateSignature($data));

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
// Accept-Language: ru-RU;q=1
// Content-Type: application/x-www-form-urlencoded; charset=UTF-8
// Content-Length: 199
// User-Agent: Instagram 9.5.2 (iPhone8,1; iPhone OS 9_3_1; ru_RU; ru-RU; scale=2.00; 750x1334) AppleWebKit/420+
// Connection: keep-alive
// X-IG-Capabilities: 3wo=
// Cookie: csrftoken=h0rtCU9uwNd4CAojcO61cVEPUl4HbIGs; mid=WATprwAAAAFg3XoGK03ZryWXvhJs

// signed_body=0a8ab4311555dde3da733e30aa625d72278881574c6b4592259f2ac295ebfa1f.%7B%22username%22%3A%22belfordhanna%22%2C%22_csrftoken%22%3A%22h0rtCU9uwNd4CAojcO61cVEPUl4HbIGs%22%7D&ig_sig_key_version=5


function check_username()
{
 
  // $data =  'signed_body=0a8ab4311555dde3da733e30aa625d72278881574c6b4592259f2ac295ebfa1f.%7B%22username%22%3A%22belfordhanna%22%2C%22_csrftoken%22%3A%22h0rtCU9uwNd4CAojcO61cVEPUl4HbIGs%22%7D&ig_sig_key_version=5';

$data = json_encode([

      "username"=>"belfordhanna",
      "_csrftoken"=>"h0rtCU9uwNd4CAojcO61cVEPUl4HbIGs"

  ]);
  $outputs = request('https://i.instagram.com/api/v1/users/check_username/', generateSignature($data));

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
// Accept-Language: ru-RU;q=1
// Content-Type: application/x-www-form-urlencoded; charset=UTF-8
// Content-Length: 472
// User-Agent: Instagram 9.5.2 (iPhone8,1; iPhone OS 9_3_1; ru_RU; ru-RU; scale=2.00; 750x1334) AppleWebKit/420+
// Connection: keep-alive
// X-IG-Capabilities: 3wo=
// Cookie: csrftoken=h0rtCU9uwNd4CAojcO61cVEPUl4HbIGs; mid=WATprwAAAAFg3XoGK03ZryWXvhJs

// signed_body=1df4671b8226d552474999160d881214ca8144cbedb73518e1003fe5379b2718.%7B%22first_name%22%3A%22Hanna%20Belford%22%2C%22password%22%3A%22qweqwe123%22%2C%22waterfall_id%22%3A%2217988db1d11b4a1283ae288c339df454%22%2C%22device_id%22%3A%22F2CD7326-EA40-44F8-9FC3-71A0A5E1F55B%22%2C%22email%22%3A%22matveev.alexander.v.l.a.d.imit.ovi4%40gmail.com%22%2C%22username%22%3A%22belfordhanna%22%2C%22_csrftoken%22%3A%22h0rtCU9uwNd4CAojcO61cVEPUl4HbIGs%22%7D&ig_sig_key_version=5


function create()
{

 
  // $data =  'signed_body=1df4671b8226d552474999160d881214ca8144cbedb73518e1003fe5379b2718.%7B%22first_name%22%3A%22Hanna%20Belford%22%2C%22password%22%3A%22qweqwe123%22%2C%22waterfall_id%22%3A%2217988db1d11b4a1283ae288c339df454%22%2C%22device_id%22%3A%22F2CD7326-EA40-44F8-9FC3-71A0A5E1F55B%22%2C%22email%22%3A%22matveev.alexander.v.l.a.d.imit.ovi4%40gmail.com%22%2C%22username%22%3A%22belfordhanna%22%2C%22_csrftoken%22%3A%22h0rtCU9uwNd4CAojcO61cVEPUl4HbIGs%22%7D&ig_sig_key_version=5';


  $data = json_encode([

     "first_name" => "Hanna Belford",
     "password" => "qweqwe123",
     "waterfall_id" => "17988db1d11b4a1283ae288c339df454",
     "device_id" => "F2CD7326-EA40-44F8-9FC3-71A0A5E1F55B",
     "email"=>"matveev.alexander.v.l.a.d.imit.ovi4@gmail.com",
     "username"=>"belfordhanna",
     "_csrftoken"=>"h0rtCU9uwNd4CAojcO61cVEPUl4HbIGs"

    ]);
  $outputs = request('https://i.instagram.com/api/v1/accounts/create/', generateSignature($data));

  // preg_match('#Set-Cookie: csrftoken=([^;]+)#', $outputs[0], $matcht);
  // $this->token = $matcht[1];
  // echo var_export($outputs);  

    return $outputs;
}


 

  function generateSignature($data)
   {

        $hash = hash_hmac('sha256', $data, 'ebbf19d239c4b2cff2df4b51cc626ffdad6fe27b5a7b39bd6e7e41b72f54c1f2'); // NEED TO EXTRACT KEY
        // echo "\n".($hash)."\n";
        
        // $hash = '88777998bb9b354a5e8882906247af04a84dca8930e055d1384a4d09e7dc32fc';    
        // echo "\n".($hash)."\n";   
        return 'signed_body='.$hash.'.'.urlencode($data).'&ig_sig_key_version=5';
    }

 

function request($endpoint, $post = null, $login = false)
  {
      

	$IGDataPath = __DIR__.DIRECTORY_SEPARATOR.'dataios'.DIRECTORY_SEPARATOR;

    $headers = [

		'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
		'Accept: *',
		'Accept-Encoding: gzip, deflate',
		'Connection: keep-alive',
		'Proxy-Connection: keep-alive',
		'X-IG-Capabilities: 3wo=',
		'Accept-Language: ru-RU;q=1',
		'X-IG-Connection-Type: WiFi-Fallback',
		'Cookie2: $Version=1',
    ];


        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Instagram 9.5.2 (iPhone8,1; iPhone OS 9_3_1; ru_RU; ru-RU; scale=2.00; 750x1334) AppleWebKit/420+');  // 9 5
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

          curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");

        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_COOKIEFILE,  $IGDataPath."cookies.dat");
        curl_setopt($ch, CURLOPT_COOKIEJAR, $IGDataPath."cookies.dat");
        //  if ( $this->proxy != null) {
        //   curl_setopt($ch, CURLOPT_PROXY, $this->proxy ); 
        // curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); 
        // curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'blackking:Name0123Space');
        // }

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



 

syncFeaturesRegister();
show_continue_as();
check_email();
username_suggestions();
check_username();
// create();

