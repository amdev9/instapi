<?php
 

//  class Email_reader {

//   // imap server connection
//   public $conn;

//   // inbox storage and inbox message count
//   private $inbox;
//   private $msg_cnt;

//   // email login credentials


// // $hostname = 
// // $username = 
// // $password = 


//   private $server = '{imap.gmail.com:993/imap/ssl}INBOX';
//   private $user   = 'iprofilenumberqweqweqweqweqweq@gmail.com';
//   private $pass   = 'iprofilenumber';
 
//   // connect to the server and get the inbox emails
//   function __construct() {
//     $this->connect();
//     $this->inbox();
//   }

//   // close the server connection
//   function close() {
//     $this->inbox = array();
//     $this->msg_cnt = 0;

//     imap_close($this->conn);
//   }

//   // open the server connection
//   // the imap_open function parameters will need to be changed for the particular server
//   // these are laid out to connect to a Dreamhost IMAP server
//   function connect() {
//     $this->conn = imap_open($this->server, $this->user, $this->pass);
//   }

//   // move the message to a new folder
//   function move($msg_index, $folder='INBOX.Processed') {
//     // move on server
//     imap_mail_move($this->conn, $msg_index, $folder);
//     imap_expunge($this->conn);

//     // re-read the inbox
//     $this->inbox();
//   }

//   // get a specific message (1 = first email, 2 = second email, etc.)
//   function get($msg_index=NULL) {
//     if (count($this->inbox) <= 0) {
//       return array();
//     }
//     elseif ( ! is_null($msg_index) && isset($this->inbox[$msg_index])) {
//       return $this->inbox[$msg_index];
//     }

//     return $this->inbox[0];
//   }

//   // read the inbox
//   function inbox() {
//     $this->msg_cnt = imap_num_msg($this->conn);

//     $in = array();
//     for($i = 1; $i <= $this->msg_cnt; $i++) {
//       $in[] = array(
//         'index'     => $i,
//         'header'    => imap_headerinfo($this->conn, $i),
//         'body'      => imap_body($this->conn, $i),
//         'structure' => imap_fetchstructure($this->conn, $i)
//       );
//     }

//     $this->inbox = $in;
//   }

// }


// $r = new Email_reader();
// echo $r->get(1);

$hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
$username = 'iprofilenumberqweqweqweqweqweq@gmail.com';
$password = 'iprofilenumber';


 
$inbox = imap_open($hostname,$username,$password); 

echo "fine";
$message_len = imap_num_msg($inbox)."\n";


$emails = imap_search($inbox,'ALL');

rsort($emails);

foreach($emails as $email_number) {

    $overview = imap_fetch_overview($inbox,$email_number,0);
    // $message = imap_fetchbody($inbox,$email_number, 1);

    $message = quoted_printable_decode(imap_fetchbody($inbox,$email_number,1)); 

   
    $pattern = '/^lose your phone number/';
    
    preg_match($pattern, $message, $matches, PREG_OFFSET_CAPTURE, 3);
print_r($matches);

//Don't lose your phone number!
    // $header = imap_headerinfo($inbox,$email_number);
    // $overview = imap_fetch_overview($inbox,$email_number);
    // $message = imap_fetchbody($inbox,$email_number ,0 );
    // echo var_export($header)."\n";
    // echo var_export($overview)."\n";
    // echo $message."\n";


    break;
}

imap_close($inbox);


// Загрузка штампа и фото, для которого применяется водяной знак (называется штамп или печать)

// $im = imagecreatefromjpeg('2.jpg');

// $degrees = 10;
// $rotate = imagecreatefromjpeg('2.jpg');

//         $square_size = imagesx($rotate); //960 

//         $original_width = imagesx($rotate); 
//         $original_height = imagesy($rotate);
//         if($original_width > $original_height){
//             $new_height = $square_size;
//             $new_width = $new_height*($original_width/$original_height);
//         }
//         if($original_height > $original_width){
//             $new_width = $square_size;
//             $new_height = $new_width*($original_height/$original_width);
//         }
//         if($original_height == $original_width){
//             $new_width = $square_size;
//             $new_height = $square_size;
//         }

//         $new_width = round($new_width);
//         $new_height = round($new_height);

//         $smaller_image = imagecreatetruecolor($new_width, $new_height);
//         $square_image = imagecreatetruecolor($square_size, $square_size);

//         imagecopyresampled($smaller_image, $rotate, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);

//         if($new_width>$new_height){
//             $difference = $new_width-$new_height;
//             $half_difference =  round($difference/2);
//             imagecopyresampled($square_image, $smaller_image, 0-$half_difference+1, 0, 0, 0, $square_size+$difference, $square_size, $new_width, $new_height);
//         }
//         if($new_height>$new_width){
//             $difference = $new_height-$new_width;
//             $half_difference =  round($difference/2);
//             imagecopyresampled($square_image, $smaller_image, 0, 0-$half_difference+1, 0, 0, $square_size, $square_size+$difference, $new_width, $new_height);
//         }
//         if($new_height == $new_width){
//             imagecopyresampled($square_image, $smaller_image, 0, 0, 0, 0, $square_size, $square_size, $new_width, $new_height);
//         }

         
//         $square_image = imagerotate($square_image, $degrees, 0);

//         $rotated_size = imagesx($square_image);
//         $enlargement_coeff = ($rotated_size - $square_size) * 1.807;
//         $enlarged_size = round($rotated_size + $enlargement_coeff);
//         $enlarged_image = imagecreatetruecolor($enlarged_size, $enlarged_size);
//         $final_image = imagecreatetruecolor($square_size, $square_size);

//         imagecopyresampled($enlarged_image, $square_image, 0, 0, 0, 0, $enlarged_size, $enlarged_size, $rotated_size, $rotated_size);
//         imagecopyresampled($final_image, $enlarged_image, 0, 0, round($enlarged_size / 2) - ($square_size / 2), round($enlarged_size / 2) - ($square_size / 2), $square_size, $square_size, $square_size, $square_size);





// // Установка полей для штампа и получение высоты/ширины штампа
// // $marge_right = 10;
// // $marge_bottom = 10;


// $stamp = imagecreatefrompng('stamp2.png');
// $sx = imagesx($stamp);
// $sy = imagesy($stamp);
// $marge_right = 30;
// imagecopy($final_image, $stamp, imagesx($final_image) - $sx + $marge_right , imagesy($final_image) - $sy , 0, 0, imagesx($stamp), imagesy($stamp));


// // Копирование изображения штампа на фотографию с помощью смещения края
// // и ширины фотографии для расчета позиционирования штампа. 

// //- $marge_bottom
// //
// // Вывод и освобождение памяти
// // header('Content-type: image/png');
// imagejpeg($final_image, "result.jpg");
// imagedestroy($final_image);



// echo time()."\n";
// echo md5(microtime())."\n";

// echo '97f2065bab894294ae8dcf8f2a6fcbe8';
// // $a= base64_encode(microtime());

//   // openssl_random_pseudo_bytes(19));

// echo $a."\n-->";

// echo base64_decode('F4Xd30I2Gnhc6fMiwVpbqP3i39LAxq');



// echo openssl_random_pseudo_bytes(8)."\n";
//  echo bin2hex(openssl_random_pseudo_bytes(8));
 
 
//   $password = explode(" ",$redis->spop("tologin"))[1]  ;  

//   echo var_export($userarray);
// echo  $password;

// function shuffle_assoc($list) { 
//   if (!is_array($list)) return $list; 

//   $keys = array_keys($list); 
//   shuffle($keys); 
//   $random = array(); 
//   foreach ($keys as $key) { 
//     $random[$key] = $list[$key]; 
//   }
//   return $random; 
// }


//  $dir = '/Users/alex/dev/instapi/src/adult/';
//  $filesVideo = scandir($dir);
//     ///!!!! need shuffle with test curl.php
//     $ava = true;
//     $uploadCounter = 0;


// $filesVid = shuffle_assoc($filesVideo);
// foreach ( $filesVid as $k => $value ) {
//           $ext = pathinfo($value, PATHINFO_EXTENSION);
// if ($ext == 'jpg') {
//   if ($uploadCounter == 2) { break; }
//   echo "$value \n";
// $uploadCounter = $uploadCounter + 1;
// }
// }

    // echo var_export($filesVideo);


 // echo rand(-12,12);
// echo count($argv);

// $variable = 100;
// $a = false;
// // while ($variable < 1000) {
// if (  $a != true && ($variable % 100 != 0 || $variable == 0) ) {
//     echo 'This number is divisible by 6. --> '.$variable."\n";
// }
// $variable = $variable +1;
  // sleep(1);
// }

// $acmed = "134534";

// if (strpos($acmed, ':') !== false) {
//           $datapart = explode(":", $acmed);
//             $actioner =   $datapart[0];
//             $medcom =  $datapart[1];
//         }
//         else 
//         {
//             $actioner =   $acmed ;
//         }
//         echo $actioner;
//         // echo $medcom;
        


// $caption = "Check out link in bio for her contacts 👆👆👆 \u{2029}";


// $tags = ["18", "follow4follow", "followforfollow", "Body", "CalvinKlein", "FitGirl", "FitnesGirls", "Fitness", "FitnessAddict", "FitnesssGirl", "GirlBody", "Motivation", "PerfectBody", "Work", "Workout", "adult", "babestation", "bigboss", "bigtitties", "bikini", "cool", "danniharwood", "dm", "fancy", "fit", "fitness", "fitnessmodel", "fuckyou", "gym", "health", "hotsexy", "hotties", "instadaily", "instagood", "juliaann", "kiaramia", "kiaramiateam", "ledlight", "like4like", "likeforlike", "lisaann", "love", "lust", "meena", "miakhalifa", "porn", "pornbros", "pornofood", "pornstarr", "prettyyoung", "pörn", "pörnstars", "recentforrecent", "sex", "sexchat", "sexvid", "sophiedee", "squats", "suckforme", "swag", "sëxchat", "sëxy", "twerk", "workout"];


//  $captiontag = [];
// while (count($captiontag) < 29)
// {
//   $tag = $tags[mt_rand(0, count($tags) - 1)];
//   array_push($captiontag, "#".$tag);
// }

// $caption =  $caption . implode(" ", $captiontag); 
// echo $caption;

 // exec("python /Users/alex/home/dev/rails/instagram/scrapping/gamm/decodesms.py", $runned);

  // $txt='Use 306 759 to verify your Instagram account.';

  // $re1='.*?'; # Non-greedy match on filler
  // $re2='(\\d+)';  # Integer Number 1
  // $re3='.*?'; # Non-greedy match on filler
  // $re4='(\\d+)';  # Integer Number 2

  // if ($c=preg_match_all ("/".$re1.$re2.$re3.$re4."/is", $txt, $matches))
  // {
  //     $int1=$matches[1][0];
  //     $int2=$matches[2][0];
  //     print "$int1$int2\n";
  // }

  #-----
  # Paste the code into a new php file. Then in Unix:
  # $ php x.php 
  #-----


  #-----
  # Paste the code into a new php file. Then in Unix:
  # $ php x.php 
  #-----


// $gd = imagecreatetruecolor($x, $y);

// $photo = "1.jpg";
// $fileToUpload1 = imagecreatefromjpeg($photo);
// $imgdata = getimagesize($photo);
// $width = $imgdata[0];
// $height = $imgdata[1];
// $pix_w=mt_rand(0, $width);
// $pix_h=mt_rand(0, $height);
// // echo $pix_w." ".$pix_h;
// $rgb = imagecolorat($fileToUpload1, $pix_w,$pix_h+10);
// imagesetpixel($fileToUpload1, $pix_w , $pix_h, $rgb);

 

// ob_start();
// imagejpeg($fileToUpload1);
// $contents =  ob_get_contents();
// ob_end_clean();

// echo $contents;

   // $fileToUpload = file_get_contents($fileToUpload1);
   // echo  $fileToUpload ;
// imagejpeg($fileToUpload, "test3.jpg");

 
// $corners[0] = array('x' => 100, 'y' =>  10);
// $corners[1] = array('x' =>   0, 'y' => 190);
// $corners[2] = array('x' => 200, 'y' => 190);



// $rgb = imagecolorallocate($gd, 255, 255, 255); 

// for ($i = 0; $i < 100000; $i++) {
//   imagesetpixel($gd, round($x),round($y), $red);
//   $a = rand(0, 2);
//   $x = ($x + $corners[$a]['x']) / 2;
//   $y = ($y + $corners[$a]['y']) / 2;
// }
 



// header('Content-Type: image/png');


 



 // $emojstring = "💦";

 // echo $emojstring;
 // echo json_decode($emojstring);

 // echo "\u{1F4A6}";


// $number = 4;
//  if($number %4 == 0) {
// //    echo "wer";
// // }

// function checkFFMPEG()
// {
//     @exec('ffmpeg -version 2>&1', $output, $returnvalue);
//     if ($returnvalue === 0) {
//         return 'ffmpeg';
//     }
//     @exec('avconv -version 2>&1', $output, $returnvalue);
//     if ($returnvalue === 0) {
//         return 'avconv';
//     }

//     return false;
// }


// $ffmpeg = checkFFMPEG();
//     if ($ffmpeg) {

