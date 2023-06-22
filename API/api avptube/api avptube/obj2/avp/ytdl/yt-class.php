<?php
class Youtube_Grabber extends Curl
{
public $link;
public $videoid;
public $videoinfolink;
public $error;
public $videodata = array();
public $outputdata;
public $decryptkey;
function __construct($link)
{
$this->link = $link;
$this->GerVideoInfoLink($this->link);
parent::SetUp($this->videoinfolink);
$this->outputdata = parent::CExec();
}
function GetVideoData()
{
$strings = array();
$s = $sig = $url = $type = $quality = $size = '';
$expire = time();
parse_str($this->outputdata,$strings);
$this->videodata['img'] = $strings['iurl'];
$this->videodata['title'] = $strings['title'];
$this->videodata['ctitle'] = $this->clean($strings['title']);
$this->videodata['duration'] = gmdate("H:i:s", $strings['length_seconds']);;
$this->videodata['description'] = $this->get_description($this->link);
if($strings['adaptive_fmts'])
{
$string = explode(",", $strings['adaptive_fmts']);
for($i=0;$i<count($string);$i++)
{
parse_str($string[$i]);
if (strlen($type) > 5)
{
$type = explode(";", $type);
$type = $type[0];
}
$url = urldecode($url);
$quality = $size;
if(strlen($s) > 10)
{
$s = $this->DecryptYouTubeCypher($s,$this->decryptkey);
$url = $url . '&signature=' .$s;
}
$url = $url;
$title= $this->videodata['ctitle'];
$size = $this->get_size($url);
$size = $this->formatBytes($size);
$link = explode('.googlevideo.com/',$url);
$link = 'http://redirector.googlevideo.com/'.$link[1].'';

if($itag == '137')
{
$this->videodata['137'] = array('$type',$clen,$link,date("G:i:s T", $expire),$size,$s,$itag,$title);
}
if($itag == '140')
{
$this->videodata['140'] = array('$type',$clen,$link,date("G:i:s T", $expire),$size,$s,$itag,$title);
}
if($itag == '136')
{
$this->videodata['136'] = array('$type',$clen,$link,date("G:i:s T", $expire),$size,$s,$itag,$title);
}
if($itag == '135')
{
$this->videodata['135'] = array('$type',$clen,$link,date("G:i:s T", $expire),$size,$s,$itag,$title);
}
if($itag == '134')
{
$this->videodata['134'] = array('$type',$clen,$link,date("G:i:s T", $expire),$size,$s,$itag,$title);
}
if($itag == '133')
{
$this->videodata['133'] = array('$type',$clen,$link,date("G:i:s T", $expire),$size,$s,$itag,$title);
}
if($itag == '160')
{
$this->videodata['160'] = array('$type',$clen,$link,date("G:i:s T", $expire),$size,$s,$itag,$title);
}
if($itag == '251')
{
$this->videodata['251'] = array('$type',$clen,$url,date("G:i:s T", $expire),$size,$s,$itag,$title);
}
if($itag == '171')
{
$this->videodata['171'] = array('$type',$clen,$url,date("G:i:s T", $expire),$size,$s,$itag,$title);
}
if($itag == '250')
{
$this->videodata['250'] = array('$type',$clen,$link,date("G:i:s T", $expire),$size,$s,$itag,$title);
}
if($itag == '249')
{
$this->videodata['249'] = array('$type',$clen,$link,date("G:i:s T", $expire),$size,$s,$itag,$title);
}
}
if($strings['url_encoded_fmt_stream_map'])
{
$string = explode(",", $strings['url_encoded_fmt_stream_map']);
for($i=0;$i<count($string);$i++)
{
parse_str($string[$i]);
if (strlen($type) > 5)
{
$type = explode(";", $type);
$type = $type[0];
}
$url = urldecode($url);
if(strlen($s) > 10)
{
$s = $this->DecryptYouTubeCypher($s,$this->decryptkey);
$url = $url . '&signature=' .$s;
}
$url = $url;
$title= $this->videodata['ctitle'];
$size = $this->get_size($url);
$size = $this->formatBytes($size);
$itag = str_ireplace('22','Download MP4 (720p) ',$itag);
$itag = str_ireplace('34','Download FLV (360p)',$itag);
$itag = str_ireplace('35','Download FLV (480p)',$itag);
$itag = str_ireplace('36','Download 3GP (240p)',$itag);
$itag = str_ireplace('37','Download MP4 (1080p)',$itag);
$itag = str_ireplace('38','Download MP4 (1080p)',$itag);
$itag = str_ireplace('43','Download WebM (360p)',$itag);
$itag = str_ireplace('44','Download WebM (480p)',$itag);
$itag = str_ireplace('45','Download WebM (720p)',$itag);
$itag = str_ireplace('46','Download WebM (1080p)',$itag);
$itag = str_ireplace('82','Download MP4 (360p 3D)',$itag);
$itag = str_ireplace('83','Download MP4 (480p 3D)',$itag);
$itag = str_ireplace('84','Download MP4 (720p 3D)',$itag);
$itag = str_ireplace('85','Download MP4 (1080p 3D)',$itag);
$itag = str_ireplace('100','Download WebM (360p 3D)',$itag);
$itag = str_ireplace('101','Download WebM (480p 3D)',$itag);
$itag = str_ireplace('133','Download MP4 (240p VO)',$itag);
$itag = str_ireplace('134','Download MP4 (360p VO)',$itag);
$itag = str_ireplace('135','Download MP4 (480p VO)',$itag);
$itag = str_ireplace('136','Download MP4 (720p VO)',$itag);
$itag = str_ireplace('137','Download MP4 (1080p VO)',$itag);
$itag = str_ireplace('139','Download MP4 (Low bitrate AO)',$itag);
$itag = str_ireplace('140','Download MP4 (Med bitrate AO)',$itag);
$itag = str_ireplace('141','Download MP4 (Hi bitrate AO)',$itag);
$itag = str_ireplace('160','Download MP4 (144p VO)',$itag);
$itag = str_ireplace('171','Download WebM (Med bitrate AO)',$itag);
$itag = str_ireplace('172','Download WebM (Hi bitrate AO)',$itag);
$itag = str_ireplace('242','Download WebM (240p VOX)',$itag);
$itag = str_ireplace('243','Download WebM (360p VOX)',$itag);
$itag = str_ireplace('244','Download WebM (480p VOX)',$itag);
$itag = str_ireplace('245','Download WebM (480p VOX)',$itag);
$itag = str_ireplace('246','Download WebM (480p VOX)',$itag);
$itag = str_ireplace('247','Download WebM (720p VOX)',$itag);
$itag = str_ireplace('248','Download WebM (1080p VOX)',$itag);
$itag = str_ireplace('264','Download MP4 (1080p VO)',$itag);
$itag = str_ireplace('5','Download FLV (240p)',$itag);
$itag = str_ireplace('17','Download 3GP (144p)',$itag);
$itag = str_ireplace('18','Download MP4 (360p)',$itag);
$link = explode('.googlevideo.com/',$url);
//var_dump($url);
$link = 'https://redirector.googlevideo.com/'.$link[1].'';//$link = $url;
$this->videodata['map'][] = array($type,$quality,$link,date("G:i:s T", $expire),$size,$s,$itag,$title);
}
}
}
}
function GerVideoInfoLink($link)
{
$this->GetVideoID($link);
$this->videoinfolink = 'http://www.youtube.com/get_video_info?&video_id='. $this->videoid. '&asv=3&el=detailpage&hl=en_US';
}
function GetVideoID($link)
{
$url   = parse_url($link);
$my_id = NULL;
if( is_array($url) && count($url)>0 && isset($url['query']) && !empty($url['query']))
{
$parts = explode('&',$url['query']);
if( is_array($parts) && count($parts) > 0 )
{
foreach( $parts as $p )
{
$pattern = '/^v\=/';
if(preg_match($pattern, $p))
{
$my_id = preg_replace($pattern,'',$p);
$this->videoid = $my_id;
return $my_id;
break;
}
}
if(!$my_id)
{
$this->error = '<p>No video id passed in</p>';
$this->Error();
}
}
}
else
{
$this->error = '<p>Invalid url</p>';
$this->Error();
}
}
function Error()
{
die($this->error);
}
function get_size($url)
{
$my_ch = curl_init();
curl_setopt($my_ch, CURLOPT_URL,$url);
curl_setopt($my_ch, CURLOPT_HEADER,         true);
curl_setopt($my_ch, CURLOPT_NOBODY,         true);
curl_setopt($my_ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($my_ch, CURLOPT_TIMEOUT,        20);
$r = curl_exec($my_ch);
foreach(explode("\n", $r) as $header)
{
if(strpos($header, 'Content-Length:') === 0)
{
return trim(substr($header,16));
}
}
return '';
}
function get_description($url)
{
$my_ch = curl_init();
curl_setopt($my_ch, CURLOPT_URL,$url);
curl_setopt($my_ch, CURLOPT_HEADER,true);
curl_setopt($my_ch, CURLOPT_RETURNTRANSFER,true);
curl_setopt($my_ch, CURLOPT_FOLLOWLOCATION,true);
$content = curl_exec($my_ch);
$r = explode('<p id="eow-description" >', $content);
if (isset($r[1]))
{
$r = explode('</p></div>', $r[1]);
return $r[0];
}
else
{
return '';
}
}
function formatBytes($bytes, $precision = 2)
{
$units = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
$bytes = max($bytes, 0);
$pow = floor(($bytes ? log($bytes) : 0) / log(1024));
$pow = min($pow, count($units) - 1);
$bytes /= pow(1024, $pow);
return round($bytes, $precision) . '' . $units[$pow];
}
function DecryptYouTubeCypher($s,$key)
{
$method = explode(" ",$key);
foreach($method as $m)
{
if($m == 'r')
$s = strrev($s);
else if( substr($m,0,1) == 's')
$s = substr($s, (int) substr($m,1) );
else if( substr($m,0,1) == 'w')
$s = $this->swap($s, (int) substr($m,1));
}
return $s;
}
function swap($a, $b)
{
$c = $a[0];
$a[0] = $a[$b];
$a[$b] = $c;
return $a;
}
function clean($string)
{
$string = preg_replace('/[^A-Za-z0-9_\s-]/', '', $string);
$string = preg_replace('/[\s-]+/', ' ', $string);
$string = preg_replace('/[\s_]/', '_', $string);
return $string;
}
}
?>