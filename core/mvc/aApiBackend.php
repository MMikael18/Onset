<?php

abstract class aApiBackend{
    private $name;
    private $values = array();

    abstract protected function start();
    abstract protected function index($params);

    public function __construct() {
        $this->name = get_class($this);
        if (class_exists($this->name."Model")) {
            $model = $this->name."Model";
            $this->model = new $model();
        }
        $this->start();
    }
    
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