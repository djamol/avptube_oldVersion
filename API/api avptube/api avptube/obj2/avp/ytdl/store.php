<?php
// Check download token
// Set operation params
error_reporting(0);
$url = base64_decode($_GET['url']); 
$mime = ($_GET['mime']);
$name = 'AvpTube_'.($_GET['name']).'.mp4';

// Fetch and serve
if ($url)
{
// Generate the server headers
if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE)
{
    header('Content-Type: "' . $mime . '"');
    header('Content-Disposition: attachment; filename="' . $name . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header("Content-Transfer-Encoding: binary");
    header('Pragma: public');
}
else
{
    header('Content-Type: "' . $mime . '"');
    header('Content-Disposition: attachment; filename="' . $name . '"');
    header("Content-Transfer-Encoding: binary");
    header('Expires: 0');
    header('Pragma: no-cache');
}
readfile($url);
exit;
}
?>