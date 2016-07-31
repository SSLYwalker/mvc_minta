<?php

if (!defined('SIMPLE_CORE_INITED'))
    exit('No direct script access allowed');
/**
 *  @file logger.php
 *  @brief Logger helper 
 *  @author Vajay Attila (https://github.com/vajayattila/easyphpframe/)
 *  @email vajay.attila@gmail.com
 *  @date 2014-07-29
 *  @copyright MIT License (MIT)
 */
/**
 *  @brief Get log level name
 *  
 *  @param [in] $loglevel 
 *  @retval Loglevel name string
 */
if (!function_exists('getloglevelname')) {

    function getloglevelname($loglevel) {
        $retval = '';
        switch ($loglevel) {
            case LOGGER_DISABLED:
                $retval = "DISABLED";
                break;
            case LOGGER_ERROR:
                $retval = "ERROR";
                break;
            case LOGGER_WARNING:
                $retval = "WARNING";
                break;
            case LOGGER_INFO:
                $retval = "INFO";
                break;
            case LOGGER_DEBUG:
                $retval = "DEBUG";
                break;
            case LOGGER_SYSTEM:
                $retval = "SYSTEM";
                break;
            default:
                $retval = "UNKNOWN";
        }
        return $retval;
    }

}

/**
 *  @brief Log message
 *  
 *  @param [in] $loglevel 
 *  @param [in] $message
 *  @param [in] $important If this value is TRUE the logmessage will be 
 *              marked up with * characters
 */
if (!function_exists('log_message')) {

    function log_message($loglevel, $message, $important = FALSE) {
        global $g_config;
        $g_logger_loglevel = &$g_config['log_level'];

        if (!isset($g_logger_loglevel)) {
            $g_logger_loglevel = LOGGER_DISABLED;
        }
        if ($loglevel <= $g_logger_loglevel && $loglevel != LOGGER_DISABLED) {
            $fh = open_logfile();
            if ($fh) {
                $logline = sprintf('%-7s', getloglevelname($loglevel)) . ' - ' . @date("Y-m-d H:i:s") . ' --> ' . $message . "\r\n";
                add_line_to_log($logline, $important, $fh);
                fclose($fh);
            }
        }
    }

}

/**
 *  @brief Log message
 *  
 *  @param [in] $loglevel 
 *  @param [in] $message
 *  @param [in] $important If this value is TRUE the logmessage will be 
 *              marked up with * characters
 */
function open_logfile() {
    // check log folder
    if (!file_exists('logs')) {
        mkdir('logs', 0777, true);
    }
    // log file name
    $filename = 'log-' . date("Y-m-d") . '.log';
    $fh = fopen('logs/' . $filename, 'a');
    return $fh;
}

function add_line_to_log($target_string, $important, $fh) {
    //   /*Az eredeti logmessage*/
    $logline = $target_string;
   
    $longest = find_longest_substr($logline);
    //print('AAAAAAAA leghosszabb: ' . $longest);

    if ($important) {
        print('- important -<br>');
        //$linelength = strlen($logline) - 2;
        if($longest == 0){
            $markup = str_repeat('*', strlen($logline) + 2) . "\r\n";
        } else {
            $markup = str_repeat('*', $longest + 4) . "\r\n";
        }
        
        fputs($fh, $markup);
        fputs($fh, add_markup_to_logline($logline, $longest));
        fputs($fh, $markup);
    } else {
        print('- NEM important -<br>');
        //$logline = @sprintf('%-7s', getloglevelname($loglevel)) . ' - ' . @date("Y-m-d H:i:s") . ' --> ' . $message . "\r\n";
        fputs($fh, $logline);
    }
}

Function find_longest_substr($target_string) {
    $longest = 0;
    /** Segéd változó a daraboláshoz */
    $temp_logline = $target_string;
    //print($temp_logline .'<br>');
    $lbr_arr = find_next_lbr($temp_logline);
    while (list($next_lbr_type, $next_lbr_pos) = each($lbr_arr)) {
        if($next_lbr_pos > $longest){
            $longest = $next_lbr_pos;
            if($next_lbr_type === 'CRLR'){
                $temp_logline = substr($temp_logline, ($next_lbr_pos + 2));
            } else {
                $temp_logline = substr($temp_logline, ($next_lbr_pos + 1));
            }
        }
    }
    return $longest;
}

