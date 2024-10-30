<?php
/*
* Script Class
*/

if(!defined('ABSPATH')){
	exit;
}
function register_script_for_slider(){
	if(!wp_style_is( 'wpos-slick-style', 'registered' ) ) {
		wp_register_style( 'wpos-slick-style', NSI_PLUGIN_URI.'/assets/css/slick.css');
	}
	wp_enqueue_style('wpos-slick-style');

	// Registring and enqueing public css
	wp_register_style( 'wpsisac-public-style', NSI_PLUGIN_URI.'/assets/css/slick-slider-style.css');
	wp_enqueue_style( 'wpsisac-public-style' );

	if(!wp_script_is('wpos-slick-jquery','registered')){
		wp_register_script( 'wpos-slick-jquery', NSI_PLUGIN_URI.'/assets/js/slick.min.js', array('jquery'));
	}	

	// Registring and enqueing public script
	wp_register_script( 'wpsisac-public-script', NSI_PLUGIN_URI.'/assets/js/wpsisac-public.js', array('jquery'));
}
add_action('init','register_script_for_slider');