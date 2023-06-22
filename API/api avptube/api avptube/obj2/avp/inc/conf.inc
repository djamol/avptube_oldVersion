<?php
 error_reporting(0);
// ini_set('display_errors', 0);
//echo'fail"d co{nne"ction';
header('Content-Type: text/html; charset=utf-8');
header('xum: zipped');
$dat = date("G");
$randm  = str_pad(dechex(mt_rand(0, 0xFFFFF)), 8, '0', STR_PAD_LEFT);
 //$datas = base64_encode(gzcompress($data));//compressed
//echo ''.(gzuncompress(base64_decode($datas)));//decompressed
//if($_GET['occ'] == 'samsung'){echo base64_encode(gzcompress('open://www.bing.com/search?q='.urlencode($_GET['q']).'&aq=t'));exit();}
//*$apisecond = 'http://23.95.10.43/ytdl/search.php?pass=12345';
//*$apithird = 'http://23.95.10.43/ytdl/search.php?pass=12345';
//AIzaSyDQHU2Oc2KrARCeWdvY-47ONP0acGxUzWA	
//AIzaSyDZ6VGiI6hA1pmQDxED2jp12aUGR8ItVIg
//AIzaSyA5psGY2p6HHuZ1qxPl1cj6CYszyixzbus
//lareetomkumtaat@gmail.com tark@26102(pass)
//prajaxxx1xx7@gmxxx.com $input = array('AIzaSyCQCYUrL6CqR1XRhyn4CTEqMHENz_aakVc', 'AIzaSyCXE3CwidnbQCjo6jPLXqWCdXzIwEjWsS8', 'AIzaSyC8zM828d5m6iK39jQnGLl0ebSz4idn_tE');
$domain = $_SERVER["SERVER_NAME"];
$apiurl = 'http://'.$domain.'/avp';$appurl = $domain.'/avp';

if($domain != "api.patilweb.com")
{

 //    $checkVars = array("s.php", "c.php", "m.php", "t.php");
//     if(in_array(basename($_SERVER['PHP_SELF']), $checkVars)){ //value found
            if(empty($_GET['rid'])){
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {$ips = $_SERVER['HTTP_CLIENT_IP'];}         elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {$ips = $_SERVER['HTTP_X_FORWARDED_FOR'];} else {$ips = $_SERVER['REMOTE_ADDR'];}     
                   include("ip2c/geoip.inc");  $gi = geoip_open("ip2c/GeoIP.dat", GEOIP_STANDARD);
            $var = geoip_country_code_by_addr($gi, $ips);geoip_close($gi);
            //if($var =="US"){ exit();}
            $rid="$ips-$var";
                }else{
            $rid=$_GET['rid'];}$xpi = explode("-",$rid)[1];

if(!empty($xpi)){
     $checkVars = array("US", "USA", "UK");
           
           if(in_array($xpi, $checkVars)){ exit();}//value found  //activate this line for disable us country user

}
//}
//echo basename($_SERVER['PHP_SELF']); //s.php
//echo $rid."@@@";
}
$u_agent = $_SERVER['HTTP_USER_AGENT'];// echo $u_agent;
//   if (!preg_match('/avp.video/i', $u_agent)) { echo base64_encode(gzcompress('update://avptube.com/AvpTube.apk'));exit();}
 
if (!preg_match('/ato/i', $u_agent)) {    if($_GET['va'] != 'amolpatil'){exit();} }
//    if ($_GET['zzz'] == "amazon"){echo'open://www.google.com/search?q='.urlencode($_GET['q']).'&aq=t';exit();}
/*
$myfile = fopen("temp.txt", "a+")  ;
$txt = "\n Query:".$_SERVER["QUERY_STRING"];
fwrite($myfile, $txt);
fclose($myfile);
*/


//echo $_SERVER["SERVER_NAME"];


//Grabber Http Html or another file
function ngegrab($url){$ch = curl_init(); curl_setopt($ch, CURLOPT_URL, $url); curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); curl_setopt($ch,CURLOPT_ENCODING,'gzip'); 
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true); curl_setopt($ch, CURLOPT_TIMEOUT, 10);
//$input = array("104.152.187.19", "104.152.187.2");
//$ip = $input[array_rand($input)];curl_setopt( $ch, CURLOPT_INTERFACE, $ip );
$header[] = "Accept-Language: en"; 
$header[] = "Mozilla/5.0 (Linux; U; Android 4.1.2; en-gb; GT-S7582 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30"; 
$header[] = "Pragma: no-cache"; $header[] = "Cache-Control: no-cache"; $header[] = "Accept-Encoding: gzip,deflate"; $header[] = "Content-Encoding: gzip"; $header[] = "Content-Encoding: deflate"; curl_setopt($ch, CURLOPT_HTTPHEADER, $header); $load = curl_exec($ch); curl_close($ch); return $load;}

if ($dat < 6) { $devkey ='AIzaSyDaPyvMO4knbaYzOGqGV1oQ2Ojs8YMaoFo'; //$welcome = 'Good morning';
}elseif ($dat > 5 && $dat < 10) {  $devkey ='AIzaSyCjC-1SI7piKg2nlXSJhBZ1GU4rLZD2UTY';
} elseif ($dat > 11 && $dat < 18) {  $devkey ='AIzaSyCRoyt-fZtAMQ4aFOyeCxNE1_kbTL7pZJw'; //$welcome = 'Good afternoon';
} elseif ($dat > 17 && $dat < 22) {  $devkey ='AIzaSyAQBZKvLV8DOIMpeoNOnMG50qlrF0VZDoU'; //$welcome = 'Good afternoon';
}//else if(date('H') > 22)
else{$devkey ='AIzaSyCy3TrF0OAcbPX17enZo4KQBLZAgfw-jKE'; //djamolgroup2gmail.com
    }
$friends=array("2dcf4e12afd6ed5119741f888260fc85", "0e645524cbd450bb21c994b0f62906f3", "b262eca1c405ed74bc5a15b35da2c14c", "5f06139391876a07e465e44f34be87c4");
$winner = array_rand($friends, 1);
$client_id2 = $friends[$winner]; //default


function dateyt($date){$date=substr($date,0,10); $date=explode('-',$date); $mn=date('F',mktime(0,0,0,$date[1])); $dates=''.$date[2].' '.$mn.' '.$date[0].''; return $dates;}

