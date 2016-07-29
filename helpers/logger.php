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
                add_line_to_log($loglevel, $message, $important, $fh);
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

function add_line_to_log($loglevel, $message, $important, $fh) {
    //   /*Az eredeti logmessage*/
    $logline = sprintf('%-7s', getloglevelname($loglevel)) . ' - ' . @date("Y-m-d H:i:s") . ' --> ' . $message; //. "\r\n";
    //    /*Az átalakítás után ez fog majd a logba kiíródni*/
    //    $new_logline = '';
    //    /*Segéd változó a daraboláshoz*/
    //   $temp_logline = '';
    //   /*A keresés kezdte innen, a string daraboláshoz lesz offset*/
    //   $start_pos = 0;
    //   /* \r\n pozíció*/
    //   $crlr_pos = FALSE;
    //  /* \n pozicio*/
    // $lr_pos = FALSE;
    // $lr_pos = strpos($logline, "\n");
    // $crlr_pos = strpos($logline, "\r\n");*/






    $longest = find_longest_substr($logline);
    print('AAAAAAAA leghosszabb: ' . $longest);

    if ($important) {

        //$linelength = strlen($logline) - 2;
        $markup = str_repeat('*', $longest + 2) . "\r\n";
        fputs($fh, $markup);
        fputs($fh, $logline);
        fputs($fh, $markup);
    } else {
        $logline = @sprintf('%-7s', getloglevelname($loglevel)) . ' - ' . @date("Y-m-d H:i:s") . ' --> ' . $message . "\r\n";
        fputs($fh, $logline);
    }
}

Function find_longest_substr($target_string) {
    $longest = 0;
    /* Segéd változó a daraboláshoz */
    $temp_logline = $target_string;
    print($temp_logline .'<br>');
   
    while (find_crlr_lr_cr($temp_logline)) {
        print(find_crlr_lr_cr($temp_logline));
        printf($found);
        switch ($found) {
            case 'CR':
                /* \r pozicio */
                $cr_pos = strpos($temp_logline, "\r");
                if ($longest < $cr_pos) {
                    $longest = $cr_pos;
                }
                $temp_logline = substr($temp_logline, ($crlr_pos + 1));
                break;
            case 'LR':
                /* \n pozicio */
                $lr_pos = strpos($temp_logline, "\n");
                 if ($longest < $lr_pos) {
                    $longest = $lr_pos;
                }
    //            print ('LR van<br>');
                $temp_logline = substr($temp_logline, ($lr_pos + 1));

                break;
            case 'CRLR':
                /* \r\n pozíció */
                $crlr_pos = strpos($temp_logline, "\r\n");
                print ('Mind két pozíció létezik<br>');
                if ($longest < $crlr_pos) {
                    $longest = $crlr_pos;
                    print('a leghosszabb: ' . $longest .'<br>' );
                }
                $temp_logline = substr($temp_logline, ($crlr_pos + 2));
                break;

            default:
                if($longest === 0 ){
                    $longest = strlen($target_string);
                }
                break;
        }
    }
    
    return $longest;
}

function find_crlr_lr_cr($target_string) {
    $found = FALSE;

    if ($target_string) {
       
        
        $cr_pos = strpos($target_string, "\r");
        $lr_pos = strpos($target_string, "\n");
        $crlr_pos = strpos($target_string, "\r\n");
        if($cr_pos !== FALSE && $cr_pos === $crlr_pos) {
             print ('IFFFFFFFFFFFFFFFFFFF');
            $found = 'CRLR';
        }
        else 
        {
            print('ELSSSSSSSSSEEE');
            $cr_lr_crlr_arr = array(
                'CR' => $cr_pos,
                'LR' => $lr_pos,
                'CRLR' => $crlr_pos
            );
        
            $found_array = array_keys($cr_lr_crlr_arr, min($cr_lr_crlr_arr));
            print_r($found_array);
            //print('sizeof' .sizeof($found_array));
            if(sizeof($found_array)  === 1){
                
                $found = $found_array[0];
            }
        }
        
    }
    var_dump($found);
    return $found;
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
            log_message(LOGGER_DEBUG, 'called function: ' . __FUNCTION__ . ' with $level=' . $g_logger_loglevel);
            return $old;
        }

    }
    $g_logger_inited = TRUE;
    setloglevel(LOGGER_DEBUG);
    //adddependency('logger', getloggerversion(), COMPONENT_HELPER, 'utils', '1.0.0.2', COMPONENT_HELPER);
}
