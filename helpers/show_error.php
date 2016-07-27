<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (! defined ( 'SIMPLE_CORE_INITED' ))
	exit ( 'No direct script access allowed' );

if ( ! function_exists('show_error')){
	function show_error($caption, $error_number, $error_text, $error_severity)
	{
            global $g_config;
            HTML_BEGIN();
            HEADER_BEGIN();
            LINK_CSS($g_config['base_url'] . 'css/default.css');
            HEADER_END();
            BODY_BEGIN();
            
            DIV_BEGIN('Error_div', 'error-div-class');
                DIV_BEGIN('Error_div_caption');
                SPAN_BEGIN('error_div_capiton_span');
                    print($caption);
                SPAN_END();
                DIV_END();
                DIV_BEGIN('error_div_content');
                    print('hiba részletei: ' . 'hibakód: ' . $error_number. ', hibaszöveg: ' . $error_text. ', hiba szint: ' . $error_severity);
                    DIV_END();
            DIV_END();
            BODY_END();
            HTML_END();
	}
}

	

