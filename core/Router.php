<?php

Class Router {
    private $table;
    public function __construct() {}

    public function getRoute()
    {
        $basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
        $uri = substr($_SERVER['REQUEST_URI'], strlen($basepath));
        if (strstr($uri, '?')) $uri = substr($uri, 0, strpos($uri, '?'));
        $uri = strtolower(trim($uri, '/'));

        return $this->stringToRoute($uri);
    }

    public static function stringToRoute($uri){
        $uri = explode('/', $uri);
        $len = 3;
        // Form strings log_up to LogUp and etc..
        foreach($uri as &$u){
            if($u == '_api') {
                $len += 1;
                continue;
            }
            $u = str_replace('_', ' ', $u);
            $u = ucwords($u);
            $u = str_replace(' ', '', $u);
        }
        // paluu arvon pitää olla vähintää 3 arvoa / listään tyhjiä jos tarvitaan
        while(count($uri) < $len ){ 
            $uri[] = "";
        }
        return $uri;
    }

}