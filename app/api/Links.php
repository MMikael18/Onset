<?php

// USER INPUT
class Links extends aApiControll{

    function start (){
        if (!isset($_SESSION['USER'])) {            
           header("Location:../login");
        }
    }

    public function index($p) {
        /*
        $lines = intval($p);
        
        $exp_item = array('id' => 0, 'title' => 'Google'.$p , 'url' => 'https://www.google.fi');

        $links = array($exp_item);
        for($i = 1; $i < $lines; ++$i) {
            array_push($links,  array('id' => $i, 'title' => 'JPPSoft Oy' , 'url' => 'https://www.jppsoft.fi'));
        }
        echo json_encode($links);
        */
    }

    public function get($p) {

        $lines = intval($p);
        
        $exp_item = $this->ext_line(0);

        $links = array($exp_item);
        for($i = 1; $i < $lines; ++$i) {
            array_push($links, $this->ext_line($i));
        }
        echo json_encode($links);
    }

    private function ext_line($i){
        return array(
            'id' => $i, 
            'title' => 'Google', 
            'url' => 'https://www.google.fi',
            'date' => date("Y.m.d"),
            'description' => 'kldjföalksj dfölakjsdfö lkajsdfölk ajsdöflk jaösdlfkj',
            'tags' =>  array('app','log','page','artikle'),
            );
    }
}