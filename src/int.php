<?php


$user_ids = ['12335461' ,'49742317', '12335461' ,'49742317', '49742317', '12335461' ,'49742317', '49742317', '12335461' ,'49742317', '49742317', '12335461', '12335461', '49742317', '49742317', '12335461']; 

$removed_ids = ['12335461' ,'49742317'];
 // $result_string_added = "";


 //  $inter = 1;
 //  $del_y = 5.1;
 //  $del_x = 4.1;

 //  $interpol_x =  $inter / $del_x;
 //  $interpol_y =  $inter / $del_y;

 

 //  $y = 1;
 //  $counter = 1;
 //  foreach ($user_ids as $user_id ) {

 //  	$x_pos = round($counter*$interpol_x,7);
	// $y_pos = round($y*$interpol_y,7);
	// echo "--\n";
 //  	if ($counter % 4 == 0) {
 //  		$counter = 0;
 //  		$y = $y + 1;
 //  	}
 //  // $y = $counter * $interpol;
 //  // echo $y."\n";
 //  // $x =  $counter * $interpol ;
 //  // echo $x."\n";
 
 //  // $x_pos = round($x *  $interpol, 7);
 //  // $y_pos = round($y *  $interpol, 7);


 //  $added_user_string = '{\"user_id\":\"'. $user_id .'\",\"position\":['. $x_pos .','. $y_pos .']}'; 
 //  $result_string_added =  $result_string_added . ",".$added_user_string;
 //  	$counter = $counter + 1;
 //  }
 //  $final_added_string = '\"in\":['. $result_string_added .']';
 //  $final_string =  "{".$final_added_string."}";

// echo $final_string;


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

    echo $final_string;
