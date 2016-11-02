<?php

class App{

    private $controller;
    public function __construct() {
        // Get route
        $router = new Router();
        $route = $router->getRoute();
    
        if($route[0] == ''){
            $this->controll = new Controll('Home');
        }else
        if($route[0] == "_api"){
            //$r =  new Rest();
            //echo $r->response();
        }else{            
            $this->controll = new Controll($route[0],$route[1],$route[2]);            
        }
    }

    public static function UserControll($controll){
        $route = Router::stringToRoute($controll);
        $usercontroll = new UserControll($route[0],$route[1],$route[2]);
    }
}

class Controll{
    
    public function __construct($controll,$action = "",$id = ""){
        $class = $controll;
        $function = $action;
        $param = $id;

        if (!class_exists($class)) {
            trigger_error("Name -". $controll."- failed to create ".$class, E_USER_NOTICE);
            return; 
        }
        $controller = new $class();
        if (!$controller instanceof aControll){        
            trigger_error("Page Controll class has to extends aControll -> ". $controll, E_USER_ERROR);
            unset($controller);
            return;
        }
        if (strlen($function) == 0){
            $controller->index($param);                
        }else{
            $controller->{$function}($param);
        }
        return $controller;
    }
}

class UserControll{
    
    public function __construct($controll,$action = "",$id = ""){
        $class = $controll;
        $function = $action;
        $param = $id;

        if (!class_exists($class)) {
            trigger_error("Name -". $controll."- failed to create ".$class, E_USER_NOTICE);
            return; 
        }
        $controller = new $class();
        if (!$controller instanceof aUserControll){        
            trigger_error("User Controll class has to extends aUserControll -> ". $controll, E_USER_ERROR);
            unset($controller);
            return;
        }
            
        if (strlen($function) == 0){
            $controller->index($param);                
        }else{
            $controller->{$function}($param);
        }
        return $controller;
    }
}

/*
// set master
$master = new Template("../app/view/layout/master.html");
$master->set("login", "login");
$master->set("main", "main");
echo $master->output();
*/

//Debug::dump($routes);
//$ole = $this->CallAPI("PUT","http://onset.dev/_api");

//$master = new Template("../app/view/layout/master.html");
//$master->set("login", $ole);
//$master->set("main", "main");
//echo $master->output();

/*/
    private function CallAPI($method, $url, $data = false)
    {
        $curl = curl_init();
        switch ($method)
        {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        // Optional Authentication:
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "username:password");
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
*/