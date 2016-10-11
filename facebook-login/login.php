<?php
require_once __DIR__.'/../config.php';
// DATA STORE
class FB_model extends aConfig{
    public $app_secret = "850a555729d096d2660ff1cb3340514f";
    public $app_id = "1241254219271435";
    
    public function __construct() {
    }
}
// USER INPUT
class FB_controll{
    private $model;
    public function __construct(FB_model $model) {
        $this->model = $model;
    }    
}
// HTML OUT
class FB_view{
    private $model;
    public function __construct(FB_model $model) {
        $this->model = $model;
    }
    public function Render() {
        return '<h1>'.$this->model->app_id.'</h1>';
    }   
}

$model = new FB_model();
$controller = new FB_controll($model);
$view = new FB_view($model);

echo $view->Render();

/*
class User_Authentication
{
    public $app_id = "";
    public $app_secret = "";

    private $fb;
    public function getFB(){
        return $this->fb;
    }

    private static $instance;
    private function __construct()
    {
        $this->fb = new Facebook\Facebook([
            'app_id' => $this->app_id,
            'app_secret' => $this->app_secret,
            'default_graph_version' => 'v2.2'
        ]);
    }

    public static function Instance()
    {
        if (is_null(self::$instance))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

}
*/
//var_dump(User_Authentication::Instance()->getFB());
/*
require_once __DIR__ . '/logout.php';

if (!session_id()) {
    session_start();
}
$fb = new Facebook\Facebook([
    'app_id' => '',
    'app_secret' => '',
    'default_graph_version' => 'v2.2'
]);
$helper = $fb->getRedirectLoginHelper();
//echo $_SESSION['fb_access_token'];
//echo $_SESSION['userdata'];

if(!isset($_SESSION['fb_access_token'])){
    $permissions = ['email','']; // Optional permissions
    $loginUrl = $helper->getLoginUrl('https://onset.dev/../facebook-login/fb-callback.php', $permissions);
    echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a><br />';
}else{
    echo '<a href="index.php?logout">Logout</a><br />';
    fb::Logout();
    $access = $_SESSION['fb_access_token'];
    try {
        // Returns a `Facebook\FacebookResponse` object
        $response = $fb->get('/me?fields=id,name,picture', $access);
        echo '<pre>' . var_export($response, true) . '</pre>';
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }
}
*/