<?php
//Video Top Lists Also With Country Code optional
if(empty($dat)){
include 'inc/conf.inc';}
  $filter ='';
if(!empty($_GET['page'])){$filter = $filter.'&pageToken='.$_GET['page'];} 
//if(!empty($_GET['c'])){
         if (!empty($_SERVER['HTTP_CLIENT_IP'])) {$ips = $_SERVER['HTTP_CLIENT_IP'];}         elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {$ips = $_SERVER['HTTP_X_FORWARDED_FOR'];} else {$ips = $_SERVER['REMOTE_ADDR'];}     
           include("ip2c/geoip.inc");
        $gi = geoip_open("ip2c/GeoIP.dat", GEOIP_STANDARD);        //$sav .=  geoip_country_code_by_addr($gi, "103.47.153.229") . "\t" .geoip_country_name_by_addr($gi, "103.47.153.229") . "\n";
        $co = geoip_country_code_by_addr($gi, $ips);geoip_close($gi); 
        if(!empty($co)){$filter = $filter.'&regionCode='.$co; $rid="$ips-$co";}

//    }
    $grab = ngegrab('https://www.googleapis.com/youtube/v3/videos?part=snippet,statistics,contentDetails&chart=mostPopular&maxResults=50&key='.$devkey.''.$filter);
  $json = json_decode($grab); //$sav .=  $devkey;
    $responada = $json->items;  
// var_dump($responada);
 $nextpage = $json->nextPageToken; //$prevpage = $json->prevPageToken;
if(!empty($responada))
{//
$goit = true;
//Title@description short@@image@videoid,
$sav .= '{"id":1,"pref":false,"rid":"'.$rid.'","status":null,"header":false,"head":"","footer":false,"foot":"","df":false,"desingf":0,"backcolor":"no","toolcolor":"no","PER_ITEM_AD":6,"banner":false,"nativead":false,"history":"Top Videos '.$co.'","type":"youtube","uplink":"null","upurl":"null","webopenback":"","webads":false,"adset":{"show":9999,"close":210000},';
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
        $sav .= '{"vid":"1","title":"'.$name.'","shr":"'.$shorted.'","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"no","bm":"ns","open":"","dte":"'.$date.'","thumb":"'.$mthumb.'","lnk":"'.$link.'"},';
        }
        
if (!empty($nextpage)){  
    $urln = ''.$apiurl.'/top-country.php?page='.$nextpage;
$sav .= '{"vid":"1","title":"More Video Result -----&gt;( NEXT )","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"next","dte":"More","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$urln.'"}';
}else{$sav .= '{"vid":"1","title":"DjAmol- Hang On (Digital Club) English Track","shr":"DjAmolOfficial-","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"no","bm":"ns","open":"","dte":"30 October 2012","thumb":"http://img.youtube.com/vi/xRS9L_03Wuw/default.jpg","lnk":"xRS9L_03Wuw"}';} 

$sav .= "]";

        }else{          
                $grab = file_get_contents("$apisecond&top=true&co=".$co);
                if (0 === strpos($grab, '{"id":2,"status"')) {
                $sav .=  $grab;
                }        else
        {
                  
                $grab = file_get_contents("$apithird&top=true&co=".$co);
                if (0 === strpos($grab, '{"id":3,"status"')) {
                $sav .=  $grab;
                }else{
                    $error = 'topc'; include'inc/error.inc';
                }}}



$sav .= ',"user":"tested'; $sav .= '"}';
echo base64_encode(gzcompress($sav));
/*
$sav = str_replace(array("\r", "\n"), '', $sav);
//if ($goit){ 
    $fp = fopen('../abstop.php', 'w'); fwrite($fp, $sav); fclose($fp); 
    //}
*/

?>