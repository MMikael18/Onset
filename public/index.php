<?php
require_once __DIR__.'/../core/debugTools.php';
require_once __DIR__.'/../core/mvcCore.php';
require_once __DIR__.'/../core/router.php';
//include_once("config.php");
require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__."/../facebook-login/login.php";
require_once __DIR__.'/../config.php';
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>On Set</title>
<style type="text/css"></style>
</head>
<body>

<a href="/">index</a><a href="/user.php">user</a>
<?php

$model = new FB_model(Config::FB());
$controller = new FB_controll($model);
$view = new Login_view($model);  
echo $view->Render();

//The following function will strip the script name from URL i.e.  http://www.something.com/search/book/fitzgerald will become /search/book/fitzgerald
$base_url = Router::getCurrentUri();
$routes = array();
$routes = explode('/', $base_url);
//Now, $routes will contain all the routes. $routes[0] will correspond to first route. For e.g. in above example $routes[0] is search, $routes[1] is book and $routes[2] is fitzgerald
Debug::dump($routes);

if($routes[0] == "search")
{
    if($routes[1] == "book")
    {
        echo "BOOKS for ";
    }
}

?>

</body>
</html>