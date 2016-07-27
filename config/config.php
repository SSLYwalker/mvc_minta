<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$g_config['base_url'] = 'http://localhost/mvc_minta/';
$g_config['html_line_break'] = TRUE;
$g_config['log_level'] = LOGGER_DEBUG;

/*ROUTES   arr[a program belépési pontja(metódus)] = default_controller/index (='kontroller/a kontroller függvénye')*/
$g_config['routes']['default_program_method'] = 'default_controller/index';
$g_config['routes']['gyozi'] = 'default/okoska';
