<?
$id = $_GET['v'];$fq = $_GET['f'];
$grab2 = file_get_contents("https://www.delyoutube.com/ytvid.php?link=$id&fq=$fq");
//$json2 = json_decode($grab2);
//var_dump($grab2);
if(preg_match('/href=(.*)" class/',$grab2 ,$matches) == true){ // check any match found or not
$str = str_replace('\\', '', $matches[1]);$str = str_replace('"', '', $str);
$str =str_ireplace('(DelYouTube.com)','AvpTube.Com',$str);
 $sz = get_size($str);
//echo $sz = formatBytes($sz);
if ($sz > 5086 ){
 header('Location: '.$str.'');
     }else{
echo "Error Try Again:<a href=\"javascript:history.go(-1)\">GO BACK</a>";}
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