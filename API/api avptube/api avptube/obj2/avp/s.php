<?php
// Search Details           //header('AppFORM: JSON');
include 'inc/conf.inc';// echo'webapp://google.com';exit();
ini_set('display_errors', 0);
$data = $_POST['data'];
$extra = "";
if (!empty($data) && $data != "null" ) {
    $data = base64_decode($data);
    $json = json_decode($data,true);
    unset($data);
            foreach($json["aweme_list"] as $index => $data) {
            $des = $data["desc"];
            $vid = $data["video"]["play_addr"]["uri"];
            //$thumb =$data["video"]["origin_cover"]["url_list"][0];
            $thumb =$data["video"]["cover"]["url_list"][0];

            $co = $data["region"];$uid = $data["author"]["short_id"];  
            $uname = $data["author"]["nickname"];   
            $uthumb =$data["author"]["avatar_thumb"]["url_list"][0];

/*                        try{
        foreach($data["text_extra"] as $datax) { $hid = $datax["hashtag_id"];$hname = $datax["hashtag_name"];
}
}catch(Exception $e) {}*/
            //$uc = $data["cha_list"][0]["cid"];$uc = $data["cha_list"][0]["cha_name"];    
                        ///var_dump($data);
            //break; 
            //echo"ULR ".$data["challenge_info"]["cid"];
            $ex = base64_encode('{"apidata":"http://api2.musical.ly/aweme/v1/feed/?type=0&max_cursor=0&min_cursor=0&count=8&volume=0.2&pull_type=1&req_from=enter_auto&gaid=3625bf6e-8e18-4e54-95cf-73d02fab0a90&ad_user_agent=Dalvik%2F1.6.0+%28Linux%3B+U%3B+Android+4.4.4%3B+SM-G900F+Build%2FKTU84Q%29&ts=1557461284&app_type=normal&version_name=8.7.2&region=US&timezone_name=America%2FLos_Angeles&device_type=SM-G900F&iid=6688917312475334405&build_number=8.7.2&resolution=1280*752&aid=1233&app_name=musical_ly&device_platform=android&version_code=872&carrier_region=&dpi=160&fp=&openudid=a3c545b4d7c037ea&sys_region=US&ssmix=a&os_api=19&mcc_mnc=&timezone_offset=-28800&device_id=6666049236067747222&device_brand=google&manifest_version_code=2018101602&os_version=4.4.4&update_version_code=2018101602&ac=wifi&app_language=en&pass-region=1&language=en&is_my_cn=0&carrier_region_v2=&channel=googleplay","apiurl":"'.$apiurl.'/ttk-top.php?","agent":""}');
            $info = base64_encode('{"un":"'.$uname.'","upic":"'.$uthumb.'","tkt":"tkt://'.$ex.'"}');
                                             $randm  = str_pad(dechex(mt_rand(0, 0xFFFFF)), 8, '0', STR_PAD_LEFT);
            $dapi ="http://api2.musical.ly/aweme/v1/play/?video_id=$vid&line=0&ratio=360p&watermark=0&media_type=4&vr_type=0&test_cdn=None&improve_bitrate=0&logo_name=ok&nc=/MyFile.mp4";
            $dapi2 ="http://api2.musical.ly/aweme/v1/play/?video_id=$vid&line=1&ratio=360p&watermark=0&media_type=4&vr_type=0&test_cdn=None&improve_bitrate=0&logo_name=ok&nc=/MyFile.mp4";
            $plr ='{"name": "Srv 1","link": "'.$dapi.'"},{"name": "Srv 2","link": "'.$dapi2.'"},';   $lastl=$dapi; 
            $player = base64_encode('{"result":[{"name": "Video1","filename":"Dubs'.$randm.'_AvpTube.mp4","player": ['.$plr.'{"name": "Null","link": "'.$lastl.'"}],"type": "video"}]}');
            $extra .='{"vid":"1","title":"Video '.$des.'","shr":"Top","poff":"true","agent":"'.$info.'","FAll":"tiktok","PTR":"","UXL":"'.$player.'","act":"no","bm":"ns","open":"","dte":"'.$co.'","thumb":"'.$thumb.'","lnk":"ttk@'.$vid.'"},';
            }
            unset($json);$api = "$apiurl/ttk-top.php";
            $fil = ("http://api2.musical.ly/aweme/v1/feed/?type=0&max_cursor=0&min_cursor=0&count=8&volume=0.2&pull_type=1&req_from=enter_auto&gaid=3625bf6e-8e18-4e54-95cf-73d02fab0a90&ad_user_agent=Dalvik%2F1.6.0+%28Linux%3B+U%3B+Android+4.4.4%3B+SM-G900F+Build%2FKTU84Q%29&ts=1557461284&app_type=normal&version_name=8.7.2&region=US&timezone_name=America%2FLos_Angeles&device_type=SM-G900F&iid=6688917312475334405&build_number=8.7.2&resolution=1280*752&aid=1233&app_name=musical_ly&device_platform=android&version_code=872&carrier_region=&dpi=160&fp=&openudid=a3c545b4d7c037ea&sys_region=US&ssmix=a&os_api=19&mcc_mnc=&timezone_offset=-28800&device_id=6666049236067747222&device_brand=google&manifest_version_code=2018101602&os_version=4.4.4&update_version_code=2018101602&ac=wifi&app_language=en&pass-region=1&language=en&is_my_cn=0&carrier_region_v2=&channel=googleplay##$api##null");
            $extra .='{"vid":"1","agent":"","FAll":"tiktok","PTR":"","UXL":"'.$fil.'","poff":"false","act":"page","bm":"true","open":"","shr":"More Videos","dte":"Next","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'?page=2","title":"GET MORE...NEXT PAGE"},';
}
    $qs = $_GET['q'];$radio =$_GET['radio'];    $cc = $_GET['count'];$dc = $_GET['dc'];
