<?php
//Music Details id
include 'inc/conf.inc';
ini_set('display_errors', 0);
$sav .= '{"id":1,"pref":false,"rid":"","status":null,"banner":"false","native":"true"';
//ini_set('display_errors', 0);//header('Content-Type: text/html; charset=utf-8');
$id =$_GET['id'];



$data = ngegrab("http://api.soundcloud.com/tracks/$id.json?&client_id=".$client_id2);
$customer = json_decode($data, true);
 //var_dump($customer );
if(!empty($customer)){  
                $stlink = $customer['stream_url']."?client_id=".$client_id2;$dstat = $customer['downloadable'];
                         $playc = $customer['playback_count'];
    $arturl = $customer['artwork_url']; 
                               if(empty($arturl)) {$arturl = ''.$apiurl.'/img/pre.png';}

 $genre = $customer['genre'];$rnd = mt_rand(100000,999999); 
         $duration = $customer['duration']; //duration in milliseconds
        if($_GET['des'] == 'html'){
            $des = base64_encode('Genre:'.$genre.' Time: '.round($duration /60000,2).'Min');  //Html Format allowed
            }else{$des = 'Genre:'.$genre.' Time: '.round($duration /60000,2).'Min';}

$sav .= ',"backcolor":"#00e64d","like":"'.$playc.'","dlike":"'.$dstat.'","des":"'.$des.'","des2":"'.$des.'"';
$sav .= ',"url":"'.$stlink.'&nc=/AvpTube.Com-Music-Song-'.$rnd.'.mp3","play":"'.$stlink.'"';
$sav .= ',"user":{"username":"FICDD","link":"'.$apiurl.'/abs.php?q=djamol&type=1"}';
$sav .= ',"img":{"img1":"'.$arturl.'","img2":"'.$arturl.'",
"img3":"'.$arturl.'","img4":"'.$arturl.'"}';
}else{
$sav .= 'Not Found - Try Again';//http://mobile.com/mp4Video.mp4';
}
$sav .= '}';
echo  base64_encode(gzcompress($sav));
?>