<?php

abstract class aModel
{   
    protected $servername = config["MySQL"]["servername"];
    protected $username = config["MySQL"]["username"];
    protected $password = config["MySQL"]["password"];

    protected function getDataDB($dbname){
        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=$dbname", $this->username, $this->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connected successfully";
            return $conn;            
        }
        catch(PDOException $e)
        {
            trigger_error("MySQL connection failed: " . $e->getMessage(), E_USER_NOTICE);
        }
    }
}
