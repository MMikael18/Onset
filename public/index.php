<?php
//include_once("config.php");
//include_once("includes/functions.php");
require_once __DIR__ .'/../vendor/autoload.php';
require_once __DIR__."/../facebook-login/login.php";
require_once __DIR__.'/../config.php';

$model = new FB_model(Config::FB());
$controller = new FB_controll($model);
$view = new Login_view($model);
echo $view->Render();

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>On Set</title>
<style type="text/css"></style>
</head>
<body>

</body>
</html>