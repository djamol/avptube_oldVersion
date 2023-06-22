<?php
// Video Details ID

include 'inc/conf.inc';
//error_reporting(E_ALL); ini_set('display_errors', '1');
$sav .= '{"id":1,"pref":false,"force":true,"rid":"","status":null,"widget":"true","banner":"false","native":"false","toolcolor":"#1a1a1a"';
$vid = $_GET['id'];
//ini_set('display_errors', 1);
                     $randm  = str_pad(dechex(mt_rand(0, 0xFFFFF)), 8, '0', STR_PAD_LEFT);

if (strpos($vid, "daily@") === 0){ 
    include 'video-daily.php';
}else if (strpos($vid, "ttk@") === 0){ 
    include 'video-ttk.php';
}else{

//$img1url = 'http://avptube.com/img.php?id='.$vid.''; 
$grab2=ngegrab('https://www.googleapis.com/youtube/v3/videos?part=snippet,statistics,contentDetails&id='.$vid.'&key='.$devkey.'');
$json2 = json_decode($grab2); //var_dump($json2);
$dagv3 = $json2->items[0];$name = $dagv3->snippet->title;
$count = $dagv3->statistics->viewCount;$like = $dagv3->statistics->likeCount;
$dislike = $dagv3->statistics->dislikeCount; //$thumb = $dagv3->snippet->thumbnails->medium->url;
$channelId =$dagv3->snippet->channelId; $live = $dagv3->snippet->liveBroadcastContent;
$chnn = $dagv3->snippet->channelTitle;
$chnn = str_ireplace('vevo','',$chnn);
$nflt = preg_replace('/[^a-zA-Z0-9_ ]/', '', $name);$aa = str_replace(' ','_',$nflt);

$sav .= ',"img":{"img":"http://i.ytimg.com/vi/'.$vid.'/0.jpg","img1":"http://i.ytimg.com/vi/'.$vid.'/1.jpg",
"img2":"http://i.ytimg.com/vi/'.$vid.'/2.jpg","img3":"http://i.ytimg.com/vi/'.$vid.'/3.jpg"}';

if ($live == 'live'){
$sav .= ',"result":[{"name":"This is Live Channel","link":"Sorry This is Live Channel"}]'; 
$sav .= ',"backcolor":"#FFB6C1","like":"'.$like.'","dlike":"'.$dislike.'","des":"VGhpcyBMaXZlIENoYW5uZWwgVmlkZW8=","des2":"'.$des2.'",';
$sav .=  '"player":null,';
$sav .= '"user":{"username":"'.$chnn.'","link":"'.$apiurl.'/absc.php?id='.$channelId.'"}';$sav .=  '}';exit();
}



if(empty($aa)){$aa = base64_encode($vid); }
$sav .= ',"result":[';


function urlip6($url){$ch = curl_init(); curl_setopt($ch, CURLOPT_URL, $url); curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); curl_setopt($ch,CURLOPT_ENCODING,'gzip'); 
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true); curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$arrX = array( "2607:5300:60:63b3::b4b:a352","2607:5300:60:63b3::4dc:1507","2607:5300:60:63b3::1179:31dd");
$randIndex = array_rand($arrX);
$ip = $arrX[$randIndex];
curl_setopt( $curl, CURLOPT_INTERFACE, $ip );
curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V6); //set ipv6 ip or hide main ip
//curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4); //set ip4
$header[] = "Accept-Language: en";$header[] = "User-Agent: Mozilla/5.0 (Linux; U; Android 4.1.2; en-gb; GT-S7582 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30"; 
$header[] = "Pragma: no-cache"; $header[] = "Cache-Control: no-cache"; $header[] = "Accept-Encoding: gzip,deflate"; $header[] = "Content-Encoding: gzip"; $header[] = "Content-Encoding: deflate"; curl_setopt($ch, CURLOPT_HTTPHEADER, $header); $load = curl_exec($ch); curl_close($ch); return $load;}

