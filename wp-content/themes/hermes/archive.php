<?php
/**
 * Displaying archive page (category, tag, archives post, author's post)
 *
 * @package LionThemes
 * @subpackage Hermes_theme
 * @since Hermes Themes 1.6
 */

get_header(); 

/**
 * determine main column size from actived sidebar
 */
$hermes_opt = get_option( 'hermes_opt' );

if(isset($hermes_opt)){
	$bloglayout = 'nosidebar';
} else {
	$bloglayout = 'sidebar';
}
if(isset($hermes_opt['blog_layout']) && $hermes_opt['blog_layout']!=''){
	$bloglayout = $hermes_opt['blog_layout'];
}
if(isset($_GET['layout']) && $_GET['layout']!=''){
	$bloglayout = $_GET['layout'];
}
$blogsidebar = 'right';
if(isset($hermes_opt['sidebarblog_pos']) && $hermes_opt['sidebarblog_pos']!=''){
	$blogsidebar = $hermes_opt['sidebarblog_pos'];
}
switch($bloglayout) {
	case 'sidebar':
		$blogclass = 'blog-sidebar';
		$blogcolclass = 9;
		break;
	default:
		$blogclass = 'blog-nosidebar';
		$blogcolclass = 12;
		$blogsidebar = 'none';
}
if(isset($_GET['side']) && $_GET['side']!=''){
	$blogsidebar = $_GET['side'];
	$blogcolclass = 9;
}
$coldata = 3;
if(!isset($hermes_opt['blog_column'])){
	$blogcolumn = 'col-sm-12';
	$col_class = 'one';
}else{
	$blogcolumn = 'col-sm-' . $hermes_opt['blog_column'];
	switch($hermes_opt['blog_column']) {
		case 6:
			$col_class = 'two';
			$coldata = 2;
			break;
		case 4:
			$col_class = 'three';
			$coldata = 3;
			break;
		case 3:
			$col_class = 'four';
			$coldata = 4;
			break;
		default:
			$col_class = 'one';
			$coldata = 1;
	}
	
}
if(isset($_GET['col']) && $_GET['col']!=''){
	$col = $_GET['col'];
	switch($col) {
		case 2:
			$blogcolumn = 'col-sm-6';
			$col_class = 'two';
			$coldata = 2;
			break;
		case 3:
			$blogcolumn = 'col-sm-4';
			$col_class = 'three';
			$coldata = 3;
			break;
		case 4:
			$blogcolumn = 'col-sm-3';
			$col_class = 'four';
			$coldata = 4;
			break;
		default:
			$blogcolumn = 'col-sm-12';
			$col_class = 'one';
			$coldata = 1;
	}
}

$hermes_opt['blogcolumn'] = $blogcolumn;

update_option( 'hermes_opt', $hermes_opt );

?>
<div id="main-content">
	<div class="container">
		<header class="entry-header">
			<div class="container">
				<h1 class="entry-title"><?php if(isset($hermes_opt)) { echo esc_html($hermes_opt['blog_header_text']); } else { esc_html_e('Blog', 'hermes');}  ?></h1>
			</div>
		</header>
		<div class="row">
			<div class="col-xs-12">
				<?php hermes_breadcrumb(); ?>
			</div>
			<?php if($blogsidebar == 'left') :?>
				<?php get_sidebar('blog'); ?>
			<?php endif; ?>
				<div class="col-xs-12 <?php echo 'col-md-'.$blogcolclass; ?> content-area" id="main-column">
					<main id="main" class="blog-page blog-<?php echo esc_attr($col_class); ?>-column<?php echo ($blogsidebar != 'none') ? '-' . esc_attr($blogsidebar) : ''; ?> site-main">
						<?php if (have_posts()) { ?> 
						<div class="row<?php echo ($coldata > 1) ? ' auto-grid':''; ?>" data-col="<?php echo esc_attr($coldata) ?>">
						<?php 
						// start the loop
						while (have_posts()) {
							the_post();
							get_template_part('content', get_post_format());
						}// end while
						?> 
						</div>
						<?php hermes_bootstrap_pagination(); ?>
						<?php } else { ?> 
						<?php get_template_part('no-results', 'index'); ?>
						<?php } // endif; ?> 
					</main>
				</div>
			<?php if($blogsidebar == 'right') :?>
				<?php get_sidebar('blog'); ?>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php get_footer(); ?> 