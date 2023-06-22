<?php
_2Download(base64_decode($_GET['token']), $_GET['title']);

function _2Download($f_location, $f_name){
header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary"); 
if(!empty($_GET['size'])){ 
header('Content-Length: ' . $_GET['size']);
} 
header("Content-disposition: attachment; filename=\"" . ($f_name) . "\""); 
readfile($f_location); // do the double-download-dance (dirty but worky)

}
?>