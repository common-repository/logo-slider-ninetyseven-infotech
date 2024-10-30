<?php
/*

Plugin Name: Logo Slider Ninetyseven Infotech
Plugin URI: https://ninetyseveninfotech.com/logo-slider
Text Domain: logo-slider-ninetyseveninfotech
Description: Logo Slider Ninetyseven Infotech | Logo Slider Ninetyseven Infotech is the best Logo slider and Logo carousel plugin available for displaying your Logo's.
Version: 1.0
Author: Ninetyseven Infotech
Author URI: https://ninetyseveninfotech.com 
License: GPLv2 or later 

Developer: 
Ninetyseven Infotech
ninetyseveninfotech@gmail.com 
Blog: https://ninetyseveninfotech.com/blog
Instagram : https://www.instagram.com/ninetyseveninfotech/
Facebook : https://www.facebook.com/ninetyseveninfotech
LinkedIn: https://www.linkedin.com/in/ninetyseven-infotech-71820219b/
*/
 
/**
* Protect From Direct Access
*/
if(!defined('ABSPATH')){
  exit;
}

/**
* Defining Constants
*/
if(!defined('NSI_HACK_MSG')) define('NSI_HACK_MSG', __( 'Silence is Golden'));
if(!defined('NSI_PLUGIN_DIR')) define('NSI_PLUGIN_DIR', plugin_dir_path( __FILE__ ));
if(!defined('NSI_PLUGIN_URI')) define('NSI_PLUGIN_URI', plugins_url('', __FILE__ ));
if(!defined('NSI_VERSION')) define('WPSISAC_VERSION', '1.0');

/*
* Admin process File
*/
require_once NSI_PLUGIN_DIR . 'includes/nsi-logo-cpt.php';
require_once NSI_PLUGIN_DIR . 'includes/nsi-logo-metabox.php';

/*
* Function File
*/
require_once NSI_PLUGIN_DIR . '/includes/nsi-function.php';

/*
* Fronted process File
*/
require_once NSI_PLUGIN_DIR . '/includes/nsi-class-script.php';
require_once NSI_PLUGIN_DIR . '/shortcode/nsi-carousel.php';

/*
* Deactive Hook
*/
register_deactivation_hook( __FILE__, 'nsi_logoslider_uninstall');
function nsi_logoslider_uninstall() {
	// Need to Flush Rules for Custom Registered Post Type
	flush_rewrite_rules();
}