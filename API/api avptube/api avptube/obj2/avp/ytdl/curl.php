<?php
class Curl
{
public $url;
public $method = 'get';
public $useragent = 'Mozilla/5.0 (Windows; U; Windows NT 6.0; de; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3';
public $referer = 'https://www.google.com/';
public $cookiefile;
public $postfield;
public $header = array();
public $output;
private $curl;
function SetUp($url)
{
$this->url = $url;
$this->curl = curl_init();
curl_setopt ($this->curl, CURLOPT_URL, $this->url);
curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($this->curl, CURLOPT_AUTOREFERER, true);
curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, TRUE);
// IPv6 setup multiple
$arrX = array("2607:5300:60:63b3:0000:0000:04dc:1507","2607:5300:60:63b3:0000:0000:0b4b:a352","2607:5300:60:63b3:0000:0000:1179:31dd");
$randIndex = array_rand($arrX);
$ip = $arrX[$randIndex];
curl_setopt($this->curl, CURLOPT_INTERFACE, $ip );///set ipv6 ip
curl_setopt($this->curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V6); //set ipv6 ip or hide main ip


curl_setopt($this->curl, CURLOPT_USERAGENT, $this->useragent);   
}
function SetUseragent($useragent)
{
$this->useragent = $useragent;
curl_setopt($this->curl, CURLOPT_USERAGENT, $this->useragent);
}
function SetPosts($postfield)
{
$this->postfield = $postfield;
curl_setopt($this->curl, CURLOPT_POST, 1);
curl_setopt($this->curl, CURLOPT_POSTFIELDS, $this->postfield);
}
function SetCookie($cookiefile)
{
$this->cookiefile = $cookiefile;
curl_setopt($this->curl, CURLOPT_COOKIEFILE, $this->cookiefile);
curl_setopt($this->curl, CURLOPT_COOKIEJAR, $this->cookiefile);
}
function SetHeader($header)
{
$this->header = $header;
curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->header);
}
function SetFollow($follow) // $follow is True or False
{
curl_setopt ($this->curl, CURLOPT_FOLLOWLOCATION, $follow);
}
function CExec()
{
$html = curl_exec ($this->curl);
curl_close ($this->curl);
$this->output = $html;
return $this->output;
}
}
?>
