<?php

class LoginModel extends aModel{

    public function __construct() {
        //echo "Init Root Model </br>";
        //$this->getDataDB();
    }

    public function createAccount($email,$password){
        try{
            $conn = $this->getDataDB("users");
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $conn->exec("INSERT INTO accounts (email, password) VALUES ('$email', '$hash')");
        }catch(PDOException $e)
        {
            trigger_error("<br>" . $e->getMessage(), E_USER_NOTICE);
        }
    }

    public function loginAccount($email,$password){

        try{
            $conn = $this->getDataDB("users");
            $STH = $conn->query("SELECT * FROM accounts WHERE email='$email'");
            # setting the fetch mode
            $STH->setFetchMode(PDO::FETCH_OBJ);
            $row = $STH->fetch();

            if (password_verify($password, $row->password)) {
                echo 'Password is valid!';
                if (!session_id()) {
                    session_start();
                }
                $_SESSION['USER'] = [
                    "id"=>$row->user_id,
                    "email"=>$row->email
                    ];                
            } else {
                echo 'Invalid password.';
            }

        }catch(PDOException $e)
        {
            trigger_error("<br>" . $e->getMessage(), E_USER_NOTICE);
        }
      
    }

}
