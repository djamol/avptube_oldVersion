<?php
// Channels Videos

include 'inc/conf.inc';

$id = $_GET['id'];$pl = $_GET['playlist'];
/*
if(!empty($_GET['uid'])){
        $iobj='&forUsername='.$_GET['uid'];
}else{
    $iobj='&id='.$id;
}
*/
if (empty($pl)){
//Get video uploaded playlist by channel id
$grab=ngegrab('https://www.googleapis.com/youtube/v3/channels?part=contentDetails,statistics,brandingSettings&id='.$id.'&key='.$devkey.'');
$json = json_decode($grab);$noc = $json->items; 
$uploads = $noc[0]->contentDetails->relatedPlaylists->uploads;
}else{$uploads =$pl;}
  $filter ='';if(!empty($_GET['page'])){$token = '&pageToken='.$_GET['page'];}else{$token = "";}
$grab=ngegrab('https://www.googleapis.com/youtube/v3/playlistItems?part=snippet%2CcontentDetails&playlistId='.$uploads.'&maxResults=50&key='.$devkey.''.$token.'');
  $json = json_decode($grab);
    $responada = $json->items;  
    $name =$responada[0]->snippet->channelTitle;
// var_dump($responada);
 $nextpage = $json->nextPageToken; //$prevpage = $json->prevPageToken;
// $hbg = base64_encode("Header");
if(!empty($responada))
{
$sav .='{"id":1,"pref":false,"rid":"","status":null,"header":false,"head":"","footer":false,"foot":"","df":false,"desingf":0,"backcolor":"no","toolcolor":"no","PER_ITEM_AD":6,"banner":false,"nativead":false,"history":"Channel-'.$name.'","type":"youtube","uplink":"null","upurl":"null","webopenback":"","webads":false,"adset":{"show":9999,"close":210000},';
$sav .='"result":[';
        foreach($json->items as $hasil) {
        $name = $hasil->snippet->title;
        
        //$note =  $hasil->contentDetails->note;
        $link =  $hasil->contentDetails->videoId;
        //$thumb = $hasil->snippet->thumbnails->default->url;
        $date =dateyt($hasil->snippet->publishedAt);
        $des = $hasil->snippet->description;$description=substr($des,0,15);
        $chnn = $hasil->snippet->channelTitle;
        $shorted =  $chnn."-".$description;
        //  $name = htmlentities($name);        //  $shorted = htmlentities($shorted);
        $name = preg_replace("/[,:\[\]}{'\"]/", " ", $name);$shorted = preg_replace("/[,:\[\]}{'\"]/", " ", $shorted);
        $mthumb = "http://img.youtube.com/vi/".$link."/default.jpg";
        //act = actionview or next  
        $sav .='{"vid":"1","title":"'.$name.'","shr":"'.$shorted.'","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"no","bm":"ns","open":"","dte":"'.$date.'","thumb":"'.$mthumb.'","lnk":"'.$link.'"},';
        }
        
if (!empty($nextpage)){  
    $urln = ''.$apiurl.'/absc.php?playlist='.$uploads.'&amp;page='.$nextpage;
$sav .='{"vid":"1","title":"More Video Result -----&gt;( NEXT )","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"next","dte":"More","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$urln.'"}';
}else{$sav .='{"vid":"1","title":"DjAmol- Hang On (Digital Club) English Track","shr":"DjAmolOfficial-","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"no","bm":"ns","open":"","dte":"30 October 2012","thumb":"http://img.youtube.com/vi/xRS9L_03Wuw/default.jpg","lnk":"xRS9L_03Wuw"}';} 

$sav .="]";

        }
        else
        {$error = 'absc'; include'inc/error.inc';
        }
        
$sav .=',"user":"tested'; $sav .='"}';
echo base64_encode(gzcompress($sav));


?>