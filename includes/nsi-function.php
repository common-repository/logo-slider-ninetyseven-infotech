<?php
/*
* Function to get shortcode designs
*/
function nsi_slider_designs() {
    $design_arr = array(
        'design-1'  => __('Design 1', 'wp-slick-slider-and-image-carousel'),
        'design-2'  => __('Design 2', 'wp-slick-slider-and-image-carousel'),
        'design-3'  => __('Design 3', 'wp-slick-slider-and-image-carousel'),
        'design-4' 	=> __('Design 4', 'wp-slick-slider-and-image-carousel'),
        'design-5' 	=> __('Design 5', 'wp-slick-slider-and-image-carousel'),
        'design-6' 	=> __('Design 6', 'wp-slick-slider-and-image-carousel'),
	);
	return apply_filters('nsi_slider_designs', $design_arr );
}


/*
* Sanitize Multiple HTML class
*/
function nsi_get_sanitize_html_classes($classes, $sep = " ") {
    $return = "";

    if( $classes && !is_array($classes) ) {
        $classes = explode($sep, $classes);
    }

    if( !empty($classes) ) {
        foreach($classes as $class){
            $return .= sanitize_html_class($class) . " ";
        }
        $return = trim( $return );
    }
    return $return;
}

/*
* Function to get Image Sizes array
*/
function nsi_logoslider_get_unique() {
    static $unique = 0;
    $unique++;

    // For Elementor & Beaver Builder
    if( ( defined('ELEMENTOR_PLUGIN_BASE') && isset( $_POST['action'] ) && $_POST['action'] == 'elementor_ajax' )
    || ( class_exists('FLBuilderModel') && ! empty( $_POST['fl_builder_data']['action'] ) )
    || ( function_exists('vc_is_inline') && vc_is_inline() ) ) {
        $unique = current_time('timestamp') . '-' . rand();
    }

    return $unique;
}

/*
*
*/
function nsi_logoslider_get_post_featured_image( $post_id = '', $size = 'full') {
    $size   = !empty($size) ? $size : 'full';
    $image  = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size );

    if( !empty($image) ) {
        $image = isset($image[0]) ? $image[0] : '';
    }
    return $image;
}