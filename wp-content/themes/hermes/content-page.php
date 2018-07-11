<?php
/**
 * The template for displaying posts in the Image post format
 *
 * @package LionThemes
 * @subpackage Hermes_theme
 * @since Hermes Themes 1.6
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?> 
		<div class="clearfix"></div>
		<?php wp_link_pages(array(
			'before' => '<div class="page-links"><span>' . esc_html__('Pages:', 'hermes') . '</span><ul class="pagination">',
			'after'  => '</ul></div>',
			'separator' => ''
		)); ?>
	</div><!-- .entry-content -->
	
	<footer class="entry-meta">
		<?php hermes_bootstrap_edit_post_link(); ?> 
	</footer>
</article><!-- #post-## -->