<?php 
get_header(); 
$hermes_opt = get_option( 'hermes_opt' );
?> 

	<div class="page-404">
		<div class="container text-center">
			<article>
				<h1><?php esc_html_e('404', 'hermes'); ?></h1>
				
				<div class="error-content">
					<?php echo (!empty($hermes_opt['404-content'])) ? $hermes_opt['404-content'] : ''; ?>
				</div>
				
				<div class="button-group">
					<a class="btn" href="<?php echo site_url() ?>"><?php echo esc_html__('Return to Home', 'hermes') ?></a>
					<a class="btn primary-bg" href="<?php echo site_url('shop') ?>"><?php echo esc_html__('Continue Shopping', 'hermes') ?></a>
				</div>
			</article>
		</div>

	</div>
	

<?php get_footer(); ?> 