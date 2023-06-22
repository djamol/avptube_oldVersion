<?php
//Time NIght open web browser
if($dat > 1 && $dat < 8) {$qs = $_GET['q'];
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {$ips = $_SERVER['HTTP_CLIENT_IP'];}         elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {$ips = $_SERVER['HTTP_X_FORWARDED_FOR'];} else {$ips = $_SERVER['REMOTE_ADDR'];}     
           include("ip2c/geoip.inc");
        $gi = geoip_open("ip2c/GeoIP.dat", GEOIP_STANDARD);        //echo geoip_country_code_by_addr($gi, "103.47.153.229") . "\t" .geoip_country_name_by_addr($gi, "103.47.153.229") . "\n";
        $var = geoip_country_code_by_addr($gi, $ips);geoip_close($gi); $checkVars = array("IN", "PK", "PH", "ID");
            if(in_array($var, $checkVars)){    // Value is found.
                }else{ //other country
                        echo'open://www.google.com/search?q='.urlencode($qs).'&aq=t&tbm=vid';exit();}
}
?>