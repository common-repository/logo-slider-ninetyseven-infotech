<?php 
/**
* Slick Carousel Slider Shortcode
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function nsi_fetch_logo_slider( $atts, $content = null ){

	// All Parameter for Shortcode
	extract(shortcode_atts(array(
		'limit'				=> '-1',
		'category' 			=> '',
		'design' 			=> 'design-1',
		'image_size' 		=> 'full',
		'slidestoshow' 		=> 4,
		'slidestoscroll' 	=> 1,
		'dots' 				=> 'true',
		'arrows'			=> 'true',
		'autoplay'			=> 'true',
		'loop'				=> 'true',
		'hover_pause'		=> 'true',
		'autoplay_interval'	=> 3000,
		'speed'				=> 300,
		'centermode'		=> 'false',
		'variablewidth'		=> 'false',
		'image_fit' 		=> 'false',
		'sliderheight'		=> '',
		'lazyload'			=> '',
		'rtl'				=> '',
		'extra_class'		=> '',
		'className'			=> '',
		'align'				=> '',
	), $atts, 'slick-carousel-slider'));

	$shortcode_designs 	= nsi_slider_designs();
	$limit 				= !empty($limit) 				? $limit 								: '-1';
	$cat 				= (!empty($category)) 			? explode(',', $category) 				: '';
	$slidestoshow 		= !empty($slidestoshow) 		? $slidestoshow 						: 3;
	$slidestoscroll 	= !empty($slidestoscroll) 		? $slidestoscroll 						: 1;
	$dots 				= ($dots == 'false') 			? 'false' 								: 'true';
	$arrows 			= ($arrows == 'false') 			? 'false' 								: 'true';
	$autoplay 			= ($autoplay == 'false') 		? 'false' 								: 'true';
	$loop 				= ($loop == 'false') 			? 'false' 								: 'true';
	$hover_pause 		= ($hover_pause == 'false') 	? 'false' 								: 'true';
	$autoplay_interval 	= (!empty($autoplay_interval)) 	? $autoplay_interval 					: 3000;
	$speed 				= (!empty($speed)) 				? $speed 								: 300;
	$sliderheight 		= (!empty($sliderheight)) 		? $sliderheight 						: '';
	$slider_height_css 	= (!empty($sliderheight))		? "style='height:{$sliderheight}px;'" 	: '';
	$lazyload 			= ($lazyload == 'ondemand' || $lazyload == 'progressive' ) ? $lazyload 	: ''; // ondemand or progressive
	$image_fit			= ($image_fit == 'false')		? 0										: 1;
	$centermode 		= ($centermode == 'false') 		? 'false' 								: 'true';
	$variablewidth 		= ($variablewidth == 'false') 	? 'false' 								: 'true';
	$sliderimage_size 	= !empty($image_size) 			? $image_size 							: 'full';
	$align				= (!empty($align))				? 'align'.$align						: '';
	$extra_class		= $align .' '. nsi_get_sanitize_html_classes($className);

	// For RTL
	if( empty($rtl) && is_rtl() ) {
		$rtl = 'true';
	} elseif ( $rtl == 'true' ) {
		$rtl = 'true';
	} else {
		$rtl = 'false';
	}

	// Shortcode file
	$design_file_path 	= NSI_PLUGIN_DIR . '/templates/' . $design . '.php';
	$design_file 		= (file_exists($design_file_path)) ? $design_file_path : '';

	// Enqueus required script
	wp_enqueue_script( 'wpos-slick-jquery' );
	wp_enqueue_script( 'wpsisac-public-script' );

	// Taking some variables
	$image_fit_class = ( $image_fit ) 	? 'wpsisac-image-fit'	: '';

	// Slider configuration
	$slider_conf = compact('slidestoshow','slidestoscroll','dots', 'arrows', 'autoplay', 'autoplay_interval', 'speed', 'rtl', 'centermode' , 'lazyload', 'variablewidth', 'loop', 'hover_pause');

	ob_start();

	// Taking some global
	global $post;

	// Taking some variables
	$unique			= nsi_logoslider_get_unique();
	$post_type 		= 'nsi-logo-slider';
	$orderby 		= 'post_date';
	$order 			= 'DESC';

	// WP Query Parameters
    $args = array ( 
        'post_type'      => $post_type,
        'orderby'        => $orderby,
        'order'          => $order,
        'posts_per_page' => $limit,
    );

    // Category Parameter
	if($cat != ""){
    	$args['tax_query'] = array( 
			array( 
				'taxonomy' => 'logo-category',
				'field' => 'term_id',
				'terms' => $cat
			) 
		);
    }

    // WP Query Parameters
    $query 		= new WP_Query($args);
    $post_count = $query->post_count;

    // If post is there
    if ( $query->have_posts() ) : ?>
		<div class="wpsisac-slick-carousal-wrp wpsisac-clearfix <?php echo $extra_class; ?>" data-conf="<?php echo htmlspecialchars(json_encode($slider_conf)); ?>">
			<div id="wpsisac-slick-carousal-<?php echo $unique; ?>"  class="wpsisac-slick-init wpsisac-slick-carousal <?php echo $design; ?> <?php echo $image_fit_class; ?> <?php if($centermode == 'true' && $variablewidth == 'true') { echo 'wpsisac-center variablewidthv'; } elseif($centermode == 'true') { echo 'wpsisac-center';} else { echo 'simplecarousal';} ?>">
				<?php
				while ( $query->have_posts() ) : $query->the_post();
					// Include shortcode html file
					if( $design_file ) {
						include( $design_file );
					}
				endwhile; ?>
			</div>
		</div>
	<?php
    endif;
    wp_reset_postdata(); // Reset WP Query
	return ob_get_clean();
}
add_shortcode('nsi_logo_slider','nsi_fetch_logo_slider');