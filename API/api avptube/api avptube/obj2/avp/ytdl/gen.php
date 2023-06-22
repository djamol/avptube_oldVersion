<?php
error_reporting(0);
if($_GET['p']!='amolpatil'){exit();}
$vid = $_GET['vid'];
//echo urlip6("https://www.whatismyip.com/");
$grab2 = urlip6("https://www.delyoutube.com/ytinfo.php?link=$vid&f=1");
$json2 = json_decode($grab2);
$idcheck2=preg_match_all ('/value=(.*)">(.*)<br/U', $grab2, $matches2);
function validate($id,$fq){$grab2 = urlip6("https://www.delyoutube.com/ytvid.php?link=$id&fq=$fq");if(preg_match('/href=(.*)" class/',$grab2 ,$matches) == true){$str = str_replace('\\', '', $matches[1]);$str = str_replace('"', '', $str);$str =str_ireplace('(DelYouTube.com)','AvpTube.Com',$str);$sz = get_size($str);if ($sz > 5086 ){return true;}else{return false;}}}
function urlip6($url){$ch = curl_init(); curl_setopt($ch, CURLOPT_URL, $url); curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); curl_setopt($ch,CURLOPT_ENCODING,'gzip'); 
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true); curl_setopt($ch, CURLOPT_TIMEOUT, 10);

$arrX = array("2607:ff48:aa81:3706:0:10:d36a:2e54","2607:ff48:aa81:3706:0:10:e875:4a0b","2607:ff48:aa81:3706:0:10:b908:5b39","2607:ff48:aa81:3706:0:10:621d:28f6","2607:ff48:aa81:3706:0:10:2b6a:140","2607:ff48:aa81:3706:0:10:2fa2:6c46","2607:ff48:aa81:3706:0:10:24b1:1484","2607:ff48:aa81:3706:0:10:c798:fa4f","2607:ff48:aa81:3706:0:10:1cab:3214","2607:ff48:aa81:3706:0:10:be65:afe2","2607:ff48:aa81:3706:0:10:9fa1:a8bc","2607:ff48:aa81:3706:0:10:6ab6:1391","2607:ff48:aa81:3706:0:10:42ac:cb19","2607:ff48:aa81:3706:0:10:71eb:ae1a","2607:ff48:aa81:3706:0:10:5196:4576","2607:ff48:aa81:3706:0:10:793e:26db","2607:ff48:aa81:3706:0:10:70d9:7d6f","2607:ff48:aa81:3706:0:10:18f5:f017","2607:ff48:aa81:3706:0:10:fe1b:be8a","2607:ff48:aa81:3706:0:10:7d3f:a617","2607:ff48:aa81:3706:0:10:c469:83ef","2607:ff48:aa81:3706:0:10:14b7:a250","2607:ff48:aa81:3706:0:10:6d18:109e","2607:ff48:aa81:3706:0:10:3243:eb10","2607:ff48:aa81:3706:0:10:6e04:75af","2607:ff48:aa81:3706:0:10:fcd0:4971","2607:ff48:aa81:3706:0:10:cf03:5f8f","2607:ff48:aa81:3706:0:10:839c:5032","2607:ff48:aa81:3706:0:10:5ad3:5e8b","2607:ff48:aa81:3706:0:10:c2b:bf3d","2607:ff48:aa81:3706:0:10:4970:f65d","2607:ff48:aa81:3706:0:10:50c:ba47","2607:ff48:aa81:3706:0:10:a806:cf82","2607:ff48:aa81:3706:0:10:1043:6d70","2607:ff48:aa81:3706:0:10:c562:1268","2607:ff48:aa81:3706:0:10:dcaf:d4cd","2607:ff48:aa81:3706:0:10:32a5:78ef","2607:ff48:aa81:3706:0:10:f8b6:2e1e","2607:ff48:aa81:3706:0:10:7973:7a67","2607:ff48:aa81:3706:0:10:923:dbd7","2607:ff48:aa81:3706:0:10:9cbf:29e3","2607:ff48:aa81:3706:0:10:babf:10c1","2607:ff48:aa81:3706:0:10:d6e2:c414","2607:ff48:aa81:3706:0:10:d56f:93fb","2607:ff48:aa81:3706:0:10:4348:d59e","2607:ff48:aa81:3706:0:10:b15e:8bd3","2607:ff48:aa81:3706:0:10:f8ba:c625","2607:ff48:aa81:3706:0:10:7a1:1504","2607:ff48:aa81:3706:0:10:1f92:6475","2607:ff48:aa81:3706:0:10:3861:d53e","2607:ff48:aa81:3706:0:10:14fc:b931");
$randIndex = array_rand($arrX);
$ip = $arrX[$randIndex];
curl_setopt( $curl, CURLOPT_INTERFACE, $ip );
curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V6); //set ipv6 ip or hide main ip
//curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4); //set ip4
$header[] = "Accept-Language: en";$header[] = "User-Agent: Mozilla/5.0 (Linux; U; Android 4.1.2; en-gb; GT-S7582 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30"; 
$header[] = "Pragma: no-cache"; $header[] = "Cache-Control: no-cache"; $header[] = "Accept-Encoding: gzip,deflate"; $header[] = "Content-Encoding: gzip"; $header[] = "Content-Encoding: deflate"; curl_setopt($ch, CURLOPT_HTTPHEADER, $header); $load = curl_exec($ch); curl_close($ch); return $load;}

//$d  =$json2->data;
//echo($d);
//var_dump($matches2);
$int = filter_var($matches2[1][0], FILTER_SANITIZE_NUMBER_INT);
$randm  = str_pad(dechex(mt_rand(0, 0xFFFFF)), 8, '0', STR_PAD_LEFT);
if(validate($vid,$int)){
foreach($matches2[1] as $index => $int) { 
$int = filter_var($int, FILTER_SANITIZE_NUMBER_INT);
$DDS ='http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
//echo $int.'<Br>'.$matches2[2][$index];
echo '#'.$DDS.'/dl.py?f='.$int.'&v='.base64_encode($vid).'&nc=/AvpTube.Com_'.$randm.'>'.$matches2[2][$index].'<';

}}
function formatBytes($bytes, $precision = 2) {
    $units = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, $precision) . '' . $units[$pow];
}
function get_size($url) {
	$my_ch = curl_init();
	curl_setopt($my_ch, CURLOPT_URL,$url);
	curl_setopt($my_ch, CURLOPT_HEADER,         true);
	curl_setopt($my_ch, CURLOPT_NOBODY,         true);
	curl_setopt($my_ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($my_ch, CURLOPT_TIMEOUT,        10);
	$r = curl_exec($my_ch);
	 foreach(explode("\n", $r) as $header) {
		if(strpos($header, 'Content-Length:') === 0) {
			return trim(substr($header,16)); 
		}
	 }
	return '';
}
?>