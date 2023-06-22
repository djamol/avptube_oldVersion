<?php
//  Search Channels
//error_reporting(E_ALL);//include 'conf.php';//$qu = $_GET['q'];
if(!empty($_GET['page'])){$token = '&pageToken='.$_GET['page'];}else{$token = "";}
if ( $ob == "0" ) {$order = '&order=videoCount';}
elseif ( $ob == "1" ) {$order = '&order=viewCount';}
elseif ( $ob == "2" ) {$order = '&order=date';}
elseif ( $ob == "3" ) {$order = '&order=rating';}
elseif ( $ob == "4" ) {$order = '&order=title';}
elseif ( $ob == "5" ) {$order = '&order=relevance';}

$grab=ngegrab('https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults=45&q='.$qu.'&type=channel'.$order.'&key='.$devkey.''.$token.'');
$json = json_decode($grab);$responada = $json->items; 
if ((count($responada) > 0)){
    $sav .='{"id":1,"pref":false,"rid":"'.$rid.'","status":null,"header":false,"head":"","footer":false,"foot":"","df":false,"desingf":0,"backcolor":"no","toolcolor":"no","PER_ITEM_AD":6,"banner":false,"nativead":false,"history":"Channel Search- '.$qs.'","type":"youtube","uplink":"null","upurl":"null","webopenback":"","webads":false,"adset":{"show":9999,"close":210000},';
$sav .='"result":[';

        $nextpage = $json->nextPageToken;$prevpage = $json->prevPageToken;

    foreach($json->items as $hasil) {
    $name = $hasil->snippet->title;

    $id =  $hasil->id->channelId;   // $description = $hasil->snippet->description;
    $url = "$apiurl/absc.php?id=".$id;
    $chname = $hasil->snippet->channelTitle;
    $thumb = $hasil->snippet->thumbnails->default->url;$date =dateyt($hasil->snippet->publishedAt);
            $sav .='{"vid":"1","title":"'.$name.'","shr":"'.$chname.'","agent":"","FAll":"","PTR":"","UXL":"","poff":"true","act":"next","bm":"ns","open":"","dte":"'.$date.'","thumb":"'.$thumb.'","lnk":"'.$url.'"},';
        
                                    }
            if (!empty($nextpage)){  
    $urln = ''.$apiurl.'/s.php?q='.$qu.'&amp;radio=2&amp;type='.$ob.'&amp;page='.$nextpage;
$sav .='{"vid":"1","title":"More Video Result -----&gt;( NEXT )","agent":"","FAll":"","PTR":"","UXL":"","poff":"true","act":"next","bm":"true","open":"","shr":"next","dte":"More","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$urln.'"}';
}else{$sav .='{"vid":"1","title":"DjAmol- Hang On (Digital Club) English Track","shr":"DjAmolOfficial-","agent":"","FAll":"","PTR":"","UXL":"","poff":"true","act":"no","bm":"ns","open":"","dte":"30 October 2012","thumb":"http://img.youtube.com/vi/xRS9L_03Wuw/default.jpg","lnk":"xRS9L_03Wuw"}';} 

$sav .="]";


$sav .=',"user":"tested'; $sav .='"}';
echo base64_encode(gzcompress($sav));
}else{
 $error = 'channel'; __DIR__.'/inc/error.inc';    
}
?>