<?php

// USER INPUT
class Header extends aUserControll{

    function start (){}

    public function index($p) {
        //Debug::dump($this->getModel());

        if(isset($_SESSION['USER'])){
            $this->set("user",$_SESSION['USER']);
        }

        $this->render();

        
    }

    public function action($p) {
        echo "header -> action -> " . $p;
    }
}