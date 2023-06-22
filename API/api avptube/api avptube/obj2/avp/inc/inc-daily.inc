<?php
if(!function_exists("dailyurl")) {
function dailyurl($Url){ 
    // is cURL installed yet?
//    if (!function_exists('curl_init')){      die('Sorry cURL is not installed!');} 
    // OK cool - then let's create a new cURL resource handle
    $ch = curl_init();
    // Now set some options (most are optional)
    // Set URL to download
    curl_setopt($ch, CURLOPT_URL, $Url);
    // Set a referer
    //curl_setopt($ch, CURLOPT_REFERER, "http://www.google.com");
    // User agent
    curl_setopt($ch, CURLOPT_USERAGENT, "Dalvik/1.6.0 (Linux; U; Android 4.4.2; SAMSUNG-SM-N900A Build/KOT49H)");
    // Include header in result? (0 = yes, 1 = no)
    curl_setopt($ch, CURLOPT_HEADER, 0);
    // Should cURL return or print out the data? (true = return, false = print)
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Timeout in seconds
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    // Download the given URL, and return output
    $output = curl_exec($ch);
 
    // Close the cURL resource, and free system resources
    curl_close($ch);
 
    return $output;
}
}
?>