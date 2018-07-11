<?php 
add_action( 'wp_enqueue_scripts', 'hermes_child_scripts_styles', 15 );
function hermes_child_scripts_styles(){
	global $hermes_opt;
	if($hermes_opt['enable_less']){
		$hermes = array(
			// less variables
		);
		if( function_exists('compileLess') ){
			compileLess('child-theme.less', 'child-theme.css', $hermes);
		}
	}
	wp_enqueue_style( 'child-theme', get_stylesheet_directory_uri() . '/css/child-theme.css' );
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css' );
}
