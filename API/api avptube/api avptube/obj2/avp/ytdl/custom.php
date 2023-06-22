<?php
include '01_curl.php';
include '01_youtube-class.php';
include '01_key-update.php';
$decrypt_key = get_key();
if(isset($_GET['query']))
{
$q = urldecode($_GET['query']);
$search_result = new Youtube_Search($q);
$search_result = $search_result->outputdata;
}
else
{
if(isset($_GET["id"]))
{
$link = urldecode($_GET['id']);
if(strlen($link) == 11)
{
$linkvideo = "http://youtube.com/watch?v=".$link;
}
else
{
$linkvideo = $link;
}
}
else
{
$lastest = file_get_contents('lastest');
if (filter_var($lastest, FILTER_VALIDATE_URL) === false)
{
$lastest = 'https://www.youtube.com/watch?v='.$_GET['v'].'';
}
$linkvideo = $lastest;
}
$video = new Youtube_Grabber($linkvideo);
$video->decryptkey = $decrypt_key;
$video->GetVideoData();
}
for($i = 0;$i < count($video->videodata['map']);$i++)
{
//var_dump($video->videodata['map']);
$title = 'AvpTube.Com_'.$video->videodata['map'][$i][7];
echo'#'.$video->videodata['map'][$i][2].'&title='.$title.'&nc=/'.$title.'.mp4>'.$video->videodata['map'][$i][6].'('.$video->videodata['map'][$i][4].')<';
}
?>