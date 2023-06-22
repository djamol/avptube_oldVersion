<?php

$idb = file_get_contents("http://dl.musiclinko.com/?url=https://www.youtube.com/watch?v=$vid");
                $idcheck=preg_match_all ('/https(.*)googlevideo(.*)"(.*)<\/a>/U', $idb, $matches);
                //var_dump($matches);
                 if(!empty($idcheck) AND ($idcheck > 2)){
                     foreach($matches[2] as $index => $val) {
                     $val = str_ireplace("Vdsmaza.com","",$val);$name =$matches[3][$index];
                     $first =$matches[1][$index];
                     $name = str_replace('rel="nofollow" class="list-group-item">','',$name);
                     $val =str_replace('title=','title=Avptube.com_',$val);
                      $vts  = str_pad(dechex(mt_rand(0, 0xFFFFF)), 8, '0', STR_PAD_LEFT);
                     $url = get_redirect_target("https".$first."googlevideo$val");$sz = get_size($url);
                       if ($sz > 5086 ){ $sizedata = formatBytes($sz);
                       if (strpos($val,'&itag=22&') !== false) {
            $getit .='{"link": "MP4 - (Max 720p) Video('.$sizedata.')","name": "http://redirector.googlevideo'.$val.'&nc=/AvpTube.Com_'.$vts.'.mp4"},'; 
            $plr .='{"name": "720p","link": "http://redirector.googlevideo'.$val.'&nc=/AvpTube.Com_'.$vts.'.mp4"},'; 
        }elseif(strpos($val,'&itag=18&') !== false){// mp4 360p
            $getit .='{"link": "MP4 - 480p Video('.$sizedata.')","name": "http://redirector.googlevideo'.$val.'&nc=/AvpTube.Com_'.$vts.'.mp4"},'; 
            $plr .='{"name": "480p","link": "http://redirector.googlevideo'.$val.'&nc=/AvpTube.Com_'.$vts.'.mp4"},'; 
        }elseif(strpos($val,'&itag=36&') !== false){//3gp 240p
            $getit .='{"link": "3GP - (240p) Video('.$sizedata.')","name": "http://redirector.googlevideo'.$val.'&nc=/AvpTube.Com_'.$vts.'.mp4"},'; 
            $plr .='{"name": "240p","link": "http://redirector.googlevideo'.$val.'&nc=/AvpTube.Com_'.$vts.'.mp4"},'; 
        
        }
}
}
}

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
function get_redirect_target($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $headers = curl_exec($ch);
    curl_close($ch);
    // Check if there's a Location: header (redirect)
    if (preg_match('/^Location: (.+)$/im', $headers, $matches))
        return trim($matches[1]);
    // If not, there was no redirect so return the original URL
    // (Alternatively change this to return false)
    return $url;
}



                      
?>