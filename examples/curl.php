
<?php
 
$size = 640;
$raw = true;
 $file = "test.jpg";
 list($width, $height) = getimagesize($file);
 echo $width.'\n';
 echo $height.'\n';

    if ($width > $height) {
        $y = 0;
        $x = ($width - $height) / 2;
        $smallestSide = $height;
    } else {
        $x = 0;
        $y = ($height - $width) / 2;
        $smallestSide = $width;
    }

    $image_p = imagecreatetruecolor($size, $size);
    $image = imagecreatefromstring(file_get_contents($file));

    imagecopyresampled($image_p, $image, 0, 0, $x, $y, $size, $size, $smallestSide, $smallestSide);
    ob_start();
    imagejpeg($image_p, null, 100);
 $i = ob_get_contents();

 ob_end_clean();

    imagedestroy($image);
    imagedestroy($image_p);
 
// imagejpeg($i, 'test2.jpg', 0 , NULL);
 
imagejpeg(imagecreatefromstring($i), 'test_3.jpg');

 // <?php
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