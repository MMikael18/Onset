<?php
require_once __DIR__ . '/../vendor/autoload.php';

class fb{
    public static function Logout(){
        if(array_key_exists('logout',$_GET))
        {
            session_start();
            unset($_SESSION['userdata']);
            session_destroy();
            //header("Location:../index.php");
        }
    }
}

