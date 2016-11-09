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
        if($route[0] == "Api"){
            $this->controll = new RestControll($route);
        }else{            
            $this->controll = new Controll($route[0],$route[1],$route[2]);            
        }
    }

    public static function UserControll($controll){
        $route = Router::stringToRoute($controll);
        $usercontroll = new UserControll($route[0],$route[1],$route[2]);
    }
}

class RestControll{
    public function __construct($controll,$action = "",$id = ""){
        
        // headers for not caching the results
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        // headers to tell that result is JSON
        header('Content-type: application/json');

        $link1 = array('id' => '1', 'title' => 'Google' , 'url' => 'https://www.google.fi');
        $link2 = array('id' => '2', 'title' => 'JPPSoft Oy', 'url' => 'https://www.jppsoft.fi');
        $result_json = array($link1,$link2);
        echo json_encode($result_json);
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
