<?php


/*
Plugin Name:  Front Systems + Miinto Product Import
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
//require_once(__DIR__ . "/hooks.php");


add_action('admin_init', function() {
  register_setting('front_settings', 'front_username', array(
    'type' => string,
    'description' => 'Front Systems Username',
    'sanitize_callback' => 'sanitize_text_field',
    'default' => NULL,
  ));
});

?>
