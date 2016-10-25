<?php

// USER INPUT
class FB_controll extends aControll{
    
    private $helper;
    private $fb;
    private $fbaccesstoken = "fb_access_token";

    public function __construct(aModel $model) {
        $this->model = $model;
        if (array_key_exists('fblogin',$_GET)){
            $this->model->loginCallBack();
        }else if(array_key_exists('fblogout',$_GET)){
            $this->model->Logout();
        }
    }
}
