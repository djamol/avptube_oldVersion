<?php




class YouTube {


    /*
     *
     * @ cache_dir
     *
     * @cookie_dir
     *
     * @itag_info
     *
     */

    private $cache_dir;

	private $cookie_dir;	

	private $itag_info = array(

		18 => "MP4",

		22 => "MP4",

		36 => "3GP",

		43 => "WebM",	

		17 => "3GP"

	);

	

	function __construct(){

		$this->cache_dir = dirname(__FILE__).'/.cache';

		$this->cookie_dir = sys_get_temp_dir();

                if(!file_exists($this->cache_dir)) {

                    mkdir($this->cache_dir,0755);

                  }

	}


        public function getDownloadLinks($id,$algorithm,$EnableV6IP) {

               $videoID = $id;
               $title ="";
               $webPage = $this->curlGet('https://www.youtube.com/embed/'.$videoID,$EnableV6IP);      

               $sts = null;

               if(preg_match('|"sts":([0-9]{4,}),"|i', $webPage, $matches)) {

               $sts = $matches[1];

               }
               
               // Add support for age-restricted content
               foreach(array('embedded', 'detailpage') as $elKey) {

                    $query = http_build_query(array(

                        'c' => 'web',

                        'el' => $elKey,

                        'ps' => 'default',

                        'sts' => $sts,

                        'eurl' => "https://youtube.googleapis.com/v/{$videoID}",

                        'video_id' => $videoID,

                    ));

          

                if ($this->is_Ok($videoData = $this->curlGet("https://www.youtube.com/get_video_info?{$query}",$EnableV6IP))) {

                        parse_str($videoData, $videoData);
                        //var_dump($videoData);
                        //echo 'title :'.$videoData['title'];
                        $title = $videoData['title'];
                        break;

                 }

              }

              // Fixed raw link
             if(isset($videoData['url_encoded_fmt_stream_map'])) {
                        $rawMediaLinks .= $videoData['url_encoded_fmt_stream_map'];
                    }
                    
                   
              $draftLink = explode(',',$rawMediaLinks);

              foreach($draftLink as $dlink) {

              parse_str($dlink,$mLink[]);

              }
              foreach($mLink as $linker) {

                if(isset($linker['s'])) {
                   
                   //https://github.com/WendyH/HMS-Youtube/blob/master/g.php
                   //$algorithm=file_get_contents("https://ytcdn.bid/latest/algo");
                   //if (!strlen($algorithm)>5){$algorithm='s2 w8 r w43 s2 w11 r';}
                   // require'ytcdnv3/core/Algo.php';//for youtube algo auto generator script
                   //echo $algorithm;
                   $linkData[] = array(

                     'url' => $linker['url'].'&signature='.self::YoutubeDecrypt($algorithm,$linker['s']),
                   
                     'itag' => $linker['itag'],
                     'title' => $title,
                     'type' => $this->itag_info[$linker['itag']]
                   );

               } else {

                  $linkData[] = array(

                    'url' => $linker['url'],

                    'itag' => $linker['itag'],
                     'title' => $title,
                    'type' => $this->itag_info[$linker['itag']]


                   );

               }

            }

            return $linkData;

        }

        private function is_Ok($var) {

                if(!preg_match('|status=fail|i',$var)) {

                return true;

                }

        }

        public function curlGet($url,$EnableV6IP){

    

                $tmpfname = $this->cookie_dir.'/cookie.txt';

	

		$ch = curl_init($url);

		

		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.81 Safari/537.36');

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		curl_setopt($ch, CURLOPT_HEADER, 0);

		

		curl_setopt($ch, CURLOPT_COOKIEJAR, $tmpfname);

		curl_setopt($ch, CURLOPT_COOKIEFILE, $tmpfname);
    if($EnableV6IP){
		// IPv6 setup multiple
    $arrX = array( "2607:5300:60:63b3::b4b:a352","2607:5300:60:63b3::4dc:1507","2607:5300:60:63b3::1179:31dd");

    $randIndex = array_rand($arrX);
    $ip = $arrX[$randIndex];
    curl_setopt($this->curl, CURLOPT_INTERFACE, $ip );///set ipv6 ip
    curl_setopt($this->curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V6); //set ipv6 ip or hide main ip
    }

		//curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

		

		$result = curl_exec($ch);

		curl_close($ch);

		

		return $result;

	}

        private function clean_name($name) {

                $special_chars = array("?", "[", "]", "/", "\\", "=", "<", ">", ":", ";", ",", "'", "\"", "&", "$", "#", "*", "|", "~", "`", "!", "{", "}", "%", "+", chr(0));

                $filename = str_replace($special_chars,' ',$name);

                $filename = preg_replace( "#\x{00a0}#siu", ' ', $filename );

                //$filename = str_replace( array( '%20', '+', ' '), '-', $filename );

                //$filename = preg_replace( '/[\r\n\t -]+/', '-', $filename );

                $filename = trim( $filename, '.-_' );

                return $filename;

        }
        
        // This magic function is optimized since 2 August 2018
        // Do not swap any char or reverse other division!!!!

        private function YoutubeDecrypt($algorithm, $sig) {
	           $method = explode(" ", $algorithm);
	          foreach($method as $m)
	            {	//  r - revers,  s - clone,  w - swap
	             	if           ($m     =='r') $sig = strrev($sig);
		            elseif(substr($m,0,1)=='s') $sig = substr($sig, (int)substr($m, 1));
		            elseif(substr($m,0,1)=='w') $sig = self::swap($sig, (int)substr($m, 1));
	        }
	          return trim($sig);
       }
        
        // Swapping between R | S | W

      private function swap($a, $b) {
	        $c = $a[0]; $a[0] = $a[$b]; $a[$b] = $c;
	        return $a;
     }
}