//  $time = exec("$ffmpeg -i /Users/alex/home/dev/rails/instagram/InstAPI/src/9/lamberis\ george\ instagram_BHMTX6rDcTj.mp4 2>&1 | grep 'Duration' | cut -d ' ' -f 4");
//         $duration = explode(':', $time);
//         $seconds = $duration[0] * 3600 + $duration[1] * 60 + round($duration[2]);

// echo $seconds;
// }
 
 
// // $line = trim(fgets(STDIN));
//   $line = "";
//   while( ctype_digit($line) != true) {
//  $line = readline("Command: ");

// }

// echo "\nentered -->".$line."\n\n";
 
   
// $txt = 'Алиса Варум';
// $re1='.*?';	# Non-greedy match on filler
// $re2='((?:[а-яa-z][a-яa-z]+))';	# Word 1
// $word1 = "";
// if ($c=preg_match_all ("/".$re1.$re2."/is", $txt, $matches))
// {
//   $word1=$matches[1][0];
// }

// echo $word1;
  //   $smiles_hi =  ["\u{26A1}", "\u{1F60C}"   ,  "\u{270C}", "\u{1F47B}", "\u{1F525}",  "\u{270B}"];
  //         $smi_hi = $smiles_hi[mt_rand(0, count($smiles_hi) - 1)];

  // echo $text = "Добрый день! $smi_hi\u{2029}\u{2757} Попробуйте признанную во всём мире органическую маску для лица @__blackmask__ \u{2757}\u{2029}\u{2753} Почему тысячи девушек выбирают Black Mask? \u{1F4AD}\u{2029}\u{2705} Потому что наша маска:\u{2029}\u{1F539} оказывает успокаивающее действие на раздраженную и воспаленную кожу;\u{2029}\u{1F539} разглаживает морщинки,возрастные складки, выравнивает текстуру кожи;\u{2029}\u{1F539} делает контур лица более четким;\u{2029}\u{1F539} улучшает цвет лица;\u{2029}\u{1F539} поглощает токсины,устраняет с поверхности эпидермиса мертвые клетки; борется с акне и прыщами\u{2029}\u{1F539} делает практически незаметными пигментные пятна различного происхождения \u{1F64C}\u{2029}\u{1F33F} При этом, маска полностью натуральная  \u{2029}\u{2705}ГАРАНТИРОВАННЫЙ РЕЗУЛЬТАТ В ТЕЧЕНИЕ 2-Х НЕДЕЛЬ! УСПЕЙ ЗАКАЗАТЬ СЕГОДНЯ ПО АКЦИИ!\u{2029}\u{27A1} Активная ссылка и подробности акции в описании профиля \u{27A1}\u{2029}\u{1F449} @__blackmask__  \u{1F448}\u{2029}\u{1F449} @__blackmask__  \u{1F448}\u{2029}\u{1F449} @__blackmask__  \u{1F448}";

              
  
//       $csvfile = __DIR__.'/devices.csv';
//       $file_handle = fopen($csvfile, 'r');
//       $line_of_text = [];
//       while (!feof($file_handle)) {
//           $line_of_text[] = fgetcsv($file_handle, 1024);
//       }
//       $deviceData = explode(';', $line_of_text[mt_rand(0, 11867)][0]);
//       fclose($file_handle);

    
  



// echo sprintf('Instagram %s Android (18/4.3; 320dpi; 720x1280; %s; %s; %s; qcom; en_US)', '8.5.1', $deviceData[0], $deviceData[1], $deviceData[2]);


  // $smiles_list =  ["\u{1F60C}" ,"\u{1F60D}" , "\u{1F61A}"  ,"\u{1F618}", "\u{2764}"];
  //         $smiles_hi =  ["\u{26A1}", "\u{1F48B}","\u{1F609}", "\u{1F633}", "\u{1F60C}" , "\u{1F61A}"  ,"\u{1F618}", "\u{270C}", "\u{1F47B}", "\u{1F525}", "\u{1F607}", "\u{1F617}", "\u{1F619}", "\u{1F60E}", "\u{1F61C}", "\u{270B}",  "\u{1F60B}"];
  //         $smiles =  ["\u{1F609}", "\u{1F60C}" ];  
  //       // $cursors = ["\u{261D}" , "\u{2B06}", "\u{2934}", "\u{1F53C}", "\u{1F51D}" ];  
  //      //    $cur = $cursors[mt_rand(0, count($cursors) - 1)];
  //          $smi = $smiles_list[mt_rand(0, count($smiles_list) - 1)];
  //         $smi_hi = $smiles_hi[mt_rand(0, count($smiles_hi) - 1)];
  //      $smil = $smiles[mt_rand(0, count($smiles) - 1)];
  //       $first_name_txt = explode(" ","Anna Kas");
  //        $hi_word = ["Hey! What's up? I am", "Hi! I am", "Hey there, I am"];
  //       $hiw = $hi_word[mt_rand(0, count($hi_word) - 1)];

  //       // $text = "$hiw $first_name_txt[0] $smi_hi Follow this awesome profile with naughty girls @livecamshowtvonline $smil $smi $cur $cur $cur";
           
  //       $smiles_hi =  ["\u{26A1}", "\u{1F60C}"   ,  "\u{270C}", "\u{1F47B}", "\u{1F525}", "\u{270B}"];
  //         $smi_hi = $smiles_hi[mt_rand(0, count($smiles_hi) - 1)];
//$smi_hi
          //////TOVARKA
  // $text = "Добрый день! \u{2029}\u{2757} Попробуйте признанную во всём мире органическую маску для лица @__blackmask__ \u{2757}\u{2029}\u{2753} Почему тысячи девушек выбирают Black Mask? \u{1F4AD}\u{2029}\u{2705} Потому что наша маска:\u{2029}\u{1F539} оказывает успокаивающее действие на раздраженную и воспаленную кожу;\u{2029}\u{1F539} разглаживает морщинки,возрастные складки, выравнивает текстуру кожи;\u{2029}\u{1F539} делает контур лица более четким;\u{2029}\u{1F539} улучшает цвет лица;\u{2029}\u{1F539} поглощает токсины,устраняет с поверхности эпидермиса мертвые клетки; борется с акне и прыщами\u{2029}\u{1F539} делает практически незаметными пигментные пятна различного происхождения \u{1F64C}\u{2029}\u{1F33F} При этом, маска полностью натуральная  \u{2029}\u{2705}ГАРАНТИРОВАННЫЙ РЕЗУЛЬТАТ В ТЕЧЕНИЕ 2-Х НЕДЕЛЬ! \u{2029}\u{27A1} Активная ссылка и подробности акции в описании профиля \u{27A1}\u{2029}\u{1F449} @__blackmask__  \u{1F448}\u{2029}\u{1F449} @__blackmask__  \u{1F448}\u{2029}\u{1F449} @__blackmask__  \u{1F448}";

              //ADULT
          // $uname = "anna123";
          // echo $text = "$hiw $first_name_txt[0] 19 years old $smi_hi Want Make Me Come? $smil Waiting for u NOW! my login $first_name_txt[0]Strip96 $smi \u{1F449} @$uname \u{1F448} Check out link in profile! \u{1F446}\u{1F446}\u{1F446}";




// $array = [1,3,4,1];
// $ar = $array;
// echo var_export($ar);
   
// //   $smiles_hi =  ["\u{26A1}", "\u{1F60C}"   ,  "\u{270C}", "\u{1F47B}", "\u{1F525}", "\u{1F60E}", "\u{270B}"];
    
//           $smi_hi = $smiles_hi[mt_rand(0, count($smiles_hi) - 1)];
           
//         // $first_name_txt = explode(" ",$GLOBALS["first_name"]);
//         // $hi_word = ["Hey! What's up? I am", "Hi! I am", "Hey there, I am"];
//         // $hiw = $hi_word[mt_rand(0, count($hi_word) - 1)];
 
           
//         // $first_name_txt = explode(" ",$GLOBALS["first_name"]);
//         // $hi_word = ["Hey! What's up? I am", "Hi! I am", "Hey there, I am"];
//         // $hiw = $hi_word[mt_rand(0, count($hi_word) - 1)];
//       $text = "Добрый день! $smi_hi\u{2029}\u{2757} Попробуйте признанную во всём мире органическую маску для лица @__blackmask__ \u{2757}\u{2029}\u{2753} Почему тысячи девушек выбирают Black Mask? \u{1F4AD}\u{2029}\u{2705} Потому что наша маска:\u{2029}\u{1F539} оказывает успокаивающее действие на раздраженную и воспаленную кожу;\u{2029}\u{1F539} разглаживает морщинки,возрастные складки, выравниваю текстуру кожи;\u{2029}\u{1F539} делает контур лица более четким;\u{2029}\u{1F539} улучшает цвет лица;\u{2029}\u{1F539} поглощает токсины,устраняет с поверхности эпидермиса мертвые клетки; борется с акне и прыщами\u{2029}\u{1F539} делает практически незаметными пигментные пятна различного происхождения \u{1F64C}\u{2029}\u{1F33F} При этом, маска полностью натуральная  \u{2029}\u{2705} ГАРАНТИРОВАННЫЙ РЕЗУЛЬТАТ В ТЕЧЕНИЕ 2-Х НЕДЕЛЬ. УСПЕЙ ЗАКАЗАТЬ СЕГОДНЯ ПО АКЦИИ!\u{2029}\u{27A1} Активная ссылка и подробности акции в описании профиля \u{27A1}\u{2029}\u{1F449} @__blackmask__  \u{1F448}\u{2029}\u{1F449} @__blackmask__  \u{1F448}\u{2029}\u{1F449} @__blackmask__  \u{1F448}";

// echo $text;

// $pizza  = "кусок1 кусок2@__blackmask__ кусок3 кусок4 кусок5@__blackmask__ кусок6";

// $pizza  = str_replace("@__blackmask__", "\u{1F4A5}@__blackmask__\u{1F4A5}", $pizza);

// echo $pizza ;

// $pieces = explode("@__blackmask__", $pizza);
// echo $pieces[0]."\u{1F4A5}"."@__blackmask__"."\u{1F4A5}".$pieces[1];

// $influencers = ["253477742", "240333138", "7061024", "217566587", "267685466", "22288455" , "256489055", "299207425", "256293874", "305007657", "544300908", "27133622", "223469204", "1449154611", "26468707", "190082554", "766088051", "377126836", "311630651", "22442174", "5510916", "260958616", "241024950", "804080917", "13115790", "20829767", "18070921", "265457536"];

// echo "\n\n".count($influencers);

// choose random 10 from influencers
// update latest comment 
// comment!

// $commentindexkeys = [1,2,3,4,5];
// $availableComments = [];
// foreach ($commentindexkeys as $ind) {
//    if ( true ) {
//    		array_push($availableComments, "chlen "); 
//    }
//    echo var_export($availableComments)."\n";
//    sleep(3);
// }


// $approxer = 3;
 
// $a =  [55.880088, 37.368901];
// $b =  [55.608911, 37.917495];

 
// $lengthY = abs($a[0]-$b[0]);
// $lengthX = abs($a[1]-$b[1]);

// if ($lengthX > $lengthY) {
// 	$sq_a = $lengthY/$approxer;
// }
// else {
// 	$sq_a = $lengthX/$approxer;
// }

 
// for ($m =0; $m < 1000; $m++)
//  	for ($n =0; $n < 1000; $n++)
//  		if ($a[0]-$m*$sq_a > $b[0]) { 
//  			if ($a[1]+$n*$sq_a < $b[1]) {
 
// 				echo "(".sprintf( "%0.06f", ($a[0] + $m*$sq_a)).",".sprintf( "%0.06f", ($a[1] + $n*$sq_a)).")\n";
// 				# puts n.to_s + "=" + m.to_s
//  			}
//  		 }
 	





// // echo "API registration:\n";
// echo "device id:";

// echo 'android-'.str_split(md5(mt_rand(1000, 9999)), 17)[mt_rand(0, 1)]."\n";
// echo str_split(md5(mt_rand(1000, 9999)), 17)[0]."\n";
// echo strlen(str_split(md5(mt_rand(1000, 9999)), 17)[0])."\n";
// echo str_split(md5(mt_rand(1000, 9999)), 17)[1]."\n"; //strlen
// echo strlen(str_split(md5(mt_rand(1000, 9999)), 17)[1])."\n\n";

// echo "-- final --\n";
//  $test = 'android-'.bin2hex(openssl_random_pseudo_bytes(8));
// echo $test;
// echo "\n___________\n";
// echo strlen(bin2hex(openssl_random_pseudo_bytes(8)));
// // // echo "API login:\n";
// //  $username = 'marie.claire12';
// // $password = 'PASS123';

// // // echo "device id:";




// function first() {


// $a = 0;	
// while ($a < 4) {

// 	echo $a;

// 	$a = $a + 1;
// 	// echo  $volatile_seed = filemtime(__DIR__)."\n\n";
// 	sleep(2);
// }

// }

// function second() {

// 	$t = 0;
// while ($t < 3) {
// 	echo $t;
// 	$t = $t + 1;
// 	sleep(2);
// }

// }
// // follow block
// function recurs() {


// first();
// second();
// //check if followers are enough and send comments

//  recurs();
// }  





// // echo __DIR__;
// echo time();
// echo  $volatile_seed = filemtime(__DIR__)."\n\n";
// // recurs();

// recurs();





