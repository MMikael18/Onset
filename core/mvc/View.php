<?php

class View{
    private $values = array();

    public function __construct($v) {
        $this->values = $v;
    }

    public function get($v){
        return $this->values[$v];
    }
}