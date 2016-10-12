<?php
if (!session_id()) {
    session_start();
}
// DATA STORE
class FB_model extends aModelCore{
    
    public $app_secret = NULL;
    public $app_id = NULL;
    public $login_text = "Log in with Facebook!";
    public $loginUrl = NULL;
    public $logout_text = "Log out";
    public $logoutUrl = NULL;
    public $absolute_url = NULL;
    public $is_loged = false;
    
    public function __construct($config) {
        $this->app_secret = $config['app_secret'];
        $this->app_id = $config['app_id'];
        $this->absolute_url = $config['absolute_url'];
        $this->logoutUrl = $config['absolute_url'].'/?fblogout';
    }
}

// USER INPUT
class FB_controll extends aControllCore{
    
    private $helper;
    private $fb;
    private $fbaccesstoken = "fb_access_token";

    public function __construct(FB_model $model) {
        $this->model = $model;
        $this->fb = new Facebook\Facebook([
            'app_id' => $model->app_id,
            'app_secret' => $model->app_secret,
            'default_graph_version' => 'v2.2'
        ]);
        
        $this->helper = $this->fb->getRedirectLoginHelper();
        $permissions = ['email'];

        if (array_key_exists('fblogin',$_GET)){
            $this->loginCallBack();
        }else if(array_key_exists('fblogout',$_GET)){
            $this->Logout();
        }

        $this->model->is_loged = false;
        if(isset($_SESSION[$this->fbaccesstoken])){
            $this->model->is_loged = true;
            $this->setData($_SESSION[$this->fbaccesstoken]);
        }
        $loginUrl = $this->helper->getLoginUrl($this->model->absolute_url.'/?fblogin', $permissions);
        $this->model->loginUrl = htmlspecialchars($loginUrl);
    }

    private function Logout(){
        if (!session_id()) {
            session_start();
        }
        unset($_SESSION['userdata']);
        session_destroy();
        header("Location:../");
    }

    private function loginCallBack(){
        try {
            $accessToken = $this->helper->getAccessToken();
        } catch(Facebook\Exceptions\FacebookResponseException $e) { // When Graph returns an error
            echo 'Graph returned an VIRHE: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) { // When validation fails or other local issues
            echo 'Facebook SDK returned an VIRHE: ' . $e->getMessage();
            exit;
        }
        if (! isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "VIRHE: " . $helper->getError() . "\n";
                echo "VIRHE Code: " . $helper->getErrorCode() . "\n";
                echo "VIRHE Reason: " . $helper->getErrorReason() . "\n";
                echo "VIRHE Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }
        // Logged in
        //var_dump($accessToken->getValue());
        // The OAuth 2.0 client handler helps us manage access tokens
        $oAuth2Client = $this->fb->getOAuth2Client();
        // Get the access token metadata from /debug_token
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);
        //Debug::dump($tokenMetadata);
        // Validation (these will throw FacebookSDKException's when they fail)
        $tokenMetadata->validateAppId($this->model->app_id); // Replace {app-id} with your app id
        // If you know the user ID this access token belongs to, you can validate it here
        //$tokenMetadata->validateUserId('123');
        $tokenMetadata->validateExpiration();
        if (! $accessToken->isLongLived()) {// Exchanges a short-lived access token for a long-lived one
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                echo "<p>Error getting long-lived access token: " . $this->helper->getMessage() . "</p>\n\n";
                exit;
            }
        }
        $_SESSION[$this->fbaccesstoken] = (string) $accessToken;
        header("Location:../");
    }

    private function setData($access_token){
        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $this->fb->get('/me?fields=id,name,picture', $access_token);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        $user = $response->getGraphUser();
        //Debug::dump($user);
        echo '<img src="'. $user['picture']['url'].'" />';
    }
}
// HTML OUT
class Login_view extends aViewCore{
    public function __construct(FB_model $model) {
        $this->model = $model;
    }
    public function Render() {
        echo '<div>';
        if($this->model->is_loged){
            echo '<a href="'.$this->model->logoutUrl.'">'.$this->model->logout_text.'</a>';
        }else{
            echo '<a href="'.$this->model->loginUrl.'">'.$this->model->login_text.'</a>';
        }
        echo '</div>';
    }   
}

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