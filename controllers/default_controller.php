<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class default_controller extends controller_base{
    public $parameters;
    public function __construct() {
        
    }
    
    public function index(){
       print ('az index metódust hívtuk meg a defult_controllerben');
        log_message(LOGGER_INFO, 'called function: ' . __FUNCTION__ . '  a defult_controllerben');
    }
    
    public function okoska(){
        log_message(LOGGER_INFO, 'called function: ' . __FUNCTION__ . '  a defult_controllerben');
        $default_model = $this->load_model('default');
        $this->parameters = array('name' => $default_model->get_name());
        $this->load_view('okoska');
        
    }
}