// array (
//   0 => 'HTTP/1.0 200 Connection established

// HTTP/1.1 200 OK
// Content-Language: en
// Expires: Sat, 01 Jan 2000 00:00:00 GMT
// Vary: Cookie, Accept-Language, Accept-Encoding
// Pragma: no-cache
// Cache-Control: private, no-cache, no-store, must-revalidate
// Date: Sat, 18 Jun 2016 10:24:20 GMT
// Content-Type: application/json
// Set-Cookie: csrftoken=d0a9150dcf35e3ada487197845da68e8; expires=Sat, 17-Jun-2017 10:24:20 GMT; Max-Age=31449600; Path=/
// Set-Cookie: s_network=; expires=Sat, 18-Jun-2016 11:24:20 GMT; Max-Age=3600; Path=/
// Set-Cookie: sessionid=IGSCecaf8148631c1e558a926cd04626773521450fb7e04ac61465a10205d59e718b%3ASX06fGRITIBw0GlzAMhGSbWxHtrHRLrP%3A%7B%22_token_ver%22%3A2%2C%22_auth_user_id%22%3A3427510552%2C%22_token%22%3A%223427510552%3AZ6Kl2auQgNxFuVop2t2JExFsh6xd93nQ%3Af6ce77e14dc09e003f87daa661c473e5e312f933f2161c3d5340106cf78d5057%22%2C%22asns%22%3A%7B%222001%3A19f0%3Aac00%3Ae9%3A7efd%3A7c0%3Ac272%3A2523%22%3A20473%2C%22time%22%3A1466245459%7D%2C%22_auth_user_backend%22%3A%22accounts.backends.CaseInsensitiveModelBackend%22%2C%22last_refreshed%22%3A1466245460.528285%2C%22_platform%22%3A1%7D; expires=Fri, 16-Sep-2016 10:24:20 GMT; httponly; Max-Age=7776000; Path=/
// Set-Cookie: ds_user_id=3427510552; expires=Fri, 16-Sep-2016 10:24:20 GMT; Max-Age=7776000; Path=/
// Connection: keep-alive
// Content-Length: 527

// ',



//   1 => 
//   array (
//     'status' => 'ok',
//     'created_user' => 
//     array (
//       'username' => 'mashaprivalova89',
//       'has_anonymous_profile_picture' => true,
//       'nux_private_first_page' => false,
//       'profile_pic_url' => 'http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/11906329_960233084022564_1448528159_a.jpg',
//       'full_name' => '',
//       'pk' => 3427510552,
//       'hd_profile_pic_url_info' => 
//       array (
//         'url' => 'http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/11906329_960233084022564_1448528159_a.jpg',
//         'width' => 150,
//         'height' => 150,
//       ),
//       'nux_private_enabled' => false,
//       'is_private' => false,
//     ),
//     'account_created' => true,
//   ),
// )

// array (
//   'status' => 'ok',
//   'user' => 
//   array (
//     'usertags_count' => 0,
//     'has_anonymous_profile_picture' => false,
//     'hd_profile_pic_versions' => 
//     array (
//       0 => 
//       array (
//         'url' => 'http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s320x320/13398826_765994626875523_2011463998_a.jpg',
//         'width' => 320,
//         'height' => 320,
//       ),
//     ),
//     'following_count' => 0,
//     'usertag_review_enabled' => false,
//     'can_boost_post' => false,
//     'full_name' => 'Masha Privalova',
//     'biography' => 'Счастливая',
//     'is_profile_action_needed' => false,
//     'has_chaining' => true,
//     'media_count' => 3,
//     'auto_expand_chaining' => false,
//     'include_direct_blacklist_status' => true,
//     'follower_count' => 0,
//     'pk' => 3427510552,
//     'is_verified' => false,
//     'username' => 'mashaprivalova89',
//     'geo_media_count' => 0,
//     'profile_pic_url' => 'http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s150x150/13398826_765994626875523_2011463998_a.jpg',
//     'profile_pic_id' => '1275281840374589405_3427510552',
//     'can_see_organic_insights' => false,
//     'can_convert_to_business' => false,
//     'is_private' => false,
//     'is_business' => false,
//     'show_insights_terms' => false,
//     'hd_profile_pic_url_info' => 
//     array (
//       'url' => 'http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/13398826_765994626875523_2011463998_a.jpg',
//       'width' => 400,
//       'height' => 400,
//     ),
//     'is_needy' => true,
//     'external_url' => '',
//   ),
// )%                     


  // $influencers = ["253477742", "240333138", "7061024","22288455","217566587", "267685466"];
     
      // $influencer = $influencers[mt_rand(0, count($influencers) - 1)];
      // $mediatocomment = $redis->spop("infpost_$influencer");

      // $commenttex = ["Спасибо за рекомендацию масочки для лица, это просто суперский эффект, заказывала тут \u{1F449} @kupit_blackmask ", "Девочки, хотите иметь молодое лицо с нежной как у младенца кожей и, избавиться от мелких морщинок? Тогда можете попробовать сделать маску для лица Black Mask в домашних условиях. Эффект – потрясающий! Затмевает применение дорогущих косметических средств. Что-то подобное с кремнием когда-то делала в салоне, отдала 2000 рублей за сеанс!!! А тут \u{27A1} @kupit_blackmask по акции всего 990 рублей. И хватает на долго!!!", "Хотела сказать спасибо за рекомендацию масочки для лица Black Mask. После первого же применения маски кожа буквально напиталась влагой! Как только смыла маску, сразу почувствовала свежесть, легкость, как будто каждая пора дышит! И такое стойкое ощущение продержалось несколько часов. После пары-тройки применений кожа приобрела тонус, подтянулась, лицо приобрело такие красивые, четкие очертания. Буду покупать еще здесь \u{2757} @kupit_blackmask и советовать коллегам"];

      // $smiles =  ["\u{1F44D}", "\u{1F44C}", "\u{1F478}" ];  
      // $smil = $smiles[mt_rand(0, count($smiles) - 1)];

      // $hiw = $commenttex[mt_rand(0, count($commenttex) - 1)];



      // echo $messageFinal = "$hiw $smil";


        // $i->comment($mediatocomment, $messageFinal); 
        



// print_r(      $lines);
//  print_r ($prox);

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






// echo date('m/d/Y H:i:s', "1465925541");
 

// irst_name":"Kylie Gross","biography":"Just look at me)","email":"kingfas.terdaimon123dqwewokmmas@gmail.com","gender":2}photo downloaded!
// 20755788521274087865860240658:med
// 15916167611273122359953034060:med
// 3517390191273509702881169961:med
// 12909814521273857097659233897:med
// 15776753861273852715323493731:med
// 33037197521265849748347831403:med
// 1323018077Not authorized to view user
// 15803091131259579925048871427:med
// 452491119735454076603564550:med
// 34212955921273979006379181121:med
// 34063715081274114063489012946:med
// 19086778171266010533290313944:med
// 15901242081271119403643160117:med
// 2613189841273224320230770135:med
// 31689265501272735796253179231:med
// 465494480Not authorized to view user
// 30180615341266838112719862830:med
// 26201174271271875487201095873:med
// 16334474161270518561129219534:med
// 3422005396PHP Notice:  Undefined offset: 0 in /Users/alex/home/dev/rails/instagram/InstAPI/examples/registrationToolOLD.php on line 367

// Notice: Undefined offset: 0 in /Users/alex/home/dev/rails/instagram/InstAPI/examples/registrationToolOLD.php on line 367
// :med
// 1795454626Not authorized to view user
// 7917601541273531506622623399:med
// 34219445711274108248534249845:med
// 34066777901274107925336136962:med
// 12366195721273217005876901517:med
// 34218915571274085907185031645:med
// 14543539451274027274927974657:med
// 1537260668Not authorized to view user
// 3421996837PHP Notice:  Undefined offset: 0 in /Users/alex/home/dev/rails/instagram/InstAPI/examples/registrationToolOLD.php on line 367

// Notice: Undefined offset: 0 in /Users/alex/home/dev/rails/instagram/InstAPI/examples/registrationToolOLD.php on line 367
// :med
// 3419967247PHP Notice:  Undefined offset: 0 in /Users/alex/home/dev/rails/instagram/InstAPI/examples/registrationToolOLD.php on line 367

// Notice: Undefined offset: 0 in /Users/alex/home/dev/rails/instagram/InstAPI/examples/registrationToolOLD.php on line 367
// :med
// 3401011491271005887125911908:med
// 29907377751274110896396526550:med
// 3421911700Not authorized to view user
// 16990908371273348858886036079:med
// 14962705731189253681666128724:med
// 20277081281273810423982909046:med
// 18026709961268092496707032843:med
// 21309223901274022908563644082:med
// 34220116921274112840497263750:med
// 3422055541PHP Notice:  Undefined offset: 0 in /Users/alex/home/dev/rails/instagram/InstAPI/examples/registrationToolOLD.php on line 367

// Notice: Undefined offset: 0 in /Users/alex/home/dev/rails/instagram/InstAPI/examples/registrationToolOLD.php on line 367
// :med
// 24112652321264224224403498759:med
// 16902706821273946824986242377:med
// 21038687641273915714603504863:med
// 29303879681274095339563804181:med
// 9089782171273347042209581651:med
// 4464826951269428185467593025:med



// $newDate = strtotime('-2 month', time()); 
// // echo date('m/d/Y H:i:s', $newDate)."\n";
// if ( "1465925541" > $newDate ) {
//    echo "wowo";
// }


// $lat = '46.537059999999997';
// $long = '48.349850000000004';

// $data = array('lat'=> $lat,
//               'lng'=> $long,
//               'username'=> 'blackkorol'
//               );

// $params = http_build_query($data);

// $service_url = 'http://api.geonames.org/countryCodeJSON?'.$params;

// // $service_url = 'http://scatter-otl.rhcloud.com/location?'.$params;


//  // create curl resource 
// $ch = curl_init(); 

// // set url 
// curl_setopt($ch, CURLOPT_URL, $service_url); 

// //return the transfer as a string 
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

// // $output contains the output string 
// $output = curl_exec($ch); 
// $js =  json_decode($output);
// echo $js->countryCode;

// // close curl resource to free up system resources 
// curl_close($ch);      


//  $romerPREDIS = '/Users/alex/home/dev/redis/predis/';
// require $romerPREDIS.'autoload.php';


//         Predis\Autoloader::register();

//         $redis = new Predis\Client(array(
//          "scheme" => "tcp",
//          "host" => "127.0.0.1",
//          "port" => 6379));

// if ($GLOBALS["redis"]->scard("foraction") == 0)
// {



// }


// $mediatocomment = $GLOBALS["redis"]->lrange("infpost_240333138", -1, -1);
// echo var_export($mediatocomment);


// echo sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x'."\n\n", 
//       mt_rand(0, 65535), 
//       mt_rand(0, 65535), 
//       mt_rand(0, 65535), 
//       mt_rand(16384, 20479), 
//       mt_rand(32768, 49151), 
//       mt_rand(0, 65535), 
//       mt_rand(0, 65535), 
//       mt_rand(0, 65535));



 



// $seed = md5($username.$password);
// //  $volatile_seed = filemtime(__DIR__);
// //         // $volatile_seed = time();
// //  echo 'android-'.substr(md5($seed.$volatile_seed), 16);

// echo $seed."\n\n";


// // echo "\nAPI useragent:\n".'Instagram 8.2.0 Android (18/4.3; 320dpi; 720x1280; Xiaomi; HM 1SW; armani; qcom; en_US)';

// // echo "\n***script device id:\n";
 

// echo mt_rand(1000, 9999);


// echo str_split(md5(mt_rand(1000, 9999)),17)[0]."\n\n";
// echo str_split(md5(mt_rand(1000, 9999)),17)[1]."\n\n";

// echo 'android-'.str_split(md5(mt_rand(0, 999999999)), 17)[mt_rand(0, 1)]."\n";


// $guid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', 
//       mt_rand(0, 65535), 
//       mt_rand(0, 65535), 
//       mt_rand(0, 65535), 
//       mt_rand(16384, 20479), 
//       mt_rand(32768, 49151), 
//       mt_rand(0, 65535), 
//       mt_rand(0, 65535), 
//       mt_rand(0, 65535));

// $device_id = "android-".$guid;

// echo $device_id ;






// function GenerateUserAgent() {  
//   $resolutions = ['720x1280', '320x480', '480x800', '1024x768', '1280x720', '768x1024', '480x320'];
//   $versions = ['GT-N7000', 'SM-N9000', 'GT-I9220', 'GT-I9100'];
//   $dpis = [ '320', '240'];

//   $ver = $versions[array_rand($versions)];
//   $dpi = $dpis[array_rand($dpis)];
//   $res = $resolutions[array_rand($resolutions)];
  
//   return 'Instagram 8.2.0'.' Android ('.'18/4.3'.'; '.$dpi.'dpi; '.$res.'; samsung; '.$ver.'; '.$ver.'; smdkc210; en_US)';
// }

// echo "\n\n".$agent = GenerateUserAgent();

// $uuid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
//       mt_rand(0, 0xffff), mt_rand(0, 0xffff),
//       mt_rand(0, 0xffff),
//       mt_rand(0, 0x0fff) | 0x4000,
//       mt_rand(0, 0x3fff) | 0x8000,
//       mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
//     );

