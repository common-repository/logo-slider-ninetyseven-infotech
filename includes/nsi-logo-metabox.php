<?php
/**
* Adds a Meta box in Logo Slider Custom Post Type.
*/
function nsi_logo_slider_add_meta_box() {
		add_meta_box(
			'nsi_logo_slider_sectionid',
			__( "Logo URL" , 'nsilogo' ),
			'nsi_logo_slider_meta_box_callback',
			'nsi-logo-slider'
		);
}
add_action( 'add_meta_boxes', 'nsi_logo_slider_add_meta_box' );

/**
* Callback function for metabox in Logo Slider Custom Post Type.
*/
function nsi_logo_slider_meta_box_callback( $post ) {

	wp_nonce_field( 'nsi_logo_slider_meta_box', 'nsi_logo_slider_meta_box_nonce' );
	$value = get_post_meta( $post->ID, 'nsi_logo_slider_url_field', true );

	echo '<label for="nsi_logo_slider_url_field">';
	_e( 'Enter Logo URL', 'nsilogo' );
	echo '</label><br/>';
	echo '<input type="url" id="nsi_logo_slider_url_field" name="nsi_logo_slider_url_field" value="' . esc_attr( $value ) . '" style="width:100%;margin-top:5px;"/>';
}

/**
* Save metabox value in Logo Slider Custom Post Type.
*/
function nsi_logo_slider_save_meta_box_data( $post_id ) {
	if (!isset($_POST['nsi_logo_slider_meta_box_nonce'])){
		return;
	}
	if (!wp_verify_nonce( $_POST['nsi_logo_slider_meta_box_nonce'], 'nsi_logo_slider_meta_box')){
		return;
	}
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
		return;
	}
	// Check Permission
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}
	} else {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}
	if ( ! isset( $_POST['nsi_logo_slider_url_field'] ) ) {
		return;
	}
	// Sanitize User Value.
	$gs_logo = sanitize_text_field( $_POST['nsi_logo_slider_url_field'] );

	// Save the Value
	update_post_meta( $post_id, 'nsi_logo_slider_url_field', $gs_logo );
}
add_action( 'save_post', 'nsi_logo_slider_save_meta_box_data' );