<?php

abstract class aControll{
    private $name;
    private $model;
    private $view;
    private $values = array();

    abstract protected function controll();
    abstract protected function index($params);

    public function __construct() {
        $this->name = get_class($this);
        
        if (class_exists($this->name."Model")) {
            $model = $this->name."Model";
            $this->model = new $model();
        }

    }
    
    public function set($key, $value) {
        //var_dump($this->view->values);
        $this->values[$key] = $value;
    }

    public function render($view = "") {
        // set view file path
        $file = "../app/view/".$view.".php";
        if(strlen($view) == 0){
            $file = "../app/view/".$this->name."View.php";
        }
        // look id view exists
        if(!file_exists($file)){
            trigger_error("aControll failed to find view ".$file, E_USER_NOTICE);
            return;
        }
        // set view
        $view = new View($this->values);
        include($file);
    }
}