$qu=str_replace(" ","+", $qs);$qu=str_replace("-","+", $qu);
$qu=str_replace("_","+", $qu); $ob =$_GET['type'];
include '../sql_sitemap.php';
///$radio =1 channel , $radio =2 playlist
if ($radio == "1"){//channel (search)
include 'inc/channel.inc'; 

}elseif ($radio == "2"){//playlist (search)
include 'inc/playlist.inc'; 

}elseif ($radio == "3"){ //music (search)
 if (!isset($_GET['p']) || $_GET['p'] <= 0) { $o = 1; $pgn = 1;} else {        
        $p = htmlentities($_GET['p']);$o = (($p - 1) * 25)+1;$pgn = $p;}
include 'inc/srchmp3.inc'; 
        }else{   // video (search)
  $filter ='';
 $cat = $_GET['cat'];$vd = $_GET['dur'];$co = $_GET['co'];
 if ( $ob == "2" ) {$filter = $filter."&order=rating";}elseif ( $ob == "3" ) {$filter = $filter."&order=viewCount";}elseif ( $ob == "4" ) {$filter = $filter."&order=title";}    
  if(!empty($vd)){$filter = $filter.'&videoDuration='.$vd; }   if(!empty($cat)){$filter=$filter.'&videoCategoryId='.$cat;}
  if(!empty($co)){$filter=$filter.'&regionCode='.$co;}
  if(!empty($_GET['page'])){$filter = $filter.'&pageToken='.$_GET['page'];} 
    $grab=ngegrab('https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults=46&type=video&q='.$qu.'&key='.$devkey.''.$filter);
  $json = json_decode($grab);
    $responada = $json->items;  
// var_dump($responada);
 $nextpage = $json->nextPageToken; //$prevpage = $json->prevPageToken; 
if(!empty($responada))
{//
//include 'inc/s/dailyinclude.inc';//enable youtube video +dailymotion video result
$sav .= '{"id":1,"pref":false,"rid":"'.$rid.'","status":null,"header":false,"head":"","footer":false,"foot":"","backcolor":"no","toolcolor":"no","df":false,"desingf":0,"banner":true,"nativead":true,"PER_ITEM_AD":10,"history":"Search- '.$qs.' ","type":"youtube","uplink":"null","upurl":"null","webopenback":"","webads":false,"adset":{"show":9999,"close":210000},';//"webopenback":"http://apvideo.info/pg/set.html?id='.$randm.'"
$sav .= '"result":[';
        if (!empty($extra)){$sav .=$extra;}
//echo'{"vid":"1","title":"Boss File Manager (FREE APP) Install Now","shr":"Boss File Manager","act":"actionview","bm":"ns","dte":"Ads","thumb":"http://mobile.djamol.com/fm.png","lnk":"market://details?id=com.file.manager.boss&rdid=com.file.manager.boss&referrer=utm_source%3Dadcolony%26utm_medium%3Dbanner%26utm_term%3Dfile%26utm_campaign%3DBossFM%26anid%3Dadcolony"},';
        foreach($json->items as $key => $hasil) {
        $name = $hasil->snippet->title;
        
        $link =  $hasil->id->videoId;
        $thumb = $hasil->snippet->thumbnails->default->url;
        $date =dateyt($hasil->snippet->publishedAt);
        $des = $hasil->snippet->description;$description=substr($des,0,15);
        $chnn = $hasil->snippet->channelTitle;
        $chnn = str_ireplace('vevo','',$chnn);
        $shorted =  $chnn."-".$description;
        //  $name = htmlentities($name);        //  $shorted = htmlentities($shorted);
        $name = preg_replace("/[,:\[\]}{'\"]/", " ", $name);$shorted = preg_replace("/[,:\[\]}{'\"]/", " ", $shorted);
        //$mthumb = 'http://ytimg.googleusercontent.com/vi/'.$link.'/mqdefault.jpg';
        //or
	    //$mthumb = "http://img.youtube.com/vi/".$link."/default.jpg";
        $mthumb = "http://i.ytimg.com/vi/".$link."/default.jpg";

       
        //act = actionview or next  
        $sav .= '{"vid":"1","title":"'.$name.'","shr":"'.$shorted.'","poff":"true","agent":NULL,"FAll":NULL,"PTR":NULL,"UXL":NULL,"act":"no","bm":"ns","agent":NULL,"FAll":NULL,"PTR":NULL,"UXL":NULL,"open":"","dte":"'.$date.'","thumb":"'.$mthumb.'","lnk":"'.$link.'"},';
       // include'inc/dailysearch.inc';
         //     include 'inc/s/adddailyparse.inc';//enable youtube video +dailymotion video result
        }
        
if (!empty($nextpage)){  
    $urln = ''.$apiurl.'/s.php?q='.$qu.'&amp;cat='.$cat.'&amp;dur='.$vd.'&amp;type='.$ob.'&amp;page='.$nextpage;
$sav .= '{"vid":"1","title":"More Video Result -----&gt;( NEXT )","poff":"true","agent":NULL,"FAll":NULL,"PTR":NULL,"UXL":NULL,"act":"next","bm":"true","open":"","shr":"next","dte":"More","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$urln.'"}';
}else{$sav .= '{"vid":"1","title":"DjAmol- Hang On (Digital Club) English Track","shr":"DjAmolOfficial-","poff":"true","agent":NULL,"FAll":NULL,"PTR":NULL,"UXL":NULL,"act":"no","bm":"ns","open":"","dte":"30 October 2012","thumb":"http://img.youtube.com/vi/xRS9L_03Wuw/default.jpg","lnk":"xRS9L_03Wuw"}';} 

$sav .= "]";

        }
        else
        {
            $grab = file_get_contents("$apisecond&q=$qu&page=".$_GET['page']);
            if (0 === strpos($grab, '{"id":2,"status"')) {
                $sav .=  $grab;
                }else {
                                $grab = file_get_contents("$apithird&q=$qu&page=".$_GET['page']);
                    if (0 === strpos($grab, '{"id":3,"status"')) {
                            $sav .=  $grab;
                                    }else {include 'abs-daily.php';}
                    }
//echo'{"id":1,"status":null,"type":"error","result":[{"vid":"1","title":"Video Not Found","poff":"true","agent":NULL,"FAll":NULL,"PTR":NULL,"UXL":NULL,"act":"no","bm":"z","shr":"Use Another Keyword","dte":"Failed","thumb":"'.$apiurl.'/img/error.png","lnk":"vGSjIt0JrS0"},{"vid":"1","title":"Use Another Keyword","poff":"true","agent":NULL,"FAll":NULL,"PTR":NULL,"UXL":NULL,"act":"no","bm":"z","shr":"Try Again","dte":"Result","thumb":"'.$apiurl.'/img/error.png","lnk":"vGSjIt0JrS0"}]';
       
}
$sav .= ',"user":"tested'; $sav .= '"}'; 
echo base64_encode(gzcompress($sav));//echo ''.(gzuncompress(base64_decode($datas)));//decompressed
}
  //     }
  //var_dump( $responada);
  //echo $sav;
  ?>