<?php
include 'inc/conf2.php';
ini_set('display_errors', 0);

header('Content-Type: text/html; charset=utf-8');
header('xum: zipped');
$total =50;
$url = "http://api2.musical.ly/aweme/v2/category/list/?cursor=0&count=$total&retry_type=no_retry&app_language=en&language=en&region=US&sys_region=US&carrier_region=&carrier_region_v2=&build_number=8.7.2&timezone_offset=-28800&timezone_name=America%2FLos_Angeles&mcc_mnc=&is_my_cn=0&fp=&pass-region=1&iid=6688917312475334405&device_id=6666049236067747333&ac=wifi&channel=googleplay&aid=1233&app_name=musical_ly&version_code=872&version_name=8.7.2&device_platform=android&ssmix=a&device_type=SM-G900F&device_brand=google&os_api=19&os_version=4.4.4&openudid=a3c545b4d7c037ea&manifest_version_code=2018101602&resolution=1280*752&dpi=160&update_version_code=2018101602&_rticket=1557387005636&ts=1557387004&as=a1b50d2ddcaf9c76434355&cp=d2f0cc55c13dd96ee1[kIo&mas=016372d3509c46520277abdcef4dd0f533acaccc2ccc2c6cecc69c";
$options = array(
  'http'=>array(
    'method'=>"GET",
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
$sav .='{"id":1,"pref":false,"rid":"","status":null,"header":false,"head":"","footer":false,"foot":"","df":true,"desingf":2,"backcolor":"no","toolcolor":"no","banner":false,"nativead":false,"PER_ITEM_AD":6,"history":"Trending. LIST HashTAG","type":"youtube","uplink":"null","upurl":"null","webopenback":"","webads":false,"adset":{"show":9999,"close":210000},';

$sav .='"result":[';

        foreach($json["category_list"] as $index => $data) {
            $des = $data["desc"];
            $name = $data["challenge_info"]["cha_name"];
            $id = $data["challenge_info"]["cid"];    
            $uc = $data["challenge_info"]["user_count"];        
            $vc = $data["challenge_info"]["view_count"];  
                        ///var_dump($data);
            //break;
            //echo"ULR ".$data["challenge_info"]["cid"];
            $sav .='{"vid":"1","agent":"","FAll":"","PTR":"","UXL":"","poff":"true","act":"next","bm":"true","open":"","shr":"Hashtag Treding Videos Category","dte":"'.$uc.'.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.''.$id.'&n='.$name.'","title":"#'.$name.' View'.$vc.'"},';

            }
            $sav .='{"vid":"1","agent":"","FAll":"","PTR":"","UXL":"","poff":"true","act":"next","bm":"true","open":"","shr":"Hashtag Treding Next","dte":"Next","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'?page=2","title":" NEXT TAG List"}';


$sav .= "]";
$sav .= ',"user":"tested'; $sav .= '"}'; 
echo base64_encode(gzcompress($sav));
//echo $sav;

?>