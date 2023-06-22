<?php
// Search Details           //header('AppFORM: JSON');
include 'inc/conf.inc';// echo'webapp://google.com';exit();
ini_set('display_errors', 0);
$qs = $_GET['q'];$radio =$_GET['radio'];    $cc = $_GET['count'];$dc = $_GET['dc'];
$qu=str_replace(" ","+", $qs);$qu=str_replace("-","+", $qu);
$qu=str_replace("_","+", $qu); $ob =$_GET['type'];
include '../sql_sitemap.php';
///$radio =1 channel , $radio =2 playlist
if ($radio == "1"){//channel (search)
include 'inc/channel.inc'; 

}elseif ($radio == "2"){//playlist (search)
include 'inc/playlist.inc'; 

}elseif ($radio == "3"){ //music (search)
 if (!isset($_GET['p']) || $_GET['p'] <= 0) { $o = 1; $pgn = 1;} else {        
        $p = htmlentities($_GET['p']);$o = (($p - 1) * 25)+1;$pgn = $p;}
include 'inc/srchmp3.inc'; 
        }else{   // video (search)
  $filter ='';
 $cat = $_GET['cat'];$vd = $_GET['dur'];$co = $_GET['co'];
 if ( $ob == "2" ) {$filter = $filter."&order=rating";}elseif ( $ob == "3" ) {$filter = $filter."&order=viewCount";}elseif ( $ob == "4" ) {$filter = $filter."&order=title";}    
  if(!empty($vd)){$filter = $filter.'&videoDuration='.$vd; }   if(!empty($cat)){$filter=$filter.'&videoCategoryId='.$cat;}
  if(!empty($co)){$filter=$filter.'&regionCode='.$co;}
  if(!empty($_GET['page'])){$filter = $filter.'&pageToken='.$_GET['page'];} 
    $grab=ngegrab('https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults=46&type=video&q='.$qu.'&key='.$devkey.''.$filter);
  $json = json_decode($grab);
    $responada = $json->items;  
// var_dump($responada);
 $nextpage = $json->nextPageToken; //$prevpage = $json->prevPageToken;
if(!empty($responada))
{//
include 'inc/s/dailyinclude.inc';
$sav .= '{"id":"Testing","rid":"","status":null,"header":false,"head":"","footer":false,"foot":"","backcolor":"no","df":false,"desingf":0,"banner":false,"nativead":true,"PER_ITEM_AD":6,"history":"Search- '.$qs.' ","type":"youtube","uplink":"null","upurl":"null","webopenback":"http://apvideo.info/pg/set.html?id='.$randm.'","webads":false,"adset":{"show":9999,"close":210000},';
$sav .= '"result":[';
//echo'{"vid":"1","title":"Boss File Manager (FREE APP) Install Now","shr":"Boss File Manager","act":"actionview","bm":"ns","dte":"Ads","thumb":"http://mobile.djamol.com/fm.png","lnk":"market://details?id=com.file.manager.boss&rdid=com.file.manager.boss&referrer=utm_source%3Dadcolony%26utm_medium%3Dbanner%26utm_term%3Dfile%26utm_campaign%3DBossFM%26anid%3Dadcolony"},';
        foreach($json->items as $key => $hasil) {
        $name = $hasil->snippet->title;
        
        $link =  $hasil->id->videoId;
        $thumb = $hasil->snippet->thumbnails->default->url;
        $date =dateyt($hasil->snippet->publishedAt);
        $des = $hasil->snippet->description;$description=substr($des,0,15);
        $chnn = $hasil->snippet->channelTitle;
        $chnn = str_ireplace('vevo','',$chnn);
        $shorted =  $chnn."-".$description;
        //  $name = htmlentities($name);        //  $shorted = htmlentities($shorted);
        $name = preg_replace("/[,:\[\]}{'\"]/", " ", $name);$shorted = preg_replace("/[,:\[\]}{'\"]/", " ", $shorted);
        //$mthumb = 'http://ytimg.googleusercontent.com/vi/'.$link.'/mqdefault.jpg';
        //or
        $mthumb = "http://img.youtube.com/vi/".$link."/default.jpg";
        
        //act = actionview or next  
        $sav .= '{"vid":"1","title":"'.$name.'","shr":"'.$shorted.'","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"no","bm":"ns","open":"","dte":"'.$date.'","thumb":"'.$mthumb.'","lnk":"'.$link.'"},';
       // include'inc/dailysearch.inc';
       include 'inc/s/adddailyparse.inc';
        }
        
if (!empty($nextpage)){  
    $urln = ''.$apiurl.'/s.php?q='.$qu.'&amp;cat='.$cat.'&amp;dur='.$vd.'&amp;type='.$ob.'&amp;page='.$nextpage;
$sav .= '{"vid":"1","title":"More Video Result -----&gt;( NEXT )","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"next","dte":"More","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$urln.'"}';
}else{$sav .= '{"vid":"1","title":"DjAmol- Hang On (Digital Club) English Track","shr":"DjAmolOfficial-","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"no","bm":"ns","open":"","dte":"30 October 2012","thumb":"http://img.youtube.com/vi/xRS9L_03Wuw/default.jpg","lnk":"xRS9L_03Wuw"}';} 

$sav .= "]";

        }
        else
        {
            $grab = file_get_contents("$apisecond&q=$qu&page=".$_GET['page']);
            if (0 === strpos($grab, '{"id":2,"status"')) {
                $sav .=  $grab;
                }else {
                                $grab = file_get_contents("$apithird&q=$qu&page=".$_GET['page']);
                    if (0 === strpos($grab, '{"id":3,"status"')) {
                            $sav .=  $grab;
                                    }else {include 'abs-daily.php';}
                    }
//echo'{"id":1,"status":null,"type":"error","result":[{"vid":"1","title":"Video Not Found","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"no","bm":"z","shr":"Use Another Keyword","dte":"Failed","thumb":"'.$apiurl.'/img/error.png","lnk":"vGSjIt0JrS0"},{"vid":"1","title":"Use Another Keyword","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"no","bm":"z","shr":"Try Again","dte":"Result","thumb":"'.$apiurl.'/img/error.png","lnk":"vGSjIt0JrS0"}]';
       
}
$sav .= ',"user":"tested'; $sav .= '"}'; 
echo (($sav));//echo ''.(gzuncompress(base64_decode($datas)));//decompressed
}
  //     }
  
  ?>