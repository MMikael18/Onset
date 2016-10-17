<?php

// VIEW OUT
class Login_view extends aViewCore{
    public function __construct(FB_model $model) {
        $this->model = $model;
    }
    public function Render() {
        echo '<div>';
        if($this->model->is_loged){
            echo '<img src="'.$this->model->userImage.'" />';
            echo '<span>'.$this->model->userName.'</span><br />';
            echo '<a href="'.$this->model->logoutUrl.'">'.$this->model->logout_text.'</a>';
        }else{
            echo '<a href="'.$this->model->loginUrl.'">'.$this->model->login_text.'</a>';
        }
        echo '</div>';
    }   
}