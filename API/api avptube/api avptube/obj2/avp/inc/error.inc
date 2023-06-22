<?php
//s absc c plid topc channel dailysrch mp3plsr pls smp3
if($error == 'c'){//channel error cat.php
        $link   =$apiurl.'/absc.php?id=';
        $chobj = array ( array("UCHgNsDiNvtT966PPFQrF4Ww","DjAmol Music"),
array("UC8-Th83bH_thdKZDJCrn88g","The Tonight Show Jimmy Fallon"),array("UCJ0uqCI0Vqr2Rrt1HseGirg","TikTok Video"),
array("UCp0hYYBW6IMayGgR-WeoCvQ","TheEllenShow"),array("UC_bsLEv3uAEAEUPA6AwFc-A","The Late Late Show with James Corden"),
array("UCMSOMKw_HCNla89Xr3JV4Bw","ViralTikTok"),array("UCHGe3AJ2ujHxJYFqMEVl-Xw","Tamil Video"),
array("UCc2nbAr6T8IUa0B40sHioqA","BGRAM Video"),array("UC7yG8ZsE8PtuBF-iqytW9sA","Vigo Video"),
array("UC16niRr50-MSBwiO3YDb3RA","BBC News"),array("UC1tnj_v8Sn-hWERFvqSjBWQ","India News"),
array("UC56gTxNs4f9xZ7Pa2i5xNzg","Sony India Music"),array("UCNJcSUSzUeFm8W9P7UUlSeQ","The Viral Fever"),
array("UCpF3nD7YjagCW--1YzDwZqg","Tom And Jerry Show"),array("UCef1-8eOpJgud7szVPlZQAQ","CNN News18"),

array("UCq-Fj5jknLsUf-MWSy4_brA","Tseries"),array("UC82o9tQyo_cJhtyoFi-ROEw","Zee Marathi")  );  
$sav .='{"id":1,"pref":false,"rid":"","status":null,"rid":"","header":false,"head":"","footer":false,"foot":"","df":true,"desingf":2,"backcolor":"no","toolcolor":"no","banner":false,"nativead":false,"PER_ITEM_AD":6,"history":"Category LIST","type":"youtube","uplink":"null","upurl":"null","webopenback":"","webads":false,"adset":{"show":9999,"close":210000},"result":[';
for ($row = 0; $row < count($chobj); $row++) {
  //for ($col = 0; $col < 2; $col++) { echo "<li>".$chobj[$row][$col]."</li>";}
 //echo 'id:'.$chobj[$row][0];  echo 'name:'.$chobj[$row][1];
    $sav .= '{"vid":"1","title":"'.$chobj[$row][1].'","shr":"'.$chobj[$row][1].'","agent":"","FAll":"","PTR":"","UXL":"","poff":"true","act":"next","bm":"ns","open":"","dte":"ERR","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$link.$chobj[$row][0].'"},';
}
$sav .= '{"vid":"1","title":"DjAmol- Hang On (Digital Club) English Track","shr":"DjAmolOfficial-","agent":"","FAll":"","PTR":"","UXL":"","poff":"true","act":"no","bm":"ns","open":"","dte":"30 October 2012","thumb":"http://img.youtube.com/vi/xRS9L_03Wuw/default.jpg","lnk":"xRS9L_03Wuw"}';
$sav .= "]";


}else{
//if($error = 's'|| $error = 'absc'|| $error = 'c'){
    $sav  .='{"id":1,"pref":false,"rid":"","status":null,"header":false,"head":"","footer":false,"foot":"","df":false,"desingf":0,"backcolor":"no","toolcolor":"no","PER_ITEM_AD":6,"banner":false,"nativead":false,"history":"@ Error Search","uplink":"null","upurl":"null"
    ,"type":"error","result":[{"vid":"1","title":"Video Not Found","agent":"","FAll":"","PTR":"","UXL":"","poff":"true","act":"no","bm":"z","open":"","shr":"Use Another Keyword","dte":"Failed","thumb":"'.$apiurl.'/img/error.png","lnk":"vGSjIt0JrS0"},{"vid":"1","title":"Use Another Keyword","agent":"","FAll":"","PTR":"","UXL":"","poff":"true","act":"no","bm":"z","open":"","shr":"Try Again","dte":"Result","thumb":"'.$apiurl.'/img/error.png","lnk":"vGSjIt0JrS0"}]';
}

?>