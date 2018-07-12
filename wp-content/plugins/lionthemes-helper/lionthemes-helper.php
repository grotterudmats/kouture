<?php
/**
 * Plugin Name: LionThemes Helper
 * Plugin URI: http://lion-themes.com/
 * Description: The helper plugin for LionThemes themes.
 * Version: 1.0.0
 * Author: LionThemes
 * Author URI: http://lion-themes.com/
 * Text Domain: lionthemes
 * License: GPL/GNU.
 * Copyright 2016  LionThemes  (email : support@lion-themes.com)
*/

define('IMPORT_LOG_PATH', plugin_dir_path( __FILE__ ) . 'wbc_importer');

//Redux wbc importer for import data one click.
function lionthemes_redux_register_extension_loader($ReduxFramework) {
	
	if ( ! class_exists( 'ReduxFramework_extension_wbc_importer' ) ) {
		$class_file = plugin_dir_path( __FILE__ ) . 'wbc_importer/extension_wbc_importer.php';
		$class_file = apply_filters( 'redux/extension/' . $ReduxFramework->args['opt_name'] . '/wbc_importer', $class_file );
		if ( $class_file ) {
			require_once( $class_file );
		}
	}
	if ( ! isset( $ReduxFramework->extensions[ 'wbc_importer' ] ) ) {
		$ReduxFramework->extensions[ 'wbc_importer' ] = new ReduxFramework_extension_wbc_importer( $ReduxFramework );
	}
}
add_action("redux/extensions/hermes_opt/before", 'lionthemes_redux_register_extension_loader', 0);

// Import slider, setup menu locations, setup home page
function lionthemes_wbc_extended_example( $demo_active_import , $demo_directory_path ) {

	reset( $demo_active_import );
	$current_key = key( $demo_active_import );

	// Revolution Slider import all
	if ( class_exists( 'RevSlider' ) ) {
		$wbc_sliders_array = array(
			'Hermes' => array('home-1.zip', 'home-2-slider.zip', 'home-3-slider.zip', 'home4.zip', 'home-5-slider.zip')
		);

		if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_sliders_array ) ) {
			$wbc_slider_import = $wbc_sliders_array[$demo_active_import[$current_key]['directory']];
			foreach($wbc_slider_import as $file_backup){
				if ( file_exists( $demo_directory_path . $file_backup ) ) {
					$slider = new RevSlider();
					$slider->importSliderFromPost( true, true, $demo_directory_path . $file_backup );
				}
			}
		}
	}
	// menu localtion settings
	$wbc_menu_array = array( 'Hermes' );

	if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && in_array( $demo_active_import[$current_key]['directory'], $wbc_menu_array ) ) {
		$primary_menu = get_term_by( 'name', 'Main menu', 'nav_menu' );
		
		if ( isset( $primary_menu->term_id ) ) {
			set_theme_mod( 'nav_menu_locations', array(
					'primary' => $primary_menu->term_id,
					'mobilemenu'  => $primary_menu->term_id
				)
			);
		}
		// update option top menu & footer menus
		$_menu1 = get_term_by( 'name', 'Information', 'nav_menu' );
		$_menu2 = get_term_by( 'name', 'Our services', 'nav_menu' );
		$_menu3 = get_term_by( 'name', 'My account', 'nav_menu' );
		$_menu4 = get_term_by( 'name', 'Footer links', 'nav_menu' );
		$hermes_opt = get_option( 'hermes_opt' );
		if(!empty( $hermes_opt )){
			if ( !empty( $_menu1->term_id ) ) {
				$hermes_opt['footer_menu1'] = $_menu1->term_id;
			}
			if ( !empty( $_menu2->term_id ) ) {
				$hermes_opt['footer_menu2'] = $_menu2->term_id;
			}
			if ( !empty( $_menu3->term_id ) ) {
				$hermes_opt['footer_menu3'] = $_menu3->term_id;
			}
			if ( !empty( $_menu4->term_id ) ) {
				$hermes_opt['footer_menu4'] = $_menu4->term_id;
			}
			update_option( 'hermes_opt', $hermes_opt );
		}
	}
	
	// megamenu options
	global $mega_main_menu;
	
	$exported_file = $demo_directory_path . 'mega-main-menu-settings.json';
	
	if ( file_exists( $exported_file ) ) {
		$backup_file_content = file_get_contents ( $exported_file );
		
		if ( $backup_file_content !== false && ( $options_backup = json_decode( $backup_file_content, true ) ) ) {
			update_option( $mega_main_menu->constant[ 'MM_OPTIONS_NAME' ], $options_backup );
		}
	}

	// Home page setup default
	$wbc_home_pages = array(
		'Hermes' => 'Home Shop 1',
	);
	$wbc_blog_page = array(
		'Hermes' => 'Blog',
	);

	if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_home_pages ) ) {
		$page = get_page_by_title( $wbc_home_pages[$demo_active_import[$current_key]['directory']] );
		$blogpage = get_page_by_title( $wbc_blog_page[$demo_active_import[$current_key]['directory']] );
		if ( isset( $page->ID ) ) {
			update_option( 'page_on_front', $page->ID );
			update_option( 'show_on_front', 'page' );
			update_option( 'page_for_posts', $blogpage->ID );
		}
	}
	update_option( 'yith_woocompare_compare_button_in_products_list', 'no' );
}
add_action( 'wbc_importer_after_content_import', 'lionthemes_wbc_extended_example', 10, 2 );


