<?php
$vd = $_GET['vd'];$ld = $_GET['ld'];$ob = $_GET['ob'];$p = $_GET['p'];
//$qu = $_GET['q']; $qu=str_replace(" ","+", $qu);$qu=str_replace("-","+", $qu);$qu=str_replace("_","+", $qu); 
//$qu=str_replace("sdaljsdlkjsdlskdj","britney", $qu);
if ($ob == 1){$obj = '&created_after='.strtotime("-1 week +1 day");}
else if ($ob == 2){$obj = '&sort=visited-hour';}
if(empty($p)){$p =1;}
if(!empty($vd)){$nvd ='&shorter_than='.$vd;}
if(!empty($ld)){$nld ='&longer_than='.$ld;}
include 'inc/inc-daily.inc';

$Data = dailyurl("https://api.dailymotion.com/videos?fields=id,thumbnail_60_url,owner.screenname,title,country,duration,created_time,owner,tags,channel,comments_total,views_last_day,views_last_hour,views_last_month,views_last_week,views_total&search=$qu&page=$p&limit=50$nvd$nld$obj");
$decode= json_decode($Data,true);
$list = $decode["list"];
//var_dump($list);
//if(count($list) > 0){ $dailyser =true;}else{$dailyser =false;}
if(count($list) == 50){ $dailyser =true;}else{$dailyser =false;}    
    ?>