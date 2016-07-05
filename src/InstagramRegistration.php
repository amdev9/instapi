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

    public function __construct($proxy, $debug = false, $IGDataPath = null)
    {
        $this->proxy = $proxy;
        $this->debug = $debug;
        $this->uuid = $this->generateUUID(true);

        //
         $this->phone_id = $this->generateUUID(true);
        $this->waterfall_id =  $this->generateUUID(true);
        $this->UA = $this->GenerateUserAgent();

        $this->device_id = 'android-'.bin2hex(openssl_random_pseudo_bytes(8));
        // str_split(md5(mt_rand(9999, 999999999999)), 16)[mt_rand(0, 1)]; 
        //

        // str_split(md5(mt_rand(9999, 999999999999)), 17)[mt_rand(0, 1)]; //99999999

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


 public function returnUUID()
  {
     return $this->uuid;
  }

 public function returnDeviceId()
  {
     return $this->device_id;
  }

 public function returnPhoneId()
  {
     return $this->phone_id;
  }


  public function checkEmail($email)
  {
    
      // $data = json_encode([ //before
      //     '_uuid'      => $this->uuid,      ///SNIFFER do not need  
      //     'email'   => $email,
      //     '_csrftoken' => $this->token, //before 'missing',   ///SNIFFER do not need  
      // ]);

      $data = json_encode([
          'email'   => $email,
          'qe_id'   => $this->uuid,        
          'waterfall_id' => $this->waterfall_id, 
      ]);

      $response =   $this->request('users/check_email/', $this->generateSignature($data));//[1];
      echo var_export($response);  
       preg_match('#Set-Cookie: csrftoken=([^;]+)#', $response[0], $matchresult);
      $this->token = $matchresult[1];
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

    //   return  $this->request('si/fetch_headers/?challenge_type=signup&guid='.$this->generateUUID(false), null);
    // return  $this->request('si/fetch_headers/?challenge_type=signup&guid='.str_replace('-', '', $this->uuid), null);
    $outputs = $this->request('si/fetch_headers/?guid='.str_replace('-', '', $this->uuid).'&challenge_type=signup', null);

   //  preg_match('#Set-Cookie: csrftoken=([^;]+)#', $outputs[0], $matcht);
   // $this->token = $matcht[1];
      
    return $outputs;
    
  }

public function usernameSuggestions($email)
  {
    $data = json_encode([
      '_csrftoken'   => $this->token,
      'name'         => '',                     //need fix to name
      'email'        => $email,
      'waterfall_id' => $this->waterfall_id,    
      ]);

      $response =   $this->request('accounts/username_suggestions/', $this->generateSignature($data))[1];
     return $response;
    
  }


// User-Agent: Instagram 8.3.0 Android (19/4.4.2; 320dpi; 720x1280; asus; PadFone 2; A68; qcom; ru_RU)

//ANDROID padfone CHECK MAIL https://i.instagram.com/api/v1/users/check_email/ 

// signed_body=26e80f5ab39e498f3e42e8106249987f23a9eb520b01f6d23fc408f62916bbd8.{
// "email"="blackkoro.l@gmail.com",
// "qe_id"="70079fbe-8663-4984-a564-f4e021f762de",
// "waterfall_id"="62a9bd9a-5a24-4cee-9d11-e33512de449d"}
// &ig_sig_key_version=4

//ANDROID GET https://i.instagram.com/api/v1/si/fetch_headers/?guid=70079fbe86634984a564f4e021f762de&challenge_type=signup HTTP/1.1
//RESPONSE!! {"status": "ok", "shift": 18, "header": "VcgkAma6zq7wP4TsRGfESjoLQtriNOIB", "edges": 100, "iterations": 10, "size": 42}

//ANDROID POST https://i.instagram.com/api/v1/accounts/username_suggestions/ HTTP/1.1
// signed_body=4f3e5002d8d396f709d7564a4575d587f639013b5d1a24379952bbd7f39e4a12.{
// "_csrftoken"="Gg24HfCNOJnER7ymHEKaAlVuVwEVBgL3",
// "name"="",
// "email"="blackkoro.l%40gmail.com",
// "waterfall_id"="62a9bd9a-5a24-4cee-9d11-e33512de449d"}
// &ig_sig_key_version=4

//ANDROID CREATE ACC  POST https://i.instagram.com/api/v1/accounts/create/ HTTP/1.1

//   signed_body=60e9c6b1eead6e6ebbb606d1505e50e3a4b6e606580f97e3e174fb6919e4904e.{
// "phone_id"="913d5b20-c76a-42d9-8132-ece7432fb11c",
// "_csrftoken"="Gg24HfCNOJnER7ymHEKaAlVuVwEVBgL3",
// "username"="blackkorol84567",
// "first_name"="",
// "guid"="70079fbe-8663-4984-a564-f4e021f762de",
// "device_id"="android-73fbaaf053107d8e",
// "email"="blackkoro.l@gmail.com",
// "force_sign_up_code"="",
// "waterfall_id"="62a9bd9a-5a24-4cee-9d11-e33512de449d",
// "qs_stamp"="1055,2734,3262,7756,15666,17956,27688,28057,28639,29759,33725,35275,36753,39425,41710,44088,47644,51482,52448,61818,62288,66538,70865,73490,76109,83455,84614,86199,86668,88357,89142,95198,99867,116711,124301,127355,131246,135837,135847,138330,156483,158728|842,7303,9906,10748,11449,21953,25855,27866,32125,33994,34044,40849,47336,47406,48225,49289,56751,66609,66888,75470,75836,76701,77976,78907,79007,82556,98894,100402,102265,110358,111657,116452,117648,121955,124571,130488,130702,137660,140621,144116,144484,150194|3004,5134,5741,6884,9703,11542,12043,13844,23061,23326,25894,27747,37092,40529,44901,48346,56208,61498,61717,70342,72206,74497,75908,79234,80279,92992,96441,97631,101822,106326,108915,109482,112894,113932,114151,115021,115440,119392,120920,127291,128675,149741|2660,3755,3943,4557,18451,22382,24540,26222,29335,37462,37637,46507,48801,49998,58344,60950,75992,78338,78584,80400,82003,86347,89196,92053,92198,92800,95927,102781,102878,107289,108044,108105,110513,110527,113163,117523,123259,124985,129297,132658,137030,154411|305,1234,3614,5278,11953,13461,18370,26837,27526,30256,30397,44710,46684,52496,52730,53605,56066,56955,58076,66128,75608,79988,80458,88027,92689,101533,102906,105108,106448,107324,108220,110054,111621,113453,123149,125012,128528,131047,131355,131410,144236,145496|600,6928,8966,10141,11086,11419,11595,16598,16911,20282,21636,24984,41192,41712,45616,49088,54214,58317,60209,67899,72120,73517,75927,76477,80670,83551,86592,89905,90016,93695,93732,95054,96736,97852,106258,106954,116807,123578,128366,129357,131034,156917|2719,5693,23855,27990,29912,30762,35619,40061,43052,48619,50509,54636,55217,59090,59636,66107,69430,70555,71927,77162,79409,81520,83656,86388,89778,99031,104690,107451,110122,112589,117364,121445,126359,128675,129613,130182,132437,132547,134095,136037,138523,153451|1537,10315,12167,12879,13638,16757,17604,21288,23670,26737,28576,31343,33883,37416,38637,42583,52963,64457,68469,68503,74572,75841,83600,88912,92459,98223,102472,104749,107236,107386,112605,116836,121000,122648,127349,131050,131818,140135,141053,141804,142778,149645|2358,6031,10150,15717,18303,20079,31616,33302,35879,39697,41029,47603,51680,66922,67834,71286,73957,74732,75222,78912,83144,83211,83800,84841,85401,86733,89973,91357,93620,94625,108743,112611,113367,116434,120854,123605,126009,127495,128662,133922,145801,146746|3321,10920,13469,16121,18383,20707,22051,29598,31156,31758,36694,40011,40892,42502,42710,44662,49517,51477,53063,66147,68372,69938,73058,74537,75073,80443,81434,85167,93631,98557,110055,110498,110736,111213,115880,119835,122621,125119,128336,130069,133377,143216",
// "password"="qweqwe5456"}&ig_sig_key_version=4



//ANDROID SYNC POST https://i.instagram.com/api/v1/qe/sync/ HTTP/1.1

//   signed_body=ec7fdd530925a6fa75dff69bfbfe46e292637c38afd256643b570e64224945c2.{
// "_csrftoken"="QxwM1rDI5rb9tge8pfD85sUWZqy18sUq",
// "id"="3491584929",
// "_uid"="3491584929",
// "_uuid"="70079fbe-8663-4984-a564-f4e021f762de",
// "experiments"="ig_android_progressive_jpeg,ig_creation_growth_holdout,ig_android_report_and_hide,ig_android_new_browser,ig_android_enable_share_to_whatsapp,ig_android_direct_drawing_in_quick_cam_universe,ig_android_universe_video_production,ig_android_direct_plus_button,ig_android_ads_heatmap_overlay_universe,ig_android_http_stack_experiment_2016,ig_android_infinite_scrolling,ig_android_direct_glyph,ig_fbns_blocked,ig_android_full_people_card_in_user_list,ig_android_post_auto_retry_v7_21,ig_fbns_push,ig_android_feed_pill,ig_android_profile_link_iab,ig_android_network_cancellation,ig_android_histogram_reporter,ig_android_anrwatchdog,ig_android_search_client_matching,ig_android_drafts_universe,ig_android_invite_entry_point_universe,ig_android_os_version_blocking,ig_android_high_res_upload_2,ig_android_new_browser_pre_kitkat,ig_android_2fac,ig_android_grid_video_icon,ig_android_video_recording_timer,ig_android_action_bar_text_button,ig_android_disable_chroma_subsampling,ig_android_share_spinner,ig_android_video_reuse_surface,ig_explore_v3_android_universe,ig_android_explore_people_feed_icon,ig_android_media_favorites,ig_android_nux_holdout,ig_android_search_null_state,ig_android_react_native_notification_setting,ig_android_ads_indicator_change_universe,liger_instagram_android_univ,ig_android_prefetch_explore_delay_time,ig_android_direct_emoji_picker,ig_android_comment_retry_tweaks_universe,ig_android_ru_page_update,ig_android_promoted_posts,ig_android_ads_cta_universe,ig_android_direct_send_auto_retry_universe,ig_android_disk_usage,ig_android_mini_inbox_2,ig_android_feed_reshare_button_nux,ig_android_boomerang_feed_attribution,ig_android_animate_share_button,ig_fbns_shared,ig_android_discover_people_compact,ig_android_react_native_edit_profile,ig_android_newsfeed_you_sections,ig_android_direct_post_to_feed,ig_android_feed_unit_footer,ig_android_media_tighten_space,ig_android_video_loopcount_int,ig_android_private_follow_request,ig_android_inline_gallery_backoff_hours_universe,ig_android_video_default_trim,ig_android_rendering_controls,ig_android_ads_cta_in_profile_style_universe,ig_android_ads_full_width_cta_universe,ig_video_max_duration_qe_preuniverse,ig_video_copyright_whitelist,ig_android_feed_send_battery_info_universe,ig_android_prefetch_explore_expire_time,ig_timestamp_public_test,ig_android_ads_heatmap_click_detect_universe,ig_android_profile,ig_android_dv2_consistent_http_realtime_response,ig_android_direct_blue_tab,ig_android_enable_share_to_messenger,ig_android_business_django_endpoint,ig_android_recommended_user_compact,ig_ranking_following,ig_android_newsfeed_banner_toast,ig_android_pending_request_search_bar,ig_android_feed_ufi_redesign,ig_android_pending_edits_dialog_universe,ig_android_video_pause_logging_fix,ig_android_default_folder_to_camera,ig_android_app_start_config,ig_android_fix_ise_two_phase,ig_android_video_stitching_7_23,ig_android_profanity_filter,ig_android_business_profile_qe,ig_android_search,ig_android_boomerang_entry,ig_android_inline_gallery_universe,ig_android_ads_overlay_design_universe,ig_android_options_app_invite,ig_android_view_count_decouple_likes_universe,ig_android_periodic_analytics_upload_v2,ig_android_feed_unit_hscroll_auto_advance,ig_peek_profile_photo_universe,ig_android_ads_holdout_universe,ig_android_prefetch_explore,ig_video_use_sve_universe,ig_android_inline_gallery_no_backoff_on_launch_universe,ig_android_camera_nux,ig_android_immersive_viewer,is_android_feed_seen_state,ig_android_share_profile_photo,ig_android_exoplayer,ig_android_add_to_last_post,ig_android_video_no_wait_for_image,ig_android_prefetch_venue_in_composer,ig_android_bigger_share_button,ig_android_dv2_realtime_private_share,ig_android_non_square_first,ig_android_video_interleaved_v2,ig_android_video_cache_policy,ig_android_video_captions_universe,ig_android_follow_search_bar,ig_android_last_edits,ig_android_video_download_logging,ig_android_ads_loop_count_universe,ig_android_swipeable_filters_blacklist,ig_android_direct_mention_qe,ig_android_direct_mutually_exclusive_experiment_universe,ig_android_following_follower_social_context"}&ig_sig_key_version=4

//ANDROID COLLECT FRIENDSHIPS CHECK GET https://i.instagram.com/api/v1/friendships/autocomplete_user_list/?followinfo=True&version=2 HTTP/1.1

//ANDROID PUSH REGISTER POST https://i.instagram.com/api/v1/push/register/ HTTP/1.1

// device_type=android_gcm
// &is_main_push_channel=true
// &phone_id=913d5b20-c76a-42d9-8132-ece7432fb11c
// &device_token=APA91bFJCnv_VOTNFV4RFaibfPPzCBn3Z9_FSA9N6cNTD_WB1wl0IeSr3OfE5bux1R6iZM9dWswDoI1t7Be2npggddbr628GNzG8V9kn1WnsQR-lwQthMAl1UopdbxRS264umtdEX16D
// &_csrftoken=QxwM1rDI5rb9tge8pfD85sUWZqy18sUq
// &guid=70079fbe-8663-4984-a564-f4e021f762de
// &_uuid=70079fbe-8663-4984-a564-f4e021f762de
// &users=3491584929  


//ANDROID DIRECT GET https://i.instagram.com/api/v1/direct_share/recent_recipients/ HTTP/1.1

//ANDROID SAME PUSH REQUSET!!!!!

//ANDROID POST https://i.instagram.com/api/v1/discover/ayml/ HTTP/1.1
//   phone_id=913d5b20-c76a-42d9-8132-ece7432fb11c
// &module=ayml_recommended_users
// &in_signup=true
// &_csrftoken=QxwM1rDI5rb9tge8pfD85sUWZqy18sUq
// &_uuid=70079fbe-8663-4984-a564-f4e021f762de
// &num_media=3

//ANDROID POST show recommendations https://i.instagram.com/api/v1/friendships/show_many/ HTTP/1.1
//   _csrftoken=QxwM1rDI5rb9tge8pfD85sUWZqy18sUq
// &user_ids=451573056,247944034,460563723,12281817,11830955,232192182,18428658,237074561,6860189,6380930,208560325,194697262,7719696,333052291,6590609,5697152,145821237,25945306,267685466,22288455,189003872,19343908,787132,1516824713,336735088,25025320,363632546,21965519,5510916,638144925,294251525,54305422,19769622,325732271,462752227,16363404,13864937,306227985,672417959,33647687,1821019,13384265,2242640123,24599245,666908117,16085990,1292592968,9281904,18478314,206022012,32973926,55260131,1153515988,28817713,1328701983,5484832,9766379,173974522,239727980,192355789,3532778,19596899,1564117978,231402544,8873242,1574083,24239929,12095217,195734327,625833324,173715345,55795588,1338968500,9902057,261272262,519673397,12246775,276192188,218374838,1097866395,7732613,21193118,1275031695,6359592,627934998,19359711,244942700,144646783,192417402,50326174,17557170,12335461,363285930,1274152083,49014950,52142935,29883180,1125136179,44534314,2336468
// &_uuid=70079fbe-8663-4984-a564-f4e021f762de

//ANDROID EDIT PROFILE POST https://i.instagram.com/api/v1/accounts/edit_profile/ HTTP/1.1
  //signed_body=cec9d8958d6b46d1ceed31cb57c4574ff0681430c210107567ad305faaa57795.{
// "external_url"="http=%2F%2Fpornohub.com",
// "gender"="3",
// "phone_number"="",
// "_csrftoken"="QxwM1rDI5rb9tge8pfD85sUWZqy18sUq",
// "username"="blackkorol84567",
// "first_name"="",
// "_uid"="3491584929",
// "biography"="%5Cn",
// "_uuid"="70079fbe-8663-4984-a564-f4e021f762de",
// "email"="blackkoro.l@gmail.com"}
// &ig_sig_key_version=4


//ANDROID2 GET https://i.instagram.com/api/v1/location_search/?latitude=56.759945&timestamp=1329426118000&longitude=37.1314441&search_query=n HTTP
  //Instagram 8.4.0 Android (17/4.2.2; 160dpi; 600x976; samsung; GT-P3100; espressorf; espresso; ru_RU)

//getLocationFeed then


// User-Agent: Instagram 8.3.0 (iPhone6,1; iPhone OS 9_3; ru_RU; ru-RU; scale=2.00; 640x1136) AppleWebKit/420+

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



// User-Agent: Instagram 5.0.0 Windows Phone (8.10.14219.0; 480x800; NOKIA; RM-846_apac_hong_kong_220; ru_RU)

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

    // signed_body=60e9c6b1eead6e6ebbb606d1505e50e3a4b6e606580f97e3e174fb6919e4904e.{
// "phone_id"="913d5b20-c76a-42d9-8132-ece7432fb11c",
// "_csrftoken"="Gg24HfCNOJnER7ymHEKaAlVuVwEVBgL3",
// "username"="blackkorol84567",
// "first_name"="",
// "guid"="70079fbe-8663-4984-a564-f4e021f762de",
// "device_id"="android-73fbaaf053107d8e",
// "email"="blackkoro.l@gmail.com",
// "force_sign_up_code"="",
// "waterfall_id"="62a9bd9a-5a24-4cee-9d11-e33512de449d",
// "qs_stamp"


      $data = json_encode([
          'phone_id'           => $this->phone_id,
          '_csrftoken'         => $this->token, //'missing', //
          'username'           => $username,
          'first_name'         => '',           //need test add this
          'guid'               => $this->uuid,
          //'device_id'          => 'android-'.str_split(md5(mt_rand(1000, 9999)), 17)[mt_rand(0, 1)],  //worked but too many already registered
           'device_id'          => $this->device_id,
          // 'device_id'          => 'android-'.$this->generateUUID(true), //need fix!!
          // 'device_id'          => 'android-'.$this->uuid,
          'email'              => $email,
          'force_sign_up_code' => '',
          'waterfall_id'       => $this->waterfall_id,
          'qs_stamp'           => $qs_stamp, 
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
        curl_setopt($ch, CURLOPT_USERAGENT, Constants::USER_AGENT); //$this->UA ); // 
      
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
