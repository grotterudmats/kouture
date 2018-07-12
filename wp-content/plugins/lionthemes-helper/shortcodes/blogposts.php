<?php
function hermes_blogposts_shortcode( $atts ) {
	global $hermes_opt;
	$post_index = 0;
	$atts = shortcode_atts( array(
		'title' => '',
		'widget_style' => '',
		'short_desc' => '',
		'number' => 5,
		'order' => 'DESC',
		'orderby' => 'post_date',
		'image' => 'wide', //square
		'length' => 20,
		'style' => 'carousel',
		'showon_effect'=>'',
		'columns' => '1',
		'rows' => '1',
		'desksmall' => '4',
		'tablet_count' => '3',
		'tabletsmall' => '2',
		'mobile_count' => '1',
		'margin' => '30',
		'autoplay' => 'false',
		'playtimeout' => '5000',
		'speed' => '250',
	), $atts, 'blogposts' );
	extract($atts);
	if($image == 'wide'){
		$imagesize = 'hermes-post-thumbwide';
	} else {
		$imagesize = 'hermes-post-thumb';
	}
	$html = '';

	$postargs = array(
		'posts_per_page'   => $number,
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => $orderby,
		'order'            => $order,
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'post',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'suppress_filters' => false );
	$postslist = get_posts( $postargs );
	$total = count($postslist);
	if($total == 0) return;
	switch ($columns) {
		case '5':
			$class_column='col-sm-20 col-xs-6';
			break;
		case '4':
			$class_column='col-sm-3 col-xs-6';
			break;
		case '3':
			$class_column='col-lg-4 col-md-4 col-sm-4 col-xs-6';
			break;
		case '2':
			$class_column='col-lg-6 col-md-6 col-sm-6 col-xs-6';
			break;
		default:
			$class_column='col-lg-12 col-md-12 col-sm-12 col-xs-6';
			break;
	}
	
	
	$owl_data = '';
	if($style == 'carousel'){
		$owl_data .= 'data-dots="false" data-nav="true" data-owl="slide" data-ow-rtl="false" ';
		$owl_data .= 'data-data-desksmall="'. esc_attr($desksmall) .'" ';
		$owl_data .= 'data-tabletsmall="'. esc_attr($tabletsmall) .'" ';
		$owl_data .= 'data-mobile="'. esc_attr($mobile_count) .'" ';
		$owl_data .= 'data-tablet="'. esc_attr($tablet_count) .'" ';
		$owl_data .= 'data-margin="'. esc_attr($margin) .'" ';
		$owl_data .= 'data-item-slide="'. esc_attr($columns) .'" ';
		$owl_data .= 'data-autoplay="'. esc_attr($autoplay) .'" ';
		$owl_data .= 'data-playtimeout="'. esc_attr($playtimeout) .'" ';
		$owl_data .= 'data-speed="'. esc_attr($speed) .'" ';
	}
	
	
	$row_cl = ' row';
	if($style != 'grid'){
		$row_cl = $class_column = '';
	}
	$html.='<div class="blog-posts '. esc_attr($row_cl) .'">';
		$html .= ($title) ? '<h3 class="vc_widget_title vc_blog_title '. esc_attr($widget_style) .'"><span>'. esc_html($title) .'</span></h3>' : '';
		$html .= ($short_desc) ? '<div class="short_desc">'. wpautop($short_desc) .'</div>' : '';
		$html .= '<div class="inner-content '.  esc_attr($widget_style) .'">';
			$html .= ($style == 'carousel') ? '<div class="owl-carousel owl-theme" ' . $owl_data . '>':'';
			$duration = 0;
			$showon_effect = ($showon_effect) ? ' wow ' . $showon_effect: '';
			foreach ( $postslist as $post ) {
				$duration = $duration + 100;
				if($rows > 1 && $style == 'carousel'){
					$post_index ++;
					if ( (( $post_index - 1 ) % $rows == 0) && $post_index < $total){
						$html .= '<div class="group">';
					}
				}
				$class_nothumb = '';
				
				if(!get_the_post_thumbnail( $post->ID, $imagesize ) && !get_post_meta( $post->ID, 'hermes_featured_post_value', true )) $class_nothumb = ' no-thumb';
				$html.='<div class="item-post post-'. $post->ID .' ' . $class_column . $class_nothumb . $showon_effect .'" data-wow-delay="'. esc_attr($duration) .'ms" data-wow-duration="0.5s">';
					$html.='<div class="post-wrapper">';
						$html.='<div class="post-thumb">';
							if(get_post_format( $post->ID ) == 'audio' && get_the_post_thumbnail( $post->ID, $imagesize )){
								$html.='<a href="'.get_the_permalink($post->ID).'">'.get_the_post_thumbnail($post->ID, $imagesize).'</a>';
							}
							if(get_post_meta( $post->ID, 'hermes_featured_post_value', true )){
								$html.= do_shortcode(get_post_meta( $post->ID, 'hermes_featured_post_value', true ));
							}elseif(get_the_post_thumbnail( $post->ID, $imagesize )){
								$html.='<a href="'.get_the_permalink($post->ID).'">'.get_the_post_thumbnail($post->ID, $imagesize).'</a>';
							}
						$html.='</div>';
						
						$html.='<div class="post-info">';
						
							$html.='<h3 class="post-title"><a href="'.get_the_permalink($post->ID).'">'.get_the_title($post->ID).'</a></h3>';
							
							$html.='<ul class="post-entry-data">
										<li class="post-date"><i class="fa fa-calendar"></i>'. get_the_date( get_option( 'date_format' ), $post->ID ) .'</li>
										<li class="post-comments"><a href="' . get_comments_link($post->ID) .'">' . sprintf(esc_html__('%d Comment(s)', 'hermes'), get_comments_number( $post->ID )) . '</a></li>
									</ul>';
							$html.='<div class="post-excerpt">';
								$html.= lionthemes_get_excerpt($post->ID, $length);
							$html.='</div>';
						
						$html.='</div>';

					$html.='</div>';
				$html.='</div>';
				if($rows > 1 && $style == 'carousel'){
					if (($post_index % $rows == 0) || $post_index == $total ) {
						$html .= '</div>';
					}
				}
			}
		$html .= ($style == 'carousel') ? '</div>':'';
	$html.='</div>';
	$html.='</div>';

	wp_reset_postdata();
	
	return $html;
}
add_shortcode( 'blogposts', 'hermes_blogposts_shortcode' );
?>