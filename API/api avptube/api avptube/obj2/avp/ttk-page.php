<?php
 error_reporting(0);
// ini_set('display_errors', 0);
//echo'fail"d co{nne"ction';
include 'inc/conf2.inc';
header('Content-Type: text/html; charset=utf-8');
header('xum: zipped');
ini_set('display_errors', 0);
$data = $_POST['data'];
$extra .= '{"id":"ok","videos":[';

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
            $extra .='{"vid":"1","title":"Video '.$des.'","info":"'.$info.'","play":"'.$player.'","act":"no","img":"'.$thumb.'","lnk":"ttk@'.$vid.'"},';
            }
            unset($json);$api = "$apiurl/ttk-page.php";
            $fil = ("http://api2.musical.ly/aweme/v1/feed/?type=0&max_cursor=0&min_cursor=0&count=8&volume=0.2&pull_type=1&req_from=enter_auto&gaid=3625bf6e-8e18-4e54-95cf-73d02fab0a90&ad_user_agent=Dalvik%2F1.6.0+%28Linux%3B+U%3B+Android+4.4.4%3B+SM-G900F+Build%2FKTU84Q%29&ts=1557461284&app_type=normal&version_name=8.7.2&region=US&timezone_name=America%2FLos_Angeles&device_type=SM-G900F&iid=6688917312475334405&build_number=8.7.2&resolution=1280*752&aid=1233&app_name=musical_ly&device_platform=android&version_code=872&carrier_region=&dpi=160&fp=&openudid=a3c545b4d7c037ea&sys_region=US&ssmix=a&os_api=19&mcc_mnc=&timezone_offset=-28800&device_id=6666049236067747222&device_brand=google&manifest_version_code=2018101602&os_version=4.4.4&update_version_code=2018101602&ac=wifi&app_language=en&pass-region=1&language=en&is_my_cn=0&carrier_region_v2=&channel=googleplay##$api##null");
            $extra .='{"play":"'.$fil.'","act":"page","img":"'.$thumb.'","lnk":"ttk@'.$vid.'"}';

}

$extra .= '],"user":"valid"}';
echo base64_encode(gzcompress($extra));//echo ''.(gzuncompress(base64_decode($datas)));//decompressed

?>

?>