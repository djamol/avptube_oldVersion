<?php
//Video Top Lists
error_reporting(E_ALL); 
include '../inc/conf.inc';
$devkey = 'AIzaSyA5psGY2p6HHuZ1qxPl1cj6CYszyixzbus';
  $filter ='';
if(!empty($_GET['page'])){$filter = $filter.'&pageToken='.$_GET['page'];} 
if(!empty($_GET['c'])){$filter = $filter.'&regionCode='.$_GET['c'];}
    $grab = ngegrab('https://www.googleapis.com/youtube/v3/videos?part=snippet,statistics,contentDetails&chart=mostPopular&maxResults=45&key='.$devkey.''.$filter);
  $json = json_decode($grab);// echo $devkey;
    $responada = $json->items;  
// var_dump($json);
 $nextpage = $json->nextPageToken; //$prevpage = $json->prevPageToken;
if(!empty($responada))
{//
$goit = true;
//Title@description short@@image@videoid,
$header = '<?php header(\'Content-Type: text/html; charset=utf-8\');
header(\'xum: zipped\');
if($_GET[\'occ\'] == \'samsung\'){ exit();}
 ?>';
$sav .= '{"id":1,"status":null,"header":false,"head":"","footer":false,"foot":"","df":false,"desingf":0,"backcolor":"#fa8072","toolcolor":"#fa8072","PER_ITEM_AD":8,"banner":false,"nativead":true,"history":"Top Videos","type":"youtube","uplink":"null","upurl":"null","webopenback":"","webads":false,"adset":{"show":9999,"close":210000},';
$sav .= '"result":[';
        foreach($json->items as $hasil) {
        $name = $hasil->snippet->title;
        
        $link =  $hasil->id;
        //$thumb = $hasil->snippet->thumbnails->default->url;
        $date =dateyt($hasil->snippet->publishedAt);
        $des = $hasil->snippet->description;$description=substr($des,0,15);
        $chnn = $hasil->snippet->channelTitle;
        $shorted =  $chnn."-".$description;
        //  $name = htmlentities($name);        //  $shorted = htmlentities($shorted);
        $name = preg_replace("/[,:\[\]}{'\"]/", " ", $name);$shorted = preg_replace("/[,:\[\]}{'\"]/", " ", $shorted);
        $mthumb = "http://img.youtube.com/vi/".$link."/default.jpg";
        //act = actionview or next  
        $sav .= '{"vid":"1","title":"'.$name.'","shr":"'.$shorted.'","act":"no","bm":"ns","open":"","dte":"'.$date.'","thumb":"'.$mthumb.'","lnk":"'.$link.'"},';
        }
        
if (!empty($nextpage)){  
    $urln = ''.$apiurl.'/t.php?page='.$nextpage;
$sav .= '{"vid":"1","title":"More Video Result -----&gt;( NEXT )","act":"next","bm":"true","open":"","shr":"next","dte":"More","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$urln.'"}';
}else{$sav .= '{"vid":"1","title":"DjAmol- Hang On (Digital Club) English Track","shr":"DjAmolOfficial-","act":"no","bm":"ns","open":"","dte":"30 October 2012","thumb":"http://img.youtube.com/vi/xRS9L_03Wuw/default.jpg","lnk":"xRS9L_03Wuw"}';} 

$sav .= "]";

        }
        else
        {$sav .= '{"id":1,"status":null,"type":"error","result":[{"vid":"1","title":"Video Not Found","act":"no","bm":"z","open":"","shr":"Use Another Keyword","dte":"Failed","thumb":"'.$apiurl.'/img/error.png"
,"lnk":"vGSjIt0JrS0"},{"vid":"1","title":"Use Another Keyword","act":"no","bm":"z","open":"","shr":"Try Again","dte":"Result","thumb":"'.$apiurl.'/img/error.png"
,"lnk":"vGSjIt0JrS0"}]';
       
}
$sav .= ',"user":"tested'; $sav .= '"}';
$sav = str_replace(array("\r", "\n"), '', $sav);
//echo$sav;
$sav = base64_encode(gzcompress($sav));
//if ($goit){ 
    $fp = fopen('../t.php', 'w'); fwrite($fp, $header.$sav); fclose($fp); 
    //}
?>