//$mob = file_get_contents("http://104.223.87.16/ytdl/ytdl.php?p=amolpatil&id=$vid");
//     $idcheck2=preg_match_all ('/#(.*)>(.*)</U', $mob, $matches2);
        //  var_dump($matches2);
          $idcheck2=0; 
        if(!empty($idcheck2) AND ($idcheck2 > 2)){
                foreach($matches2[1] as $index => $url) { 
              // foreach($matches2[1] as $val) { 
            $title =  $matches2[2][$index]; //second array extracto 
            //echo'<div class="menu2"><a rel="nofollow" href="'.$url.'">'.$title.'...</a></div>';
            $getit .='{"link": "'.$title.'","name": "'.$url.'.mp4"},'; 
            $whatIWant = substr($title, strpos($title, "(") + 1);
            $plr .='{"name": "'.$whatIWant.'","link": "'.$url.'.mp4"},'; 
                }
                $sav .=  $getit.'{"name":"Try Again","link":"1)Try Again."}'; 
                $player = base64_encode('{"result":[{"name": "Video1","player": ['.$plr.'{"name": "Null","link": "'.$lastl.'"}],"type": "video"}]}');
      
}else{

                    $idb = file_get_contents("http://104.223.87.163/ytdl/indirect-d.php?p=amolpatil&id=$vid");
                    $idcheck2=preg_match_all ('/#(.*)>(.*)</U', $idb, $matches2);
                    if(!empty($idcheck2) AND ($idcheck2 > 2)){   $randm  = str_pad(dechex(mt_rand(0, 0xFFFFF)), 8, '0', STR_PAD_LEFT);
                        foreach($matches2[1] as $index => $url) { 
                       //     $durl = 'http://144.172.83.135/css_images/store.py?name='.$randm.'&url='.base64_encode($url).'&nc=/AvpTube.Com_'.$randm.'.mp4';
                      $durl=$url;//.'&nc=/AvpTube.Com_'.$randm.'.mp4';
                      // foreach($matches2[1] as $val) { 
                        $title =  $matches2[2][$index]; //second array extracto
                              $getit .='{"link": "'.$title.'","name": "'.$durl.'.mp4"},'; 
                               $whatIWant = substr($title, strpos($title, "(") + 1);
                                $plr .='{"name": "'.$whatIWant.'","link": "'.$durl.'.mp4"},'; }
                                            $sav .=  $getit.'{"name":"Try Again","link":"2)Try Again."}'; 
                                            $player = base64_encode('{"result":[{"name": "Video1","player": ['.$plr.'{"name": "Null","link": "'.$lastl.'"}],"type": "video"}]}');
      
            }else{

     $idb = file_get_contents("http://mobile.djamol.com/data/obj2/avp/ytcdn/ytcdn-indirect.php?id=$vid&p=amolpatil");
//    $sav .=  $idb;
     $idcheck2=preg_match_all ('/#(.*)>(.*)</U', $idb, $matches2);
        //  var_dump($matches2);
          
                 if(!empty($idcheck2) AND ($idcheck2 >= 1)){
                //    include'thirdlink.php';
        foreach($matches2[1] as $index => $url) { 
          //  var_dump($val);
              // foreach($matches2[1] as $val) { 
         $title =  $matches2[2][$index]; //second array extractor
            $getit .='{"link": "'.$title.'","name": "'.$url.'"},'; 
            $whatIWant = substr($title, strpos($title, "(") + 1);
            $plr .='{"name": "'.$whatIWant.'","link": "'.$url.'"},'; 
        // $sav .=  '<div class="menu2"><a '.$matches1[0][3].$val.'  </div>';
        
        }
        if (!empty($getit)){$sav .=  $getit; }   
        //$sav .=  $plr;
$sav .= '{"name":"Try Again","link":"3)Try Again."}'; 

$player = base64_encode('{"result":[{"name": "Video1","player": ['.$plr.'{"name": "Null","link": "'.$lastl.'"}],"type": "video"}]}');

        }else{
                                           include'direct.php';                                            
                                            }
                                            }
                                            
}
$sav .= ']';
//base64_encode('Source DailyM<a href="gogov://'.base64_encode('{"title":"Britney Spears - Make Me... (Audio) ft. G-Eazy","shr":"BritneySpears- Glory the ni","date":"15 July 2016","url":"http://img.youtube.com/vi/oydff0QlXSM/default.jpg","vid":"oydff0QlXSM"}').'">HELLO</a>');
if($_GET['des'] == 'html'){
    
$des = base64_encode('<a href="vidos://'.$appurl.'/absc.php?id='.$channelId.'">More Video By '.$chnn.'</a>'); 
$des2 = base64_encode('.'); 
}else{$des = 'Source DM';}// //Html Format allowed

$sav .= ',"backcolor":"#1a1a1a","like":"'.$like.'","dlike":"'.$dislike.'","des":"'.$des.'","des2":"'.$des2.'",';
$sav .=  '"player":"'.$player.'",';
$sav .= '"user":{"username":"'.$chnn.'","link":"'.$apiurl.'/absc.php?id='.$channelId.'"}';


$subcribe = base64_encode($chnn."#".$channelId."#Subcribe Channel#$apiurl");
$sav .=  ',"subch":"'.$subcribe.'"}';

echo base64_encode(gzcompress($sav));
//if($_GET['va'] == 'amolpatil'){echo$sav;}
}

?>