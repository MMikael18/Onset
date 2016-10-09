<?php
require_once __DIR__ . '/../vendor/autoload.php';
$fb = new Facebook\Facebook([
    'app_id' => '1241254219271435',
    'app_secret' => '850a555729d096d2660ff1cb3340514f',
    'default_graph_version' => 'v2.2'
]);

if(array_key_exists('logout',$_GET))
{
	session_start();
	unset($_SESSION['userdata']);
	session_destroy();
	header("Location:../index.php");
}
echo '<a href="/">Home</a>';