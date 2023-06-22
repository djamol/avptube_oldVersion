<?php
// The file
$filename = $_GET['url'];
$new_width = 120; $new_height = 90;

// Content type
header('Content-type: image/jpeg');

// Get new dimensions
list($width, $height) = getimagesize($filename);
//$percent = 0.9; // percentage of resize
//$new_width = $width * $percent;
//$new_height = $height * $percent;

// Resample
$image_p = imagecreatetruecolor($new_width, $new_height);
$image = imagecreatefromjpeg($filename);
imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

// Output
imagejpeg($image_p, null, 100);
?>