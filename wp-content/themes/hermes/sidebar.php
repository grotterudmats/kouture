<?php
/**
 * The sidebar containing the main widget area
 *
 * @package LionThemes
 * @subpackage Hermes_theme
 * @since Hermes Themes 1.6
 */
?>

<?php if ( is_active_sidebar( 'page' ) ) : ?>
	<div class="col-md-3" id="sidebar-page">
		<?php do_action('before_sidebar'); ?> 
		<?php dynamic_sidebar( 'page' ); ?>
	</div><!-- #sidebar -->
<?php endif; ?>