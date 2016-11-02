<?php

class LoginModel {

    private $servername = config["MySQL"]["servername"];
    private $username = config["MySQL"]["username"];
    private $password = config["MySQL"]["password"];

    public function __construct() {
        //echo "Init Root Model </br>";
        //$this->getDataDB();
    }

    public function createAccount($email,$password){
        try{
            $conn = $this->getDataDB("onset");
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $conn->exec("INSERT INTO accounts (email, password) VALUES ('$email', '$hash')");
        }catch(PDOException $e)
        {
            trigger_error("<br>" . $e->getMessage(), E_USER_NOTICE);
        }
    }

    public function loginAccount($email,$password){

        try{
            $conn = $this->getDataDB("onset");
            $STH = $conn->query("SELECT * FROM accounts WHERE email='$email'");
            # setting the fetch mode
            $STH->setFetchMode(PDO::FETCH_OBJ);
            $row = $STH->fetch();

            if (password_verify($password, $row->password)) {
                echo 'Password is valid!';
                if (!session_id()) {
                    session_start();
                }
                $_SESSION['user_id'] = $row->user_id;
                $_SESSION['user_email'] = $row->email;
                
            } else {
                echo 'Invalid password.';
            }

        }catch(PDOException $e)
        {
            trigger_error("<br>" . $e->getMessage(), E_USER_NOTICE);
        }
      
    }

    private function getDataDB($dbname){
        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=$dbname", $this->username, $this->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connected successfully";
            return $conn;
            
        }
        catch(PDOException $e)
        {
            trigger_error("Connection failed: " . $e->getMessage(), E_USER_NOTICE);
        }
    }

}

