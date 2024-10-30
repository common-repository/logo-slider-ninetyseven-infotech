<?php

/**
* Protect From Direct Access
*/

if (!defined('ABSPATH')) die(NSI_HACK_MSG);

/**
* Registers a new post type
* @uses $wp_post_types Inserts new post type object into the list
*
* @param string Post type key, must not exceed 20 characters
* @param array|string  See optional args description above.
* @return object|WP_Error the registered post type object, or an error object
*/

/**
* Logo Custom Post Type 
*/
function NSI_Logo_Slider() {
	$labels = array(
		'name'               	=> _x( 'Logos', 'nsilogo' ),
		'singular_name'      	=> _x( 'Logo', 'nsilogo' ),
		'menu_name'          	=> _x( 'Logo Slider', 'admin menu', 'nsilogo' ),
		'name_admin_bar'     	=> _x( 'Logo Slider', 'add new on admin bar', 'nsilogo' ),
		'add_new'            	=> _x( 'Add New Logo', 'logo', 'nsilogo' ),
		'add_new_item'       	=> __( 'Add New Logo', 'nsilogo' ),
		'new_item'           	=> __( 'New Logo', 'nsilogo' ),
		'edit_item'          	=> __( 'Edit Logo', 'nsilogo' ),
		'view_item'          	=> __( 'View Logo', 'nsilogo' ),
		'all_items'          	=> __( 'All Logos', 'nsilogo' ),
		'search_items'       	=> __( 'Search Logos', 'nsilogo' ),
		'parent_item_colon'  	=> __( 'Parent Logos:', 'nsilogo' ),
		'not_found'          	=> __( 'No logos found.', 'nsilogo' ),
		'not_found_in_trash' 	=> __( 'No logos found in Trash.', 'nsilogo' ),
		'featured_image'     	=> __( 'Add Logo', 'nsilogo' ),
		'set_featured_image'    => __( 'Add New Logo', 'nsilogo' ),
		'remove_featured_image' => __( 'Remove This Logo', 'nsilogo' ),
		'use_featured_image'    => __( 'Use This Logo', 'nsilogo' ),
	);

	$args = array(
		'labels'             	=> $labels,
		'show_ui'            	=> true,
		'exclude_from_search' 	=> true,
		'public'            	=> false,
		'has_archive'       	=> false,
		'hierarchical'       	=> false,
		'capability_type'    	=> 'post',
		'menu_icon'          	=> 'dashicons-admin-users',
		'supports'           	=> array( 'title', 'editor', 'thumbnail')
	);
	// Register Post Type
	register_post_type( 'nsi-logo-slider', $args );
}
add_action( 'init', 'NSI_Logo_Slider' );

/**
* Logo Taxonomy 
*/
if (!function_exists('nsi_logo_category')){
	// Register Logo Slider Taxonomy
	function nsi_logo_category() {
		$labels = array(
			'name'                       => _x( 'Logo Categories', 'Taxonomy General Name', 'nsilogo' ),
			'singular_name'              => _x( 'Logo Category', 'Taxonomy Singular Name', 'nsilogo' ),
			'menu_name'                  => __( 'Logo Category', 'nsilogo' ),
			'all_items'                  => __( 'All Logo Category', 'nsilogo' ),
			'parent_item'                => __( 'Parent Logo Category', 'nsilogo' ),
			'parent_item_colon'          => __( 'Parent Logo Category:', 'nsilogo' ),
			'new_item_name'              => __( 'New Logo Category', 'nsilogo' ),
			'add_new_item'               => __( 'Add New Logo Category', 'nsilogo' ),
			'edit_item'                  => __( 'Edit Logo Category', 'nsilogo' ),
			'update_item'                => __( 'Update Logo Category', 'nsilogo' ),
			'separate_items_with_commas' => __( 'Separate Logo Category with commas', 'nsilogo' ),
			'search_items'               => __( 'Search Logo Category', 'nsilogo' ),
			'add_or_remove_items'        => __( 'Add or remove Logo Category', 'nsilogo' ),
			'choose_from_most_used'      => __( 'Choose from the most used Logo categories', 'nsilogo' ),
			'not_found'                  => __( 'Not Found', 'nsilogo' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => false,
			'show_ui'                    => true,
			'show_admin_column'          => true,			
			'show_tagcloud'              => false,
		);
		// Register Categories for Logo
		register_taxonomy( 'logo-category', array( 'nsi-logo-slider' ), $args );
	}	
	add_action( 'init', 'nsi_logo_category', 0 );
}

// Register Theme Features (feature image for Logo)
if (!function_exists('nsi_logo_theme_support') ) {

	function nsi_logo_theme_support()  {
		// Add Theme Support for Featured Images
		add_theme_support('post-thumbnails', array('nsi-logo-slider' ) );
		add_theme_support('post-thumbnails', array('post') ); // Add it for posts
		add_theme_support('post-thumbnails', array('page') ); // Add it for pages
		add_theme_support('post-thumbnails', array('product') ); // Add it for products
		add_theme_support('post-thumbnails');
		// Add Shortcode support in text widget
		add_filter('widget_text', 'do_shortcode'); 
	}
	// Hook this After Setup Theme action
	add_action( 'after_setup_theme', 'nsi_logo_theme_support' );
}