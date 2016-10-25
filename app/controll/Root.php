<?php

// USER INPUT
class Root extends aControll{

    function controll (){

    }

    public function index($p) {
        echo "</br>Action index ".$p;
        $this->set("jaska","paska");
        $this->render();
    }

    public function action($i = "") {
        echo "</br>DefaultAction Controll -> Id ".$i;
    }
}