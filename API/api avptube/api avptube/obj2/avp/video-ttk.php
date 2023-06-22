<?php
ini_set('display_errors', 0);

header('Content-Type: text/html; charset=utf-8');
header('xum: zipped');
$vid = $_GET['id'];
$vid = str_replace('ttk@','',$vid);

$dapi ="https://api2.musical.ly/aweme/v1/play/?video_id=$vid&line=0&ratio=360p&watermark=0&media_type=4&vr_type=0&test_cdn=None&improve_bitrate=0&logo_name=ok&nc=/MyFile.mp4";
$dapi2 ="https://api2.musical.ly/aweme/v1/play/?video_id=$vid&line=1&ratio=360p&watermark=0&media_type=4&vr_type=0&test_cdn=None&improve_bitrate=0&logo_name=ok&nc=/MyFile.mp4";


//$sav .='{"id":1,"pref":false,"force":true,"rid":"","status":null,"widget":"true","banner":"false","native":"false","toolcolor":"#1a1a1a"';
$sav .=',"img":{"img":"http://i.ytimg.com/vi/F8pWG8DSeOY/0.jpg","img1":"http://i.ytimg.com/vi/F8pWG8DSeOY/1.jpg", "img2":"http://i.ytimg.com/vi/F8pWG8DSeOY/2.jpg","img3":"http://i.ytimg.com/vi/F8pWG8DSeOY/3.jpg"},';

$sav .='"result":[';

    $plr .='{"name": "Srv 1","link": "'.$dapi.'"},';     $plr .='{"name": "Srv 2","link": "'.$dapi2.'"},';   $lastl=$dapi; 
    $sav .='{"link": "Download Video Srv1","name": "'.str_replace("https://","http://",$dapi).'"},';  
    $sav .='{"link": "Download Video Srv2","name": "'.str_replace("https://","http://",$dapi2).'"},'; 
    


    
    
    $sav .= '{"name":"3)Try Again","link":"Try Again."}'; 
    $player = base64_encode('{"result":[{"name": "Video1","player": ['.$plr.'{"name": "Null","link": "'.$lastl.'"}],"type": "video"}]}');
$sav .= '],';
$sav .=  '"player":"'.$player.'","screen":"p"';

$des =base64_encode("Source TTK");
$sav .=',"backcolor":"#1a1a1a","like":"154","dlike":"6","des":"'.$des.'","des2":"","user":{"username":"rahul kumar4577","link":"http://api.patilweb.com/avp/absc.php?id=UC1rKNZUN8zeEFd_u39WIHFA"},"subch":"cmFodWwga3VtYXI0NTc3I1VDMXJLTlpVTjh6ZUVGZF91MzlXSUhGQSNTdWJjcmliZSBDaGFubmVsI2h0dHA6Ly9hcGkucGF0aWx3ZWIuY29tL2F2cA=="}';
//echo base64_encode(gzcompress($sav));

echo $sav;