// echo 'UUID:'.$uuid;

 






// echo urlencode('New York')."\n\n\n";


// $a =  'Another account is using aaaaaaaaaaaaaaaaaaaaaaaaaaa.aaa@gmail.com.';
// // check if 
// if (strpos($a, 'Another account is using') !== false) {
//     echo 'contains!';
// }



// array (
//   'has_more' => true,
//   'items' => 
//   array (
//     0 => 
//     array (
//       'media_bundles' => 
//       array (
//       ),
//       'subtitle' => '',
//       'location' => 
//       array (
//         'external_source' => 'facebook_places',
//         'city' => '',
//         'name' => 'New York, New York',
//         'facebook_places_id' => 108424279189115,
//         'address' => '',
//         'lat' => 40.714199999999998,
//         'pk' => 212988663,
//         'lng' => -74.006399999999999,
//       ),
//       'title' => 'New York, New York',
//     ),
//     1 => 
//     array (
//       'media_bundles' => 
//       array (
//       ),
//       'subtitle' => 'New York, NY',
//       'location' => 
//       array (
//         'external_source' => 'facebook_places',
//         'city' => 'New York, NY',
//         'name' => 'New York University',
//         'facebook_places_id' => 103256838688,
//         'address' => '',
//         'lat' => 40.729796595308997,
//         'pk' => 6768,
//         'lng' => -73.996120570667003,
//       ),
//       'title' => 'New York University',
//     ),
//     2 => 



       //  $smiles_list =  ["\u{1F60C}" ,"\u{1F60D}" , "\u{1F61A}"  ,"\u{1F618}", "\u{2764}", "\u{1F64C}"];
       //  $smiles_hi =  ["\u{26A1}", "\u{1F48B}","\u{1F609}", "\u{1F633}", "\u{1F60C}" , "\u{1F61A}"  ,"\u{1F618}", "\u{270C}", "\u{1F47B}", "\u{1F525}", "\u{1F607}", "\u{1F617}", "\u{1F619}", "\u{1F60E}", "\u{1F61C}", "\u{270B}",  "\u{1F60B}"];
       //  $smiles =  ["\u{1F609}", "\u{1F60C}" ];  
       //  $cursors = ["\u{261D}" , "\u{2B06}", "\u{2934}", "\u{1F53C}", "\u{1F51D}" ];  
       //    $cur = $cursors[mt_rand(0, count($cursors) - 1)];
       //    $smi = $smiles_list[mt_rand(0, count($smiles_list) - 1)];
       //    $smi_hi = $smiles_hi[mt_rand(0, count($smiles_hi) - 1)];
       //    $smil = $smiles[mt_rand(0, count($smiles) - 1)];
       //  $first_name_txt = explode(" ",$first_name);
       //  $hi_word = ["Hey! What's up? I am", "Hi! I am", "Hey there, I am"];
       //  $hiw = $hi_word[mt_rand(0, count($hi_word) - 1)];

       // echo $text = "$hiw $first_name_txt[0] $smi_hi  Do you wanna play with me? $smil  I'm online here @girlshothere                @girlshothere                @girlshothere    $smi $cur $cur $cur";




// $commentindexkeys = $GLOBALS["redis"]->hkeys("comments");    // get  index of comment here


//       $commentindex = $commentindexkeys[mt_rand(0, count($commentindexkeys) - 1)]; // make it RANDOM
//    echo $commentindex; 
// echo $commenttex = $GLOBALS["redis"]->hget("comments", $commentindex);



  //       $med = 'test123';
  //       $fol = 'fol112';
  //       $key = 'test';
  // $redis->sadd($key, $fol.":".$med);
  // $res = $redis->spop($key);
  // $resarr = explode(":",$res);
  // echo $resarr[0]." ---> ".$resarr[1];



// // lat=57.703048435429999&long=11.98996533319  



// // ['items'][0]['pk']   -  latest media_id

// // array (
// //   'status' => 'ok',
// //   'num_results' => 12,
// //   'auto_load_more_enabled' => true,
// //   'items' => 
// //   array (
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
// //       array (
// //         'username' => 'suzannesvanevik',
// //         'has_anonymous_profile_picture' => false,
// //         'is_unpublished' => false,
// //         'profile_pic_url' => 'http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s150x150/12145429_927730610635383_1307205056_a.jpg',
// //         'is_favorite' => false,
// //         'full_name' => 'S U Z A N N E  S V A N E V I K',
// //         'pk' => 13226335,
// //         'is_verified' => false,
// //         'is_private' => false,
// //       ),
// //       'organic_tracking_token' => 'eyJ2ZXJzaW9uIjo1LCJwYXlsb2FkIjp7ImlzX2FuYWx5dGljc190cmFja2VkIjpmYWxzZSwidXVpZCI6IjIwZTU0ODhhZTA2MjRiMDBhYWNjYjc4MDlhNDU2NzQwMTI2MTc0MTY2NTExNjU0NTU2NCIsInNlcnZlcl90b2tlbiI6IjE0NjU0NzgzMTUwMDZ8MTI2MTc0MTY2NTExNjU0NTU2NHwzMzE4ODA2OTQyfDBmNjYyNzUwYTdiZDFmZGQ5ZDhmNTEzYjczZjczZjkxMzdmMzdiNjI5MTRhZjdmNDAzNGMxYWM5ZjJjZWVkNTIifSwic2lnbmF0dXJlIjoiIn0=',
// //       'like_count' => 3529,
// //       'has_liked' => false,
// //       'has_more_comments' => true,
// //       'next_max_id' => 17848061371099354,
// //       'max_num_visible_preview_comments' => 2,
// //       'comments' => 
// //       // array (
// //       //   0 => 
// //       //   array (
// //       //     'status' => 'Active',
// //       //     'user_id' => 13226335,
// //       //     'created_at_utc' => 1464679709,
// //       //     'created_at' => 1464679709,
// //       //     'bit_flags' => 0,
// //       //     'user' => 
// //       //     array (
// //       //       'username' => 'suzannesvanevik',
// //       //       'profile_pic_url' => 'http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s150x150/12145429_927730610635383_1307205056_a.jpg',
// //       //       'full_name' => 'S U Z A N N E  S V A N E V I K',
// //       //       'pk' => 13226335,
// //       //       'is_verified' => false,
// //       //       'is_private' => false,
// //       //     ),
// //       //     'content_type' => 'comment',
// //       //     'text' => '@amalieenilsen @borgevictoria ❤️😘',
// //       //     'media_id' => 1261741665116545564,
// //       //     'pk' => 17847952564099354,
// //       //     'type' => 0,
// //       //   ),
// //       //   1 => 
// //       //   array (
// //       //     'status' => 'Active',
// //       //     'user_id' => 371911901,
// //       //     'created_at_utc' => 1465024175,
// //       //     'created_at' => 1465024175,
// //       //     'bit_flags' => 0,
// //       //     'user' => 
// //       //     array (
// //       //       'username' => 'angelina_stay_fit',
// //       //       'profile_pic_url' => 'http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s150x150/12237317_978292562212302_1381679108_a.jpg',
// //       //       'full_name' => '💪💥 Mrs. ALPHA 🏆 󾓨➕󾓬',
// //       //       'pk' => 371911901,
// //       //       'is_verified' => false,
// //       //       'is_private' => false,
// //       //     ),
// //       //     'content_type' => 'comment',
// //       //     'text' => '💕🙇💪',
// //       //     'media_id' => 1261741665116545564,
// //       //     'pk' => 17848061371099354,
// //       //     'type' => 0,
// //       //   ),
// //       // ),
// //       'comment_count' => 15,
// //       'caption' => 
// // //       array (
// // //         'status' => 'Active',
// // //         'user_id' => 13226335,
// // //         'created_at_utc' => 1464631360,
// // //         'created_at' => 1464631360,
// // //         'bit_flags' => 0,
// // //         'user' => 
// // //         array (
// // //           'username' => 'suzannesvanevik',
// // //           'has_anonymous_profile_picture' => false,
// // //           'is_unpublished' => false,
// // //           'profile_pic_url' => 'http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s150x150/12145429_927730610635383_1307205056_a.jpg',
// // //           'is_favorite' => false,
// // //           'full_name' => 'S U Z A N N E  S V A N E V I K',
// // //           'pk' => 13226335,
// // //           'is_verified' => false,
// // //           'is_private' => false,
// // //         ),
// // //         'content_type' => 'comment',
// // //         'text' => 'What a weekend!! ❤️🎶👫 🇸🇪 🎉 
// // // #summerburst',
// // //         'media_id' => 1261741665116545564,
// // //         'pk' => 17847937411099354,
// // //         'type' => 1,
// // //       ),
// //       'caption_is_edited' => true,
// //       'usertags' => 
// //       array (
// //         'in' => 
// //         array (
// //           0 => 
// //           array (
// //             'position' => 
// //             array (
// //               0 => 0.28933333333333328,
// //               1 => 0.52275249722530526,
// //             ),
// //             'user' => 
// //             array (
// //               'username' => 'alexanderhanseen',
// //               'profile_pic_url' => 'http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/11325067_1458641184432380_1125557864_a.jpg',
// //               'full_name' => 'A L E X A N D E R  H A N S E N',
// //               'pk' => 143733623,
// //               'is_verified' => false,
// //               'is_private' => false,
// //             ),
// //           ),
// //         ),
// //       ),
// //       'photo_of_you' => false,
// //     ),
// //   ),
// //   'more_available' => true,
// //   'next_max_id' => '1234210888711725980_13226335',
// // )

 
// ////////////////////////////////////////////////////////////////////////////////////////
//             //////////////////////////////////////////////////////////////////////
//             ///////////////////////////////////////////////////////////////////////////



// // $recipients = array("1009845355", "3299015045");
// // if (!is_array($recipients)) {
// //             $recipients = [$recipients];
// //         }
// //         $string = [];
// //         foreach ($recipients as $recipient) {
// //             $string[] = "\"$recipient\"";
// //         }
// //         $recipient_users = implode(',', $string);

// echo "[[$recipient_users]]";



// function uniord($u) {
//     // i just copied this function fron the php.net comments, but it should work fine!
//     $k = mb_convert_encoding($u, 'UCS-2LE', 'UTF-8');
//     $k1 = ord(substr($k, 0, 1));
//     $k2 = ord(substr($k, 1, 1));
//     return $k2 * 256 + $k1;
//  }
// function is_arabic($str) {
//   if(strlen($str) == 0) {
//     return false;
//   } else {

//       if(mb_detect_encoding($str) !== 'UTF-8') {
//           $str = mb_convert_encoding($str,mb_detect_encoding($str),'UTF-8');
//       }

      
//       $str = str_split($str); <- this function is not mb safe, it splits by bytes, not characters. we cannot use it
//       $str = preg_split('//u',$str); <- this function woulrd probably work fine but there was a bug reported in some php version so it pslits by bytes and not chars as well
      
//       preg_match_all('/.|\n/u', $str, $matches);
//       $chars = $matches[0];
//       $arabic_count = 0;
//       $latin_count = 0;
//       $total_count = 0;
//       foreach($chars as $char) {
//           //$pos = ord($char); we cant use that, its not binary safe 
//           $pos = uniord($char);
//           // echo $char ." --> ".$pos.PHP_EOL;

//           if($pos >= 1536 && $pos <= 1791) {
//               $arabic_count++;
//           } else if($pos > 123 && $pos < 123) {
//               $latin_count++;
//           }
//           $total_count++;
//       }
//       if(($arabic_count/$total_count) > 0.0001) {
//           // 60% arabic chars, its probably arabic
//           return true;
//       }
//       return false;
//   }
// }

// $sss  = 'asdaاasdasdasd';
// // echo $sss;


// $arabic = is_arabic($sss); 
// var_dump($arabic);



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

 
        //error_reporting(E_ALL);

     // Script to test if the CURL extension is installed on this server

// Define function to test
 
 
			



 //         $key = "names";


 
 //    while ( $redis->scard($key) > 0 ) {  
 //        $pieces = explode(" ",  $redis->spop($key));
 //        $check = $r->checkUsername($pieces[0]);
 //        if ($check['available'] == true) {
 //            $GLOBALS["username"] = $pieces[0];
 //            $GLOBALS["first_name"] = $pieces[1]." ".$pieces[2];
         
 //            break;
 //        }    

 
 //        sleep(1);
 //    } 
     


 //         $key = "proxy";
 
 //    while ( $redis->scard($key) > 0 ) {  
         
 //        echo $redis->spop($key). "\n";
 
 //        sleep(3);
//  //    } 

// $username = "tester123";
// exec("/usr/local/bin/send-telegram.sh '$username --> fail to send message'  /dev/null 2>/dev/null &");

//  /dev/null 2>/dev/null &



