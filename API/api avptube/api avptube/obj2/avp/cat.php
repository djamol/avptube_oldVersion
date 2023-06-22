<?php
// Categories
$locc = $_GET['country'];//country
$cat = $_GET['cat'];//category id
$t = $_GET['type'];// top video or top users

include 'inc/conf.inc';
if(!empty($cat)){$cats = "&categoryId=".$cat;}

if(!empty($_GET['page'])){$token = '&pageToken='.$_GET['page'];}else{$token = "";}

$grab=ngegrab('https://www.googleapis.com/youtube/v3/channels?part=snippet,statistics'.$cats.'&regionCode='.$locc.'&maxResults=50&key='.$devkey.''.$token.'');
//echo 'https://www.googleapis.com/youtube/v3/channels?part=snippet,statistics'.$cats.'&regionCode='.$locc.'&maxResults=50&key='.$devkey.''.$token.' @@';
$json = json_decode($grab);$responada = $json->items; //if ($json->error) {errorapi($json->error,$devkey);}  //var_dump($responada);
// var_dump($json);
 $nextpage = $json->nextPageToken; //$prevpage = $json->prevPageToken;
if(count($responada) > 0)
    {     
          $sav .='{"id":1,"pref":false,"status":null,"rid":"","header":false,"head":"","footer":false,"foot":"","df":false,"desingf":0,"backcolor":"no","toolcolor":"no","banner":false,"nativead":true,"PER_ITEM_AD":6,"history":"Category Channel-'.$locc.'","type":"youtube","uplink":"null","upurl":"null","webopenback":"","webads":false,"adset":{"show":9999,"close":210000},';

            $sav .= '"result":[';

        //$nextpage = $json->nextPageToken;$prevpage = $json->prevPageToken;
        foreach($json->items as $hasil) {
            $chnn = $hasil->snippet->channelTitle;
        $des = $hasil->snippet->description;  $description=substr($des,0,15);
        $name = $hasil->snippet->title; $shorted =  $chnn."-".$description;
        $link =  $hasil->id;$thumb = $hasil->snippet->thumbnails->default->url;
        $date =dateyt($hasil->snippet->publishedAt);        

    $link   =$apiurl.'/absc.php?id='.$link;        
        /*
        $dur = $hasil->contentDetails->duration;//Duration  Converter
        $start = new DateTime('@0'); $start->add(new DateInterval($dur));$myids[] = $link;
        if($start->format('g') != 12)
        {$duration= $start->format('g:i:s');}else{$duration= $start->format('i:s');}  
        //Statistics of Video
        $count = $hasil->statistics->viewCount;$like = $hasil->statistics->likeCount;$dislike = $hasil->statistics->dislikeCount;
        $fav = $hasil->statistics->favoriteCount; $comm = $hasil->statistics->commentCount; 
        $rating=($like+$dislike)/$like*5;$rate=substr($rating,0,1);//Rating Fun
        */
        $shorted = preg_replace("/[,:\[\]}{'\"]/", " ", $shorted);
    $sav .= '{"vid":"1","title":"'.$name.'","shr":"'.$shorted.'","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"ns","open":"","dte":"'.$date.'","thumb":"'.$thumb.'","lnk":"'.$link.'"},';
        
        }
        
if (!empty($nextpage)){  
    $urln = ''.$apiurl.'/absscat.php?co='.$loc.'&amp;c='.$cat.'&amp;page='.$nextpage;
$sav .= '{"vid":"1","title":"More Video Result -----&gt;( NEXT )","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"next","dte":"More","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$urln.'"}';
}else{$sav .= '{"vid":"1","title":"DjAmol- Hang On (Digital Club) English Track","shr":"DjAmolOfficial-","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"no","bm":"ns","open":"","dte":"30 October 2012","thumb":"http://img.youtube.com/vi/xRS9L_03Wuw/default.jpg","lnk":"xRS9L_03Wuw"}';} 

$sav .= "]";

        }
        else
        {$error = 'c'; include 'inc/error.inc';

}
$sav .= ',"user":"tested'; $sav .= '"}';


echo base64_encode(gzcompress($sav));
//echo $sav;

?>