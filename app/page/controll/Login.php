<?php

// USER INPUT
class Login extends aControll{

    function start (){}

    public function index($p) {
        if (isset($_SESSION['user_id'])) {
            header("Location:../");
        }
        $this->set("action","singIn");
        $this->set("title","Sing in");
        $this->render("SingIn");
    }

    public function startSingUp(){
        $this->set("action","singUp");
        $this->set("title","Sing up");
        $this->render("SingUp");
    }

    public function singUp() {
        Form::validPost($_POST);
        if( !isset($_POST['email'])    || 
            !isset($_POST['password']) ||
            !isset($_POST['emailre'])  || 
            !isset($_POST['passwordre'])
            ){
                trigger_error("Login view don't post all values", E_USER_NOTICE);                
                return;
            }

        $isEmailValid = false;
        $isPassWordValid = false;
        // Is email valid            
        if($_POST['email'] == $_POST['emailre']){
            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $isEmailValid = true;
            }
        }
        // Is password valid            
        if($_POST['password'] == $_POST['passwordre']){
            if (strlen($_POST['password']) > 7) {
                $isPassWordValid = true;
            }
        }
        // If ok create account
        if($isEmailValid && $isPassWordValid){
            $this->getModel()->createAccount($_POST['email'],$_POST['password']);
            return;
        }
        trigger_error("The form data sent is incorrect.", E_USER_NOTICE);                
    }

    public function singIn() {
        Form::validPost($_POST);
        if( !isset($_POST['email']) || 
            !isset($_POST['password'])){
                trigger_error("Login view don't post all values", E_USER_NOTICE);                
                return;
        }
        $this->getModel()->loginAccount($_POST['email'],$_POST['password']);
        header("Location:../");
    }

     public function LoginOut(){
        session_destroy();
        header("Location:../");
    }
}