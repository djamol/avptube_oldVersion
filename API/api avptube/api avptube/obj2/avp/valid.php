<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
$domain = $_SERVER["SERVER_NAME"];

if($domain == "api.patilweb.com")
{
   echo' {"id":1,"entry":false,"status":"login","reg":"","zone":"act","msg":"Welcome","result":{"uplink":"http://avptube.com/AvpTube.apk","msg":"hi New Version Release"},"adid":false,"ads":false,"adset":{"show":9999,"close":210000,"banner":"ca-app-pub-3940256099942544/6300978111","inter":"ca-app-pub-3940256099942544/1033173712","native":""}} ';
   exit();
}

$op=$_GET['iop'];$opd=$_GET['data'];
$opp=$_GET['package'];$opc=$_GET['code'];
if(!empty($op)){ 
$js=json_decode(base64_decode($op));//echo $json->isp;echo $json->countryCode;
if (stripos($js->isp,"Google") !== false ||$js->countryCode=="US" ) {//echo 'true';if google word case insentative in isp or countryCode is US
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {$ips = $_SERVER['HTTP_CLIENT_IP'];}         elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {$ips = $_SERVER['HTTP_X_FORWARDED_FOR'];} else {$ips = $_SERVER['REMOTE_ADDR'];}             
$myfile = fopen('log.txt','a') or die("Unable to open file!");$date = date('d/m/y  h:i:s A');
$txt = "\n$date-$js-$ips-$opd";
fwrite($myfile, $txt);fclose($myfile);
echo '{"id":1,"entry":false,"status":"login","reg":"","zone":"xox","msg":"Hi","result":{"uplink":"http://....","msg":"hi New Version Release"},"adid":false,"ads":false,"adset":{"show":9999,"close":210000,"banner":"ca-app-pub-3940256099942544/6300978111","inter":"ca-app-pub-3940256099942544/1033173712","native":""}} ';
exit();
}} 

//temp this code
/*
if($js->countryCode != "IN"){
echo '{"id":1,"entry":false,"status":"login","reg":"","zone":"xox","msg":"Hi","result":{"uplink":"http://....","msg":"hi New Version Release"},"adid":false,"ads":false,"adset":{"show":9999,"close":210000,"banner":"ca-app-pub-3940256099942544/6300978111","inter":"ca-app-pub-3940256099942544/1033173712","native":""}} ';
exit();    
}
*/
//$code = $_GET['code'];
echo'{"id":1,"entry":false,';

/*if($code<750){
echo '"status":"update",';
}else{
*/echo '"status":"login","reg":"",';    //}
//if($dat > 1 && $dat < 8) {$qs = $_GET['q'];
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {$ips = $_SERVER['HTTP_CLIENT_IP'];}         elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {$ips = $_SERVER['HTTP_X_FORWARDED_FOR'];} else {$ips = $_SERVER['REMOTE_ADDR'];}     
                   include("ip2c/geoip.inc");  $gi = geoip_open("ip2c/GeoIP.dat", GEOIP_STANDARD);
        $var = geoip_country_code_by_addr($gi, $ips);geoip_close($gi); $checkVars = array("UK", "US","");//"IN", "PK", "PH", "ID"
            if(in_array($var, $checkVars)){  echo'"zone":"xox","msg":"Hi",';//no entry US,UK,blank  // Value is found.
                }else{
                    echo'"zone":"act","msg":"Welcome",';//other country allowed //other country
                    //"zone":"act"
                } 
 

        
//echo'"zone":"xox",';//""act" is splash without login also in login page,crash is "crash" app on login page


echo '"result":{"uplink":"http://....","msg":"hi New Version Release"},';
echo'"adid":false,"ads":false,"adset":{"show":9999,"close":210000,';
echo'"banner":"ca-app-pub-3940256099942544/6300978111","inter":"ca-app-pub-3940256099942544/1033173712","native":""}}';


?> 