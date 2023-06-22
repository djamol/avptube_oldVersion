#!/usr/bin/php -q
<?php

// This code demonstrates how to lookup the country by IP Address

include("geoip.inc");

// Uncomment if querying against GeoIP/Lite City.
// include("geoipcity.inc");

$gi = geoip_open("GeoIP.dat", GEOIP_STANDARD);

//echo geoip_country_code_by_addr($gi, "24.24.24.24") . "\t" .
//    geoip_country_name_by_addr($gi, "24.24.24.24") . "\n";
echo geoip_country_code_by_addr($gi, "103.47.153.229") . "\t" .
    geoip_country_name_by_addr($gi, "103.47.153.229") . "\n";

geoip_close($gi);

?>
