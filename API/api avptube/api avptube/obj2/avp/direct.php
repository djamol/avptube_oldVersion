<?php
//@set_time_limit(0); 
ini_set('display_errors', 0);
     //$vid = $_GET['id'];
//http://tube.wapsend.com/01_download.php?v=JLf9q36UsBk
$idb = file_get_contents("http://downloadnee.com/api?format=mp4&id=".$vid."");
function FormatZ($idc){switch($idc){case 43: $idc="Download Video 360p WEBM"; break;case 18: $idc="Download Video 360p MP4"; break;case 36: $idc="Download Video 240p 3gp"; break;case 17: $idc="Download Video 144p 3GP"; break;default:$idc="Download Video ----Unknown";}return $idc;}
 
    $idcheck2=preg_match_all ('/href="download(.*)"></U', $idb, $matches2);
         //var_dump($matches2);
          
                 if(!empty($idcheck2) AND ($idcheck2 > 2)){
        foreach($matches2[1] as $index => $url) { 
                $idc = substr($url,1,2);
                $title = FormatZ($idc);
            $url = 'http://downloadnee.com/download'.$url;
            $getit .='{"link": "'.$title.'","name": "'.$url.'"},'; 
            $whatIWant = substr($title, strpos($title, "(") + 1);
            $plr .='{"name": "'.$whatIWant.'","link": "'.$url.'"},'; 
        // $sav .=  '<div class="menu2"><a '.$matches1[0][3].$val.'  </div>';
        
        }
        if (!empty($getit)){$sav .=  $getit;  }   
        //$sav .=  $plr;
$sav .= '{"name":"Try Again","link":"Try Again.."}'; 


/*

$idb = file_get_contents("http://198.23.241.207/ytdl/01_download.php?id=".$vid."");

     $idcheck2=preg_match_all ('/#(.*)>(.*)</U', $idb, $matches2);
          //var_dump($matches2);
          
                 if(!empty($idcheck2) AND ($idcheck2 > 2)){
        foreach($matches2[1] as $index => $url) { 
          //  var_dump($val);
              // foreach($matches2[1] as $val) { 
         $title =  $matches2[2][$index]; //second array extractor
            $getit .='{"link": "'.$title.'","name": "'.$url.'"},'; 
            $whatIWant = substr($title, strpos($title, "(") + 1);
            $plr .='{"name": "'.$whatIWant.'","link": "'.$url.'"},'; 
        // $sav .=  '<div class="menu2"><a '.$matches1[0][3].$val.'  </div>';
        
        }
        if (!empty($getit)){$sav .=  $getit;  }   
        //$sav .=  $plr;
$sav .= '{"name":"Try Again","link":"Try Again.."}'; 

*/
}else{

$idb = file_get_contents($apiurl."/ytdl/custom.php?id=".$vid."");

     $idcheck2=preg_match_all ('/#(.*)>(.*)</U', $idb, $matches2);
          //var_dump($matches2);
          
                 if(!empty($idcheck2) AND ($idcheck2 > 2)){
        foreach($matches2[1] as $index => $url) { 
          //  var_dump($val);
              // foreach($matches2[1] as $val) { 
         $title =  $matches2[2][$index]; //second array extractor
            $getit .='{"link": "'.$title.'","name": "'.$url.'"},'; 
            $whatIWant = substr($title, strpos($title, "(") + 1);
            $plr .='{"name": "'.$whatIWant.'","link": "'.$url.'"},'; 
        // $sav .=  '<div class="menu2"><a '.$matches1[0][3].$val.'  </div>';
        
        }
        if (!empty($getit)){$sav .=  $getit;  }   
        //$sav .=  $plr;
$sav .= '{"name":"Try Again","link":"Try Again..."}'; 




}else{
/*


//echo'testing';

$idb = file_get_contents("https://keepvid.com/?url=https%3A%2F%2Fwww.youtube.com%2Fwatch%3Fv%3D".$vid."&ratebypass=yes");
//echo $idb;
//$idb = file_get_contents("http://api2.vidsid.com/getvideo.php?videoid=$vid");
$idcheck2 = preg_match_all('/googlevideo(.*)"/U', $idb, $matches2);                                          // var_dump($tng);


                 if(!empty($idcheck2) AND ($idcheck2> 2)){

        foreach($matches2[1] as $index => $url) { 
              // foreach($matches2[1] as $val) { 
        // $size =  $matches3[0][$index]; //second array extractor
        $url =  urldecode($url);
        $url =str_replace('title=','title=Avptube_App_',$url);
      //  $url =str_ireplace('www.gvideo.in','',$url);
            if (preg_match('[itag=18|itag=22|itag=36|itag=17]' , $url)) {
                $urld = 'https://redirector.googlevideo'.$url;

        if (preg_match("/itag=18/i", $url)) { 
            $getit .='{"link": "Download 360p Video","name": "'.$urld.'&&nc=/AvpTube.Com_'.$aa.'.mp4"},'; 
            $plr .='{"name": "360p","link": "'.$urld.'"},'; }
        if (preg_match("/itag=36/i", $url)) {
            $getit .='{"link": "Download 240p Video","name": "'.$urld.'&&nc=/AvpTube.Com_'.$aa.'.3gp"},';
            $plr .='{"name": "240p","link": "'.$urld.'"},'; }
        if (preg_match("/itag=22/i", $url)) { 
            $getit .='{"link": "Download 720p Video","name": "'.$urld.'&&nc=/AvpTube.Com_'.$aa.'.mp4"},';
            $plr .='{"name": "720p","link": "'.$urld.'"},'; }
        if (preg_match("/itag=17/i", $url)) { 
            $lastl = $urld;
            $getit .='{"link": "Download 144p Video","name": "'.$lastl.'&nc=/AvpTube.Com_'.$aa.'.3gp"},'; 
            $plr .='{"name": "144p","link": "'.$urld.'"},';
            }   }
        // $sav .=  '<div class="menu2"><a '.$matches1[0][3].$url.'  </div>';
        
        }
        if (!empty($getit)){$sav .=  $getit;  }
$sav .= '{"name":"Try Again","link":"Try Again||"}'; 

        
}else{
*/    
    parse_str(file_get_contents('http://www.youtube.com/get_video_info?video_id='.$vid),$info); 
$streams = explode(',',$info['url_encoded_fmt_stream_map']); 

foreach($streams as $stream){ 
    parse_str($stream,$real_stream); 
    $stype = $real_stream['type']; 
//   $sav .=  $stype.'<br/>';
    if(strpos($real_stream['type'],';') !== false){ 
        $tmp = explode(';',$real_stream['type']); 
        $stype = $tmp[0]; 
        unset($tmp); 
    } 
    $urld =$real_stream['url'].'&signature='.$real_stream['sig'];
        if ($real_stream['itag'] == '18'){ 
        //$sav .=  $real_stream['url'].'&signature='.$real_stream['sig'].'<br>';
                 $sav .=  '{"link": "Download 360p -Video","name": "'.$urld.'&&nc=/AvpTube.Com_'.$aa.'.mp4"},'; 
                $plr .='{"name": "360p","link": "'.$urld.'"},';
        }elseif($real_stream['itag'] == '36'){
                $sav .=  '{"link": "Download 240p -Video","name": "'.$urld.'&&nc=/AvpTube.Com_'.$aa.'.3gp"},';
                $plr .='{"name": "240p","link": "'.$urld.'"},';
        }elseif($real_stream['itag'] == '22'){  
            $sav .=  '{"link": "Download 720p -Video","name": "'.$urld.'&&nc=/AvpTube.Com_'.$aa.'.mp4"},';
            $plr .='{"name": "720p","link": "'.$urld.'"},'; 
        }elseif($real_stream['itag'] == '17'){    
            // $lastl = $urld;
            $sav .=  '{"link": "Download 144p -Video","name": "'.$urld.'&nc=/AvpTube.Com_Video_'.$aa.'.3gp"},'; 
            $plr .='{"name": "144p","link": "'.$urld.'"},';
            }

}

$sav .= '{"name":"Try Again","link":"||Try Again||"}'; 

}

}

        if (!empty($plr)){
$player = base64_encode('{"result":[{"name": "Video1","player": ['.$plr.'{"name": "Null","link": "Null"}],"type": "video"}]}');
        }else{
         $player = base64_encode('{"result":[{"name": "Video1","player": [{"name": "480P","link":"'.$playurl.'"},{"name": "780P","link":"SEcond Player"}],"type": "video"}]}');   
        }
        

?>