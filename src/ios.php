<?php

 
class InstaOS  extends Threaded
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
 
  protected $waterfall_id;
  protected $phone_id;

 

public function run() {   
    

      $this->redis = $this->worker->getConnection();
      $this->debug = true;
      $IGDataPath = null;
      $this->UA = 'Instagram 9.5.2 (iPhone8,1; iPhone OS 9_3_1; ru_RU; ru-RU; scale=2.00; 750x1334) AppleWebKit/420+';
      
      $this->uuid = $this->generateUUID(true);
      $this->waterfall_id =  $this->generateUUID(true);

      // this data from redis
      $this->proxy = null; //$this->redis->spop('proxy');

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

      // $this->check_email();
      // $this->username_suggestions();
      // $this->check_username();
      // $this->create();

      // $this->sync();
      // $this->ayml();

 }



   public function syncFeaturesRegister()
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
       "id" =>  $this->uuid, //"F2CD7326-EA40-44F8-9FC3-71A0A5E1F55B",  
       "experiments" => "ig_ios_link_ci_in_reg_test,ig_ios_email_phone_switcher_universe,ig_ios_registration_robo_call_time,ig_ios_continue_as_2_universe,ig_ios_ci_checkbox_in_reg_test,ig_ios_reg_redesign,ig_ios_reg_flow_status_bar,ig_ios_one_click_login_tab_design_universe,ig_ios_password_less_registration_universe,ig_ios_iconless_contactpoint,ig_ios_universal_link_login,ig_ios_reg_filled_button_universe,ig_nonfb_sso_universe,enable_nux_language,ig_ios_iconless_confirmation,ig_ios_use_family_device_id_universe,ig_ios_one_click_login_universe_2,ig_ios_one_password_extension,ig_ios_new_fb_signup_universe,ig_ios_iconless_username",
     ]);
     //   // &ig_sig_key_version=5


      // $data =  'signed_body=88777998bb9b354a5e8882906247af04a84dca8930e055d1384a4d09e7dc32fc.%7B%22id%22%3A%22F2CD7326-EA40-44F8-9FC3-71A0A5E1F55B%22%2C%22experiments%22%3A%22ig_ios_link_ci_in_reg_test%2Cig_ios_email_phone_switcher_universe%2Cig_ios_registration_robo_call_time%2Cig_ios_continue_as_2_universe%2Cig_ios_ci_checkbox_in_reg_test%2Cig_ios_reg_redesign%2Cig_ios_reg_flow_status_bar%2Cig_ios_one_click_login_tab_design_universe%2Cig_ios_password_less_registration_universe%2Cig_ios_iconless_contactpoint%2Cig_ios_universal_link_login%2Cig_ios_reg_filled_button_universe%2Cig_nonfb_sso_universe%2Cenable_nux_language%2Cig_ios_iconless_confirmation%2Cig_ios_use_family_device_id_universe%2Cig_ios_one_click_login_universe_2%2Cig_ios_one_password_extension%2Cig_ios_new_fb_signup_universe%2Cig_ios_iconless_username%22%7D&ig_sig_key_version=5';


     // generateSignature($data);

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
// User-Agent: Instagram 9.5.2 (iPhone8,1; iPhone OS 9_3_1; ru_RU; ru-RU; scale=2.00; 750x1334) AppleWebKit/420+
// Accept-Language: ru-RU;q=1
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
// Accept-Language: ru-RU;q=1
// Content-Type: application/x-www-form-urlencoded; charset=UTF-8
// Content-Length: 199
// User-Agent: Instagram 9.5.2 (iPhone8,1; iPhone OS 9_3_1; ru_RU; ru-RU; scale=2.00; 750x1334) AppleWebKit/420+
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
// Accept-Language: ru-RU;q=1
// Content-Type: application/x-www-form-urlencoded; charset=UTF-8
// Content-Length: 472
// User-Agent: Instagram 9.5.2 (iPhone8,1; iPhone OS 9_3_1; ru_RU; ru-RU; scale=2.00; 750x1334) AppleWebKit/420+
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
    
     $outputs = $this->request('https://i.instagram.com/api/v1/feed/reels_tray/?tray_session_id=1ae5839959534712b3ffd12aa1a2cb6d');
    return $outputs;
}

