<?php
/**
 * The template for displaying posts in the Gallery post format
 *
 * @package LionThemes
 * @subpackage Hermes_Themes
 * @since Hermes Themes 1.6
 */

$hermes_opt = get_option( 'hermes_opt' );
$blogcolumn = (isset($hermes_opt['blogcolumn'])) ? $hermes_opt['blogcolumn'] : '';
if(is_single()) $blogcolumn = '';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($blogcolumn); ?>>
	<div class="post-wrapper">
	<?php if ( ! post_password_required() && ! is_attachment() ) : ?>
	<?php 
		if ( is_single() ) { ?>
			<div class="post-thumbnail"><?php echo do_shortcode(get_post_meta( get_the_ID(), 'hermes_featured_post_value', true )); ?></div>
		<?php }
	?>
	<?php if ( !is_single() ) { ?>
		<div class="post-thumbnail">
			<?php echo do_shortcode(get_post_meta( get_the_ID(), 'hermes_featured_post_value', true )); ?>
		</div>
	<?php } ?>
	<?php endif; ?>
	
		<div class="post-info<?php if ( !has_post_thumbnail() ) { echo ' no-thumbnail';} ?>">
			<header class="entry-header">
				<?php if ( is_single() ) : ?>
					<h1 class="entry-title"><?php the_title(); ?></h1>
				<?php else : ?>
					<h3 class="entry-title">
						<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
					</h3>
				<?php endif; ?>
				<ul class="post-entry-data">
					<li class="post-date"><?php echo get_the_date() ?></li>
					<li class="post-comments"><a href="<?php echo get_comments_link() ?>"><?php echo sprintf(esc_html__('%d Comment(s)', 'hermes'), get_comments_number( $post->ID )) ?></a></li>
				</ul>
			</header>
			
			<?php if (is_search()) { // Only display Excerpts for Search ?> 
			<div class="entry-summary">
				<?php the_excerpt(); ?> 
				<div class="clearfix"></div>
			</div><!-- .entry-summary -->
			<?php } else { ?> 
				<?php if ( is_single() ) : ?>
					<div class="entry-content">
						<?php the_content( esc_html__( 'Continue reading <span class="meta-nav">&rarr;</span>', 'hermes' ) ); ?>
						<?php wp_link_pages(array(
							'before' => '<div class="page-links"><span>' . esc_html__('Pages:', 'hermes') . '</span><ul class="pagination">',
							'after'  => '</ul></div>',
							'separator' => ''
						)); ?>
					</div>
				<?php else : ?>
					<div class="entry-summary">
						<?php the_excerpt(); ?>
					</div>
				<?php endif; ?>
			<?php } //endif; ?> 
			<?php if ( is_single() ){ ?>
			<footer class="entry-meta">
				<?php if ('post' == get_post_type()) { // Hide category and tag text for pages on Search ?> 
				<div class="entry-meta-category-tag">
					<?php
						/* translators: used between list items, there is a space after the comma */
						$categories_list = get_the_category_list(esc_html__(', ', 'hermes'));
						if (!empty($categories_list)) {
					?> 
					<span class="cat-links">
						<?php echo hermes_bootstrap_categories_list($categories_list); ?> 
					</span>
					<?php } // End if categories ?> 

					<?php
						/* translators: used between list items, there is a space after the comma */
						$tags_list = get_the_tag_list('', esc_html__(', ', 'hermes'));
						if ($tags_list) {
					?> 
					<span class="tags-links">
						<?php echo hermes_bootstrap_tags_list($tags_list); ?> 
					</span>
					<?php } // End if $tags_list ?> 
				</div>
				<?php } // End if 'post' == get_post_type() ?> 

				<div class="entry-counter">
					<div class="post-comments" title="<?php echo esc_html__('Total Comments', 'hermes') ?>" data-toggle="tooltip"><i class="fa fa-comments"></i><?php echo get_comments_number( get_the_ID() ) ?></div>
					<div class="post-views" title="<?php echo esc_html__('Total Views', 'hermes') ?>" data-toggle="tooltip">
						<i class="fa fa-eye"></i><?php echo hermes_get_post_viewed(get_the_ID()); ?>
					</div>
					<?php $liked = hermes_check_liked_post(get_the_ID()); ?>
					<div class="likes-counter" title="<?php echo (!$liked) ?  esc_html__('Like this post', 'hermes') : esc_html__('Unlike this post', 'hermes'); ?>" data-toggle="tooltip">
						<a class="hermes_like_post<?php echo ($liked) ? ' liked':''; ?>" href="javascript:void(0)" data-post_id="<?php the_ID() ?>" data-liked_title="<?php echo esc_html__('Unlike this post', 'hermes') ?>" data-unliked_title="<?php echo esc_html__('Like this post', 'hermes') ?>">
							<i class="fa fa-heart"></i><span class="number"><?php echo hermes_get_liked(get_the_ID()); ?></span>
						</a>
					</div>
				</div>
				<?php if( function_exists('hermes_blog_sharing') && is_single()) { ?>
					<div class="social-sharing"><?php hermes_blog_sharing(); ?></div>
				<?php } ?>
			</footer>
			<?php } ?>
		</div>
	</div>
</article>