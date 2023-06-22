<?php
$apiurl = 'http://mobile.djamol.com/data/avp';
$qs = $_GET['q'];$is = $_GET['is'];
$qu=str_replace(" ","+", $qs);$top = $_GET['top'];
$qu=str_replace("-","+", $qu);$qu=str_replace("_","+", $qu);
 //AIzaSyDQHU2Oc2KrARCeWdvY-47ONP0acGxUzWA	
//AIzaSyDZ6VGiI6hA1pmQDxED2jp12aUGR8ItVIg
//AIzaSyA5psGY2p6HHuZ1qxPl1cj6CYszyixzbus
//lareetomkumtaat@gmail.com tark@26xx2(pass)
$input = array('AIzaSyDQHU2Oc2KrARCeWdvY-47ONP0acGxUzWA', 'AIzaSyDZ6VGiI6hA1pmQDxED2jp12aUGR8ItVIg', 'AIzaSyA5psGY2p6HHuZ1qxPl1cj6CYszyixzbus');
$k = array_rand($input, 1);$devkey = $input[$k];
if(!empty($_GET['page'])){$filter = $filter.'&pageToken='.$_GET['page'];} 
if ($top == 'true'){$co = $_GET['co']; if(!empty($co)){$filter = $filter.'&regionCode='.$co;}
    $grab = ngegrab('https://www.googleapis.com/youtube/v3/videos?part=snippet,statistics,contentDetails&chart=mostPopular&maxResults=50&key='.$devkey.''.$filter);
}else{
    $grab=ngegrab('https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults=44&type=video&q='.$qu.'&key='.$devkey.''.$filter);
}
  $json = json_decode($grab);
    $responada = $json->items;  
// var_dump($responada);
 $nextpage = $json->nextPageToken; //$prevpage = $json->prevPageToken;
if(!empty($responada))
{//


echo'{"id":2,"status":null,"rid":"","header":false,"head":"","footer":false,"foot":"","df":false,"desingf":0,"backcolor":"no","banner":false,"nativead":true,"PER_ITEM_AD":6,"history":"Search- '.$qs.' ","type":"youtube","uplink":"null","upurl":"null","webopenback":"","webads":false,"adset":{"show":9999,"close":210000},';

echo'"result":[';
        foreach($json->items as $hasil) {
        $name = $hasil->snippet->title;
        if ($top == 'true'){$link =  $hasil->id;}else{
        $link =  $hasil->id->videoId;}
        //$thumb = $hasil->snippet->thumbnails->default->url;
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
        echo'{"vid":"1","title":"'.$name.'","shr":"'.$shorted.'","act":"no","bm":"ns","open":"","dte":"'.$date.'","thumb":"'.$mthumb.'","lnk":"'.$is.''.$link.'"},';
        }
        
if (!empty($nextpage)){  
    $urln = ''.$apiurl.'/search.php?q='.$qu.'&amp;cat='.$cat.'&amp;dur='.$vd.'&amp;type='.$ob.'&amp;page='.$nextpage;
echo'{"vid":"1","title":"More Video Result -----&gt;( NEXT )","act":"next","bm":"true","open":"","shr":"next","dte":"More","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$urln.'"}';
}else{echo'{"vid":"1","title":"DjAmol- Hang On (Digital Club) English Track","shr":"DjAmolOfficial-","act":"no","bm":"ns","open":"","dte":"30 October 2012","thumb":"http://img.youtube.com/vi/xRS9L_03Wuw/default.jpg","lnk":"xRS9L_03Wuw"}';} 

echo"]";



}
function ngegrab($url){$ch = curl_init(); curl_setopt($ch, CURLOPT_URL, $url); curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); curl_setopt($ch,CURLOPT_ENCODING,'gzip'); 


curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true); curl_setopt($ch, CURLOPT_TIMEOUT, 10);
//$input = array("104.152.187.19", "104.152.187.2");
//$ip = $input[array_rand($input)];curl_setopt( $ch, CURLOPT_INTERFACE, $ip );

$header[] = "Accept-Language: en"; 
$header[] = "Mozilla/5.0 (Linux; U; Android 4.1.2; en-gb; GT-S7582 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30"; 
$header[] = "Pragma: no-cache"; $header[] = "Cache-Control: no-cache"; $header[] = "Accept-Encoding: gzip,deflate"; $header[] = "Content-Encoding: gzip"; $header[] = "Content-Encoding: deflate"; curl_setopt($ch, CURLOPT_HTTPHEADER, $header); $load = curl_exec($ch); curl_close($ch); return $load;}
function dateyt($date){$date=substr($date,0,10); $date=explode('-',$date); $mn=date('F',mktime(0,0,0,$date[1])); $dates=''.$date[2].' '.$mn.' '.$date[0].''; return $dates;}

?>