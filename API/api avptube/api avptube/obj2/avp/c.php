<?php
//  ?cat=video&type=top      cat=channel   cat=more 
include 'inc/conf.inc';


$cat = $_GET['cat'];

if(empty($_GET['c'])){
   if($cat == 'video'){
   include 'inc/c/video.inc';
   }elseif($cat == 'channel'){
    include 'inc/c/channel.inc';
   }elseif($cat == 'more'){
    include 'inc/c/more.inc';
   }elseif($cat == 'feed'){
    include 'inc/c/tiktok.inc';
   }

}else{
$sav .='{"id":1,"pref":false,"rid":"","status":null,"header":false,"head":"","footer":false,"foot":"","df":true,"desingf":2,"backcolor":"no","toolcolor":"no","banner":false,"nativead":false,"PER_ITEM_AD":6,"history":"Category LIST","type":"youtube","uplink":"null","upurl":"null","webopenback":"","webads":false,"adset":{"show":9999,"close":210000},';

$sav .='"result":[';

$url = $apiurl.'/cat.php?c='.$_GET['c'].'&cat='.$cat;
 $sav .='{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=US&l=","title":"Worldwide (All)"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=DZ&l=","title":"Algeria"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=AR&l=","title":"Argentina"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=AU&l=","title":"Australia"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=AT&l=","title":"Austria"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=BH&l=","title":"Bahrain"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=BE&l=","title":"Belgium"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=BA&l=","title":"Bosnia and Herzegovina"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=BR&l=","title":"Brazil"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=BG&l=","title":"Bulgaria"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=CA&l=","title":"Canada"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=CL&l=","title":"Chile"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=CO&l=","title":"Colombia"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=HR&l=","title":"Croatia"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=CZ&l=","title":"Czech Republic"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=DK&l=","title":"Denmark"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=EG&l=","title":"Egypt"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=EE&l=","title":"Estonia"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=FI&l=","title":"Finland"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=FR&l=","title":"France"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=DE&l=","title":"Germany"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=GH&l=","title":"Ghana"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=GR&l=","title":"Greece"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=HK&l=","title":"Hong Kong"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=HU&l=","title":"Hungary"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=IN&l=","title":"India"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=ID&l=","title":"Indonesia"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=IE&l=","title":"Ireland"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=IL&l=","title":"Israel"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=IT&l=","title":"Italy"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=JP&l=","title":"Japan"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=JO&l=","title":"Jordan"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=KE&l=","title":"Kenya"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=KW&l=","title":"Kuwait"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=LV&l=","title":"Latvia"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=LB&l=","title":"Lebanon"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=LT&l=","title":"Lithuania"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=MK&l=","title":"Macedonia"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=MY&l=","title":"Malaysia"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=MX&l=","title":"Mexico"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=ME&l=","title":"Montenegro"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=MA&l=","title":"Morocco"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=NL&l=","title":"Netherlands"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=NZ&l=","title":"New Zealand"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=NG&l=","title":"Nigeria"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=NO&l=","title":"Norway"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=OM&l=","title":"Oman"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=PE&l=","title":"Peru"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=PH&l=","title":"Philippines"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=PL&l=","title":"Poland"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=PT&l=","title":"Portugal"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=QA&l=","title":"Qatar"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=RO&l=","title":"Romania"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=RU&l=","title":"Russia"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=SA&l=","title":"Saudi Arabia"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=SN&l=","title":"Senegal"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=RS&l=","title":"Serbia"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=SG&l=","title":"Singapore"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=SK&l=","title":"Slovakia"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=SI&l=","title":"Slovenia"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=ZA&l=","title":"South Africa"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=KR&l=","title":"South Korea"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=ES&l=","title":"Spain"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=SE&l=","title":"Sweden"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=CH&l=","title":"Switzerland"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=TW&l=","title":"Taiwan"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=TH&l=","title":"Thailand"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=TN&l=","title":"Tunisia"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=TR&l=","title":"Turkey"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=UG&l=","title":"Uganda"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=UA&l=","title":"Ukraine"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=AE&l=","title":"United Arab Emirates"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=GB&l=","title":"United Kingdom"},
{"vid":"1","poff":"true","agent":"","FAll":"","PTR":"","UXL":"","act":"next","bm":"true","open":"","shr":"Top '.$cat.' Select Country","dte":"Country.","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$url.'&country=YE&l=","title":"Yemen"}';

$sav .= "]";
$sav .= ',"user":"tested'; $sav .= '"}'; 
echo base64_encode(gzcompress($sav));
}
//echo $sav;