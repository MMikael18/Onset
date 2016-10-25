<?php

Class Router {
    private $table;
    public function __construct() {
        
    }
    public function getRoute()
    {
        $basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
        $uri = substr($_SERVER['REQUEST_URI'], strlen($basepath));
        if (strstr($uri, '?')) $uri = substr($uri, 0, strpos($uri, '?'));
        $uri = trim($uri, '/');
        return explode('/', $uri);
    }
}