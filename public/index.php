<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../core/autoload.php';

if (!session_id()) {
    session_start();
}

$app = new App();

/*
$profile = new Template("../app/view/tpl/login.html");
$profile->set("photoURL", "photo.jpg");
$profile->set("name", "Monkey man");
$profile->set("linkURL", "23");
$profile->set("link", "23");  

$model = new FBmodel();
$controller = new FB_controll($model);
$view = new Login_view($model);

$master = new Template("../app/view/layout/master.html");
$master->set("login", $view->Render());
$master->set("main", $profile->output());
echo $master->output();
*/
/*
$profile = new Template("../app/tpl/login.html");
$profile->set("photoURL", "photo.jpg");
$profile->set("name", "Monkey man");
$profile->set("linkURL", "23");
$profile->set("link", "23");  
echo $profile->output();
*/
/*
$model = new FB_model($config);
$controller = new FB_controll($model);
$view = new Login_view($model);  
echo $view->Render();
*/
/*
//The following function will strip the script name from URL i.e.  http://www.something.com/search/book/fitzgerald will become /search/book/fitzgerald
$routes = Router::getRoute();
Debug::dump($routes);
//Now, $routes will contain all the routes. $routes[0] will correspond to first route. For e.g. in above example $routes[0] is search, $routes[1] is book and $routes[2] is fitzgerald
if($routes[0] == "search")
{
    if($routes[1] == "book")
    {
        echo "BOOKS for ";
    }
}
*/

?>