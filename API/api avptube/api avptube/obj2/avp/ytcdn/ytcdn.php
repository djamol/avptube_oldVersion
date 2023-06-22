<?php
//if($_GET['p']!='amolpatil'){exit();}
error_reporting(0);

//@error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
@ignore_user_abort(0);
@set_time_limit(0);
require 'YouTube.php';
require'Algo.php';//for youtube algo auto generator script
 function get_size($url){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
    curl_exec($ch);
    $filesize = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
    curl_close($ch);
    if ($filesize) return $filesize;
}

function fb($number, $plus24, $uppercase) {
        $return = '0 ';
        // Validate number
        if(is_numeric($number) && $number >= 0) {
            // Optimize arguments
            $plus24 = !!$plus24;
            $uppercase = !!$uppercase;
            // Binary data measurement units
            $bUnits = $plus24
                ? array('B' => 1, 'K' => 1024, 'M' => 1048576, 'G' => 1073741824)
                : array('B' => 1, 'K' => 1000, 'M' => 1000000, 'G' => 1000000000);
            // Get human friendly binary unit
            $bunit = $number < $bUnits['K']
                ? 'B' : ($number < $bUnits['M']
                    ? 'K' : ($number < $bUnits['G']
                        ? 'M' : 'G'));
            // Calculate binary size
            $number = ($number / $bUnits[$bunit]) + 0.000001;
            // Process output
            if($number >= 10) {
                if($number >= 100) {
                    $nSTR = (string)round($number);
                    $number = $number > 1000 ? $nSTR : " {$nSTR}";
                } else {
                    preg_match('/^[0-9]*\\.[0-9]/i', (string)$number, $matches);
                    $number = $matches[0];
                }
            } else {
                preg_match('/^[0-9]*\\.[0-9]{2}/i', (string)$number, $matches);
                $number = $matches[0];
            }
            $return = $number . ($bunit != "B" ? ("{$bunit}") : ' ');
            $return = $uppercase ? strtoupper($return) : strtolower($return);
        }
        return $return;
    }

$yt = new YouTube();
$id = str_replace('https://www.youtube.com/watch?v=', '', $_GET['id']);
$links = $yt->getDownloadLinks($id,$algorithm,false); //true false for enable ipv6 function if true then change ipv6 list 

foreach ($links as $url) {
    
    $binsize = get_size($url['url']);
    $link = $url['url'];
    $tag = $url['itag'];
    $vtag = $url['itag'];
    $vtag = str_ireplace('22', '720p', $vtag);
    $vtag = str_ireplace('18', '360p', $vtag);
    $vtag = str_ireplace('43', '360p', $vtag);
    $vtag = str_ireplace('36', '240p', $vtag);
    $vtag = str_ireplace('240p0p', '360p', $vtag); // bug on 360p itag
    $vtag = str_ireplace('17', '144p', $vtag);
    $nt = $vtag;
    $nt = str_ireplace('720p', 'q720p', $nt);
    $nt = str_ireplace('480p', 'q192', $nt);
    $nt = str_ireplace('360p', 'q128', $nt); 
    $nt = str_ireplace('240p', 'q240p', $nt);
    $nt = str_ireplace('144p', 'q144p', $nt);
    $type = $url['type'];
    $size = get_size($url['url']);
    $size = fb($size, true, true).'B';
    
    // Link 
    $dl_link = $url['url'];
        
       
//            echo '<a class="btn video '.$nt.'" rel="nofollow" href="'.$dl_link.'"> <div class="btn-border"> <div class="btn-mp3">'.$vtag.'</div><div class="btn-bitrate">'.$type.'</div><div class="btn-line"></div><div class="btn-filesize">'.$size.'</div></div></a>';
      $title = 'AvpTube.Com_'.urlencode($url['title']);
    echo'#'.$dl_link.'&title='.$title.'&nc=/'.$title.'.mp4>Download '.$vtag.'-'.$type.'('.$size.')<';
       
    }

?>
