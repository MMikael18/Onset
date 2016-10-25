<?php

// VIEW OUT
class Login_view extends aView{
    public function __construct(aModel $model) {
        $this->model = $model;
    }
    public function Render() {
        $data = '<div>';
        if($this->model->is_loged){
            $data .= '<img src="'.$this->model->userImage.'" />';
            $data .= '<span>'.$this->model->userName.'</span><br />';
            $data .= '<a href="'.$this->model->logoutUrl.'">'.$this->model->logout_text.'</a>';
        }else{
            $data .= '<a href="'.$this->model->loginUrl.'">'.$this->model->login_text.'</a>';
        }
        $data .= '</div>';
        return $data;
    }   
}