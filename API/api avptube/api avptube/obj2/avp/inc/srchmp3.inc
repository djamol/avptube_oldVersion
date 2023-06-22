<?php
// Search Songs
//$client_id2 ="b2602e2704c247f311826b1542ac38cb"; //play page
if ( $ob == "5" ) { //playlist search
    
include __DIR__.'/mp3plsr.inc';
}else{


if ( $ob == "1" ) {$week = strtotime("-1 week");$start_week = date("Y-m-d",$week); // This Week
$filter='&created_at[from]='.$start_week.'%2000:00:00';}
elseif ( $ob == "2" ) {$week = strtotime("-1 month");$start_week = date("Y-m-d",$week);//This Month
$filter='&created_at[from]='.$start_week.'%2000:00:00';}
elseif ( $ob == "3" ) {$y = date("Y"); //This Year
$filter='&created_at[from]='.$y.'-01-01%2000:00:00';}
elseif ( $ob == "4" ) {$y = date("Y")-1; //Last Year
$filter='&created_at[from]='.$y.'-01-01%2000:00:00&created_at[to]='.$y.'-12-25%2000:00:00';}


$data = ngegrab("http://api.soundcloud.com/tracks.json?q=$qu&limit=25&offset=$o&client_id=$client_id2$filter");
$data = json_decode($data, true);
// var_dump($data);
$sav .= '{"id":1,"pref":false,"rid":"'.$rid.'","status":null,"header":false,"head":"","footer":false,"foot":"","df":false,"desingf":0,"backcolor":"no","toolcolor":"no","PER_ITEM_AD":6,"banner":true,"nativead":false,"history":"Music Search- '.$qs.'","type":"music","uplink":"null","upurl":"null","webopenback":"","webads":false,"adset":{"show":9999,"close":210000},';
$sav .= '"result":[';

if(!empty($data)){  
foreach ($data as $customer) {
 $link = $customer['permalink']; 
    $title = $customer['title'];
    $id = $customer['id'];
    $arturl = $customer['artwork_url']; 
      if(empty($arturl)) {$arturl = ''.$apiurl.'/img/pre.png';}
 //       $genre = $customer['genre'];
        $duration = $customer['duration']; //duration in milliseconds
        $minutes = $duration/60000;

//        $type = $customer['track_type'];  
//        $tag = $customer['tag_list'];
        $creat = $customer['created_at'];$date = date_parse($creat);
        $date = $date["day"].'/'.$date["month"].'/'.$date["year"];
       
                        //$userlink = $customer['user']['permalink']; 
                        //$userid = $customer['user']['id']; 
                        //$username = $customer['user']['username']; 
                        //$useravatar = $customer['user']['avatar_url'];
                        
                        //Track Details 
                         
                         //$playc = $customer['playback_count'];
                         //$dloadc = $customer['download_count'];
                         //$favc = $customer['favoritings_count'];
                         //$comc = $customer['comment_count'];
$name = str_replace(array(',', '<', '>', '*'), ' ', $title);
$name = preg_replace("/[,:\[\]}{'\"]/", " ", $name);
$sav .= '{"vid":"1","title":"'.$name.'","shr":"Duration '.$minutes.' Min","agent":"","FAll":"","PTR":"","UXL":"","poff":"true","act":"no","bm":"ns","open":"","dte":"'.$date.'","thumb":"'.$arturl.'","lnk":"'.$id.'"},';
}
$sav .= '{"vid":"1","title":"DjAmol- Hang on ( Digital Club)","shr":"Duration 3 Min","agent":"","FAll":"","PTR":"","UXL":"","poff":"true","act":"no","bm":"ns","open":"","dte":"08/05/2016","thumb":"https://i1.sndcdn.com/artworks-000108405450-cjnq5u-large.jpg","lnk":"62625018"}';        

$sav .= "]";

}else{
      $error = 'smp3'; __DIR__.'/inc/error.inc';    
}
$sav .= ',"user":"tested'; $sav .= '"}';
echo base64_encode(gzcompress($sav));

}
?>