// # array (
// #   'status' => 'ok',
// #   'user' => 
// #   array (
// #     'username' => 'suzannesvanevik',
// #     'usertags_count' => 1115,
// #     'has_anonymous_profile_picture' => false,
// #     'media_count' => 1022,
// #     'hd_profile_pic_versions' => 
// #     array (
// #       0 => 
// #       array (
// #         'url' => 'http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s320x320/12145429_927730610635383_1307205056_a.jpg',
// #         'width' => 320,
// #         'height' => 320,
// #       ),
// #       1 => 
// #       array (
// #         'url' => 'http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s640x640/12145429_927730610635383_1307205056_a.jpg',
// #         'width' => 640,
// #         'height' => 640,
// #       ),
// #     ),
// #     'following_count' => 368,
// #     'is_business' => false,
// #     'auto_expand_chaining' => false,
// #     'has_chaining' => true,
// #     'geo_media_count' => 249,
// #     'profile_pic_url' => 'http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s150x150/12145429_927730610635383_1307205056_a.jpg',
// #     'is_favorite' => false,
// #
// # Performance is beauty 🎀
// # Bergen Performance Center 🏋🏽
// # 📩 suzannesvanevik@gmail.com 
// # LIVE • LOVE • LIFT',
// #     'full_name' => 'S U Z A N N E  S V A N E V I K',
// #     'follower_count' => 216756,
// #     'pk' => 13226335,
// #     'hd_profile_pic_url_info' => 
// #     array (
// #       'url' => 'http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/12145429_927730610635383_1307205056_a.jpg',
// #       'width' => 948,
// #       'height' => 948,
// #     ),
// #     'is_private' => false,
// #     'external_url' => '',
// #   ),
// # )




//  http://blackking:Name0123Space@104.156.229.189:30616<-------------------------*********************
// REQUEST: users/check_username/
// DATA: ig_sig_key_version=4&signed_body=2591634f599f9da2c10883099cb6bad2a9f91631d1d27ed5d524af2bb5c619d6.%7B%22_uuid%22%3A%22cdb4f438-03b6-41dc-a946-f97ef4bfd914%22%2C%22username%22%3A%22rachelgross93%22%2C%22_csrftoken%22%3A%22missing%22%7D
// RESPONSE: {"username": "rachelgross93", "available": true, "status": "ok"}

// REQUEST: accounts/create/
// DATA: ig_sig_key_version=4&signed_body=6f48270960e52f106335bfcad228f3882af6977ab8e9d4ad4cbad7e3a41ef6c7.%7B%22phone_id%22%3A%22cdb4f438-03b6-41dc-a946-f97ef4bfd914%22%2C%22_csrftoken%22%3A%22missing%22%2C%22username%22%3A%22rachelgross93%22%2C%22first_name%22%3A%22%22%2C%22guid%22%3A%22cdb4f438-03b6-41dc-a946-f97ef4bfd914%22%2C%22device_id%22%3A%22android-684d3b0ea933702%22%2C%22email%22%3A%22igroma.yneedyouqwe12awqweqwqqer%40gmail.com%22%2C%22force_sign_up_code%22%3A%22%22%2C%22qs_stamp%22%3A%22%22%2C%22password%22%3A%22FJSD24P7%22%7D
// RESPONSE: {"status": "ok", "created_user": {"username": "rachelgross93", "has_anonymous_profile_picture": true, "nux_private_first_page": false, "profile_pic_url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/11906329_960233084022564_1448528159_a.jpg", "full_name": "", "pk": 3410235335, "hd_profile_pic_url_info": {"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/11906329_960233084022564_1448528159_a.jpg", "width": 150, "height": 150}, "nux_private_enabled": false, "is_private": false}, "account_created": true}

// array (
//   0 => 'HTTP/1.0 200 Connection established

// HTTP/1.1 200 OK
// Content-Language: en
// Expires: Sat, 01 Jan 2000 00:00:00 GMT
// Vary: Cookie, Accept-Language, Accept-Encoding
// Pragma: no-cache
// Cache-Control: private, no-cache, no-store, must-revalidate
// Date: Mon, 13 Jun 2016 18:38:07 GMT
// Content-Type: application/json
// Set-Cookie: csrftoken=142b2baeff1753a5d5b7494d3da5d67b; expires=Mon, 12-Jun-2017 18:38:07 GMT; Max-Age=31449600; Path=/
// Set-Cookie: s_network=; expires=Mon, 13-Jun-2016 19:38:07 GMT; Max-Age=3600; Path=/
// Set-Cookie: sessionid=IGSC213d97dea1e335afdd26eebeea5d27c06bd04b203a2666559e0fbd3811672460%3AY3DUkKuiYVE58jTSubPYpQQ19o1uB8ti%3A%7B%22_token_ver%22%3A2%2C%22_auth_user_id%22%3A3410235335%2C%22_token%22%3A%223410235335%3ATCNJ6sbGK1zaryilk8CayaG2bzDJTcxq%3A68c1ab84c86626fb7274bb6ce38aabf1fe795d3e1d34ddf0f13706971e17d276%22%2C%22asns%22%3A%7B%222001%3A19f0%3Aac00%3Ae9%3A66c7%3A10a5%3Abb95%3Afb13%22%3A20473%2C%22time%22%3A1465843087%7D%2C%22_auth_user_backend%22%3A%22accounts.backends.CaseInsensitiveModelBackend%22%2C%22last_refreshed%22%3A1465843087.853234%2C%22_platform%22%3A1%7D; expires=Sun, 11-Sep-2016 18:38:07 GMT; httponly; Max-Age=7776000; Path=/
// Set-Cookie: ds_user_id=3410235335; expires=Sun, 11-Sep-2016 18:38:07 GMT; Max-Age=7776000; Path=/
// Connection: keep-alive
// Content-Length: 524

// ',
//   1 => 
//   array (
//     'status' => 'ok',
//     'created_user' => 
//     array (
//       'username' => 'rachelgross93',
//       'has_anonymous_profile_picture' => true,
//       'nux_private_first_page' => false,
//       'profile_pic_url' => 'http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/11906329_960233084022564_1448528159_a.jpg',
//       'full_name' => '',
//       'pk' => 3410235335,
//       'hd_profile_pic_url_info' => 
//       array (
//         'url' => 'http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/11906329_960233084022564_1448528159_a.jpg',
//         'width' => 150,
//         'height' => 150,
//       ),
//       'nux_private_enabled' => false,
//       'is_private' => false,
//     ),
//     'account_created' => true,
//   ),
// )
// connection_established


//  PROX ---------->http://blackking:Name0123Space@104.156.229.189:30616


//  _proxy_------>http://blackking:Name0123Space@104.156.229.189:30616
// * Hostname 104.156.229.189 was found in DNS cache
// *   Trying 104.156.229.189...
// * Connected to 104.156.229.189 (104.156.229.189) port 30616 (#0)
// * Establish HTTP proxy tunnel to i.instagram.com:443
// * Proxy auth using Basic with user 'blackking'
// > CONNECT i.instagram.com:443 HTTP/1.1
// Host: i.instagram.com:443
// Proxy-Authorization: Basic YmxhY2traW5nOk5hbWUwMTIzU3BhY2U=
// User-Agent: Instagram 8.0.0 Android (18/4.3; 320dpi; 720x1280; Xiaomi; HM 1SW; armani; qcom; en_US)
// Proxy-Connection: Keep-Alive

// < HTTP/1.0 200 Connection established
// < 
// * Proxy replied OK to CONNECT request
// * TLS 1.2 connection using TLS_ECDHE_RSA_WITH_AES_128_GCM_SHA256
// * Server certificate: *.instagram.com
// * Server certificate: DigiCert SHA2 High Assurance Server CA
// * Server certificate: DigiCert High Assurance EV Root CA
// > POST /api/v1/accounts/change_profile_picture/ HTTP/1.1
// Host: i.instagram.com
// User-Agent: Instagram 8.0.0 Android (18/4.3; 320dpi; 720x1280; Xiaomi; HM 1SW; armani; qcom; en_US)
// Cookie: csrftoken=142b2baeff1753a5d5b7494d3da5d67b; ds_user_id=3410235335; mid=V179PgABAAHXbGPAOatlHiFb8foB; s_network=; sessionid=IGSC213d97dea1e335afdd26eebeea5d27c06bd04b203a2666559e0fbd3811672460%3AY3DUkKuiYVE58jTSubPYpQQ19o1uB8ti%3A%7B%22_token_ver%22%3A2%2C%22_auth_user_id%22%3A3410235335%2C%22_token%22%3A%223410235335%3ATCNJ6sbGK1zaryilk8CayaG2bzDJTcxq%3A68c1ab84c86626fb7274bb6ce38aabf1fe795d3e1d34ddf0f13706971e17d276%22%2C%22asns%22%3A%7B%222001%3A19f0%3Aac00%3Ae9%3A66c7%3A10a5%3Abb95%3Afb13%22%3A20473%2C%22time%22%3A1465843087%7D%2C%22_auth_user_backend%22%3A%22accounts.backends.CaseInsensitiveModelBackend%22%2C%22last_refreshed%22%3A1465843087.853234%2C%22_platform%22%3A1%7D
// Proxy-Connection: keep-alive
// Connection: keep-alive
// Accept: */*
// Content-type: multipart/form-data; boundary=18cd1d45-104f-4ec6-866b-8ad25a00b483
// Accept-Language: en-en
// Accept-Encoding: gzip, deflate
// Content-Length: 71741
// Expect: 100-continue

// < HTTP/1.1 100 Continue
// < Date: Mon, 13 Jun 2016 18:38:09 GMT
// * We are completely uploaded and fine
// < HTTP/1.1 200 OK
// < Server: nginx
// < Date: Mon, 13 Jun 2016 18:38:10 GMT
// < Content-Type: application/json
// < Content-Language: en
// < Content-Encoding: gzip
// < Expires: Sat, 01 Jan 2000 00:00:00 GMT
// < Vary: Cookie, Accept-Language, Accept-Encoding
// < Pragma: no-cache
// < Cache-Control: private, no-cache, no-store, must-revalidate
// * Replaced cookie csrftoken="142b2baeff1753a5d5b7494d3da5d67b" for domain i.instagram.com, path /, expire 1497292691
// < Set-Cookie: csrftoken=142b2baeff1753a5d5b7494d3da5d67b; expires=Mon, 12-Jun-2017 18:38:10 GMT; Max-Age=31449600; Path=/
// * Replaced cookie s_network="" for domain i.instagram.com, path /, expire 1465846691
// < Set-Cookie: s_network=; expires=Mon, 13-Jun-2016 19:38:10 GMT; Max-Age=3600; Path=/
// * Replaced cookie ds_user_id="3410235335" for domain i.instagram.com, path /, expire 1473619091
// < Set-Cookie: ds_user_id=3410235335; expires=Sun, 11-Sep-2016 18:38:10 GMT; Max-Age=7776000; Path=/
// < Connection: keep-alive
// < Content-Length: 321
// < 
// * Connection #0 to host 104.156.229.189 left intact
// {"_uuid":"18cd1d45-104f-4ec6-866b-8ad25a00b483","_uid":"3410235335","_csrftoken":"142b2baeff1753a5d5b7494d3da5d67b","external_url":"","phone_number":"","username":"rachelgross93","first_name":"Rachel Gross","biography":"Love or s _ x? ^^","email":"igroma.yneedyouqwe12awqweqwqqer@gmail.com","gender":2}REQUEST: accounts/edit_profile/
// DATA: ig_sig_key_version=4&signed_body=6218c57cf6f753796fa49e8c48ae8b45196f3aac8b833c6aabb28b559ba6750c.{"_uuid":"18cd1d45-104f-4ec6-866b-8ad25a00b483","_uid":"3410235335","_csrftoken":"142b2baeff1753a5d5b7494d3da5d67b","external_url":"","phone_number":"","username":"rachelgross93","first_name":"Rachel Gross","biography":"Love or s _ x? ^^","email":"igroma.yneedyouqwe12awqweqwqqer@gmail.com","gender":2}
// RESPONSE: {"status": "ok", "user": {"username": "rachelgross93", "phone_number": "", "has_anonymous_profile_picture": false, "hd_profile_pic_versions": [{"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s320x320/13413450_1761784037401767_952894660_a.jpg", "width": 320, "height": 320}], "gender": 2, "birthday": null, "profile_pic_url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s150x150/13413450_1761784037401767_952894660_a.jpg", "profile_pic_id": "1271906489581519467_3410235335", "biography": "Love or s _ x? ^^", "full_name": "Rachel Gross", "pk": 3410235335, "hd_profile_pic_url_info": {"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/13413450_1761784037401767_952894660_a.jpg", "width": 478, "height": 478}, "email": "igroma.yneedyouqwe12awqweqwqqer@gmail.com", "is_private": false, "external_url": ""}}

// * Hostname 104.156.229.189 was found in DNS cache
// *   Trying 104.156.229.189...
// * Connected to 104.156.229.189 (104.156.229.189) port 30616 (#0)
// * Establish HTTP proxy tunnel to i.instagram.com:443
// * Proxy auth using Basic with user 'blackking'
// > CONNECT i.instagram.com:443 HTTP/1.1
// Host: i.instagram.com:443
// Proxy-Authorization: Basic YmxhY2traW5nOk5hbWUwMTIzU3BhY2U=
// User-Agent: Instagram 8.0.0 Android (18/4.3; 320dpi; 720x1280; Xiaomi; HM 1SW; armani; qcom; en_US)
// Proxy-Connection: Keep-Alive

