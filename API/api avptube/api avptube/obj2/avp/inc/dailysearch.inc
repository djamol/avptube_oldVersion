<?php
ini_set('display_errors', 0);
include __DIR__.'/inc-daily.inc';//$qu = 'marathi';
$Data = dailyurl("https://api.dailymotion.com/videos?fields=id,thumbnail_60_url,owner.screenname,title,country,duration,created_time,owner,tags,channel,comments_total,views_last_day,views_last_hour,views_last_month,views_last_week,views_total&search=$qu&page=1&limit=5$nvd$nld$obj");
$decode= json_decode($Data,true); $list = $decode["list"];
//var_dump($Data);
if(count($list) > 0)
{
//        $total=  $decode["total"]; $more = $decode["has_more"];
                foreach($list as $fetch) {
               $link =  'daily@'.$fetch["id"];  $name =  $fetch["title"];  $dur =  $fetch["duration"];
               $mthumb =  $fetch["thumbnail_60_url"];  //$owner =  $fetch["owner"];  $channel =  $fetch["channel"];
               //$lm =  $fetch["views_last_month"];  $lw =  $fetch["views_last_week"]; // $lh =  $fetch["views_last_hour"];  $ld =  $fetch["views_last_day"];
               $vt =  $fetch["views_total"];  $date =  $fetch["created_time"];  
               //$CC =  $fetch["country"]; // $tags =  $fetch["tags"];  
               $sn =  $fetch["owner.screenname"];
 if ($dur > 3600){$dur = gmdate("H:i:s", $dur).' Hour';}else{$dur = gmdate("i:s", $dur).' Min';};
 $date =  gmdate("d-M-Y", $date); //$tags = implode (", ", $tags);
 
        $shorted =  $sn."";
        //  $name = htmlentities($name);        //  $shorted = htmlentities($shorted);
        $name = preg_replace("/[,:\[\]}{'\"]/", " ", $name);$shorted = preg_replace("/[,:\[\]}{'\"]/", " ", $shorted);

        $sav .='{"vid":"1","title":"#'.$name.'","shr":"'.$shorted.'('.$dur.')","agent":"","FAll":"","PTR":"","UXL":"","poff":"true","act":"no","bm":"ns","open":"http://www.dailymotion.com/json/video/'.$fetch["id"].'?fields=title,stream_h264_url,stream_h264_ld_url,stream_h264_hq_url,stream_h264_hd_url,stream_h264_hd1080_url","dte":"'.$date.'","thumb":"'.$mthumb.'","lnk":"'.$link.'"},';
        }
}else{
     $error = 'dailysrch'; __DIR__.'/inc/error.inc'; 
}
//echo $sav;

?>