<?php
// new post meta data callback
function hermes_post_meta_box_callback( $post ) {
	wp_nonce_field( 'hermes_meta_box', 'hermes_meta_box_nonce' );
	$value = get_post_meta( $post->ID, 'hermes_featured_post_value', true );
	echo '<label for="hermes_post_intro">';
	esc_html_e( 'This content will be used to replace the featured image, use shortcode here', 'hermes' );
	echo '</label><br />';
	wp_editor( $value, 'hermes_post_intro', $settings = array() );
}
// register new meta box
add_action( 'add_meta_boxes', 'hermes_add_post_meta_box' );
function hermes_add_post_meta_box(){
	$screens = array( 'post' );
	foreach ( $screens as $screen ) {
		add_meta_box(
			'hermes_post_intro_section',
			esc_html__( 'Post featured content', 'hermes' ),
			'hermes_post_meta_box_callback',
			$screen
		);
	}
	add_meta_box(
		'hermes_page_config_section',
		esc_html__( 'Page config', 'hermes' ),
		'hermes_page_meta_box_callback',
		'page',
		'normal',
		'high'
	);
}
// new page meta data callback
function hermes_page_meta_box_callback( $post ) {
	wp_nonce_field( 'hermes_meta_box', 'hermes_meta_box_nonce' );
	$header_val = get_post_meta( $post->ID, 'hermes_header_page', true );
	$layout_val = get_post_meta( $post->ID, 'hermes_layout_page', true );
	$logo_val = get_post_meta( $post->ID, 'hermes_logo_page', true );
	$footer_val = get_post_meta( $post->ID, 'hermes_footer_page', true );
	$content_layout = get_post_meta( $post->ID, 'hermes_content_layout', true );
	$disable_responsive = get_post_meta( $post->ID, 'hermes_disable_responsive', true );
	echo '<div class="bootstrap">';
		echo '<div class="option row">';
			echo '<div class="option_label col-md-3 col-sm-12"><label for="custom_header_option">' . esc_html__('Custom header:', 'hermes') . '</label></div>';
			echo '<div class="option_field col-md-9 col-sm-12"><select id="custom_header_option" name="hermes_header_page">';
			echo '<option value="">'. esc_html__('Inherit theme options', 'hermes') .'</option>';
			echo '<option value="first"'. (($header_val == 'first') ? ' selected="selected"' : '') .'>'. esc_html__('Header first (Default)', 'hermes') .'</option>';
			echo '<option value="second"'. (($header_val == 'second') ? ' selected="selected"' : '') .'>'. esc_html__('Header second', 'hermes') .'</option>';
			echo '<option value="third"'. (($header_val == 'third') ? ' selected="selected"' : '') .'>'. esc_html__('Header third', 'hermes') .'</option>';
			echo '<option value="fourth"'. (($header_val == 'fourth') ? ' selected="selected"' : '') .'>'. esc_html__('Header fourth', 'hermes') .'</option>';
			echo '<option value="fifth"'. (($header_val == 'fifth') ? ' selected="selected"' : '') .'>'. esc_html__('Header fifth', 'hermes') .'</option>';
			echo '</select></div>';
		echo '</div>';
		
		echo '<div class="option row">';
			echo '<div class="option_label col-md-3 col-sm-12"><label for="custom_footer_option">' . esc_html__('Custom footer:', 'hermes') . '</label></div>';
			echo '<div class="option_field col-md-9 col-sm-12"><select id="custom_footer_option" name="hermes_footer_page">';
			echo '<option value="">'. esc_html__('Inherit theme options', 'hermes') .'</option>';
			echo '<option value="first"'. (($footer_val == 'first') ? ' selected="selected"' : '') .'>'. esc_html__('Footer first', 'hermes') .'</option>';
			echo '<option value="second"'. (($footer_val == 'second') ? ' selected="selected"' : '') .'>'. esc_html__('Footer second', 'hermes') .'</option>';
			echo '<option value="third"'. (($footer_val == 'third') ? ' selected="selected"' : '') .'>'. esc_html__('Footer third', 'hermes') .'</option>';
			echo '<option value="fourth"'. (($footer_val == 'fourth') ? ' selected="selected"' : '') .'>'. esc_html__('Footer fourth', 'hermes') .'</option>';
			echo '<option value="fifth"'. (($footer_val == 'fifth') ? ' selected="selected"' : '') .'>'. esc_html__('Footer fifth', 'hermes') .'</option>';
			echo '</select></div>';
		echo '</div>';
		
		echo '<div class="option row">';
			echo '<div class="option_label col-md-3 col-sm-12"><label for="custom_layout_option">' . esc_html__('Custom layout:', 'hermes') . '</label></div>';
			echo '<div class="option_field col-md-9 col-sm-12"><select id="custom_layout_option" name="hermes_layout_page">';
			echo '<option value="">'. esc_html__('Inherit theme options', 'hermes') .'</option>';
			echo '<option value="full"'. (($layout_val == 'full') ? ' selected="selected"' : '') .'>'. esc_html__('Full (Default)', 'hermes') .'</option>';
			echo '<option value="box"'. (($layout_val == 'box') ? ' selected="selected"' : '') .'>'. esc_html__('Box', 'hermes') .'</option>';
			echo '</select></div>';
		echo '</div>';
		
		echo '<div class="option row">';
			echo '<div class="option_label col-md-3 col-sm-12"><label for="custom_logo_option">' . esc_html__('Custom logo:', 'hermes') . '</label></div>';
			echo '<div class="option_field col-md-9 col-sm-12"><input type="hidden" name="hermes_logo_page" id="custom_logo_option" value="'. esc_attr($logo_val) . '" />';
			echo '<div class="wp-media-buttons"><button id="hermes_media_button" class="button" type="button"/>'. esc_html__('Upload Logo', 'hermes') .'</button><button id="hermes_remove_media_button" class="button" type="button">'. esc_html__('Remove', 'hermes') .'</button></div>';
			echo '<div id="hermes_page_selected_media">'. (($logo_val) ? '<img width="150" src="'. esc_url($logo_val) .'" />':'') .'</div>';
			echo '</div>';
		echo '</div>';
		
		echo '<div class="option row">';
			echo '<div class="option_label col-md-3 col-sm-12"><label for="custom_content_layout">' . esc_html__('Content layout:', 'hermes') . '</label></div>';
			echo '<div class="option_field col-md-9 col-sm-12"><select id="custom_content_layout" name="hermes_content_layout">';
			echo '<option value="">'. esc_html__('Default layout', 'hermes') .'</option>';
			echo '<option value="home2_style"'. (($content_layout == 'home2_style') ? ' selected="selected"' : '') .'>'. esc_html__('Home 2 style', 'hermes') .'</option>';
			echo '</select></div>';
		echo '</div>';

		echo '<div class="option row">';
			echo '<div class="option_label col-md-3 col-sm-12"><label for="custom_responsive_mode">' . esc_html__('Disable Responsive:', 'hermes') . '</label></div>';
			echo '<div class="option_field col-md-9 col-sm-12"><select id="custom_responsive_mode" name="hermes_disable_responsive">';
			echo '<option value="">'. esc_html__('No', 'hermes') .'</option>';
			echo '<option value="1"'. (($disable_responsive == 1) ? ' selected="selected"' : '') .'>'. esc_html__('Yes', 'hermes') .'</option>';
			echo '</select></div>';
		echo '</div>';
		
		
	echo '</div>';
	
	function hermes_admin_scripts() {
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
    }
    function hermes_admin_styles() {
        wp_enqueue_style('thickbox');
    }
    add_action('admin_print_scripts', 'hermes_admin_scripts');
    add_action('admin_print_styles', 'hermes_admin_styles');
}
// save new meta box value
add_action( 'save_post', 'hermes_save_meta_box_data' );
function hermes_save_meta_box_data( $post_id ) {
	// Check if our nonce is set.
	if ( ! isset( $_POST['hermes_meta_box_nonce'] ) ) {
		return;
	}
	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['hermes_meta_box_nonce'], 'hermes_meta_box' ) ) {
		return;
	}
	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}
	} else {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}
	/* OK, it's safe for us to save the data now. */
	
	// Make sure that it is set.
	if ( isset( $_POST['hermes_post_intro'] ) ) {
		// Sanitize user input.
		$my_data = sanitize_text_field( $_POST['hermes_post_intro'] );
		// Update the meta field in the database.
		update_post_meta( $post_id, 'hermes_featured_post_value', $my_data );
	}
	if ( isset( $_POST['hermes_header_page'] ) ) {
		// Sanitize user input.
		$my_data = sanitize_text_field( $_POST['hermes_header_page'] );
		// Update the meta field in the database.
		update_post_meta( $post_id, 'hermes_header_page', $my_data );
	}
	if ( isset( $_POST['hermes_footer_page'] ) ) {
		// Sanitize user input.
		$my_data = sanitize_text_field( $_POST['hermes_footer_page'] );
		// Update the meta field in the database.
		update_post_meta( $post_id, 'hermes_footer_page', $my_data );
	}
	if ( isset( $_POST['hermes_layout_page'] ) ) {
		// Sanitize user input.
		$my_data = sanitize_text_field( $_POST['hermes_layout_page'] );
		// Update the meta field in the database.
		update_post_meta( $post_id, 'hermes_layout_page', $my_data );
	}
	if ( isset( $_POST['hermes_logo_page'] ) ) {
		// Sanitize user input.
		$my_data = sanitize_text_field( $_POST['hermes_logo_page'] );
		// Update the meta field in the database.
		update_post_meta( $post_id, 'hermes_logo_page', $my_data );
	}
	if ( isset( $_POST['hermes_content_layout'] ) ) {
		// Sanitize user input.
		$my_data = sanitize_text_field( $_POST['hermes_content_layout'] );
		// Update the meta field in the database.
		update_post_meta( $post_id, 'hermes_content_layout', $my_data );
	}
	if ( isset( $_POST['hermes_disable_responsive'] ) ) {
		// Sanitize user input.
		$my_data = sanitize_text_field( $_POST['hermes_disable_responsive'] );
		// Update the meta field in the database.
		update_post_meta( $post_id, 'hermes_disable_responsive', $my_data );
	}
	
	return;
}

