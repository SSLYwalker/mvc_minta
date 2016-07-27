<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of default_model
 *
 * @author ozep
 */
class default_model {
    public function __construct() {
    log_message(LOGGER_INFO, 'called function: ' . __FUNCTION__ . '  a defult_modelben');    
    }
     
    public function get_name(){
        log_message(LOGGER_INFO, 'called function: ' . __FUNCTION__ . '  a defult_modelben');    
        return 'Vitézke László';
    }
}
