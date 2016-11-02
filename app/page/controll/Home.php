<?php

// USER INPUT
class Home extends aControll{

    function start (){
        if (!session_id()) {
            session_start();
        }
    }

    public function index($p) {
       
        if (isset($_SESSION['user_id'])) {            
           $this->render();
        }else{
            header("Location:../login");
        }
        
    }

}