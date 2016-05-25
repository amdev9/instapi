 <?php
        //error_reporting(E_ALL);

        if( $ch = curl_init ())
        {            
         curl_setopt ($ch, CURLOPT_URL, 'http://google.com'); 
         curl_setopt ($ch, CURLOPT_TIMEOUT, 60); 
         curl_setopt ($ch, CURLOPT_PROXY, "45.55.178.19:5013"); 
         curl_setopt ($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); 
         curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE); 
         curl_setopt ($ch, CURLOPT_FAILONERROR, true); 
         curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1); 
         curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'blackking:Name0123Space');
         
         $result = curl_exec($ch); 
         //print curl_errno ($ch); 
         //print $result; 
         echo $result;
         curl_close ($ch); 
        } 
 ?>

