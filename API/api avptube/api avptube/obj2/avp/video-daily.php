<?php
include 'inc/inc-daily.inc';
$vid = $_GET['id'];$open = urldecode($_GET['open']);
$vid = str_replace('daily@','',$vid);
$DATA =dailyurl("https://api.dailymotion.com/video/$vid?fields=id,title,owner.screenname,description,created_time,comments_total,channel,duration,owner,tags,thumbnail_120_url,thumbnail_180_url,views_last_day,views_last_month");
$fetch = json_decode($DATA,true);
 if(!empty($fetch["id"]) AND !empty($vid)){
    
    $id =  $fetch["id"];  $name =  $fetch["title"];  $dur =  $fetch["duration"];
               $thumb =  $fetch["thumbnail_120_url"];  $owner =  $fetch["owner"];  $channel =  $fetch["channel"];
               $lm =  $fetch["views_last_month"];  $lw =  $fetch["views_last_week"]; // $lh =  $fetch["views_last_hour"];  
               $lds =  $fetch["views_last_day"];$vt =  $fetch["views_total"];  $date =  $fetch["created_time"];  
               $CC =  $fetch["country"];  $tags =  $fetch["tags"];  
               $chnn =  $fetch["owner.screenname"];$desn =  $fetch["description"];  
 if ($dur > 3600){$duration = gmdate("H:i:s", $dur).' Hour';}else{$duration = gmdate("i:s", $dur).' Min';};
 $date =  gmdate("d-M-Y", $date); $tags = implode (", ", $tags);
 
 

$sav .= ',"img":{"img":"'.$thumb.'","img1":"'.$thumb.'",
"img2":"'.$thumb.'","img3":"'.$thumb.'"}';


$nflt = preg_replace('/[^a-zA-Z0-9_ ]/', '', $name);$aa = str_replace(' ','_',$nflt);

$sav .= ',"result":[';
if($open == null || $open =="error"){
$dlink = dailyurl("http://www.dailymotion.com/json/video/$vid?fields=title,stream_h264_url,stream_h264_ld_url,stream_h264_hq_url,stream_h264_hd_url,stream_h264_hd1080_url");
$rd = 'http://mobile.djamol.com/data/api/start-daily.php?url=';$nnc = '*';
}else{
$dlink = $open;    
}
$dlink = json_decode($dlink);$lo = $dlink->stream_h264_url;//480 low
$ld = $dlink->stream_h264_ld_url;//360
$hd = $dlink->stream_h264_hd_url;//480 high
$hq = $dlink->stream_h264_hq_url;//720

            $sav .=  '{"link": "'.$nnc.'Download 480p(Low) Video","name": "'.$rd.$lo.'&&nc=/AvpTube.Com_'.$aa.'.mp4"},';
            $plr .='{"name": "480pL","link": "'.$rd.$lo.'"},';
            $sav .=  '{"link": "'.$nnc.'Download 360p Video","name": "'.$rd.$ld.'&&nc=/AvpTube.Com_'.$aa.'.mp4"},';
            $plr .='{"name": "360p","link": "'.$rd.$ld.'"},';
            $sav .=  '{"link": "'.$nnc.'Download 480p(High) Video","name": "'.$rd.$hd.'&&nc=/AvpTube.Com_'.$aa.'.mp4"},';
            $plr .='{"name": "480pH","link": "'.$rd.$hd.'"},';
            $sav .=  '{"link": "'.$nnc.'Download 720p Video","name": "'.$rd.$hq.'&&nc=/AvpTube.Com_'.$aa.'.mp4"},';
            $plr .='{"name": "720p","link": "'.$rd.$hq.'"},';

$player = base64_encode('{"result":[{"name": "Video1","player": ['.$plr.'{"name": "Null","link": "'.$ld.'"}],"type": "video"}]}');
        
$sav .= '{"name":"Try Again","link":"Try Again"}'; 

$sav .= ']';


if($_GET['des'] == 'html'){
$des = base64_encode('<a href="gogos://'.$appurl.'/absc.php?id='.$channelId.'">More Video By '.$chnn.'</a>'); 
$des2 = base64_encode('.'); 
}else{$des = 'Source DM';}// //Html Format allowed


$sav .= ',"backcolor":"#FFB6C1","like":"'.$vt.'","dlike":"'.$lds.'","des":"'.$des.'","des2":"'.$des2.'",';
$sav .=  '"player":"'.$player.'",';
$sav .= '"user":{"username":"'.$chnn.'","link":"'.$apiurl.'/absc.php?id='.$channelId.'"}';


$sav .=  '}';//echo$sav;
echo base64_encode(gzcompress($sav));


}
?>