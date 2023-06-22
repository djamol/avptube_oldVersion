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

$Data = dailyurl("https://api.dailymotion.com/videos?fields=id,thumbnail_60_url,owner.screenname,title,country,duration,created_time,owner,tags,channel,comments_total,views_last_day,views_last_hour,views_last_month,views_last_week,views_total&search=$qu&page=$p&limit=20$nvd$nld$obj");
$decode= json_decode($Data,true);
$list = $decode["list"];
if(count($list) > 0)
{
        $total=  $decode["total"]; $more = $decode["has_more"];
    

$sav .= '{"id":1,"pref":false,"rid":"","status":null,"header":false,"head":"","footer":false,"foot":"","df":false,"desingf":0,"backcolor":"no","toolcolor":"no","banner":false,"nativead":true,"PER_ITEM_AD":6,"history":"Search*- '.$qs.' ","type":"dailymotion","uplink":"null","upurl":"null","webopenback":"","webads":false,"adset":{"show":9999,"close":210000},';
    $sav .='"result":[';
    
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

        $sav .='{"vid":"1","title":"'.$name.'","shr":"'.$shorted.'('.$dur.')","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"no","bm":"ns","open":"http://www.dailymotion.com/json/video/'.$fetch["id"].'?fields=title,stream_h264_url,stream_h264_ld_url,stream_h264_hq_url,stream_h264_hd_url,stream_h264_hd1080_url","dte":"'.$date.'","thumb":"'.$mthumb.'","lnk":"'.$link.'"},';
        }
        $prevpage =$p-1;$nextpage =$p+1;$flt = '&vd='.$vd.'&ld='.$ld.'';$ob1 = '&ob='.$ob;
            if (!empty($nextpage)){  
            $urln = ''.$apiurl.'/abs.php?q='.$qu.'&amp;cat='.$cat.'&amp;dur='.$vd.''.$ob1.''.$flt.'&amp;type='.$ob.'&amp;page='.$nextpage;
            $sav .='{"vid":"1","title":"More Video Result -----&gt;( NEXT )","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","shr":"next","dte":"More","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$urln.'"}';
            }else{$sav .='{"vid":"1","title":"DjAmol- Hang On (Digital Club) English Track","shr":"DjAmolOfficial-","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"no","bm":"ns","dte":"30 October 2012","thumb":"http://img.youtube.com/vi/xRS9L_03Wuw/default.jpg","lnk":"xRS9L_03Wuw"}';} 

$sav .="]";


    
    
    
}else{
    $sav  .='{"id":1,"pref":false,"rid":"","status":null,"header":false,"head":"","footer":false,"foot":"","df":false,"desingf":0,"backcolor":"no","toolcolor":"no","PER_ITEM_AD":6,"banner":false,"nativead":false,"history":"@ Error Search","uplink":"null","upurl":"null"
    ,"type":"error","result":[{"vid":"1","title":"Video Not Found","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"no","bm":"z","open":"","shr":"Use Another Keyword","dte":"Failed","thumb":"'.$apiurl.'/img/error.png","lnk":"vGSjIt0JrS0"},{"vid":"1","title":"Use Another Keyword","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"no","bm":"z","open":"","shr":"Try Again","dte":"Result","thumb":"'.$apiurl.'/img/error.png","lnk":"vGSjIt0JrS0"}]';
}    



?>