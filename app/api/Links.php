<?php

// USER INPUT
class Links extends aApiControll{

    function start (){
        if (!isset($_SESSION['USER'])) {            
           header("Location:../login");
        }
    }

    public function index($p) {

        $lines = intval($p);
        

        $links = array(array('id' => 0, 'title' => 'Google'.$p , 'url' => 'https://www.google.fi'));
        for($i = 1; $i < $lines; ++$i) {
            array_push($links,  array('id' => $i, 'title' => 'JPPSoft Oy' , 'url' => 'https://www.jppsoft.fi'));
        }
        echo json_encode($links);
    }

}