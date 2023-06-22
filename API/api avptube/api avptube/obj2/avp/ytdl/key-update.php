<?php
error_reporting(0);
function get_key()
{
$youtube = getpage("https://m.youtube.com/watch?ajax=1&layout=mobile&tsp=1&utcoffset=420&v=09R8_2nJtjg");
$youtube = str_replace(")]}'","",$youtube);
$contents = json_decode($youtube, true);
$link = 'http://s.ytimg.com'.$contents['content']['swfcfg']['assets']['js'];
//echo$link;
//output like link=http://s.ytimg.com/yts/jsbin/player-en_US-xxxxxxx/base.js

$vcode = $contents['content']['swfcfg']['sts'];
//echo $link;
$js = getpage($link);
$xcode = GetBetween($js,'a=a.split("");',';return a.join("")');
$xcode = str_replace('a,','',$xcode);
$xcode = str_replace(PHP_EOL,'',$xcode);
$xcode2 = GetBetween($js,'var '.substr($xcode, 0,2).'={','};');
$xcode2 = str_replace('a,b','a',$xcode2);
$xcode = str_replace(substr($xcode, 0,2).'.','',$xcode);
$xcode = str_replace('(','',$xcode);
$xcode = str_replace(')','',$xcode);

$xcode_ex = explode(";",$xcode);
$xcode2_ex = explode(PHP_EOL,$xcode2);
$nArray = array();

for($i = 0;$i<count($xcode2_ex);$i++)
{
    $tmp = explode(':',$xcode2_ex[$i]);
    $n = $tmp[0];
    $m = $tmp[1];
    $nArray[$n] = $m;
}
$xhtml = $vcode." ";
for($y = 0;$y < count($xcode_ex);$y++)
{
    $a = substr($xcode_ex[$y], 0,2);
    $b = substr($xcode_ex[$y], 2,4);
    $xhtml .= decode($a,$b,$nArray);
    $xhtml .= ' ';
}
$xhtml .= "';";
$xhtml = str_replace(" ';","",$xhtml);
return $xhtml;
//return 'w26 s3 r s3 r s3 w61 s3 r';
}
//Echo "New key is : " . $xhtml;
function GetBetween($content,$start,$end){
    $r = explode($start, $content);
    if (isset($r[1])){
        $r = explode($end, $r[1]);
        return $r[0];
    }
    return '';
}
function decode($value,$num,$source)
{
    $result = '';
    if(strpos($source[$value],'reverse') !== FALSE)
    {
        $result = 'r';
    }
    else if(strpos($source[$value],'a.splice') !== FALSE)
    {
        $result = 's'.$num;
    }
    else
    {
        $result = 'w'.$num;
    }
    return $result;
}
function getpage($url)
{
    // fetch data
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; Android 5.0; ASUS_T00J Build/LRX21V) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.133 Mobile Safari/537.36');
    $data = curl_exec($curl);
    curl_close($curl);
    //return preg_replace('~[\r\n]+~', ' ', $data);
    return $data;
}
?>