public function discover_explore()
{
    
     $outputs = $this->request('https://i.instagram.com/api/v1/discover/explore/?is_on_wifi=true&network_transfer_rate=30.99&is_prefetch=true&session_id='.$this->username_id.'_'.$this->generateUUID(true).'&timezone_offset=10800');  /// fix for transfer rate
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
  


public function  notifications_badge()
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
          'Accept-Language: ru', 
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


//////2////

public function graphFb_activities_appinstall() {
 
  $endpoint = 'https://graph.facebook.com/v2.7/124024574287414/activities?advertiser_id=9AA0EE34-845C-4793-8830-0D3F354A474B&advertiser_tracking_enabled=1&anon_id=XZFF8E8CDC-77F3-4FFD-83C8-0CC2E75D8B61&application_tracking_enabled=1&event=MOBILE_APP_INSTALL&extinfo=%5B%22i2%22%2C%22com.burbn.instagram%22%2C%2241483633%22%2C%229.5.2%22%2C%229.3.1%22%2C%22iPhone8%2C1%22%2C%22ru_RU%22%2C%22GMT%2B3%22%2C%22Beeline%22%2C375%2C667%2C%222.00%22%2C2%2C12%2C11%2C%22Europe%5C%2FMoscow%22%5D&format=json&include_headers=false&sdk=ios&url_schemes=%5B%22fb124024574287414%22%2C%22instagram%22%2C%22instagram-capture%22%2C%22fsq%2Bkylm3gjcbtswk4rambrt4uyzq1dqcoc0n2hyjgcvbcbe54rj%2Bpost%22%5D';

  // https://graph.facebook.com/v2.7/124024574287414/activities?
  // rawurldecode(
  // advertiser_id=9AA0EE34-845C-4793-8830-0D3F354A474B
  // &advertiser_tracking_enabled=1
  // &anon_id=XZFF8E8CDC-77F3-4FFD-83C8-0CC2E75D8B61
  // &application_tracking_enabled=1&event=MOBILE_APP_INSTALL
  // &extinfo=["i2","com.burbn.instagram","41483633","9.5.2","9.3.1","iPhone8,1","ru_RU","GMT+3","Beeline",375,667,"2.00",2,12,11,"Europe\/Moscow"]
  // &format=json
  // &include_headers=false
  // &sdk=ios
  // &url_schemes=["fb124024574287414","instagram","instagram-capture","fsq+kylm3gjcbtswk4rambrt4uyzq1dqcoc0n2hyjgcvbcbe54rj+post"]
  // )

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
              'data' => 'XZFF8E8CDC-77F3-4FFD-83C8-0CC2E75D8B61',
          ],
          [
              'type' => 'form-data',
              'name' => 'application_tracking_enabled',
              'data' => '1',
          ],
          [
              'type' => 'form-data',
              'name' => 'extinfo',
              'data' => '["i2","com.burbn.instagram","41483633","9.5.2","9.3.1","iPhone8,1","ru_RU","GMT+3","Beeline",375,667,"2.00",2,12,11,"Europe/Moscow"]',
          ],
           [
              'type' => 'form-data',
              'name' => 'event',
              'data' => 'MOBILE_APP_INSTALL',
          ],
          [
              'type' => 'form-data',
              'name' => 'advertiser_id',
              'data' => '9AA0EE34-845C-4793-8830-0D3F354A474B',
                          
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
          'Accept-Language: ru', 
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

///////3//////



public function graphFb_activities_appevents() 
{


   $endpoint = 'https://graph.facebook.com/v2.7/124024574287414/activities?advertiser_id=9AA0EE34-845C-4793-8830-0D3F354A474B&advertiser_tracking_enabled=1&anon_id=XZFF8E8CDC-77F3-4FFD-83C8-0CC2E75D8B61&application_tracking_enabled=1&event=CUSTOM_APP_EVENTS&extinfo=%5B%22i2%22%2C%22com.burbn.instagram%22%2C%2241483633%22%2C%229.5.2%22%2C%229.3.1%22%2C%22iPhone8%2C1%22%2C%22ru_RU%22%2C%22GMT%2B3%22%2C%22Beeline%22%2C375%2C667%2C%222.00%22%2C2%2C12%2C11%2C%22Europe%5C%2FMoscow%22%5D&format=json&include_headers=false&sdk=ios&url_schemes=%5B%22fb124024574287414%22%2C%22instagram%22%2C%22instagram-capture%22%2C%22fsq%2Bkylm3gjcbtswk4rambrt4uyzq1dqcoc0n2hyjgcvbcbe54rj%2Bpost%22%5D';


 // https://graph.facebook.com/v2.7/124024574287414/activities?
 // advertiser_id=9AA0EE34-845C-4793-8830-0D3F354A474B
 // &advertiser_tracking_enabled=1
 // &anon_id=XZFF8E8CDC-77F3-4FFD-83C8-0CC2E75D8B61
 // &application_tracking_enabled=1
 // &event=CUSTOM_APP_EVENTS
 // &extinfo=["i2","com.burbn.instagram","41483633","9.5.2","9.3.1","iPhone8,1","ru_RU","GMT+3","Beeline",375,667,"2.00",2,12,11,"Europe\/Moscow"]
 // &format=json
 // &include_headers=false
 // &sdk=ios
 // &url_schemes=["fb124024574287414","instagram","instagram-capture","fsq+kylm3gjcbtswk4rambrt4uyzq1dqcoc0n2hyjgcvbcbe54rj+post"] 


     $boundary = '3i2ndDfv2rTHiSisAbouNdArYfORhtTPEefj3q2f'; 

      $bodies = [
          [
              'type' => 'form-data',
              'name' => 'custom_events_file',
              'filename' => 'custom_events_file',
              'headers'  => [
                  'Content-Type: content/unknown',   
              ],
              'data' => '[{"_ui":"no_ui","_eventName":"fb_mobile_activate_app","_logTime":1476716975,"_session_id":"24E504EA-4510-4F88-83AC-AB2E833B6B46","fb_mobile_launch_source":"Unclassified"}]',

          ],

          [
              'type' => 'form-data',
              'name' => 'anon_id',
              'data' => 'XZFF8E8CDC-77F3-4FFD-83C8-0CC2E75D8B61',
          ],
          [
              'type' => 'form-data',
              'name' => 'application_tracking_enabled',
              'data' => '1',
          ],
          [
              'type' => 'form-data',
              'name' => 'extinfo',
              'data' => '["i2","com.burbn.instagram","41483633","9.5.2","9.3.1","iPhone8,1","ru_RU","GMT+3","Beeline",375,667,"2.00",2,12,11,"Europe/Moscow"]',
          ],
           [
              'type' => 'form-data',
              'name' => 'event',
              'data' => 'CUSTOM_APP_EVENTS',
          ],
          [
              'type' => 'form-data',
              'name' => 'advertiser_id',
              'data' => '9AA0EE34-845C-4793-8830-0D3F354A474B',
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
          'Accept-Language: ru', 
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


public function timeline()
{

// Host: i.instagram.com
// Accept: *
// Proxy-Connection: keep-alive +
// X-IG-Connection-Type: WiFi +
// Accept-Language: ru-RU;q=1 +
// Accept-Encoding: gzip, deflate +
// X-IDFA: 9AA0EE34-845C-4793-8830-0D3F354A474B  /// -> facebook adveriser id +
// X-Ads-Opt-Out: 0
// X-FB: 0
// User-Agent: Instagram 9.5.2 (iPhone8,1; iPhone OS 9_3_1; ru_RU; ru-RU; scale=2.00; 750x1334) AppleWebKit/420+
// X-DEVICE-ID: F2CD7326-EA40-44F8-9FC3-71A0A5E1F55B    /// -> uuid +
// Connection: keep-alive +
// X-IG-Capabilities: 3wo=
// Cookie: csrftoken=ZcsBlgJVBdnESnAEUMBuWuy2W2vAwQRZ; ds_user_id=4050134364; mid=WATprwAAAAFg3XoGK03ZryWXvhJs; s_network=; sessionid=IGSC66cf8f8c5da55856662424dd8207ecdb44820e4a92d744132029951ed222570d%3AxB1GJdpcuewZSQgPxGpJbNALz3SXj8vd%3A%7B%22_token_ver%22%3A2%2C%22_auth_user_id%22%3A4050134364%2C%22_token%22%3A%224050134364%3AjASZsutTjkcaDyLDvHI8FQojv7nkLtkk%3A64b954b6b30319c845822728b604e02a96a17358a5787e752f5483944b41e135%22%2C%22asns%22%3A%7B%2295.73.175.251%22%3A25515%2C%22time%22%3A1476717052%7D%2C%22_auth_user_backend%22%3A%22accounts.backends.CaseInsensitiveModelBackend%22%2C%22last_refreshed%22%3A1476717052.30863%2C%22_platform%22%3A0%2C%22_auth_user_hash%22%3A%22%22%7D
// X-IG-INSTALLED-APPS: eyIxIjowLCIyIjowfQ==          /// -> check if the same for devices


  $endpoint = 'https://i.instagram.com/api/v1/feed/timeline/?unseen_posts=&recovered_from_crash=1&seen_posts=&is_prefetch=0&timezone_offset=10800';


$headers = [
        'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
        'Accept: *',
        'Accept-Encoding: gzip, deflate',
        'X-IDFA: 9AA0EE34-845C-4793-8830-0D3F354A474B',   /// -> facebook adveriser id'
        'X-Ads-Opt-Out: 0',
        'X-FB: 0',
        'X-DEVICE-ID: F2CD7326-EA40-44F8-9FC3-71A0A5E1F55B',  /// -> uuid 
        'Connection: keep-alive',
        'Proxy-Connection: keep-alive',
        'X-IG-Capabilities: 3wo=',
        'Accept-Language: ru-RU;q=1',
        'X-IG-Connection-Type: WiFi-Fallback',
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
        curl_setopt($ch, CURLOPT_COOKIEFILE,  $this->IGDataPath."cookies.dat");
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->IGDataPath."cookies.dat");
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
  // User-Agent: Instagram 9.5.2 (iPhone8,1; iPhone OS 9_3_1; ru_RU; ru-RU; scale=2.00; 750x1334) AppleWebKit/420+
  // Accept-Language: ru-RU;q=1
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

        $hash = hash_hmac('sha256', $data, 'ebbf19d239c4b2cff2df4b51cc626ffdad6fe27b5a7b39bd6e7e41b72f54c1f2'); // NEED TO EXTRACT KEY
        // echo "\n".($hash)."\n";
        
        return 'signed_body='.$hash.'.'.urlencode($data).'&ig_sig_key_version=5';
    }

 

  public function request($endpoint, $post = null, $login = false)
  {

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
        curl_setopt($ch, CURLOPT_USERAGENT, $this->UA);  // 9 5
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

          curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");

        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_COOKIEFILE,  $this->IGDataPath."cookies.dat");
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->IGDataPath."cookies.dat");
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


}
