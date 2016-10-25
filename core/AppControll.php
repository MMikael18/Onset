<?php

class AppControll{

    private $controller;
    public function __construct() {
        // Get route
        $router = new Router();
        $routes = $router->getRoute();
        
        Debug::dump($routes);

        if($routes[0] == ''){
            $this->CreateControll('Root');
        }else
        if($routes[0] == "_api"){
            //$r =  new Rest();
            //echo $r->response();
        }else{
            $this->CreateControll($routes[0],$routes[1],$routes[2]);
        }

    }

    private function CreateControll($controll,$action = "",$id = ""){
            $class = $controll;
            $function = $action;
            $param = $id;

            if (!class_exists($class)) {
                trigger_error("CreateControll in a AppControll failed to create ".$class, E_USER_NOTICE);
                return; 
            }

            //Run the controller action
            $this->controller = new $class();
            //echo $function; 
            if (strlen($function) == 0){
                $this->controller->index($param);                
            }else{
                $this->controller->{$function}($param);
            }
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