// < HTTP/1.0 200 Connection established
// < 
// * Proxy replied OK to CONNECT request
// * TLS 1.2 connection using TLS_ECDHE_RSA_WITH_AES_128_GCM_SHA256
// * Server certificate: *.instagram.com
// * Server certificate: DigiCert SHA2 High Assurance Server CA
// * Server certificate: DigiCert High Assurance EV Root CA
// > POST /api/v1/upload/photo/ HTTP/1.1
// Host: i.instagram.com
// User-Agent: Instagram 8.0.0 Android (18/4.3; 320dpi; 720x1280; Xiaomi; HM 1SW; armani; qcom; en_US)
// Cookie: csrftoken=142b2baeff1753a5d5b7494d3da5d67b; ds_user_id=3410235335; mid=V179PgABAAHXbGPAOatlHiFb8foB; s_network=; sessionid=IGSC213d97dea1e335afdd26eebeea5d27c06bd04b203a2666559e0fbd3811672460%3AY3DUkKuiYVE58jTSubPYpQQ19o1uB8ti%3A%7B%22_token_ver%22%3A2%2C%22_auth_user_id%22%3A3410235335%2C%22_token%22%3A%223410235335%3ATCNJ6sbGK1zaryilk8CayaG2bzDJTcxq%3A68c1ab84c86626fb7274bb6ce38aabf1fe795d3e1d34ddf0f13706971e17d276%22%2C%22asns%22%3A%7B%222001%3A19f0%3Aac00%3Ae9%3A66c7%3A10a5%3Abb95%3Afb13%22%3A20473%2C%22time%22%3A1465843087%7D%2C%22_auth_user_backend%22%3A%22accounts.backends.CaseInsensitiveModelBackend%22%2C%22last_refreshed%22%3A1465843087.853234%2C%22_platform%22%3A1%7D
// Connection: close
// Accept: */*
// Content-type: multipart/form-data; boundary=18cd1d45-104f-4ec6-866b-8ad25a00b483
// Content-Length: 71874
// Cookie2: $Version=1
// Accept-Language: en-US
// Accept-Encoding: gzip
// Expect: 100-continue

// < HTTP/1.1 100 Continue
// < Date: Mon, 13 Jun 2016 18:38:25 GMT
// * We are completely uploaded and fine
// < HTTP/1.1 200 OK
// < Server: nginx
// < Date: Mon, 13 Jun 2016 18:38:26 GMT
// < Content-Type: application/json
// < Content-Language: en
// < Expires: Sat, 01 Jan 2000 00:00:00 GMT
// < Vary: Cookie, Accept-Language
// < Pragma: no-cache
// < Cache-Control: private, no-cache, no-store, must-revalidate
// * Replaced cookie csrftoken="142b2baeff1753a5d5b7494d3da5d67b" for domain i.instagram.com, path /, expire 1497292706
// < Set-Cookie: csrftoken=142b2baeff1753a5d5b7494d3da5d67b; expires=Mon, 12-Jun-2017 18:38:26 GMT; Max-Age=31449600; Path=/
// * Replaced cookie ds_user_id="3410235335" for domain i.instagram.com, path /, expire 1473619106
// < Set-Cookie: ds_user_id=3410235335; expires=Sun, 11-Sep-2016 18:38:26 GMT; Max-Age=7776000; Path=/
// < Connection: close
// < Content-Length: 46
// < 
// * Closing connection 0
// RESPONSE: {"status": "ok", "upload_id": "1465843104098"}

// REQUEST: media/configure/
// DATA: ig_sig_key_version=4&signed_body=980fdbed59eca567b2a4baebacccd3ceab95d33cd4ca068f4727e32bda4a9046.{"upload_id":"1465843104098","camera_model":"HM1S","source_type":3,"date_time_original":"2016:06:13 18:38:26","camera_make":"XIAOMI","edits":{"crop_original_size":[478,478],"crop_zoom":1.3333334,"crop_center":[0,-0]},"extra":{"source_width":478,"source_height":478},"device":{"manufacturer":"Xiaomi","model":"HM 1SW","android_version":18,"android_release":"4.3"},"_csrftoken":"142b2baeff1753a5d5b7494d3da5d67b","_uuid":"18cd1d45-104f-4ec6-866b-8ad25a00b483","_uid":"3410235335","caption":"Wow) Do you like?"}
// RESPONSE: {"status": "ok", "media": {"taken_at": 1465843107, "pk": 1271906630426247792, "id": "1271906630426247792_3410235335", "device_timestamp": 1465843104098, "media_type": 1, "code": "BGmuFduBUJw", "client_cache_key": "MTI3MTkwNjYzMDQyNjI0Nzc5Mg==.2", "filter_type": 0, "image_versions2": {"candidates": [{"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/e35/13398414_1028322283910971_527592875_n.jpg?ig_cache_key=MTI3MTkwNjYzMDQyNjI0Nzc5Mg%3D%3D.2", "width": 478, "height": 478}, {"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/s320x320/e35/13398414_1028322283910971_527592875_n.jpg?ig_cache_key=MTI3MTkwNjYzMDQyNjI0Nzc5Mg%3D%3D.2", "width": 320, "height": 320}, {"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/s240x240/e35/13398414_1028322283910971_527592875_n.jpg?ig_cache_key=MTI3MTkwNjYzMDQyNjI0Nzc5Mg%3D%3D.2", "width": 240, "height": 240}, {"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/s150x150/e35/13398414_1028322283910971_527592875_n.jpg?ig_cache_key=MTI3MTkwNjYzMDQyNjI0Nzc5Mg%3D%3D.2", "width": 150, "height": 150}]}, "original_width": 478, "original_height": 478, "user": {"username": "rachelgross93", "has_anonymous_profile_picture": false, "is_unpublished": false, "profile_pic_url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s150x150/13413450_1761784037401767_952894660_a.jpg", "full_name": "Rachel Gross", "pk": 3410235335, "is_private": false}, "organic_tracking_token": "eyJ2ZXJzaW9uIjo1LCJwYXlsb2FkIjp7ImlzX2FuYWx5dGljc190cmFja2VkIjpmYWxzZSwidXVpZCI6IjJmMDEzMGFmZDlkNDQxNTRhMTY1YWFjY2ZhNGZiNDIyMTI3MTkwNjYzMDQyNjI0Nzc5MiIsInNlcnZlcl90b2tlbiI6IjE0NjU4NDMxMDc4NTd8MTI3MTkwNjYzMDQyNjI0Nzc5MnwzNDEwMjM1MzM1fDE0M2EzOTYyMWQ3OTY1OGYyNmQyZDExYTRkN2VmODljZGRlMzcwMWE0OTBhMmU1M2FkYTA3NjdhZWYyNmQ5OTgifSwic2lnbmF0dXJlIjoiIn0=", "has_liked": false, "has_more_comments": false, "max_num_visible_preview_comments": 4, "comments": [], "comment_count": 0, "caption": {"status": "Active", "user_id": 3410235335, "created_at_utc": 1465843107, "created_at": 1465843107, "bit_flags": 0, "user": {"username": "rachelgross93", "has_anonymous_profile_picture": false, "is_unpublished": false, "profile_pic_url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s150x150/13413450_1761784037401767_952894660_a.jpg", "full_name": "Rachel Gross", "pk": 3410235335, "is_private": false}, "content_type": "comment", "text": "Wow) Do you like?", "media_id": 1271906630426247792, "pk": 17848237786089336, "type": 1}, "caption_is_edited": false, "photo_of_you": false}, "upload_id": "1465843104098"}

// REQUEST: qe/expose/
// DATA: ig_sig_key_version=4&signed_body=1c7bbac2cfe40c8e9af68bf79d9a379d1e872f8f0422bb8253f669a3ed718ca3.{"_uuid":"18cd1d45-104f-4ec6-866b-8ad25a00b483","_uid":"3410235335","id":"3410235335","_csrftoken":"142b2baeff1753a5d5b7494d3da5d67b","experiment":"ig_android_profile_contextual_feed"}
// RESPONSE: {"status": "ok"}

// * Hostname 104.156.229.189 was found in DNS cache
// *   Trying 104.156.229.189...
// * Connected to 104.156.229.189 (104.156.229.189) port 30616 (#0)
// * Establish HTTP proxy tunnel to i.instagram.com:443
// * Proxy auth using Basic with user 'blackking'
// > CONNECT i.instagram.com:443 HTTP/1.1
// Host: i.instagram.com:443
// Proxy-Authorization: Basic YmxhY2traW5nOk5hbWUwMTIzU3BhY2U=
// User-Agent: Instagram 8.0.0 Android (18/4.3; 320dpi; 720x1280; Xiaomi; HM 1SW; armani; qcom; en_US)
// Proxy-Connection: Keep-Alive

// < HTTP/1.0 200 Connection established
// < 
// * Proxy replied OK to CONNECT request
// * TLS 1.2 connection using TLS_ECDHE_RSA_WITH_AES_128_GCM_SHA256
// * Server certificate: *.instagram.com
// * Server certificate: DigiCert SHA2 High Assurance Server CA
// * Server certificate: DigiCert High Assurance EV Root CA
// > POST /api/v1/upload/photo/ HTTP/1.1
// Host: i.instagram.com
// User-Agent: Instagram 8.0.0 Android (18/4.3; 320dpi; 720x1280; Xiaomi; HM 1SW; armani; qcom; en_US)
// Cookie: csrftoken=142b2baeff1753a5d5b7494d3da5d67b; ds_user_id=3410235335; mid=V179PgABAAHXbGPAOatlHiFb8foB; s_network=; sessionid=IGSC213d97dea1e335afdd26eebeea5d27c06bd04b203a2666559e0fbd3811672460%3AY3DUkKuiYVE58jTSubPYpQQ19o1uB8ti%3A%7B%22_token_ver%22%3A2%2C%22_auth_user_id%22%3A3410235335%2C%22_token%22%3A%223410235335%3ATCNJ6sbGK1zaryilk8CayaG2bzDJTcxq%3A68c1ab84c86626fb7274bb6ce38aabf1fe795d3e1d34ddf0f13706971e17d276%22%2C%22asns%22%3A%7B%222001%3A19f0%3Aac00%3Ae9%3A66c7%3A10a5%3Abb95%3Afb13%22%3A20473%2C%22time%22%3A1465843087%7D%2C%22_auth_user_backend%22%3A%22accounts.backends.CaseInsensitiveModelBackend%22%2C%22last_refreshed%22%3A1465843087.853234%2C%22_platform%22%3A1%7D
// Connection: close
// Accept: *
// Content-type: multipart/form-data; boundary=18cd1d45-104f-4ec6-866b-8ad25a00b483
// Content-Length: 66594
// Cookie2: $Version=1
// Accept-Language: en-US
// Accept-Encoding: gzip
// Expect: 100-continue

// < HTTP/1.1 100 Continue
// < Date: Mon, 13 Jun 2016 18:38:40 GMT
// * We are completely uploaded and fine
// < HTTP/1.1 200 OK
// < Server: nginx
// < Date: Mon, 13 Jun 2016 18:38:41 GMT
// < Content-Type: application/json
// < Content-Language: en
// < Expires: Sat, 01 Jan 2000 00:00:00 GMT
// < Vary: Cookie, Accept-Language
// < Pragma: no-cache
// < Cache-Control: private, no-cache, no-store, must-revalidate
// * Replaced cookie csrftoken="142b2baeff1753a5d5b7494d3da5d67b" for domain i.instagram.com, path /, expire 1497292722
// < Set-Cookie: csrftoken=142b2baeff1753a5d5b7494d3da5d67b; expires=Mon, 12-Jun-2017 18:38:41 GMT; Max-Age=31449600; Path=/
// * Replaced cookie ds_user_id="3410235335" for domain i.instagram.com, path /, expire 1473619122
// < Set-Cookie: ds_user_id=3410235335; expires=Sun, 11-Sep-2016 18:38:41 GMT; Max-Age=7776000; Path=/
// < Connection: close
// < Content-Length: 46
// < 
// * Closing connection 0
// RESPONSE: {"status": "ok", "upload_id": "1465843119469"}

