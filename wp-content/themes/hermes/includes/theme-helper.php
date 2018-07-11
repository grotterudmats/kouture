<?php
// create table to save user like
add_action( 'init', 'hermes_new_like_post_table' );
function hermes_new_like_post_table(){
	global $wpdb;
	$table_name = $wpdb->prefix.'hermes_user_like_ip';
	if($wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name) {
		 //table not in database. Create new table
		 $charset_collate = $wpdb->get_charset_collate();
		 $sql = "CREATE TABLE `{$table_name}` (
			  `post_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
			  `user_ip` VARCHAR(100) NOT NULL DEFAULT '',
			  PRIMARY KEY (`post_id`,`user_ip`)
		 ) {$charset_collate}";
		 require_once(  ABSPATH . 'wp-admin/includes/upgrade.php' );
		 dbDelta( $sql );
	}
}


// All Voisen theme helper functions in here
function hermes_get_effect_list(){
	return array(
		esc_html__( 'None', 'hermes' ) 	=> '',
		esc_html__( 'Bounce In', 'hermes' ) 	=> 'bounceIn',
		esc_html__( 'Bounce In Down', 'hermes' ) 	=> 'bounceInDown',
		esc_html__( 'Bounce In Left', 'hermes' ) 	=> 'bounceInLeft',
		esc_html__( 'Bounce In Right', 'hermes' ) 	=> 'bounceInRight',
		esc_html__( 'Bounce In Up', 'hermes' ) 	=> 'bounceInUp',
		esc_html__( 'Fade In', 'hermes' ) 	=> 'fadeIn',
		esc_html__( 'Fade In Down', 'hermes' ) 	=> 'fadeInDown',
		esc_html__( 'Fade In Left', 'hermes' ) 	=> 'fadeInLeft',
		esc_html__( 'Fade In Right', 'hermes' ) 	=> 'fadeInRight',
		esc_html__( 'Fade In Up', 'hermes' ) 	=> 'fadeInUp',
		esc_html__( 'Flip In X', 'hermes' ) 	=> 'flipInX',
		esc_html__( 'Flip In Y', 'hermes' ) 	=> 'flipInY',
		esc_html__( 'Light Speed In', 'hermes' ) 	=> 'lightSpeedIn',
		esc_html__( 'Rotate In', 'hermes' ) 	=> 'rotateIn',
		esc_html__( 'Rotate In Down Left', 'hermes' ) 	=> 'rotateInDownLeft',
		esc_html__( 'Rotate In Down Right', 'hermes' ) 	=> 'rotateInDownRight',
		esc_html__( 'Rotate In Up Left', 'hermes' ) 	=> 'rotateInUpLeft',
		esc_html__( 'Rotate In Up Right', 'hermes' ) 	=> 'rotateInUpRight',
		esc_html__( 'Slide In Down', 'hermes' ) 	=> 'slideInDown',
		esc_html__( 'Slide In Left', 'hermes' ) 	=> 'slideInLeft',
		esc_html__( 'Slide In Right', 'hermes' ) 	=> 'slideInRight',
		esc_html__( 'Roll In', 'hermes' ) 	=> 'rollIn',
	);
}


// All Hermes theme helper functions in here
function hermes_woocommerce_query($type,$post_per_page=-1,$cat='', $keyword = null){
	$args = hermes_woocommerce_query_args($type,$post_per_page,$cat, $keyword);
	return new WP_Query($args);
}
function hermes_vc_custom_css_class( $param_value, $prefix = '' ) {
	$css_class = preg_match( '/\s*\.([^\{]+)\s*\{\s*([^\}]+)\s*\}\s*/', $param_value ) ? $prefix . preg_replace( '/\s*\.([^\{]+)\s*\{\s*([^\}]+)\s*\}\s*/', '$1', $param_value ) : '';
	return $css_class;
}
function hermes_woocommerce_query_args($type,$post_per_page=-1,$cat='',$keyword=null){
	global $woocommerce;
    remove_filter( 'posts_clauses', array( $woocommerce->query, 'order_by_popularity_post_clauses' ) );
	$product_visibility_term_ids = wc_get_product_visibility_term_ids();
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $post_per_page,
        'post_status' => 'publish',
		'date_query' => array(
			array(
			   'before' => date('Y-m-d H:i:s', current_time( 'timestamp' ))
			)
		 ),
		 'tax_query' => array(
			array(
				'taxonomy' => 'product_visibility',
				'field'    => 'term_taxonomy_id',
				'terms'    => is_search() ? $product_visibility_term_ids['exclude-from-search'] : $product_visibility_term_ids['exclude-from-catalog'],
				'operator' => 'NOT IN',
			)
		 ),
		 'post_parent' => 0
    );
    switch ($type) {
        case 'best_selling':
            $args['meta_key']='total_sales';
            $args['orderby']='meta_value_num';
            $args['ignore_sticky_posts']   = 1;
            $args['meta_query'] = array();
            break;
        case 'featured_product':
            $args['ignore_sticky_posts'] = 1;
            $args['meta_query'] = array();
            $args['tax_query'][] = array(
				'taxonomy' => 'product_visibility',
				'field'    => 'term_taxonomy_id',
				'terms'    => $product_visibility_term_ids['featured'],
			);
            break;
        case 'top_rate':
            $args['meta_key']='_wc_average_rating';
            $args['orderby']='meta_value_num';
            $args['order']='DESC';
            $args['meta_query'] = array();
            break;
        case 'recent_product':
            $args['meta_query'] = array();
            break;
        case 'on_sale':
            $args['meta_query'] = array();
            $product_ids_on_sale    = wc_get_product_ids_on_sale();
			$product_ids_on_sale[]  = 0;
            $args['post__in'] = $product_ids_on_sale;
            break;
        case 'recent_review':
            if($post_per_page == -1) $_limit = 4;
            else $_limit = $post_per_page;
            global $wpdb;
            $query = "SELECT c.comment_post_ID FROM {$wpdb->posts} p, {$wpdb->comments} c WHERE p.ID = c.comment_post_ID AND c.comment_approved > 0 AND p.post_type = 'product' AND p.post_status = 'publish' AND p.comment_count > 0 ORDER BY c.comment_date ASC LIMIT 0, %d";
            $safe_sql = $wpdb->prepare( $query, $_limit );
			$results = $wpdb->get_results($safe_sql, OBJECT);
            $_pids = array();
            foreach ($results as $re) {
                $_pids[] = $re->comment_post_ID;
            }

            $args['meta_query'] = array();
            $args['post__in'] = $_pids;
            break;
        case 'deals':
            $args['meta_query'] = array();
            $args['meta_query'][] = array(
                                 'key' => '_sale_price_dates_to',
                                 'value' => '0',
                                 'compare' => '>');
            $product_ids_on_sale    = wc_get_product_ids_on_sale();
			$product_ids_on_sale[]  = 0;
            $args['post__in'] = $product_ids_on_sale;
            break;
    }

    if($cat!=''){
        $args['tax_query'] = array(
			array(
				'taxonomy' => 'product_cat',
				'field' => 'slug',
				'terms' => $cat
			)
		);
    }
	if($keyword){
		$args['s'] = $keyword;
	}
    return $args;
}
function hermes_make_id($length = 5){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
//Change excerpt length
add_filter( 'excerpt_length', 'hermes_excerpt_length', 999 );
function hermes_excerpt_length( $length ) {
	global $hermes_opt;
	if(isset($hermes_opt['excerpt_length'])){
		return $hermes_opt['excerpt_length'];
	}
	return 22;
}
function hermes_get_the_excerpt($post_id) {
	global $post;
	$temp = $post;
    $post = get_post( $post_id );
    setup_postdata( $post );
    $excerpt = get_the_excerpt();
    wp_reset_postdata();
    $post = $temp;
    return $excerpt;
}

//Add breadcrumbs
function hermes_breadcrumb() {
	global $post, $hermes_opt;
	
	$brseparator = '<span class="separator">/</span>';
	if (!is_home()) {
		echo '<div class="breadcrumbs">';
		
		echo '<a href="';
		echo esc_url( home_url( '/' ) );
		echo '">';
		echo esc_html__('Home', 'hermes');
		echo '</a>'.$brseparator;
		if (is_category() || is_single()) {
			the_category($brseparator);
			if (is_single()) {
				echo ''.$brseparator;
				the_title();
			}
		} elseif (is_page()) {
			if($post->post_parent){
				$anc = get_post_ancestors( $post->ID );
				$title = get_the_title();
				foreach ( $anc as $ancestor ) {
					$output = '<a href="'. esc_url(get_permalink($ancestor)).'" title="'.esc_attr(get_the_title($ancestor)).'">'. esc_html(get_the_title($ancestor)) .'</a>'.$brseparator;
				}
				echo wp_kses($output, array(
						'a'=>array(
							'href' => array(),
							'title' => array()
						),
						'span'=>array(
							'class'=>array()
						)
					)
				);
				echo '<span title="'.esc_attr($title).'"> '.esc_html($title).'</span>';
			} else {
				echo '<span> '. esc_html(get_the_title()).'</span>';
			}
		}
		elseif (is_tag()) {single_tag_title();}
		elseif (is_day()) {echo "<span>" . sprintf(esc_html__('Archive for %s', 'hermes'), the_time('F jS, Y')); echo '</span>';}
		elseif (is_month()) {echo "<span>" . sprintf(esc_html__('Archive for %s', 'hermes'), the_time('F, Y')); echo '</span>';}
		elseif (is_year()) {echo "<span>" . sprintf(esc_html__('Archive for %s', 'hermes'), the_time('Y')); echo '</span>';}
		elseif (is_author()) {echo "<span>" . esc_html__('Author Archive', 'hermes'); echo '</span>';}
		elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "<span>" . esc_html__('Blog Archives', 'hermes'); echo '</span>';}
		elseif (is_search()) {echo "<span>" . esc_html__('Search Results', 'hermes'); echo '</span>';}
		
		echo '</div>';
	} else {
		echo '<div class="breadcrumbs">';
		
		echo '<a href="';
		echo esc_url( home_url( '/' ) );
		echo '">';
		echo esc_html__('Home', 'hermes');
		echo '</a>'.$brseparator;
		
		if(isset($hermes_opt['blog_header_text']) && $hermes_opt['blog_header_text']!=""){
			echo esc_html($hermes_opt['blog_header_text']);
		} else {
			echo esc_html__('Blog', 'hermes');
		}
		
		echo '</div>';
	}
}
//social share products
function hermes_product_sharing() {
	global $hermes_opt;
	$pro_social_share = array();
	if(isset($hermes_opt['pro_social_share']) && is_array($hermes_opt['pro_social_share'])){
		$pro_social_share = array_filter($hermes_opt['pro_social_share']);
	}
	if(!empty($pro_social_share)){
		if(isset($_POST['data'])) { // for the quickview
			$postid = intval( $_POST['data'] );
		} else {
			$postid = get_the_ID();
		}
		
		$share_url = get_permalink( $postid );

		$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $postid ), 'large' );
		$postimg = $large_image_url[0];
		$posttitle = get_the_title( $postid );
		?>
		<div class="widget widget_socialsharing_widget">
			<h3 class="widget-title"><?php if(isset($hermes_opt['product_share_title'])) { echo esc_html($hermes_opt['product_share_title']); } else { esc_html_e('Share this product', 'hermes'); } ?></h3>
			<ul class="social-icons">
				<?php if(!empty($hermes_opt['pro_social_share']['facebook'])){ ?>
				<li><a class="facebook social-icon" href="javascript:void(0)" onclick="javascript:window.open('<?php echo 'https://www.facebook.com/sharer/sharer.php?u='.esc_url($share_url); ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;" title="<?php echo esc_attr__('Facebook', 'hermes'); ?>"><i class="fa fa-facebook"></i></a></li>
				<?php } ?>
				<?php if(!empty($hermes_opt['pro_social_share']['twitter'])){ ?>
				<li><a class="twitter social-icon" href="javascript:void(0)" onclick="javascript:window.open('<?php echo 'https://twitter.com/home?status='.esc_html($posttitle).'&nbsp;'.esc_url($share_url); ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;" title="<?php echo esc_attr__('Twitter', 'hermes'); ?>" ><i class="fa fa-twitter"></i></a></li>
				<?php } ?>
				<?php if(!empty($hermes_opt['pro_social_share']['pinterest'])){ ?>
				<li><a class="pinterest social-icon" href="javascript:void(0)" onclick="javascript:window.open('<?php echo 'https://pinterest.com/pin/create/button/?url='.esc_url($share_url).'&amp;media='.esc_html($postimg).'&amp;description='.esc_url($posttitle); ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;" title="<?php echo esc_attr__('Pinterest', 'hermes'); ?>"><i class="fa fa-pinterest"></i></a></li>
				<?php } ?>
				<?php if(!empty($hermes_opt['pro_social_share']['gplus'])){ ?>
				<li><a class="gplus social-icon" href="javascript:void(0)" onclick="javascript:window.open('<?php echo 'https://plus.google.com/share?url='.esc_url($share_url); ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;" title="<?php echo esc_attr__('Google +', 'hermes'); ?>"><i class="fa fa-google-plus"></i></a></li>
				<?php } ?>
				<?php if(!empty($hermes_opt['pro_social_share']['linkedin'])){ ?>
				<li><a class="linkedin social-icon" href="javascript:void(0)" onclick="javascript:window.open('<?php echo 'https://www.linkedin.com/shareArticle?mini=true&amp;url='.esc_url($share_url).'&amp;title='.esc_html($posttitle); ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;" title="<?php echo esc_attr__('LinkedIn', 'hermes'); ?>"><i class="fa fa-linkedin"></i></a></li>
				<?php } ?>
			</ul>
		</div>
	<?php
	}
}
//social share blog
function hermes_blog_sharing() {
	global $hermes_opt;
	$blog_social_share = array();
	if(isset($hermes_opt['blog_social_share']) && is_array($hermes_opt['blog_social_share'])){
		$blog_social_share = array_filter($hermes_opt['blog_social_share']);
	}
	if(!empty($blog_social_share)){
		if(isset($_POST['data'])) { // for the quickview
			$postid = intval( $_POST['data'] );
		} else {
			$postid = get_the_ID();
		}
		
		$share_url = get_permalink( $postid );

		$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $postid ), 'large' );
		$postimg = $large_image_url[0];
		$posttitle = get_the_title( $postid );
		?>
		<div class="widget widget_socialsharing_widget">
			<ul class="social-icons">
				<?php if(!empty($hermes_opt['blog_social_share']['facebook'])){ ?>
				<li><a class="facebook social-icon" href="javascript:void(0)" onclick="javascript:window.open('<?php echo 'https://www.facebook.com/sharer/sharer.php?u='. esc_url($share_url); ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;" title="<?php echo esc_attr__('Facebook', 'hermes'); ?>"><i class="fa fa-facebook"></i></a></li>
				<?php } ?>
				<?php if(!empty($hermes_opt['blog_social_share']['twitter'])){ ?>
				<li><a class="twitter social-icon" href="javascript:void(0)" onclick="javascript:window.open('<?php echo 'https://twitter.com/home?status='.esc_html($posttitle).'&nbsp;'.esc_url($share_url); ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;" title="<?php echo esc_attr__('Twitter', 'hermes'); ?>"><i class="fa fa-twitter"></i></a></li>
				<?php } ?>
				<?php if(!empty($hermes_opt['blog_social_share']['pinterest'])){ ?>
				<li><a class="pinterest social-icon" href="javascript:void(0)" onclick="javascript:window.open('<?php echo 'https://pinterest.com/pin/create/button/?url='.esc_url($share_url).'&amp;media='.esc_url($postimg).'&amp;description='.esc_html($posttitle); ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;" title="<?php echo esc_attr__('Pinterest', 'hermes'); ?>"><i class="fa fa-pinterest"></i></a></li>
				<?php } ?>
				<?php if(!empty($hermes_opt['blog_social_share']['gplus'])){ ?>
				<li><a class="gplus social-icon" href="javascript:void(0)" onclick="javascript:window.open('<?php echo 'https://plus.google.com/share?url='.esc_url($share_url); ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;" title="<?php echo esc_attr__('Google +', 'hermes'); ?>"><i class="fa fa-google-plus"></i></a></li>
				<?php } ?>
				<?php if(!empty($hermes_opt['blog_social_share']['linkedin'])){ ?>
				<li><a class="linkedin social-icon" href="javascript:void(0)" onclick="javascript:window.open('<?php echo 'https://www.linkedin.com/shareArticle?mini=true&amp;url='.esc_url($share_url).'&amp;title='.esc_html($posttitle); ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;" title="<?php echo esc_attr__('LinkedIn', 'hermes'); ?>"><i class="fa fa-linkedin"></i></a></li>
				<?php } ?>
			</ul>
		</div>
	<?php
	}
}
// function display number view of posts.
function hermes_get_post_viewed($postID){
    $count_key = 'post_views_count';
	delete_post_meta($postID, 'post_like_count');
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return 0;
    }
    return $count;
}
// function to count views.
function hermes_set_post_view($postID){
    $count_key = 'post_views_count';
    $count = (int)get_post_meta($postID, $count_key, true);
    if(!$count){
        $count = 1;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, $count);
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
// function display number like of posts.
function hermes_get_liked($postID){
    global $wpdb;
    $table_name = $wpdb->prefix . 'hermes_user_like_ip';
	$safe_sql = $wpdb->prepare("SELECT COUNT(*) FROM {$table_name} WHERE post_id = %s", $postID);
    $results = $wpdb->get_var( $safe_sql );
    return $results;
}

add_action( 'wp_ajax_hermes_update_like', 'hermes_update_like' );
add_action( 'wp_ajax_nopriv_hermes_update_like', 'hermes_update_like' );
function hermes_get_the_user_ip(){
	if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}
function hermes_check_liked_post($postID){
	global $wpdb;
    $table_name = $wpdb->prefix . 'hermes_user_like_ip';
	$user_ip = hermes_get_the_user_ip();
	$safe_sql = $wpdb->prepare("SELECT COUNT(*) FROM {$table_name} WHERE post_id = %s AND user_ip = %s", $postID, $user_ip);
    $results = $wpdb->get_var( $safe_sql );
	return $results;
}
function hermes_update_like(){
	$count_key = 'post_like_count';
	if(empty($_POST['post_id'])){
	   die('0');
	}else{
		global $wpdb;
		$table_name = $wpdb->prefix . 'hermes_user_like_ip';
		$postID = intval($_POST['post_id']);
		$check = hermes_check_liked_post($postID);
		$ip = hermes_get_the_user_ip();
		$data = array('post_id' => $postID, 'user_ip' => $ip);
		if($check){
			//remove like record
			$wpdb->delete( $table_name, $data ); 
		}else{
			//add new like record
			$wpdb->insert( $table_name, $data );
		}
		echo hermes_get_liked($postID);
		die();
	}
}


//get taxonomy list by parent children
function hermes_get_all_taxonomy_terms($taxonomy = 'product_cat', $all = false){
	
	global $wpdb;
	
	$arr = array(
		'orderby' => 'name',
		'hide_empty' => 0
	);
	$categories = $wpdb->get_results($wpdb->prepare("SELECT t.name,t.slug,t.term_group,x.term_taxonomy_id,x.term_id,x.taxonomy,x.description,x.parent,x.count FROM {$wpdb->prefix}term_taxonomy x LEFT JOIN {$wpdb->prefix}terms t ON (t.term_id = x.term_id) WHERE x.taxonomy=%s ORDER BY x.parent ASC, t.name ASC;", $taxonomy));
	$output = array();
	if($all) $output = array( array('label' => esc_html__('All categories', 'hermes'), 'value' => '') );
	if(!is_array($categories)) return $output;
	hermes_get_repare_terms_children( 0, 0, $categories, 0, $output );
	
	return $output;
}

function hermes_get_repare_terms_children( $parent_id, $pos, $categories, $level, &$output ) {
	for ( $i = $pos; $i < count( $categories ); $i ++ ) {
		if ( isset($categories[ $i ]->parent) && $categories[ $i ]->parent == $parent_id ) {
			$name = str_repeat( " - ", $level ) . ucfirst($categories[ $i ]->name);
			$value = $categories[ $i ]->slug;
			$output[] = array( 'label' => $name, 'value' => $value );
			hermes_get_repare_terms_children( $categories[ $i ]->term_id, $i, $categories, $level + 1, $output );
		}
	}
}


//popup onload home page
add_action( 'wp_footer', 'hermes_popup_onload');
function hermes_popup_onload(){
	
	global $hermes_opt;
	
	echo '<div class="quickview-wrapper"><div class="overlay-bg" onclick="hideQuickView()"></div><div class="quick-modal"><span class="qvloading"></span><span class="closeqv"><i class="fa fa-times"></i></span><div id="quickview-content"></div><div class="clearfix"></div></div></div>';
	
	if(isset($hermes_opt['enable_popup']) && $hermes_opt['enable_popup']){
		if (is_front_page() && (!empty($hermes_opt['popup_onload_form']) || !empty($hermes_opt['popup_onload_content']))) {
			$no_again = 0; 
			if(isset($_COOKIE['no_again'])) $no_again = $_COOKIE['no_again'];
			if(!$no_again){
		?>
			<div class="popup-content" id="popup_onload">
				<div class="overlay-bg-popup"></div>
				<div class="popup-content-wrapper">
					<a class="close-popup" href="javascript:void(0)"><i class="fa fa-times"></i></a>
					<div class="popup-container">
						<div class="row">
							<div class="col-md-offset-6">
								<?php if(!empty($hermes_opt['popup_onload_content'])){ ?>
								<div class="popup-content-text">
									<?php echo wp_kses($hermes_opt['popup_onload_content'], array(
											'a' => array(
											'href' => array(),
											'title' => array()
											),
											'div' => array(
												'class' => array(),
											),
											'img' => array(
												'src' => array(),
												'alt' => array()
											),
											'h1' => array(
												'class' => array(),
											),
											'h2' => array(
												'class' => array(),
											),
											'h3' => array(
												'class' => array(),
											),
											'h4' => array(
												'class' => array(),
											),
											'ul' => array(),
											'li' => array(),
											'i' => array(
												'class' => array()
											),
											'br' => array(),
											'em' => array(),
											'strong' => array(),
											'p' => array(),
									)); ?>
								</div>
								<?php } ?>
								<?php if(!empty($hermes_opt['popup_onload_form'])){ ?>
								<div class="newletter-form">
									<?php 
										$short_code = (!empty($hermes_opt['use_mailchimp_form'])) ? 'mc4wp_form' : 'wysija_form';
										echo do_shortcode( '['. $short_code .' id="'. $hermes_opt['popup_onload_form'] .'"]' );
									?>
								</div>
								<?php } ?>
								<label class="not-again"><input type="checkbox" value="1" name="not-again" /><span><?php echo esc_html__('Do not show this popup again', 'hermes'); ?></span></label>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } 
		}
	}
}
?>