function find_next_lbr($target_string) {
    $next_lbr_arr = FALSE;
    $found_arr = array();
    if ($target_string) {
        $cr_pos = strpos($target_string, "\r");
        $lr_pos = strpos($target_string, "\n");
        $crlr_pos = strpos($target_string, "\r\n");
        $next_lbr_arr = array();
        if($cr_pos != FALSE && $cr_pos != $crlr_pos){
            $found_arr['CR'] = $cr_pos;
        }
        if($lr_pos != FALSE){
            $found_arr['LR'] = $lr_pos;
        }
        if($crlr_pos !== FALSE){
            $found_arr['CRLR'] = $crlr_pos;
        }
        if(sizeof($found_arr) > 0){
            $next_lbr_value = min($found_arr);
            $next_lbr_type = array_search($next_lbr_value, $found_arr); 
            $next_lbr_arr = array($next_lbr_type => $next_lbr_value);
        }
    }    
    return $next_lbr_arr;
}

function add_markup_to_logline($target_string, $longest) {
    
    /** Segéd változó a daraboláshoz */
    $temp_logline = $target_string;
    print($temp_logline .'<br>');
   if(find_next_lbr($temp_logline)){
       $logline = '* ';
       $lbr_arr = find_next_lbr($temp_logline);
       
    while (is_array($lbr_arr) && list($next_lbr_type, $next_lbr_pos) = each($lbr_arr)) {
        print($next_lbr_type . ' <- type and pos -> ' . $next_lbr_pos . '<br>');
        switch ($next_lbr_type) {
            case 'CR':
                /* \r pozicio */
                $logline .= substr($temp_logline, 0 , $next_lbr_pos) . str_repeat(' ', $longest - $next_lbr_pos) . " *\r";
                print($logline . '<br>');
                $temp_logline = substr($temp_logline, ($next_lbr_pos + 1));
                $lbr_arr = find_next_lbr($temp_logline);
                break;
            case 'LR':
                /* \n pozicio */
                $logline .= '* ' . substr($temp_logline, 0 , $next_lbr_pos) . str_repeat(' ', $longest - $next_lbr_pos) . " *\n";
                print($logline . '<br>');
                $temp_logline = substr($temp_logline, ($next_lbr_pos + 1));
                $lbr_arr = find_next_lbr($temp_logline);
                break;
            case 'CRLR':
                /* \r\n pozíció */
                $logline .= substr($temp_logline, 0 , $next_lbr_pos). str_repeat(' ', $longest - $next_lbr_pos)  . " *\r\n";
                print($logline . '<br>');
                $temp_logline = substr($temp_logline, ($next_lbr_pos + 2));
                $lbr_arr = find_next_lbr($temp_logline);
                break;
        }  
    }
   } else {
       $logline = '* ' . $temp_logline;
   }
   $logline .= " *\r\n";
   return $logline;
}

if (!defined('logger_inited')) {
    global $g_config;
    define('logger_inited', true);
    $g_logger_loglevel = &$g_config['log_level'];
    global $g_logger_inited;
    /**
     *  @brief Get logger version
     *  
     *  @retval logger version
     */
    if (!function_exists('getloggerversion')) {

        function getloggerversion() {
            return '1.0.0.2';
        }

    }
    if (!function_exists('setloglevel')) {

        /**
         *  @brief Setting log level
         *  
         *  @param [in] $level new log level
         *  @return old log level
         */
        function setloglevel($level) {
            $g_logger_loglevel = &$g_config['log_level'];
            $old = $g_logger_loglevel;
            $g_logger_loglevel = intval($level);
            log_message(LOGGER_DEBUG, 'called function: ' . __FUNCTION__ . ' with $level=' . $g_logger_loglevel, TRUE);
            return $old;
        }

    }
    $g_logger_inited = TRUE;
    setloglevel(LOGGER_DEBUG);
    //adddependency('logger', getloggerversion(), COMPONENT_HELPER, 'utils', '1.0.0.2', COMPONENT_HELPER);
}
