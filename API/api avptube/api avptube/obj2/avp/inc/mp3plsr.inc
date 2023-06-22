<?php
//search playlist
//error_reporting(E_ALL);
//include 'conf.php';
//$qu = $_GET['q'];
if(!empty($_GET['page'])){$token = '&pageToken='.$_GET['page'];}else{$token = "";}

$data = ngegrab("http://api.soundcloud.com/playlists.json?limit=5&q=$qu&offset=$o&client_id=$client_id2");
$data = json_decode($data, true);//var_dump($data);
if(!empty($data)){//if(!empty($data) AND !empty($q)){
    $sav .= '{"id":1,"pref":false,"rid":"'.$rid.'","status":null,"header":false,"head":"","footer":false,"foot":"","df":false,"desingf":0,"backcolor":"no","toolcolor":"no","PER_ITEM_AD":6,"banner":false,"nativead":false,"history":"Mp3 Playlist Search- '.$qs.'","type":"youtube","uplink":"null","upurl":"null","webopenback":"","webads":false,"adset":{"show":9999,"close":210000},';
$sav .= '"result":[';

foreach ($data as $customer) {
    $link = $customer['permalink']; 
    $title = $customer['title'];
    $name = str_replace(array(',', '<', '>', '*'), ' ', $title);
    $name = preg_replace("/[,:\[\]}{'\"]/", " ", $name);
    $id = $customer['id'];
   // $creat = $customer['created_at'];
   $creat = $customer['created_at'];$date = date_parse($creat);
   $date = $date["day"].'/'.$date["month"].'/'.$date["year"];
       
    $lastm = $customer['last_modified'];


                        $userlink = $customer['user']['permalink']; 
                        $userid = $customer['user']['id']; 
                        $username = $customer['user']['username']; 
                        $useravatar = $customer['user']['avatar_url'];
                        //$lastmd = $customer['user']['last_modified'];                        
                        //Track Details 
                                $total = count($customer['tracks']);
   $url = "$apiurl/mp3plid.php?id=".$id;
            $sav .= '{"vid":"1","title":"'.$name.'","shr":"Tracks -'.$total.'","agent":"","FAll":"","PTR":"","UXL":"","poff":"true","act":"next","bm":"ns","open":"","dte":"'.$date.'","thumb":"'.$useravatar.'","lnk":"'.$url.'"},';
        
                                    }
            if (!empty($nextpage)){  
    $urln = ''.$apiurl.'/s.php?q='.$qu.'&amp;radio=3&amp;type=5&amp;page='.$nextpage;
$sav .= '{"vid":"1","title":"More Video Result -----&gt;( NEXT )","agent":"","FAll":"","PTR":"","UXL":"","poff":"true","act":"next","bm":"true","open":"","shr":"next","dte":"More","thumb":"'.$apiurl.'/img/next.png","lnk":"'.$urln.'"}';
}else{$sav .= '{"vid":"1","title":"DjAmol- Hang On (Digital Club) English Track","shr":"DjAmolOfficial-","agent":"","FAll":"","PTR":"","UXL":"","poff":"true","act":"no","bm":"ns","open":"","dte":"30 October 2012","thumb":"http://img.youtube.com/vi/xRS9L_03Wuw/default.jpg","lnk":"xRS9L_03Wuw"}';} 

$sav .= "]";


$sav .= ',"user":"tested'; $sav .= '"}';
echo base64_encode(gzcompress($sav));

}else{
     $error = 'mp3plsr'; __DIR__.'/inc/error.inc'; 
    
}
?>