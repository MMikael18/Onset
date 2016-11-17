<?php

spl_autoload_register(function ($class_name) 
{
    //class directories
    $dir = '../';
    $directorys = array(
        'core/',
        'core/mvc/',
        'app/api/',
        'app/page/model/',
        'app/page/controll/',
        'app/page/view/',
        'app/user/model/',
        'app/user/controll/',
        'app/user/view/'
    );
    
    //for each directory
    foreach($directorys as $directory)
    {                   
        //$className = str_replace("/", "\\", $className);
        if(file_exists($dir.$directory.$class_name . '.php'))//see if the file exsists
        {
            require_once($dir.$directory.$class_name . '.php'); 
        }            
    }
});