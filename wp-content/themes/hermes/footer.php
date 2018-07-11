<?php
/**
 * The template for displaying the footer
 *
 * @package LionThemes
 * @subpackage Hermes_theme
 * @since Hermes Themes 1.6
 */
?>
<?php 
	$hermes_opt = get_option( 'hermes_opt' ); 
	$footer = (!isset($hermes_opt['footer_layout']) || $hermes_opt['footer_layout'] == 'default') ? 'first' : $hermes_opt['footer_layout'];
	if(get_post_meta( get_the_ID(), 'hermes_footer_page', true )){
		$footer = get_post_meta( get_the_ID(), 'hermes_footer_page', true );
	}
?>
		
		</div><!--.site-content-->
		<footer id="site-footer">
			<?php
				get_footer($footer);
			?>
		</footer>
		<?php if ( isset($hermes_opt['back_to_top']) && $hermes_opt['back_to_top'] ) { ?>
		<div id="back-top"><i class="fa fa-long-arrow-up"></i></div>
		<?php } ?>
	</div><!--.main wrapper-->
	<?php wp_footer(); ?>
</body>
</html>