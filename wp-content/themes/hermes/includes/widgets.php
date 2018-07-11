<?php
/**
* Theme specific widgets or widget overrides
*
* @package LionThemes
* @subpackage Hermes_theme
* @since Hermes Themes 1.6
*/
 
/**
 * Register widgets
 *
 * @return void
 */
function hermes_widgets_init() {
	register_sidebar( array(
		'name' => esc_html__( 'Blog Sidebar', 'hermes' ),
		'id' => 'blog',
		'description' => esc_html__( 'Appears on blog page', 'hermes' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s first_last">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	) );
	
	register_sidebar( array(
		'name' => esc_html__( 'Shop Sidebar', 'hermes' ),
		'id' => 'shop',
		'description' => esc_html__( 'Sidebar on shop page', 'hermes' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s first_last">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	) );

	register_sidebar( array(
		'name' => esc_html__( 'Product Sidebar', 'hermes' ),
		'id' => 'product',
		'description' => esc_html__( 'Sidebar on product detail page', 'hermes' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s first_last">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	) );

	register_sidebar( array(
		'name' => esc_html__( 'Top Bar Header', 'hermes' ),
		'id' => 'top_header',
		'description' => esc_html__( 'This area on top bar of header to display language switcher, currency switcher, hotline ...', 'hermes' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	) );

	
	register_sidebar( array(
		'name' => esc_html__( 'Footer 4 columns', 'hermes' ),
		'id' => 'footer_4columns',
		'description' => esc_html__( 'This area to display 4 widgets for 4 columns, use in Home 1, 2, 3 footer layout.', 'hermes' ),
		'before_widget' => '<div class="col-md-3 col-sm-6">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	) );

	register_sidebar( array(
		'name' => esc_html__( 'Footer 3 columns left', 'hermes' ),
		'id' => 'footer_3columns_left',
		'description' => esc_html__( 'This area to display one widget for 3 columns left, use in Home 4, 5 footer layout.', 'hermes' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	) );

	register_sidebar( array(
		'name' => esc_html__( 'Footer 3 columns center', 'hermes' ),
		'id' => 'footer_3columns_center',
		'description' => esc_html__( 'This area to display 2 widgets for 3 columns center, use in Home 4, 5 footer layout.', 'hermes' ),
		'before_widget' => '<div class="col-md-2 col-sm-6">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	) );

	
	register_sidebar( array(
		'name' => esc_html__( 'Footer 3 columns right', 'hermes' ),
		'id' => 'footer_3columns_right',
		'description' => esc_html__( 'This area to display one widget for 3 columns right, use in Home 4, 5 footer layout.', 'hermes' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	) );

	register_sidebar( array(
		'name' => esc_html__( 'Footer Vertical Newsletter', 'hermes' ),
		'id' => 'footer_newsletter',
		'description' => esc_html__( 'This area to display Newsletter widget for vertical form in footer, use in Home 1, 2 footer layout.', 'hermes' ),
		'before_widget' => '<div class="newletter-form-wrapper">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="newletter-title"><span>',
		'after_title' => '</span></h3>',
	) );

	register_sidebar( array(
		'name' => esc_html__( 'Footer Vertical Menu Links', 'hermes' ),
		'id' => 'footer_vertical_menu',
		'description' => esc_html__( 'This area to display vertical links in footer, use in Home 1, 2 footer layout.', 'hermes' ),
		'before_widget' => '<div class="widget widget_menu">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	) );

	register_sidebar( array(
		'name' => esc_html__( 'Footer Payment Support', 'hermes' ),
		'id' => 'footer_payment',
		'description' => esc_html__( 'This area to display footer payment support.', 'hermes' ),
		'before_widget' => '<div class="widget-payment">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	) );

	register_sidebar( array(
		'name' => esc_html__( 'Footer Copyright text', 'hermes' ),
		'id' => 'footer_copyright',
		'description' => esc_html__( 'This area to display custom copyright text. Default it get home page and website name with current year to display.', 'hermes' ),
		'before_widget' => '<div class="widget-copyright">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	) );

	register_widget( 'Hermes_Widget_Post' );
	register_widget( 'Hermes_Widget_Recent_Comment' );
}
add_action( 'widgets_init', 'hermes_widgets_init' ); 


//custom blog widget
class Hermes_Widget_Post extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'description' => esc_html__( 'Hermes recent post', 'hermes' )
		);
		parent::__construct( 'hermes_recent_post', esc_html__( 'Hermes - Recent Post', 'hermes' ), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		if ( empty( $instance['number'] ) || !$number = absint( $instance['number'] ) ) {
			$number = 10;
		}
		$args_sql = array(
			'post_type' => 'post', 
			'numberposts' => $number,
			'post_status' => 'publish, future',
			'suppress_filters' => false,
			'date_query' => array(
				array(
				   'before' => date('Y-m-d H:i:s', current_time( 'timestamp' ))
				)
			 )
		);
		$recents = wp_get_recent_posts($args_sql);
		
		if ( !empty($recents) ){
			echo $before_widget;
			if ( $title ) {
				echo $before_title . $title . $after_title;
			}
			echo '<ul>';
			foreach( $recents as $recent ){ ?>
				<li>
					<a class="post-thumbnail pull-left<?php echo (!get_the_post_thumbnail( $recent["ID"], 'thumbnail' )) ? ' no-thumb':''; ?>" href="<?php echo get_permalink($recent["ID"]); ?>">
						<?php echo get_the_post_thumbnail( $recent["ID"], 'thumbnail' ); ?>
					</a>
					<div class="post-info media-body">
						<a class="post-title" href="<?php echo get_permalink($recent["ID"]); ?>">
							<?php echo esc_html($recent["post_title"]); ?>
						</a>
						<span class="post-date"><?php echo get_the_date(get_option( 'date_format' ), $recent["ID"]); ?></span>
					</div>
				</li>
			<?php }
			echo '</ul>';
			echo $after_widget;
		}
		
	}
	// widget options
	function form( $instance ){
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 10;
		?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php echo esc_html__( 'Title:', 'hermes' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php echo esc_html__( 'Number of post to show:', 'hermes' ); ?></label>
		<input id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" type="text" value="<?php echo esc_attr($number); ?>" size="3" /></p>
		<?php
	}
}

//custom recent comment widget
class Hermes_Widget_Recent_Comment extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'description' => esc_html__( 'Hermes recent comment', 'hermes' )
		);
		parent::__construct( 'hermes_recent_comment', esc_html__( 'Hermes - Recent Comment', 'hermes' ), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		if ( empty( $instance['number'] ) || !$number = absint( $instance['number'] ) ) {
			$number = 10;
		}
		$args = array();
		$args['post_type'] = empty( $instance['post_type'] ) ? '' : $instance['post_type'];
		$args['status'] = 'approve';
		$args['number'] = $number;
		$comments = get_comments($args);
		if ( !empty($comments) ){
			echo $before_widget;
			if ( $title ) {
				echo $before_title . $title . $after_title;
			}
			echo '<ul>';
			foreach( $comments as $comment ){ ?>
				<li>
					<div class="avatar pull-left"><?php echo get_avatar( $comment->comment_author_email ) ?></div>
					<div class="comment_info media-body">
						<p class="author"><?php echo esc_html($comment->comment_author) ?></p>
						<p class="comment_content"><?php echo wp_trim_words( $comment->comment_content, $num_words = 5, $more = '...' ) ?></p>
						<p class="on_post"><?php echo esc_html__('on', 'hermes') ?> <a href="<?php echo get_permalink($comment->comment_post_ID) . '#comment-' . $comment->comment_ID; ?>"><?php echo get_the_title($comment->comment_post_ID) ?></a></p>
					</div>
				</li>
			<?php }
			echo '</ul>';
			echo $after_widget;
		}
		
	}
	// widget options
	function form( $instance ){
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 10;
		$post_type = isset( $instance['post_type'] ) ? esc_attr( $instance['post_type'] ) : '';
		?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php echo esc_html__( 'Title:', 'hermes' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php echo esc_html__( 'Number of post to show:', 'hermes' ); ?></label>
		<input id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" type="text" value="<?php echo esc_attr($number); ?>" size="3" /></p>
		
		<p><label for="<?php echo esc_attr($this->get_field_id( 'post_type' )); ?>"><?php echo esc_html__( 'Type of list:', 'hermes' ); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id( 'post_type' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'post_type' )); ?>">
				<option value=""><?php echo esc_html__('All', 'hermes' ) ?></option>
				<option value="product" <?php echo ($post_type == 'product') ? 'selected="selected"': ''; ?>><?php echo esc_html__('Products', 'hermes' ) ?></option>
				<option value="post" <?php echo ($post_type == 'post') ? 'selected="selected"': ''; ?>><?php echo esc_html__('Post', 'hermes' ) ?></option>
			</select>
		</p>
		
		<?php
	}
}