// REQUEST: media/configure/
// DATA: ig_sig_key_version=4&signed_body=f8f96a7ba3d42537dd2fee5093756ff21963ad9bf8d1bbeeb2b549557b38efc6.{"upload_id":"1465843119469","camera_model":"HM1S","source_type":3,"date_time_original":"2016:06:13 18:38:42","camera_make":"XIAOMI","edits":{"crop_original_size":[640,640],"crop_zoom":1.3333334,"crop_center":[0,-0]},"extra":{"source_width":640,"source_height":640},"device":{"manufacturer":"Xiaomi","model":"HM 1SW","android_version":18,"android_release":"4.3"},"_csrftoken":"142b2baeff1753a5d5b7494d3da5d67b","_uuid":"18cd1d45-104f-4ec6-866b-8ad25a00b483","_uid":"3410235335","caption":"Wow) Do you like?"}
// RESPONSE: {"status": "ok", "media": {"taken_at": 1465843122, "pk": 1271906759015219829, "id": "1271906759015219829_3410235335", "device_timestamp": 1465843119469, "media_type": 1, "code": "BGmuHVehUJ1", "client_cache_key": "MTI3MTkwNjc1OTAxNTIxOTgyOQ==.2", "filter_type": 0, "image_versions2": {"candidates": [{"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/e35/13298018_109203629506060_398026500_n.jpg?ig_cache_key=MTI3MTkwNjc1OTAxNTIxOTgyOQ%3D%3D.2", "width": 640, "height": 640}, {"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/s480x480/e35/13298018_109203629506060_398026500_n.jpg?ig_cache_key=MTI3MTkwNjc1OTAxNTIxOTgyOQ%3D%3D.2", "width": 480, "height": 480}, {"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/s320x320/e35/13298018_109203629506060_398026500_n.jpg?ig_cache_key=MTI3MTkwNjc1OTAxNTIxOTgyOQ%3D%3D.2", "width": 320, "height": 320}, {"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/s240x240/e35/13298018_109203629506060_398026500_n.jpg?ig_cache_key=MTI3MTkwNjc1OTAxNTIxOTgyOQ%3D%3D.2", "width": 240, "height": 240}, {"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/s150x150/e35/13298018_109203629506060_398026500_n.jpg?ig_cache_key=MTI3MTkwNjc1OTAxNTIxOTgyOQ%3D%3D.2", "width": 150, "height": 150}]}, "original_width": 640, "original_height": 640, "user": {"username": "rachelgross93", "has_anonymous_profile_picture": false, "is_unpublished": false, "profile_pic_url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s150x150/13413450_1761784037401767_952894660_a.jpg", "full_name": "Rachel Gross", "pk": 3410235335, "is_private": false}, "organic_tracking_token": "eyJ2ZXJzaW9uIjo1LCJwYXlsb2FkIjp7ImlzX2FuYWx5dGljc190cmFja2VkIjpmYWxzZSwidXVpZCI6ImZiMmE3YWE3YWUxZjQ4ZGM5NjM0OWQ2MzFiYjZmN2UwMTI3MTkwNjc1OTAxNTIxOTgyOSIsInNlcnZlcl90b2tlbiI6IjE0NjU4NDMxMjMyMjJ8MTI3MTkwNjc1OTAxNTIxOTgyOXwzNDEwMjM1MzM1fGMxMDI5ZTQ5YTQ2ZjcxYjhiMzM5MWNiZjk3YTU2ZTgyNGI4MmVkMWRkNjBkNjZhYWNjNTYxNDNkNWUxYTJjMWQifSwic2lnbmF0dXJlIjoiIn0=", "has_liked": false, "has_more_comments": false, "max_num_visible_preview_comments": 4, "comments": [], "comment_count": 0, "caption": {"status": "Active", "user_id": 3410235335, "created_at_utc": 1465843123, "created_at": 1465843123, "bit_flags": 0, "user": {"username": "rachelgross93", "has_anonymous_profile_picture": false, "is_unpublished": false, "profile_pic_url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s150x150/13413450_1761784037401767_952894660_a.jpg", "full_name": "Rachel Gross", "pk": 3410235335, "is_private": false}, "content_type": "comment", "text": "Wow) Do you like?", "media_id": 1271906759015219829, "pk": 17848451701109682, "type": 1}, "caption_is_edited": false, "photo_of_you": false}, "upload_id": "1465843119469"}

// REQUEST: qe/expose/
// DATA: ig_sig_key_version=4&signed_body=1c7bbac2cfe40c8e9af68bf79d9a379d1e872f8f0422bb8253f669a3ed718ca3.{"_uuid":"18cd1d45-104f-4ec6-866b-8ad25a00b483","_uid":"3410235335","id":"3410235335","_csrftoken":"142b2baeff1753a5d5b7494d3da5d67b","experiment":"ig_android_profile_contextual_feed"}
// RESPONSE: {"status": "ok"}

// * Hostname 104.156.229.189 was found in DNS cache
// *   Trying 104.156.229.189...
// * Connected to 104.156.229.189 (104.156.229.189) port 30616 (#0)
// * Establish HTTP proxy tunnel to i.instagram.com:443
// * Proxy auth using Basic with user 'blackking'
// > CONNECT i.instagram.com:443 HTTP/1.1
// Host: i.instagram.com:443
// Proxy-Authorization: Basic YmxhY2traW5nOk5hbWUwMTIzU3BhY2U=
// User-Agent: Instagram 8.0.0 Android (18/4.3; 320dpi; 720x1280; Xiaomi; HM 1SW; armani; qcom; en_US)
// Proxy-Connection: Keep-Alive

// < HTTP/1.0 200 Connection established
// < 
// * Proxy replied OK to CONNECT request
// * TLS 1.2 connection using TLS_ECDHE_RSA_WITH_AES_128_GCM_SHA256
// * Server certificate: *.instagram.com
// * Server certificate: DigiCert SHA2 High Assurance Server CA
// * Server certificate: DigiCert High Assurance EV Root CA
// > POST /api/v1/upload/photo/ HTTP/1.1
// Host: i.instagram.com
// User-Agent: Instagram 8.0.0 Android (18/4.3; 320dpi; 720x1280; Xiaomi; HM 1SW; armani; qcom; en_US)
// Cookie: csrftoken=142b2baeff1753a5d5b7494d3da5d67b; ds_user_id=3410235335; mid=V179PgABAAHXbGPAOatlHiFb8foB; s_network=; sessionid=IGSC213d97dea1e335afdd26eebeea5d27c06bd04b203a2666559e0fbd3811672460%3AY3DUkKuiYVE58jTSubPYpQQ19o1uB8ti%3A%7B%22_token_ver%22%3A2%2C%22_auth_user_id%22%3A3410235335%2C%22_token%22%3A%223410235335%3ATCNJ6sbGK1zaryilk8CayaG2bzDJTcxq%3A68c1ab84c86626fb7274bb6ce38aabf1fe795d3e1d34ddf0f13706971e17d276%22%2C%22asns%22%3A%7B%222001%3A19f0%3Aac00%3Ae9%3A66c7%3A10a5%3Abb95%3Afb13%22%3A20473%2C%22time%22%3A1465843087%7D%2C%22_auth_user_backend%22%3A%22accounts.backends.CaseInsensitiveModelBackend%22%2C%22last_refreshed%22%3A1465843087.853234%2C%22_platform%22%3A1%7D
// Connection: close
// Accept: *
// Content-type: multipart/form-data; boundary=18cd1d45-104f-4ec6-866b-8ad25a00b483
// Content-Length: 126541
// Cookie2: $Version=1
// Accept-Language: en-US
// Accept-Encoding: gzip
// Expect: 100-continue

// < HTTP/1.1 100 Continue
// < Date: Mon, 13 Jun 2016 18:38:56 GMT
// * We are completely uploaded and fine
// < HTTP/1.1 200 OK
// < Server: nginx
// < Date: Mon, 13 Jun 2016 18:38:59 GMT
// < Content-Type: application/json
// < Content-Language: en
// < Expires: Sat, 01 Jan 2000 00:00:00 GMT
// < Vary: Cookie, Accept-Language
// < Pragma: no-cache
// < Cache-Control: private, no-cache, no-store, must-revalidate
// * Replaced cookie csrftoken="142b2baeff1753a5d5b7494d3da5d67b" for domain i.instagram.com, path /, expire 1497292739
// < Set-Cookie: csrftoken=142b2baeff1753a5d5b7494d3da5d67b; expires=Mon, 12-Jun-2017 18:38:59 GMT; Max-Age=31449600; Path=/
// * Replaced cookie ds_user_id="3410235335" for domain i.instagram.com, path /, expire 1473619139
// < Set-Cookie: ds_user_id=3410235335; expires=Sun, 11-Sep-2016 18:38:59 GMT; Max-Age=7776000; Path=/
// < Connection: close
// < Content-Length: 46
// < 
// * Closing connection 0
// RESPONSE: {"status": "ok", "upload_id": "1465843134667"}

// REQUEST: media/configure/
// DATA: ig_sig_key_version=4&signed_body=d57eb1c9485a7732a7c85cf130199d2f5d7db01cb98714f70aa4b8656a90474e.{"upload_id":"1465843134667","camera_model":"HM1S","source_type":3,"date_time_original":"2016:06:13 18:38:59","camera_make":"XIAOMI","edits":{"crop_original_size":[400,400],"crop_zoom":1.3333334,"crop_center":[0,-0]},"extra":{"source_width":400,"source_height":400},"device":{"manufacturer":"Xiaomi","model":"HM 1SW","android_version":18,"android_release":"4.3"},"_csrftoken":"142b2baeff1753a5d5b7494d3da5d67b","_uuid":"18cd1d45-104f-4ec6-866b-8ad25a00b483","_uid":"3410235335","caption":"Wow) Do you like?"}
// RESPONSE: {"status": "ok", "media": {"taken_at": 1465843141, "pk": 1271906914867167866, "id": "1271906914867167866_3410235335", "device_timestamp": 1465843134667, "media_type": 1, "code": "BGmuJmoBUJ6", "client_cache_key": "MTI3MTkwNjkxNDg2NzE2Nzg2Ng==.2", "filter_type": 0, "image_versions2": {"candidates": [{"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/e35/13391108_542813085925277_1367422999_n.jpg?ig_cache_key=MTI3MTkwNjkxNDg2NzE2Nzg2Ng%3D%3D.2", "width": 400, "height": 400}, {"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/s320x320/e35/13391108_542813085925277_1367422999_n.jpg?ig_cache_key=MTI3MTkwNjkxNDg2NzE2Nzg2Ng%3D%3D.2", "width": 320, "height": 320}, {"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/s240x240/e35/13391108_542813085925277_1367422999_n.jpg?ig_cache_key=MTI3MTkwNjkxNDg2NzE2Nzg2Ng%3D%3D.2", "width": 240, "height": 240}, {"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/s150x150/e35/13391108_542813085925277_1367422999_n.jpg?ig_cache_key=MTI3MTkwNjkxNDg2NzE2Nzg2Ng%3D%3D.2", "width": 150, "height": 150}]}, "original_width": 400, "original_height": 400, "user": {"username": "rachelgross93", "has_anonymous_profile_picture": false, "is_unpublished": false, "profile_pic_url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s150x150/13413450_1761784037401767_952894660_a.jpg", "full_name": "Rachel Gross", "pk": 3410235335, "is_private": false}, "organic_tracking_token": "eyJ2ZXJzaW9uIjo1LCJwYXlsb2FkIjp7ImlzX2FuYWx5dGljc190cmFja2VkIjpmYWxzZSwidXVpZCI6IjQ2ZTAzOTI5NTQxODQ4YjZiOGY4OWYyYWNjOGNkNWU2MTI3MTkwNjkxNDg2NzE2Nzg2NiIsInNlcnZlcl90b2tlbiI6IjE0NjU4NDMxNDE3OTh8MTI3MTkwNjkxNDg2NzE2Nzg2NnwzNDEwMjM1MzM1fGVhNjNlM2UyN2MxMDE2MWYyNzJjZjIwNjI2YmUwNzUyMTFhY2Y1ZDY3ZDliMzQ2NGI1YWJmM2Y1OTgzODdhMjkifSwic2lnbmF0dXJlIjoiIn0=", "has_liked": false, "has_more_comments": false, "max_num_visible_preview_comments": 4, "comments": [], "comment_count": 0, "caption": {"status": "Active", "user_id": 3410235335, "created_at_utc": 1465843141, "created_at": 1465843141, "bit_flags": 0, "user": {"username": "rachelgross93", "has_anonymous_profile_picture": false, "is_unpublished": false, "profile_pic_url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s150x150/13413450_1761784037401767_952894660_a.jpg", "full_name": "Rachel Gross", "pk": 3410235335, "is_private": false}, "content_type": "comment", "text": "Wow) Do you like?", "media_id": 1271906914867167866, "pk": 17848255651112833, "type": 1}, "caption_is_edited": false, "photo_of_you": false}, "upload_id": "1465843134667"}

// REQUEST: qe/expose/
// DATA: ig_sig_key_version=4&signed_body=1c7bbac2cfe40c8e9af68bf79d9a379d1e872f8f0422bb8253f669a3ed718ca3.{"_uuid":"18cd1d45-104f-4ec6-866b-8ad25a00b483","_uid":"3410235335","id":"3410235335","_csrftoken":"142b2baeff1753a5d5b7494d3da5d67b","experiment":"ig_android_profile_contextual_feed"}
// RESPONSE: {"status": "ok"}

// * Hostname 104.156.229.189 was found in DNS cache
// *   Trying 104.156.229.189...
// * Connected to 104.156.229.189 (104.156.229.189) port 30616 (#0)
// * Establish HTTP proxy tunnel to i.instagram.com:443
// * Proxy auth using Basic with user 'blackking'
// > CONNECT i.instagram.com:443 HTTP/1.1
// Host: i.instagram.com:443
// Proxy-Authorization: Basic YmxhY2traW5nOk5hbWUwMTIzU3BhY2U=
// User-Agent: Instagram 8.0.0 Android (18/4.3; 320dpi; 720x1280; Xiaomi; HM 1SW; armani; qcom; en_US)
// Proxy-Connection: Keep-Alive

