<?php




class default_controller extends controller_base{
    public $parameters;
    public function __construct() {
        
    }
    
    public function index(){
       //print ('az index metódust hívtuk meg a defult_controllerben');
        //log_message(LOGGER_INFO, 'called function: ' . __FUNCTION__ . '  a defult_controllerben', TRUE);
    }
    
    public function okoska(){
       // log_message(LOGGER_INFO, 'called function: ' . __FUNCTION__ . '  a defult_controllerben');
        $default_model = $this->load_model('default');
        $this->parameters = array('name' => $default_model->get_name());
        $this->load_view('okoska');
        
    }
}