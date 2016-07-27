<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of controller_base
 *
 * @author ozep
 */
class controller_base {

    public function __construct() {
        
    }

    public function load_view($view_name) {
        require_once ('views/' . $view_name . '.php');
    }

    public function &load_model($model_name) {
        $modelname = $model_name . '_model';
        require_once ('models/' . $modelname . '.php');
        //print($modelname);
        $model = new $modelname();
        return $model;
    }

}
