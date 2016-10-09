<?php

if (!session_id()) {
    session_start();
}
$fb = new Facebook\Facebook([
    'app_id' => '1241254219271435',
    'app_secret' => '850a555729d096d2660ff1cb3340514f',
    'default_graph_version' => 'v2.2'
]);
$helper = $fb->getRedirectLoginHelper();

//echo $_SESSION['fb_access_token'];
//echo $_SESSION['userdata'];

$permissions = ['email','']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://onset.dev/facebook-login/fb-callback.php', $permissions);
echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';

echo '<br /><a href="/facebook-login/logout.php?logout">Logout</a>';

echo '<br />';
$access = $_SESSION['fb_access_token'];
if(isset($access)){
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