<?php

// USER INPUT
class Home extends aControll{

    function start (){}

    public function index($p) {
        if (isset($_SESSION['USER'])) {            
           $this->render();
        }else{
            header("Location:../login");
        }   
    }

}