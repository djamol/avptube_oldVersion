<?php
include'algo_class.php';
//classess include end
/*
* Code Get From https://github.com/WendyH/HMS-Youtube
* File URL https://github.com/WendyH/HMS-Youtube/blob/8e5983f467e8b13007f6181cb4efa60debfbcb3c/g.php
*/
$videoId="VY1eFxgRR-k";

$options  = array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"Accept-language: ru-ru,ru;q=0.8,en-us;q=0.5,en;q=0.3\r\n" .
              "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36\r\n"
  )
);
if ($ip  ) $options['http']['header'] .= "X-Forwarded-For: ".$ip."\r\n" ;
if ($auth) $options['http']['header'] .= "Authorization: Bearer ".$auth."\r\n" ;
if ($headers) {
	$hdrs = explode('|', $headers);
	foreach ($hdrs as $h) $options['http']['header'] .= $h."\r\n" ;
}
if ($checkRestrict) echo "Headers: \r\n" . $options['http']['header'];
$context  = stream_context_create($options);
$VideoUrl = 'http://www.youtube.com/watch?v='.$videoId.'&hl=ru&persist_hl=1&has_verified=1&bpctr='.(time() + (2.5 * 60 * 60));
if ($time) $VideoUrl .= '&t='.$time;
$pageHtml = file_get_contents($VideoUrl, false, $context);
// Search ytPlayer.Config json in video page
if (!preg_match('/player.config\s*?=\s*?({.*?});/', $pageHtml, $matches)) {
	if ($checkRestrict) die(StatusError(6, "Video unavaliable"));
	echo file_get_contents('http://rus.lostcut.net/youtube/g.php?'.http_build_query($_REQUEST));
	exit;
}
if (!preg_match('/player.config\s*?=\s*?({.*?});/', $pageHtml, $matches)) {
	$msg = preg_match('/<h[^>]+unavailable-message.*?<\/h\d>/s', $pageHtml, $matches) ? $matches[0] : '';
	if ($msg) $msg = trim(strip_tags($msg));
	if ($msg) die(StatusError(2, $msg));
	else die(StatusError(3, "Video page do not contains player.config json object"));
}
$PlayerConfig = new ArrayPath($matches[1]);
$Algorithms   = new IniDatabase('algorithms.ini');
$hlsUrl      = ExpandUrl($PlayerConfig['args\\hlsvp']);
$ttsUrl      = ExpandUrl($PlayerConfig['args\\ttsurl']);
$flp         = ExpandUrl($PlayerConfig['url']);
$jsUrl       = ExpandUrl($PlayerConfig['assets\\js']);
$is3D        = false;
$isLive      = (bool)($hlsUrl!='');
$dashMpdLink = $PlayerConfig['args\\dashmpd'];
$streamMap   = $PlayerConfig['args\\url_encoded_fmt_stream_map'];
if ($adaptive && $PlayerConfig['args\\adaptive_fmts']) 
  $streamMap = $PlayerConfig['args\\adaptive_fmts'];
if (!$streamMap && !$isLive) die(StatusError(4, "Can not found stream map in player config"));
$playerId    = preg_match('/player-([\w_-]+)/', $jsUrl, $matches) ? $matches[1] : '';
$algorithm   = $playerId ? $Algorithms[$playerId] : '';
$selectedUrl = '';
$height      = 0;
$minPriority = 9;
$selHeight   = 0;
$selAudio    = '';
if (!$algorithm && !$isLive) { 
	// If no algorithm in our database - load javascript, search and store algo
	$algorithm = GetAlgorithm($jsUrl);
	if ($algorithm) $Algorithms[$playerId] = $algorithm;
	else die(StatusError(5, "Can not find algorithm in player javascript"));
}

function GetAlgorithm($jsUrl) {
	if      (substr($jsUrl, 0, 2)=="//") $jsUrl = "https:".$jsUrl;
	else if (substr($jsUrl, 0, 1)=="/" ) $jsUrl = "https://www.youtube.com".$jsUrl;
	$algo = "";
	$data = file_get_contents($jsUrl);
	$fns  = preg_match('/a=a\.split\(""\);(.*?)return/s', $data, $m) ? $m[1] : '';
	$arr  = explode(';', $fns);
	// Iterate all operations in algorithm
	foreach ($arr as $func) {
	   $textFunc = $func;
		// if called function of object - search the object and its function
		if (preg_match('/([\$\w]+)\.(\w+)\(/s', $textFunc, $m)) {
			$obj = $m[1];
			$fun = $m[2];
			if (($obj!='a') && preg_match('/var '.$obj.'=\{.*?('.$fun.':function|function '.$fun.'\()(.*?})/s', $data, $m))
				$textFunc = $m[2];
			else if (($obj!='a') && preg_match('/var \\'.$obj.'=\{.*?('.$fun.':function|function '.$fun.'\()(.*?})/s', $data, $m))
				$textFunc = $m[2];
		}
		// if called named function - search text of this function
		if (preg_match('/a=(\w+)\(/s', $textFunc, $m)) {
			$fun = $m[1];
			if (preg_match('/var '.$obj.'=\{.*?('.$fun.':function|function '.$fun.'\())(.*?})/s', $data, $m))
				$textFunc = $m[2];
			else if (preg_match('/var \\'.$obj.'=\{.*?('.$fun.':function|function '.$fun.'\())(.*?})/s', $data, $m))
				$textFunc = $m[2];
		}
		// get the value of parameter
		$numb = preg_match('/\(.*?(\d+)/s', $func, $m) ? $m[1] : '';
		// determine the type of the function
		$type = 'w';
		if     (preg_match('/revers/'        , $textFunc, $m)) $type = 'r';
		elseif (preg_match('/(splice|slice)/', $textFunc, $m)) $type = 's';
		if (($type!='r') && ($numb==='')) continue; // it's no cypher function
		$algo .= ($type=='r') ? $type.' ' : $type.$numb.' ';
	}
	return trim($algo);
}

// ----------------------------------------------------------------------------
function StatusError($errorCode, $msg) {
	$result = array('status' => 'error', 'error' => $errorCode, 'reason' => $msg);
	return json_encode($result, JSON_UNESCAPED_UNICODE);
}
function ExpandUrl($url) {
	if (substr($url, 0, 2)=='//') $url = 'http:' . trim($url);
	return $url;
}
function MediaFormatPriority($height, $mediaFormats) {
	$formats = explode(',', $mediaFormats);
	for ($i=0; $i < count($formats); $i++) { 
		$m = explode('-', $formats[$i]);
		$min = isset($m[0]) ? intval($m[0]) : 0;
		$max = isset($m[1]) ? intval($m[1]) : 0;
		if (($min>0) && ($height>=$min) && ($max>0) && ($height<=$max)) return $i;
	}
	return -1;
}


?>