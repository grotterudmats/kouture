<?php
/**
 * Template Name: Page Template
 *
 * @package LionThemes
 * @subpackage Hermes_theme
 * @since Hermes Themes 1.6
 */
get_header(); 
?>
	<div id="main-content">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php 
				the_content(); 
			?>
			
		<?php endwhile; // end of the loop. ?>
	</div>
<?php
get_footer();
