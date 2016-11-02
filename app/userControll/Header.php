<?php

// USER INPUT
class Header extends aUserControll{

    function start (){
        if (!session_id()) {
            session_start();
        }
    }

    public function index($p) {
        echo "header controll";
    }

    public function action($p) {
        echo "header -> action -> " . $p;
    }
}