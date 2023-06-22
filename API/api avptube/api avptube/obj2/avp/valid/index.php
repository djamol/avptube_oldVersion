<?php
header('Content-Type: text/html; charset=utf-8');
//GET Values ->?id="+BuildConfig.APPLICATION_ID+"&v="+BuildConfig.VERSION_CODE+"&cd="+manufacturer+"-"+deviceCode+"&data=" + info);
//$v = $_GET['v'];

//this include in 750 up version (added 27/12/2017)
//Change only #version->version and set new version code
//Example :{"key":"#keyname","value":"stringvalue"},{"key":"@keyname","value":false},
echo  '{"#version":750,';
echo '"result":[';

echo '{"key":"#keyname","value":"stringvalue"},';//string value

echo '{"key":"@keyname","value":false}';//boolean value

echo ']}';
?>