<?php
/**
 * The Header template for our theme
 *
 * @package LionThemes
 * @subpackage Hermes_theme
 * @since Hermes Themes 1.6
 */
?>
<?php 

$hermes_opt = get_option( 'hermes_opt' );

?>


<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<?php if(!$disable_responsive = get_post_meta( get_the_ID(), 'hermes_disable_responsive', true )) { ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php } ?>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
</head>
<?php
	$layout = (isset($hermes_opt['page_layout']) && $hermes_opt['page_layout'] == 'box') ? ' box-layout':'';
	$header = (empty($hermes_opt['header_layout']) || $hermes_opt['header_layout'] == 'default') ? 'first': $hermes_opt['header_layout'];
	$content_layout = '';
	if(get_post_meta( get_the_ID(), 'hermes_header_page', true )){
		$header = get_post_meta( get_the_ID(), 'hermes_header_page', true );
	}
	if(get_the_ID()){
		$layout = get_post_meta( get_the_ID(), 'hermes_layout_page', true );
		$content_layout = get_post_meta( get_the_ID(), 'hermes_content_layout', true );
	}
?>
<body <?php body_class(); ?>>
<div class="main-wrapper<?php echo esc_attr($layout); ?><?php echo ($disable_responsive) ? ' disable-responsive' : ''; ?>">
<?php do_action('before'); ?> 
	<header>
	<?php
		get_header($header);
	?>
	</header>
	<div id="content" class="site-content <?php echo $content_layout; ?>">