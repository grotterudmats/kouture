<?php
/**
 * The template for displaying search results.
 *
 * @package LionThemes
 * @subpackage Hermes_Themes
 * @since Hermes Themes 1.6
 */

get_header();

/**
 * determine main column size from actived sidebar
 */
$hermes_opt = get_option( 'hermes_opt' );
?> 
<div id="main-content">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<?php hermes_breadcrumb(); ?>
			</div>
			<?php if(isset($hermes_opt['sidebarblog_pos']) && $hermes_opt['sidebarblog_pos']=='left') :?>
				<?php get_sidebar('blog'); ?>
			<?php endif; ?>
				<div class="col-xs-12 <?php if ( is_active_sidebar( 'blog' ) ) : ?>col-md-9<?php endif; ?> content-area" id="main-column">
					<main id="main" class="site-main">
						<?php if (have_posts()) { ?> 
						<header class="page-header">
							<h1 class="page-title"><?php printf(esc_html__('Search Results for: %s', 'hermes'), '<span>' . get_search_query() . '</span>'); ?></h1>
						</header><!-- .page-header -->
						<?php 
						// start the loop
						while (have_posts()) {
							the_post();
							
							/* Include the Post-Format-specific template for the content.
							* If you want to override this in a child theme, then include a file
							* called content-___.php (where ___ is the Post Format name) and that will be used instead.
							*/
							get_template_part('content', 'search');
						}// end while
						
						hermes_bootstrap_pagination();
						?> 
						<?php } else { ?> 
						<?php get_template_part('no-results', 'search'); ?>
						<?php } // endif; ?> 
					</main>
				</div>
			<?php if(isset($hermes_opt['sidebarblog_pos']) && $hermes_opt['sidebarblog_pos']=='right') :?>
				<?php get_sidebar('blog'); ?>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php get_footer(); ?> 