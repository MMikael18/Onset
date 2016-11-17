<?php

abstract class aApiControll{
    private $name;
    private $model;
    private $view;
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

    protected function getModel(){
        return isset($this->model) ? $this->model : null;
    }

    protected function setModel($model){
        $this->model = new $model();
    }
    
    protected function set($key, $value) {
        //var_dump($this->view->values);
        $this->values[$key] = $value;
    }

    protected function render($view = "") {
        // set view file path
        /*
        $file = "../app/user/view/".$view.".php";
        if(strlen($view) == 0){
            $file = "../app/user/view/".$this->name."View.php";
        }
        */
        // look id view exists
        if(!file_exists($file)){
            trigger_error("aApiControll failed to find view ".$file, E_USER_NOTICE);
            return;
        }
        // set view
        $view = new View($this->values);
        include($file);
    }
}