<?php

Class Form {

    public static function validPost(&$post){
        foreach( $post as $key => $value){
            $post[$key] = Form::test_input($value);
            //$array[$key] = "jaska";
        }
    }

    public static function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}