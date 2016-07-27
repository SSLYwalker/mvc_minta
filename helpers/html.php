<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (! defined ( 'SIMPLE_CORE_INITED' ))
	exit ( 'No direct script access allowed' );

if (! function_exists ( 'GETBR' )) {
	function GETBR() {
            global $g_config;
            return $g_config['html_line_break'] ? "\r\n" : "";
	}
}

/**
 *  @brief Echo html begin 
 */
if ( ! function_exists('HTML_BEGIN')){
    function HTML_BEGIN()
    {
        echo '<!DOCTYPE html>'.GETBR();
        echo '<html>'.GETBR();
    }
}
/**
 *  @brief Echo html end 
 */
if ( ! function_exists('HTML_END')){
    function HTML_END()
    {
        echo '</html>'.GETBR();
    }
}

/**
 *  @brief Echo html head 
 *  
 *  @param [in] $codepage The html codepage. Default value is UTF-8.
 */
if ( ! function_exists('HEADER_BEGIN')){
    function HEADER_BEGIN($codepage='UTF-8')
    {
        echo '<head>'.GETBR();
        echo '<meta http-equiv="Content-Type" content="text/html; charset='.$codepage.'" >'.GETBR();
    }
}
/**
 *  @brief Echo html head end
 *
 *  @param [in] $codepage The html codepage. Default value is UTF-8.
 */
if ( ! function_exists('HEADER_END')){
	function HEADER_END()
	{
		echo '</head>'.GETBR();
	}
}
/**
 *  @brief Echo body begin
 */
if ( ! function_exists('BODY_BEGIN')){
    function BODY_BEGIN($tagid='', $tagclass='')
    {
        echo '<body '.        
        ($tagid!=''?'id="'.$tagid.'"':'').' '.
        ($tagclass!=''?'class="'.$tagclass.'"':'').
        '>'.GETBR();
    }
}
/**
 *  @brief Echo body end tag.
 */
if ( ! function_exists('BODY_END')){
	function BODY_END()
	{
		echo '</body>'.GETBR();
	}
}
/**
 *  @brief Echo div begin tag.
 */
if ( ! function_exists('DIV_BEGIN')){
	function DIV_BEGIN($tagid='', $tagclass='')
	{
        echo '<div '.        
        ($tagid!=''?'id="'.$tagid.'"':'').' '.
        ($tagclass!=''?'class="'.$tagclass.'"':'').
        '>'.GETBR();
	}
}
/**
 *  @brief Echo div end tag.
 */
if ( ! function_exists('DIV_END')){
    function DIV_END()
    {
        echo '</div>'.GETBR();
    }
}
/**
 *  @brief Echo link css tag.
 */
if ( ! function_exists('LINK_CSS')){
	function LINK_CSS($href)
	{
		echo '<link rel="stylesheet" type="text/css" href="'.$href.'">'.GETBR();
	}
}
 
/**
 *  @brief Echo header begin tag.
 */
if ( ! function_exists('H_BEGIN')){
	function H_BEGIN($headlevel, $tagid='', $tagclass='')
	{
		global $save_h_pos;
		$save_h_pos=$headlevel;		
		echo '<h' . $headlevel . ' ' . 
		($tagid != '' ? 'id="' . $tagid . '"' : '') . 
		' ' . 
		($tagclass != '' ? 'class="' . $tagclass . '"' : '') . '>' .GETBR();
	}
}
/**
 *  @brief Echo header end tag.
 */
if ( ! function_exists('H_END')){
	function H_END()
	{
		global $save_h_pos;
		echo '</h'.$save_h_pos.'>'.GETBR();
	}
}
/**
 *  @brief Echo anchor tag.
 */
if (! function_exists ( 'ANCHOR' )) {
	function ANCHOR($href='#', $text='', $target='_self', $tagid = '', $tagclass = '') {
		echo 
			'<a ' . 
			($target != '' ? 'target="' . $target . '"' : '') . 
			' ' . 
			($tagid != '' ? 'id="' . $tagid . '"' : '') . 
			' ' . 
			($tagclass != '' ? 'class="' . $tagclass . '"' : '') .
			' href="'.$href.'"'.
			'>'.$text.'</a>' .GETBR();
	}
}
/**
 *  @brief Echo break tag.
 */
if (! function_exists ( 'BR' )) {
	function BR($tagid = '', $tagclass = '') {
		echo
		'<br ' .
		($tagid != '' ? 'id="' . $tagid . '"' : '') .
		' ' .
		($tagclass != '' ? 'class="' . $tagclass . '"' : ''). '>' .GETBR();
	}
}
/**
 *  @brief Echo button 
 */
if (! function_exists ( 'BUTTON' )) {
	function BUTTON($href='', $text='', $tagid = '', $tagclass = '') {
		echo
		'<button ' .
		' onclick="location.href=\''.$href.'\'" '.
		' ' .
		($tagid != '' ? 'id="' . $tagid . '"' : '') .
		' ' .
		($tagclass != '' ? 'class="' . $tagclass . '"' : '') .
		'>'.$text.'</button>' .GETBR();
	}
}
/**
 *  @brief Echo body begin
 */
if ( ! function_exists('SPAN_BEGIN')){
	function SPAN_BEGIN($tagid='', $tagclass='')
	{
		echo '<span '.
				($tagid!=''?'id="'.$tagid.'"':'').' '.
				($tagclass!=''?'class="'.$tagclass.'"':'').
				'>'.GETBR();
	}
}
/**
 *  @brief Echo body end tag.
 */
if ( ! function_exists('SPAN_END')){
	function SPAN_END()
	{
		echo '</span>'.GETBR();
	}
}
/**
 *  @brief Add meta
 */
if ( ! function_exists('META')){
	function META($data)
	{
		echo '<meta '.$data.'>'.GETBR();
	}
}
/**
 *  @brief UL begin tag
 */
if ( ! function_exists('UL_BEGIN')){
	function UL_BEGIN($tagid = '', $tagclass = '', $additional='') {
		echo
		'<UL ' .
		($tagid != '' ? 'id="' . $tagid . '"' : '') .
		' ' .
		($tagclass != '' ? 'class="' . $tagclass . '"' : ''). ' '.$additional.'>' .GETBR();
	}
}
/**
 *  @brief UL end tag
 */
if ( ! function_exists('UL_END')){
	function UL_END() {
		echo '</UL>' .GETBR();
	}
}
/**
 *  @brief LI begin tag
 */
if ( ! function_exists('LI_BEGIN')){
	function LI_BEGIN($tagid = '', $tagclass = '', $additional='') {
		echo
		'<li ' .
		($tagid != '' ? 'id="' . $tagid . '"' : '') .
		' ' .
		($tagclass != '' ? 'class="' . $tagclass . '"' : ''). ' '.$additional.'>' .GETBR();
	}
}
/**
 *  @brief LI end tag
 */
if ( ! function_exists('LI_END')){
	function LI_END() {
		echo '</li>' .GETBR();
	}
}
/**
 *  @brief Load svg image. If it is not success then try to load png. For example:
 *  if logo.svg is can not load try to load logo.png   
 */
if (! function_exists ( 'SVG' )) {
	function SVG($name, $tagid = '', $tagclass = '', $additional='') {
		$name = geteasy()->getbaseurl() . 'images/logo';
		echo '<img '.
		($tagid != '' ? 'id="' . $tagid . '"' : '') .
		' ' . ($tagclass != '' ? 'class="' . $tagclass . '"' : '').
		' src="' . $name . '.svg" onerror="this.onerror=null; this.src=\'' . $name . '.png\'" '.$additional.'/>';
	}
}
