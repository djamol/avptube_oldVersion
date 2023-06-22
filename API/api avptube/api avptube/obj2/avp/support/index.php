<?php
$gcm = $_GET['gcm'];
$fbm = $_GET['fbm'];
//echo'msg://Hello Sir '; Custom  Send push message  to

if (empty($gcm) || $gcm == 'null'){ echo'gcmid';//google cloud messanger id empty run register func
}else{
     $info = base64_decode($_GET['info']);
     $ns  = explode('&',$info);$device = $ns[12];
     $deviceid = $ns[0]; $ip = getRealUserIp();
     ADDtosql($deviceid,$ip,$info,$gcm);
                 //   OR  //
    //             SendMail($deviceid,$ip,$info,$device,$gcm);
            
            }
    
            
 function ADDtosql($deviceid,$ip,$info,$gcm){$msg = base64_decode($_GET['msg']);
 include '../../sql1.php';
 
    $order = "INSERT INTO androidchat VALUES ( NULL, '$deviceid', '$ip', '$info', '$gcm','$msg','$fbm')";
//mysqli_query($dbcon,"SET NAMES utf8");
$result = mysqli_query($dbcon,$order);	//order executes
if($result){ echo'success';  }           
            }

function SendMail($deviceid,$ip,$info,$device,$gcm){
         $from_fullname = 'AvpTube Chat';$from_email = 'chat@djamol.com';
     $email_subject = 'AvpTube -'.$deviceid;
    $email_message = "Android Device ID :$deviceid <br><br>
    IP : $ip <br>
    <form name='lookup' method='post' action='https://www.iplocation.net/'><input type='hidden' name='query' value= '$ip'><input type='submit' name='submit' value='IP Lookup'></form>
    <br><br><br>GCM ID :$gcm <br> <a href='http://apvideo.info/inc/admin/gmc2.php?uid=$gcm' target='_blank'>Click Here Reply</a><br><br>Device Name :$device <br><br><br><br>Message :".base64_decode($_GET['msg'])."<br><br>".str_replace('&',"<br>",$info);
	//$email_message     = nl2br(trim(strip_tags($email_message)));
    $to_email = 'djamolgroup@gmail.com';
    $headers      = "From: $from_fullname <$from_email>\r\n";
    $headers   .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $headers   .= "Message-ID: <".time().rand(1,1000)."@".$_SERVER['SERVER_NAME'].">". "\r\n";  
$vasplus_mailer_delivers_greatly = @mail($to_email, $email_subject, $email_message."<br>Using DjAmol.Com-Contact", $headers);

			if ($vasplus_mailer_delivers_greatly) 
			 {echo'success';}

}
            
            function getRealUserIp(){
    switch(true){
      case (!empty($_SERVER['HTTP_X_REAL_IP'])) : return $_SERVER['HTTP_X_REAL_IP'];
      case (!empty($_SERVER['HTTP_CLIENT_IP'])) : return $_SERVER['HTTP_CLIENT_IP'];
      case (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) : return $_SERVER['HTTP_X_FORWARDED_FOR'];
      default : return $_SERVER['REMOTE_ADDR'];
    }
 }       
            
?>