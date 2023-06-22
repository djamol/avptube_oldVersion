<?php
           include("geoip.inc");
        $gi = geoip_open("GeoIP.dat", GEOIP_STANDARD);        //echo geoip_country_code_by_addr($gi, "103.47.153.229") . "\t" .geoip_country_name_by_addr($gi, "103.47.153.229") . "\n";
        echo 'IP: 103.47.153.229 C:'.geoip_country_code_by_addr($gi, "103.47.153.229").'<br>';
        echo 'IP: 104.132.10.102 C:'.geoip_country_code_by_addr($gi, "104.132.10.102").'<br>';
        echo 'IP: 66.102.6.24 C:'.geoip_country_code_by_addr($gi, "66.102.6.24").'<br>';
        echo 'IP: 66.102.6.28 C:'.geoip_country_code_by_addr($gi, "66.102.6.28").'<br>';
        echo 'IP: 66.102.8.216 C:'.geoip_country_code_by_addr($gi, "66.102.8.216").'<br>';
        echo 'IP: 66.102.8.218 C:'.geoip_country_code_by_addr($gi, "66.102.8.218").'<br>';
        echo 'IP: 104.132.223.111 C:'.geoip_country_code_by_addr($gi, "104.132.223.111").'<br>';
        echo 'IP: 66.249.88.62 C:'.geoip_country_code_by_addr($gi, "66.249.88.62").'<br>';
        echo 'IP: 66.102.6.26 C:'.geoip_country_code_by_addr($gi, "66.102.6.26").'<br>';
        echo 'IP: 66.102.8.216 C:'.geoip_country_code_by_addr($gi, "66.102.8.216").'<br>';
        $ip="104.133.10.111";echo 'IP: '.$ip.' C:'.geoip_country_code_by_addr($gi, $ip).'<br>';
        $ip="108.177.7.87";echo 'IP: '.$ip.' C:'.geoip_country_code_by_addr($gi, $ip).'<br>';
        $ip="108.177.6.56";echo 'IP: '.$ip.' C:'.geoip_country_code_by_addr($gi, $ip).'<br>';
        $ip="66.102.6.88";echo 'IP: '.$ip.' C:'.geoip_country_code_by_addr($gi, $ip).'<br>';
        $ip="108.177.7.86";echo 'IP: '.$ip.' C:'.geoip_country_code_by_addr($gi, $ip).'<br>';
        
        geoip_close($gi);
        
        
        ?>