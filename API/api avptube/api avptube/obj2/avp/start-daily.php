<?php
$attachment_location = $_GET['url'];
//if (file_exists($attachment_location)) {
/*
    //header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
    header("Cache-Control: public"); // needed for internet explorer
    header("Content-Type: video/mp4");
    header("Content-Transfer-Encoding: Binary");
    header("Content-Length:".remotefileSize($attachment_location));
    header("Content-Disposition: attachment; filename=AvpTube.mp4");
    readfile($attachment_location);
  //  die();
//} else {
//    die("Error: File not found.");
//}
function remotefileSize($url) {
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_NOBODY, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
curl_exec($ch);
$filesize = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
curl_close($ch);
if ($filesize) return $filesize;
}
*/
    header("Location: $attachment_location");
?>