// add placeholder for input social icons 
add_action("redux/field/hermes_opt/sortable/fieldset/after/hermes_opt", 'lionthemes_helper_redux_add_placeholder_sortable', 0);
function lionthemes_helper_redux_add_placeholder_sortable($data){
	$fieldset_id = $data['id'] . '-list';
	$base_name = 'hermes_opt['. $data['id'] .']';
	echo "<script type=\"text/javascript\">
			jQuery('#$fieldset_id li input[type=\"text\"]').each(function(){
				var my_name = jQuery(this).attr('name');
				placeholder = my_name.replace('$base_name', '').replace('[','').replace(']','');
				jQuery(this).attr('placeholder', placeholder);
				jQuery(this).next('span').attr('title', placeholder);
			});
		</script>";
}

//Less compiler
function compileLess($input, $output, $params){
    // input and output location
	$inputFile = get_template_directory().'/less/'.$input;
	$outputFile = get_template_directory().'/css/'.$output;
	if(!file_exists($inputFile)) return;
	// include Less Lib
	if(file_exists( plugin_dir_path( __FILE__ ) . 'less/lessc.inc.php' )){
		require_once( plugin_dir_path( __FILE__ ) . 'less/lessc.inc.php' );
		try{
			$less = new lessc;
			$less->setVariables($params);
			$less->setFormatter("compressed");
			$cache = $less->cachedCompile($inputFile);
			file_put_contents($outputFile, $cache["compiled"]);
			$last_updated = $cache["updated"];
			$cache = $less->cachedCompile($cache);
			if ($cache["updated"] > $last_updated) {
				file_put_contents($outputFile, $cache["compiled"]);
			}
		}catch(Exception $e){
			$error_message = $e->getMessage();
			echo $error_message;
		}
	}
	return;
}
$shortcodes = array(
	'brands.php',
	'blogposts.php',
	'products.php',
	'productscategory.php',
	'testimonials.php',
	'countdown.php',
	'featurecontent.php',
);
//Shortcodes for Visual Composer
foreach($shortcodes as $shortcode){
	if ( file_exists( plugin_dir_path( __FILE__ ). 'shortcodes/' . $shortcode ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'shortcodes/' . $shortcode;
	}
}

add_action( 'init', 'lionthemes_remove_upsell' );
function lionthemes_remove_upsell(){
	global $hermes_opt;
	if(!empty($hermes_opt['enable_upsells'])){
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
	}
}


// remove redux ads
add_action('admin_enqueue_scripts','lionthemes_remove_redux_ads', 10, 1);
function lionthemes_remove_redux_ads(){
	$remove_redux = 'jQuery(document).ready(function($){
						setTimeout(
							function(){
								$(".rAds, .redux-notice, .vc_license-activation-notice, #js_composer-update").remove();
								$("tr[data-slug=\"js_composer\"]").removeClass("update");
							}, 500);
					});';
	if ( ! wp_script_is( 'jquery', 'done' ) ) {
		wp_enqueue_script( 'jquery' );
	}
	wp_add_inline_script( 'jquery-migrate', $remove_redux );
}


function lionthemes_get_excerpt($post_id, $limit){
    $the_post = get_post($post_id);
    $the_excerpt = do_shortcode($the_post->post_content);
    $the_excerpt = strip_tags($the_excerpt);
    $words = explode(' ', $the_excerpt, $limit + 1);

    if(count($words) > $limit) :
        array_pop($words);
        array_push($words, '…');
        $the_excerpt = implode(' ', $words);
    endif;

    $the_excerpt = '<p>' . $the_excerpt . '</p>';

    return $the_excerpt;
}
?>
