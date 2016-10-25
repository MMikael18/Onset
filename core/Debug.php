<?php

class Debug{
    
    public static function dump($obj,$title = "title"){
        if($title != "title") echo "<h3>".$title."</h3>";
        echo "<pre>". var_export($obj,true)."</pre>";
    }
}