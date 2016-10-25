<?php

class Template {
    protected $file;
    protected $values = array();
  
    public function __construct($file) {
        $this->file = $file;
    }

    public function set($key, $value) {
        $this->values[$key] = $value;
    }

    public function getSubViews(){
        if (!file_exists($this->file)) {
            return "Error loading html file ($this->file).";
        }
        $output = file_get_contents($this->file);
        $output = str_replace('<', '&lt;', $output);
        $output = str_replace('>', '&gt;', $output);
        $actions = array();
        preg_match_all("/({:([^{]|)*})/", $output, $actions);
        
        return $actions[0];
    }
    
    public function output() {

        $a = $this->getSubViews();
        var_dump($a);
        
        if (!file_exists($this->file)) {
            return "Error loading html file ($this->file).";
        }
        $output = file_get_contents($this->file);
    
        foreach ($this->values as $key => $value) {
            $tagToReplace = "[:$key]";
            $output = str_replace($tagToReplace, $value, $output);
        }
        return $output;
    }
}