// < HTTP/1.0 200 Connection established
// < 
// * Proxy replied OK to CONNECT request
// * TLS 1.2 connection using TLS_ECDHE_RSA_WITH_AES_128_GCM_SHA256
// * Server certificate: *.instagram.com
// * Server certificate: DigiCert SHA2 High Assurance Server CA
// * Server certificate: DigiCert High Assurance EV Root CA
// > POST /api/v1/upload/photo/ HTTP/1.1
// Host: i.instagram.com
// User-Agent: Instagram 8.0.0 Android (18/4.3; 320dpi; 720x1280; Xiaomi; HM 1SW; armani; qcom; en_US)
// Cookie: csrftoken=142b2baeff1753a5d5b7494d3da5d67b; ds_user_id=3410235335; mid=V179PgABAAHXbGPAOatlHiFb8foB; s_network=; sessionid=IGSC213d97dea1e335afdd26eebeea5d27c06bd04b203a2666559e0fbd3811672460%3AY3DUkKuiYVE58jTSubPYpQQ19o1uB8ti%3A%7B%22_token_ver%22%3A2%2C%22_auth_user_id%22%3A3410235335%2C%22_token%22%3A%223410235335%3ATCNJ6sbGK1zaryilk8CayaG2bzDJTcxq%3A68c1ab84c86626fb7274bb6ce38aabf1fe795d3e1d34ddf0f13706971e17d276%22%2C%22asns%22%3A%7B%222001%3A19f0%3Aac00%3Ae9%3A66c7%3A10a5%3Abb95%3Afb13%22%3A20473%2C%22time%22%3A1465843087%7D%2C%22_auth_user_backend%22%3A%22accounts.backends.CaseInsensitiveModelBackend%22%2C%22last_refreshed%22%3A1465843087.853234%2C%22_platform%22%3A1%7D
// Connection: close
// Accept: 
// Content-type: multipart/form-data; boundary=18cd1d45-104f-4ec6-866b-8ad25a00b483
// Content-Length: 121921
// Cookie2: $Version=1
// Accept-Language: en-US
// Accept-Encoding: gzip
// Expect: 100-continue

// < HTTP/1.1 100 Continue
// < Date: Mon, 13 Jun 2016 18:39:14 GMT
// * We are completely uploaded and fine
// < HTTP/1.1 200 OK
// < Server: nginx
// < Date: Mon, 13 Jun 2016 18:39:16 GMT
// < Content-Type: application/json
// < Content-Language: en
// < Expires: Sat, 01 Jan 2000 00:00:00 GMT
// < Vary: Cookie, Accept-Language
// < Pragma: no-cache
// < Cache-Control: private, no-cache, no-store, must-revalidate
// * Replaced cookie csrftoken="142b2baeff1753a5d5b7494d3da5d67b" for domain i.instagram.com, path /, expire 1497292756
// < Set-Cookie: csrftoken=142b2baeff1753a5d5b7494d3da5d67b; expires=Mon, 12-Jun-2017 18:39:16 GMT; Max-Age=31449600; Path=/
// * Replaced cookie ds_user_id="3410235335" for domain i.instagram.com, path /, expire 1473619156
// < Set-Cookie: ds_user_id=3410235335; expires=Sun, 11-Sep-2016 18:39:16 GMT; Max-Age=7776000; Path=/
// < Connection: close
// < Content-Length: 46
// < 
// * Closing connection 0
// RESPONSE: {"status": "ok", "upload_id": "1465843153567"}

// REQUEST: media/configure/
// DATA: ig_sig_key_version=4&signed_body=a89629f07b20ac32505a9a796f77a6455cdf7190ff0a20c1a6d2fe31631cca45.{"upload_id":"1465843153567","camera_model":"HM1S","source_type":3,"date_time_original":"2016:06:13 18:39:16","camera_make":"XIAOMI","edits":{"crop_original_size":[500,500],"crop_zoom":1.3333334,"crop_center":[0,-0]},"extra":{"source_width":500,"source_height":500},"device":{"manufacturer":"Xiaomi","model":"HM 1SW","android_version":18,"android_release":"4.3"},"_csrftoken":"142b2baeff1753a5d5b7494d3da5d67b","_uuid":"18cd1d45-104f-4ec6-866b-8ad25a00b483","_uid":"3410235335","caption":"Wow) Do you like?"}
// RESPONSE: {"status": "ok", "media": {"taken_at": 1465843157, "pk": 1271907048816460415, "id": "1271907048816460415_3410235335", "device_timestamp": 1465843153567, "media_type": 1, "code": "BGmuLjYBUJ_", "client_cache_key": "MTI3MTkwNzA0ODgxNjQ2MDQxNQ==.2", "filter_type": 0, "image_versions2": {"candidates": [{"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/e35/13388473_1737742199828813_1818836340_n.jpg?ig_cache_key=MTI3MTkwNzA0ODgxNjQ2MDQxNQ%3D%3D.2", "width": 500, "height": 500}, {"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/s320x320/e35/13388473_1737742199828813_1818836340_n.jpg?ig_cache_key=MTI3MTkwNzA0ODgxNjQ2MDQxNQ%3D%3D.2", "width": 320, "height": 320}, {"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/s240x240/e35/13388473_1737742199828813_1818836340_n.jpg?ig_cache_key=MTI3MTkwNzA0ODgxNjQ2MDQxNQ%3D%3D.2", "width": 240, "height": 240}, {"url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-15/s150x150/e35/13388473_1737742199828813_1818836340_n.jpg?ig_cache_key=MTI3MTkwNzA0ODgxNjQ2MDQxNQ%3D%3D.2", "width": 150, "height": 150}]}, "original_width": 500, "original_height": 500, "user": {"username": "rachelgross93", "has_anonymous_profile_picture": false, "is_unpublished": false, "profile_pic_url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s150x150/13413450_1761784037401767_952894660_a.jpg", "full_name": "Rachel Gross", "pk": 3410235335, "is_private": false}, "organic_tracking_token": "eyJ2ZXJzaW9uIjo1LCJwYXlsb2FkIjp7ImlzX2FuYWx5dGljc190cmFja2VkIjpmYWxzZSwidXVpZCI6IjRhMGQzMmQ5YjU5OTQ5YTlhYWI2NjBmNjhiN2E1MTZkMTI3MTkwNzA0ODgxNjQ2MDQxNSIsInNlcnZlcl90b2tlbiI6IjE0NjU4NDMxNTc3OTB8MTI3MTkwNzA0ODgxNjQ2MDQxNXwzNDEwMjM1MzM1fGIzYzAzMGI3MjMyOWJmNzY2N2E0ZWIxZTc0ZGZkY2M1M2Y4ZjUxNDBlYjljNzRmM2Y0YjNlYjg0ZmRkZjhiNjkifSwic2lnbmF0dXJlIjoiIn0=", "has_liked": false, "has_more_comments": false, "max_num_visible_preview_comments": 4, "comments": [], "comment_count": 0, "caption": {"status": "Active", "user_id": 3410235335, "created_at_utc": 1465843157, "created_at": 1465843157, "bit_flags": 0, "user": {"username": "rachelgross93", "has_anonymous_profile_picture": false, "is_unpublished": false, "profile_pic_url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s150x150/13413450_1761784037401767_952894660_a.jpg", "full_name": "Rachel Gross", "pk": 3410235335, "is_private": false}, "content_type": "comment", "text": "Wow) Do you like?", "media_id": 1271907048816460415, "pk": 17858342170018747, "type": 1}, "caption_is_edited": false, "photo_of_you": false}, "upload_id": "1465843153567"}

// REQUEST: qe/expose/
// DATA: ig_sig_key_version=4&signed_body=1c7bbac2cfe40c8e9af68bf79d9a379d1e872f8f0422bb8253f669a3ed718ca3.{"_uuid":"18cd1d45-104f-4ec6-866b-8ad25a00b483","_uid":"3410235335","id":"3410235335","_csrftoken":"142b2baeff1753a5d5b7494d3da5d67b","experiment":"ig_android_profile_contextual_feed"}
// RESPONSE: {"status": "ok"}

// photo downloaded!
// REQUEST: accounts/set_private/
// DATA: ig_sig_key_version=4&signed_body=a60e3841ee9bf82f1af585793e7a54da1b6884cdf33dc14d89b64f72b45e6eda.{"_uuid":"18cd1d45-104f-4ec6-866b-8ad25a00b483","_uid":"3410235335","_csrftoken":"142b2baeff1753a5d5b7494d3da5d67b"}
// RESPONSE: {"status": "ok", "user": {"username": "rachelgross93", "has_anonymous_profile_picture": false, "profile_pic_url": "http://scontent-sjc2-1.cdninstagram.com/t51.2885-19/s150x150/13413450_1761784037401767_952894660_a.jpg", "biography": "Love or s _ x? ^^", "full_name": "Rachel Gross", "pk": 3410235335, "is_private": true, "external_url": ""}}

// * Hostname in DNS cache was stale, zapped
// *   Trying 104.156.229.189...
// * Connected to 104.156.229.189 (104.156.229.189) port 30616 (#0)
// * Establish HTTP proxy tunnel to i.instagram.com:443
// * Proxy auth using Basic with user 'blackking'
// > CONNECT i.instagram.com:443 HTTP/1.1
// Host: i.instagram.com:443
// Proxy-Authorization: Basic YmxhY2traW5nOk5hbWUwMTIzU3BhY2U=
// User-Agent: Instagram 8.0.0 Android (18/4.3; 320dpi; 720x1280; Xiaomi; HM 1SW; armani; qcom; en_US)
// Proxy-Connection: Keep-Alive

// < HTTP/1.0 200 Connection established
// < 
// * Proxy replied OK to CONNECT request
// * TLS 1.2 connection using TLS_ECDHE_RSA_WITH_AES_128_GCM_SHA256
// * Server certificate: *.instagram.com
// * Server certificate: DigiCert SHA2 High Assurance Server CA
// * Server certificate: DigiCert High Assurance EV Root CA
// > POST /api/v1/direct_v2/threads/broadcast/media_share/?media_type=photo HTTP/1.1
// Host: i.instagram.com
// User-Agent: Instagram 8.0.0 Android (18/4.3; 320dpi; 720x1280; Xiaomi; HM 1SW; armani; qcom; en_US)
// Cookie: csrftoken=142b2baeff1753a5d5b7494d3da5d67b; ds_user_id=3410235335; mid=V179PgABAAHXbGPAOatlHiFb8foB; s_network=; sessionid=IGSC213d97dea1e335afdd26eebeea5d27c06bd04b203a2666559e0fbd3811672460%3AY3DUkKuiYVE58jTSubPYpQQ19o1uB8ti%3A%7B%22_token_ver%22%3A2%2C%22_auth_user_id%22%3A3410235335%2C%22_token%22%3A%223410235335%3ATCNJ6sbGK1zaryilk8CayaG2bzDJTcxq%3A68c1ab84c86626fb7274bb6ce38aabf1fe795d3e1d34ddf0f13706971e17d276%22%2C%22asns%22%3A%7B%222001%3A19f0%3Aac00%3Ae9%3A66c7%3A10a5%3Abb95%3Afb13%22%3A20473%2C%22time%22%3A1465843087%7D%2C%22_auth_user_backend%22%3A%22accounts.backends.CaseInsensitiveModelBackend%22%2C%22last_refreshed%22%3A1465843087.853234%2C%22_platform%22%3A1%7D
// Proxy-Connection: keep-alive
// Connection: keep-alive
// Accept: *
// Content-type: multipart/form-data; boundary=18cd1d45-104f-4ec6-866b-8ad25a00b483
// Accept-Language: en-en
// Content-Length: 750


// $first_name = "asd as";
//     $smiles_list =  ["\u{1F60C}" ,"\u{1F60D}" , "\u{1F61A}"  ,"\u{1F618}", "\u{2764}", "\u{1F64C}"];
//                 $smiles_hi =  ["\u{26A1}", "\u{1F48B}","\u{1F609}", "\u{1F633}", "\u{1F60C}" , "\u{1F61A}"  ,"\u{1F618}", "\u{270C}", "\u{1F47B}", "\u{1F525}", "\u{1F607}", "\u{1F617}", "\u{1F619}", "\u{1F60E}", "\u{1F61C}", "\u{270B}",  "\u{1F60B}"];
//                 $smiles =  ["\u{1F609}", "\u{1F60C}", "\u{1F46B}" ];    
//                 $cursors = ["\u{261D}" , "\u{2B06}", "\u{2934}", "\u{1F53C}", "\u{1F51D}" ];  
//                 $cur = $cursors[mt_rand(0, count($cursors) - 1)];
//                 $smi = $smiles_list[mt_rand(0, count($smiles_list) - 1)];
//                 $smi_hi = $smiles_hi[mt_rand(0, count($smiles_hi) - 1)];
//                 $smil = $smiles[mt_rand(0, count($smiles) - 1)];
//                 $first_name_txt = explode(" ",$first_name);
//                 $hi_word = ["Hey! What's up? I am", "Hi! I am", "Hey there, I am"];
//                 $hiw = $hi_word[mt_rand(0, count($hi_word) - 1)];

//              echo   $text = "$hiw $first_name_txt[0] $smi_hi  I am searching for a partner $smil  Please, S_I_G_N U_P by аddrеss in @kupit_nike profile $cur $cur $cur and write me there $smi";


 //        curl_setopt($ch, CURLOPT_URL, Constants::API_URL.$endpoint);
 //        curl_setopt($ch, CURLOPT_USERAGENT, Constants::USER_AGENT);
 //        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 //         curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
 //        curl_setopt($ch, CURLOPT_HEADER, true);
 //        curl_setopt($ch, CURLOPT_VERBOSE, false);
 //        curl_setopt($ch, CURLOPT_PROXY, $this->proxy ); 
 //        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); 
 //        curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'blackking:Name0123Space');


 // // 