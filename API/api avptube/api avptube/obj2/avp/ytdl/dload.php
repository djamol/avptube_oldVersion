<?php

function _Download($f_location, $f_name){
  //$file = 'temp/'.uniqid() . '.mp4';
  $file = 'temp/'.$f_name . '.mp4';

  file_put_contents($file,file_get_contents($f_location));

  header('Content-Description: File Transfer');
  header('Content-Type: application/octet-stream');
  header('Content-Length: ' . filesize($file));
  header('Content-Disposition: attachment; filename=' . basename($f_name));

  readfile($file); 
}

_2Download(base64_decode($_GET['token']), $_GET['title']);

function _2Download($f_location, $f_name){
header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=\"" . basename($f_location) . "\""); 
readfile($f_location); // do the double-download-dance (dirty but worky)

}

/*
		header('Content-Type: "' . $mime . '"');
		header('Content-Disposition: attachment; filename="' . $name . '"');
		header("Content-Transfer-Encoding: binary");
		header('Expires: 0');
		header('Content-Length: '.$size);
		header('Pragma: no-cache');

function get_size($url) {
	$my_ch = curl_init();
	curl_setopt($my_ch, CURLOPT_URL,$url);
	curl_setopt($my_ch, CURLOPT_HEADER,         true);
	curl_setopt($my_ch, CURLOPT_NOBODY,         true);
	curl_setopt($my_ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($my_ch, CURLOPT_TIMEOUT,        10);
	$r = curl_exec($my_ch);
	 //echo "<br /><br />".$url."<br /><br />".$r."<br /><br />";
	 foreach(explode("\n", $r) as $header) {
		if(strpos($header, 'Content-Length:') === 0) {
			return trim(substr($header,16));
		}
	 }
	return '';
}
*/

