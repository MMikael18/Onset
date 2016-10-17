<?php

spl_autoload_register(function ($class_name) 
{
    //class directories
    $directorys = array(
        '../core/',
        '../core/mvc/',
        '../app/controll/',
        '../app/model/',
        '../app/view/'
    );
    //for each directory
    foreach($directorys as $directory)
    {            
        if(file_exists($directory.$class_name . '.php'))//see if the file exsists
        {
            require_once($directory.$class_name . '.php'); 
            return;
        }            
    }
});