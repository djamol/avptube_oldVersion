<?php
//error_reporting(E_ALL); ini_set('display_errors', 1);
$fire=$_GET['s'];$tag=$_GET['id'];
include'../../algo/Algo.php';
//echo $algorithm;
    echo base64_encode($tag."#".YoutubeDecrypt($algorithm,$fire));
    function YoutubeDecrypt($algorithm, $sig) {
  //          echo 'algo-:'.$algorithm;            echo 'sig-:'.$sig; 

	           $method = explode(" ", $algorithm);
	          foreach($method as $m)
	            {	//  r - revers,  s - clone,  w - swap
	             	if           ($m     =='r') $sig = strrev($sig);
		            elseif(substr($m,0,1)=='s') $sig = substr($sig, (int)substr($m, 1));
		            elseif(substr($m,0,1)=='w') $sig = swap($sig, (int)substr($m, 1));
	        }
	          return trim($sig);
       }
        
       
       function swap($a, $b) {
	        $c = $a[0]; $a[0] = $a[$b]; $a[$b] = $c;
	        return $a;
     }

    // echo  "URL--".YoutubeDecrypt("r s1 w50 w1",$fire);
