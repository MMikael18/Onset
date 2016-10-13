<?php
if (!session_id()) {
    session_start();
}
// DATA STORE
class FB_model extends aModelCore{

    /* App */
    public $app_secret = NULL;
    public $app_id = NULL;
    /* View static data  */
    public $login_text = "Log in with Facebook!";
    public $loginUrl = NULL;
    public $logout_text = "Log out";
    public $logoutUrl = NULL;
    /* Settings */
    public $absolute_url = NULL;
    public $is_loged = false;
    /* Connection objects */
    private $helper;
    private $fb;
    private $fbaccesstoken = "fb_access_token";
    /* User data */
    public $id;
    public $userName;
    public $userImage; 

    public function __construct($config) {
        // Fb settings
        $this->app_secret = $config['app_secret'];
        $this->app_id = $config['app_id'];
        $this->absolute_url = $config['absolute_url'];
        $this->logoutUrl = $config['absolute_url'].'/?fblogout';

        $this->InitalFacebook();
    }

    private function InitalFacebook(){
        // Set fb objects
        $this->fb = new Facebook\Facebook([
            'app_id' => $this->app_id,
            'app_secret' => $this->app_secret,
            'default_graph_version' => 'v2.2'
        ]);
        $this->helper = $this->fb->getRedirectLoginHelper();
        $permissions = ['email'];
        
        $this->is_loged = false;
        if(isset($_SESSION['fbaccess'])){
        // Get user data if login
            $_SESSION['logged_in'] = 'true';
            $this->is_loged = true;
            $this->setUserData($_SESSION['fbaccess']);
        }else{
        // Login url
            $loginUrl = $this->helper->getLoginUrl($this->absolute_url.'/?fblogin', $permissions);
            $this->loginUrl = htmlspecialchars($loginUrl);
        }        
    }

    public function Logout(){
        if (!session_id()) {
            session_start();
        }
        unset($_SESSION['fbaccess']);
        unset($_SESSION['logged_in']);
        session_destroy();
        header("Location:../");
    }

    public function loginCallBack(){
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
        $oAuth2Client = $this->fb->getOAuth2Client(); // The OAuth 2.0 client handler helps us manage access tokens
        $tokenMetadata = $oAuth2Client->debugToken($accessToken); // Get the access token metadata from /debug_token
        //Debug::dump($tokenMetadata); 
        $tokenMetadata->validateAppId($this->app_id); // Validation (these will throw FacebookSDKException's when they fail)
        //$tokenMetadata->validateUserId('123'); // If you know the user ID this access token belongs to, you can validate it here
        $tokenMetadata->validateExpiration();
        if (! $accessToken->isLongLived()) {// Exchanges a short-lived access token for a long-lived one
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                echo "<p>Error getting long-lived access token: " . $this->helper->getMessage() . "</p>\n\n";
                exit;
            }
        }
        $_SESSION['fbaccess'] = (string) $accessToken;
        header("Location:../");
    }

    private function setUserData($access_token){
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
        $this->userId = $user['id'];
        $this->userName = $user['name'];
        $this->userImage = $user['picture']['url'];   
    }
}

// USER INPUT
class FB_controll extends aControllCore{
    
    private $helper;
    private $fb;
    private $fbaccesstoken = "fb_access_token";

    public function __construct(FB_model $model) {
        $this->model = $model;
        if (array_key_exists('fblogin',$_GET)){
            $this->model->loginCallBack();
        }else if(array_key_exists('fblogout',$_GET)){
            $this->model->Logout();
        }
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
            echo '<img src="'.$this->model->userImage.'" />';
            echo '<span>'.$this->model->userName.'</span><br />';
            echo '<a href="'.$this->model->logoutUrl.'">'.$this->model->logout_text.'</a>';
        }else{
            echo '<a href="'.$this->model->loginUrl.'">'.$this->model->login_text.'</a>';
        }
        echo '</div>';
    }   
}