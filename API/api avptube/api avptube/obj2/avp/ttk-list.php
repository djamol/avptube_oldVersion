<?php
include 'inc/conf2.php';
ini_set('display_errors', 0);
header('Content-Type: text/html; charset=utf-8');
header('xum: zipped');
$cid = $_GET["cid"];$total =50;$n = $_GET["n"];
$url = "http://api2.musical.ly/aweme/v1/challenge/aweme/?ch_id=$cid&query_type=0&cursor=0&count=$total&type=5&retry_type=no_retry&app_language=en&language=en&region=US&sys_region=US&carrier_region=&carrier_region_v2=&build_number=8.7.2&timezone_offset=-28800&timezone_name=America%2FLos_Angeles&mcc_mnc=&is_my_cn=0&fp=&pass-region=1&iid=6688917312475334405&device_id=6666049236067747333&ac=wifi&channel=googleplay&aid=1233&app_name=musical_ly&version_code=872&version_name=8.7.2&device_platform=android&ssmix=a&device_type=SM-G900F&device_brand=google&os_api=19&os_version=4.4.4&openudid=a3c545b4d7c037ea&manifest_version_code=2018101602&resolution=800*1232&dpi=160";
$options = array(  'http'=>array('method'=>"GET",
    'header'=>"Accept-language: en\r\n" .
              "Cookie: app=com.zhiliaoapp.musically\r\n" .  // check function.stream-context-create on php.net
              "User-Agent: com.zhiliaoapp.musically/2018101602 (Linux; U; Android 4.4.4; en_US; SM-G900F; Build/KTU84Q; Cronet/58.0.2991.0)\r\n" // i.e. An iPad 
  )
);

$context = stream_context_create($options);
$file = file_get_contents($url, false, $context);
$json = json_decode($file,true);
unset($file);
//var_dump($json);
//echo($json['cursor']);
$url = $apiurl.'/ttk-list.php?cid=';
$sav .='{"id":1,"pref":false,"rid":"","status":null,"header":false,"head":"","footer":false,"foot":"","backcolor":"no","toolcolor":"no","df":false,"desingf":0,"banner":true,"nativead":true,"PER_ITEM_AD":10,"history":"HashTag '.$n.'","type":"tiktok","uplink":"null","upurl":"null","webopenback":"","webads":false,"adset":{"show":9999,"close":210000},';

$sav .='"result":[';

        foreach($json["aweme_list"] as $index => $data) {
            $des = $data["desc"];
            $vid = $data["video"]["play_addr"]["uri"];
            //$thumb =$data["video"]["origin_cover"]["url_list"][0];
            $thumb =$data["video"]["cover"]["url_list"][0];

            $co = $data["region"];$uid = $data["author_user_id"];    
/*                        try{
        foreach($data["text_extra"] as $datax) { $hid = $datax["hashtag_id"];$hname = $datax["hashtag_name"];
}
}catch(Exception $e) {}*/
            //$uc = $data["cha_list"][0]["cid"];$uc = $data["cha_list"][0]["cha_name"];    
                        ///var_dump($data);
            //break; 
            //echo"ULR ".$data["challenge_info"]["cid"];
            $randm  = str_pad(dechex(mt_rand(0, 0xFFFFF)), 8, '0', STR_PAD_LEFT);
            $dapi ="http://api2.musical.ly/aweme/v1/play/?video_id=$vid&line=0&ratio=360p&watermark=0&media_type=4&vr_type=0&test_cdn=None&improve_bitrate=0&logo_name=ok&nc=/MyFile.mp4";
            $dapi2 ="http://api2.musical.ly/aweme/v1/play/?video_id=$vid&line=1&ratio=360p&watermark=0&media_type=4&vr_type=0&test_cdn=None&improve_bitrate=0&logo_name=ok&nc=/MyFile.mp4";
            $plr ='{"name": "Srv 1","link": "'.$dapi.'"},{"name": "Srv 2","link": "'.$dapi2.'"},';   $lastl=$dapi; 
            $player = base64_encode('{"result":[{"name": "Video1","filename":"Dub'.$randm.'_AvpTube.mp4","player": ['.$plr.'{"name": "Null","link": "'.$lastl.'"}],"type": "video"}]}');

            $sav .='{"vid":"1","title":"Video '.$des.'","shr":"Top","poff":"true","agent":"","FAll":"tiktok","PTR":"","UXL":"'.$player.'","act":"no","bm":"ns","open":"","dte":"'.$co.'","thumb":"'.$thumb.'","lnk":"ttk@'.$vid.'"},';

            }
            $sav .='{"vid":"1","agent":"","FAll":"","PTR":"","UXL":"","poff":"false","act":"next","bm":"true","open":"","shr":"Select Channel Category","dte":"Next","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'?page=2","title":" NEXT TAG List"}';


$sav .= "]";
$sav .= ',"user":"tested'; $sav .= '"}'; 
echo base64_encode(gzcompress($sav));
//echo $sav;

?>