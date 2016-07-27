<?php

define('SIMPLE_CORE_INITED', TRUE);
require_once './helpers/constants.php';
require_once './config/config.php';
require_once './helpers/logger.php';
require_once './core/controller_base.php';
require_once './helpers/html.php'; /* Rajzolást segítő */
require_once './helpers/show_error.php'; /* Használja a rajzolást */

/*
 * 
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Simple_core {

    protected $m_controller_name;
    protected $m_method;
    protected $m_base_url;
    protected $m_parameters; /* Paramétertömb  név = érték */
    protected $m_function;
    protected $m_segments; /**/

    public function __construct() {
        log_message(LOGGER_INFO, 'Simple_core konstruktor start!');
        session_start();
        global $g_config;
        $this->m_base_url = $g_config['base_url'];
        $this->m_controller_name = 'default_controller';
        $this->m_method = 'index';
    }

    public function run() {
        $this->parse_http_get();
        $controllername=$this->m_controller_name;
        //print($controllername);
        require_once ('controllers/' . $controllername . '.php');
        $controller = new $controllername();
        $functionname=$this->m_function;
       
        $controller->$functionname();
    }

    protected function parse_http_get() {
        global $g_config;
        $current_url_host = filter_input(INPUT_SERVER, 'HTTP_HOST');
        $current_uri = filter_input(INPUT_SERVER, 'REQUEST_URI');
        $temporary_actual_url = $current_url_host . $current_uri;
        $temporary_base_url = substr($this->m_base_url, strpos($this->m_base_url, '://') + 3);
        if (substr($temporary_actual_url, 0, strlen($temporary_base_url)) == $temporary_base_url) {
            $temporary_actual_url = substr($temporary_actual_url, strlen($temporary_base_url));
            // Find m_parameters
            $poz = strpos($temporary_actual_url, '?');
            if ($poz !== FALSE) {
                $arr = explode('&', substr($temporary_actual_url, $poz + 1));
                foreach ($arr as $item) {
                    $par = explode('=', $item);
                    $this->m_parameters[] = array(
                        'name' => isset($par[0]) ? urldecode($par[0]) : '',
                        'value' => isset($par[1]) ? urldecode($par[1]) : ''
                    );
                }
                //print('<pre>found m_parameters=' . print_r($this->m_parameters, true) . '</pre>');
                log_message(LOGGER_INFO, 'found m_parameters=' . print_r($this->m_parameters, true));
                $temporary_actual_url = substr($temporary_actual_url, 0, strpos($temporary_actual_url, '?'));
            } else {
                $this->m_parameters = array();
            }

            if (!$temporary_actual_url || strtoupper($temporary_actual_url) == 'INDEX.PHP') { // Not found method
                $temporary_actual_url = 'default_program_method';
            } else {
                // remove index.php
                $temporary_actual_url = str_replace('index.php/', '', $temporary_actual_url);
                $temporary_actual_url = str_replace('index.php', '', $temporary_actual_url);
            }
            if (!$this->parsemethod($temporary_actual_url)) {
                /* Show error */
                $arr = explode('/', $temporary_actual_url);
                log_message(LOGGER_SYSTEM, print_r($arr[0], true) . ' method not found!');
                show_error('Hiba', ERR_UNK_METHOD, 'A következő metódus nem tlaálható: ' . $arr[0], SEVERITY_ERROR);
                exit();
            }
        } else {
            show_error('hiba', ERR_URL, 'Hibás url!', SEVERITY_ERROR);
            exit();
        }
    }

    protected function parsemethod($turl) {
        global $g_config;
        $retval = false;
        $urlarray = explode('/', $turl);
        // $urlarray[1] is the method name
        // Find method
        if (isset($urlarray [0])) {
            $this->m_method = $urlarray [0];
            //log_message ( LOGGER_INFO, 'found m_method=' . print_r ( $this->m_method, true ) );
            //$value = getinireqvalue ( 'config', 'config.ini', 'routes', $this->m_method );
            //print($this->m_method);
            if (isset($g_config['routes'][$this->m_method])) {
                $value = $g_config['routes'][$this->m_method];
                if ($value) {
                    $carr = explode('/', $value);
                    if (isset($carr [0])) {
                        $this->m_controller_name = urldecode($carr [0]);
                        log_message(LOGGER_INFO, 'found controller=' . print_r($this->controller, true));
                    }
                    if (isset($carr [1])) {
                        $this->m_function = $carr [1];
                        log_message(LOGGER_INFO, 'found functionname=' . print_r($this->functionname, true));
                    }
                    for ($index = 1; isset($urlarray [$index]); $index ++) {
                        $this->m_segments [] = urldecode($urlarray [$index]);
                    }
                    if (sizeof($this->m_segments)) {
                        log_message(LOGGER_INFO, 'found segments=' . print_r($this->segments, true));
                    }
                    $retval = true;
                }
            } else {
                print('jipppp');
                show_error('Hiba', ERR_UNK_ROUTE, 'Ismeretlen elérési út', SEVERITY_ERROR);
                exit();
            }
        }
        return $retval;
    }

}

$core = new Simple_core();
$core->run();