function hermes_custom_media_upload_field_js($hook) {
	global $post;
	if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
		if('page' === $post->post_type){
			$media_upload_js = '
				var file_frame;
				jQuery(document).on(\'click\', \'#hermes_remove_media_button\', function(e){
					e.preventDefault();
					jQuery(\'#custom_logo_option\').val(\'\');
					jQuery(\'#hermes_page_selected_media\').html(\'\');
				});
				jQuery(document).on(\'click\', \'#hermes_media_button\', function(e){
					
					if (file_frame){
						file_frame.open();
						return;
					}
					file_frame = wp.media.frames.file_frame = wp.media({
						title: jQuery(this).data(\'uploader_title\'),
						button: {
							text: jQuery(this).data(\'uploader_button_text\'),
						},
						multiple: false
					});
					file_frame.on(\'select\', function(){
						attachment = file_frame.state().get(\'selection\').first().toJSON();
						var url = attachment.url;
						var field = document.getElementById("custom_logo_option");
						field.value = url;
						jQuery(\'#hermes_page_selected_media\').html(\'<img width="150" src="\'+ url +\'" />\');
						file_frame.close();
					});
					file_frame.open();
					e.preventDefault();
				});
			';
			wp_add_inline_script( 'media-upload', $media_upload_js );
		}
	}
}
add_action('admin_enqueue_scripts','hermes_custom_media_upload_field_js', 10, 1);