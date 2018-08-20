<?php

	/*
	*
	*	Atelier Functions
	*	------------------------------------------------
	*	Swift Framework
	* 	Copyright Swift Ideas 2016 - http://www.swiftideas.com
	*
	*	VARIABLE DEFINITIONS
	*	PLUGIN INCLUDES
	*	THEME UPDATER
	*	THEME SUPPORT
	*	THUMBNAIL SIZES
	*	CONTENT WIDTH
	*	LOAD THEME LANGUAGE
	*	sf_custom_content_functions()
	*	sf_include_framework()
	*	sf_enqueue_styles()
	*	sf_enqueue_scripts()
	*	sf_load_custom_scripts()
	*	sf_admin_scripts()
	*	sf_layerslider_overrides()
	*
	*/
	

	/* VARIABLE DEFINITIONS
	================================================== */
	define('SF_TEMPLATE_PATH', get_template_directory());
	define('SF_INCLUDES_PATH', SF_TEMPLATE_PATH . '/includes');
	define('SF_FRAMEWORK_PATH', SF_TEMPLATE_PATH . '/swift-framework');
	define('SF_WIDGETS_PATH', SF_INCLUDES_PATH . '/widgets');
	define('SF_LOCAL_PATH', get_template_directory_uri());

	/* PLUGIN INCLUDES
	================================================== */
	require_once(SF_INCLUDES_PATH . '/plugins/aq_resizer.php');
	include_once(SF_INCLUDES_PATH . '/plugin-includes.php');
	require_once(SF_INCLUDES_PATH . '/theme_update_check.php');
	$AtelierUpdateChecker = new ThemeUpdateChecker(
	    'atelier',
	    'https://kernl.us/api/v1/theme-updates/564c90177ad3303b210d6b47/'
	);

	/* THEME SETUP
	================================================== */
	if (!function_exists('sf_atelier_setup')) {
		function sf_atelier_setup() {

			/* SF THEME OPTION CHECK
			================================================== */
			if ( get_option( 'sf_theme' ) == false ) {
				update_option( 'sf_theme', 'atelier' );
			}

			/* THEME SUPPORT
			================================================== */
			add_theme_support( 'structured-post-formats', array('audio', 'gallery', 'image', 'link', 'video') );
			add_theme_support( 'post-formats', array('aside', 'chat', 'quote', 'status') );
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'woocommerce' );
			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );
			
			add_theme_support( 'swiftframework', array(
				'swift-smartscript'			=> true,
				'slideout-menu'				=> true,
				'page-heading-woocommerce'	=> false,
				'pagination-fullscreen'		=> false,
				'bordered-button'			=> true,
				'3drotate-button'			=> false,
				'rounded-button'			=> true,
				'product-inner-heading'		=> true,
				'product-summary-tabs'		=> false,
				'product-layout-opts'		=> true,
				'mobile-shop-filters' 		=> true,
				'mobile-logo-override'		=> true,
				'product-multi-masonry'		=> true,
				'product-preview-slider'	=> true,
				'super-search-config'		=> true,
				'advanced-row-styling'		=> true,
				'gizmo-icon-font'			=> false,
				'icon-mind-font'			=> true,
				'nucleo-general-font'		=> false,
				'nucleo-interface-font'		=> false,
				'menu-new-badge'			=> true,
				'advanced-map-styles'		=> true,
				'minimal-team-hover'		=> false,
				'pushnav-menu'				=> false,
				'split-nav-menu'			=> false,
				'max-mega-menu'				=> false,
				'page-heading-woo-description' => false,
				'header-aux-modals'			=> false,
				'hamburger-css' 			=> false,
				'alt-recent-post-list'		=> false,
			) );

			/* THUMBNAIL SIZES
			================================================== */
			set_post_thumbnail_size( 220, 150, true);
			add_image_size( 'widget-image', 94, 70, true);
			add_image_size( 'thumb-square', 250, 250, true);
			add_image_size( 'thumb-image', 600, 450, true);
			add_image_size( 'thumb-image-twocol', 900, 675, true);
			add_image_size( 'thumb-image-onecol', 1800, 1200, true);
			add_image_size( 'blog-image', 1280, 9999);
			add_image_size( 'gallery-image', 1000, 9999);
			add_image_size( 'large-square', 1200, 1200, true);
			add_image_size( 'full-width-image-gallery', 1280, 720, true);

			/* CONTENT WIDTH
			================================================== */
			if ( ! isset( $content_width ) ) $content_width = 1140;

			/* LOAD THEME LANGUAGE
			================================================== */
			load_theme_textdomain('swiftframework', SF_TEMPLATE_PATH.'/language');

		}
		add_action( 'after_setup_theme', 'sf_atelier_setup' );
	}


	/* THEME FRAMEWORK FUNCTIONS
	================================================== */
	include_once( SF_FRAMEWORK_PATH . '/core/sf-sidebars.php' );
	include_once( SF_FRAMEWORK_PATH . '/widgets/widget-twitter.php' );
	include_once( SF_FRAMEWORK_PATH . '/widgets/widget-flickr.php' );
	include_once( SF_FRAMEWORK_PATH . '/widgets/widget-instagram.php' );
	include_once( SF_FRAMEWORK_PATH . '/widgets/widget-video.php' );
	include_once( SF_FRAMEWORK_PATH . '/widgets/widget-posts.php' );
	include_once( SF_FRAMEWORK_PATH . '/widgets/widget-portfolio.php' );
	include_once( SF_FRAMEWORK_PATH . '/widgets/widget-portfolio-grid.php' );
	include_once( SF_FRAMEWORK_PATH . '/widgets/widget-advertgrid.php' );
	include_once( SF_FRAMEWORK_PATH . '/widgets/widget-infocus.php' );
	include_once( SF_FRAMEWORK_PATH . '/widgets/widget-comments.php' );
	include_once( SF_FRAMEWORK_PATH . '/widgets/widget-mostloved.php' );
	require_once(SF_INCLUDES_PATH . '/overrides/sf-theme-overrides.php');
	
	include_once(SF_INCLUDES_PATH . '/meta-box/meta-box.php');
	include_once(SF_INCLUDES_PATH . '/meta-boxes.php');
	
	if (!function_exists('sf_include_framework')) {
		function sf_include_framework() {
			require_once(SF_INCLUDES_PATH . '/overrides/sf-theme-functions.php');
			require_once(SF_INCLUDES_PATH . '/sf-customizer-options.php');
			include_once(SF_INCLUDES_PATH . '/sf-custom-styles.php');
			include_once(SF_INCLUDES_PATH . '/sf-styleswitcher/sf-styleswitcher.php');
			require_once(SF_INCLUDES_PATH . '/overrides/sf-spb-overrides.php');
			require_once(SF_FRAMEWORK_PATH . '/swift-framework.php');			
			include_once(SF_INCLUDES_PATH . '/overrides/sf-framework-overrides.php');
		}
		add_action('init', 'sf_include_framework', 5);
	}


	/* THEME OPTIONS FRAMEWORK
	================================================== */
	require_once(SF_INCLUDES_PATH . '/sf-colour-scheme.php');
	if (!function_exists('sf_include_theme_options')) {
		function sf_include_theme_options() {
			if (!class_exists( 'ReduxFramework' )) {
			    require_once( SF_INCLUDES_PATH . '/options/framework.php' );
			}
			require_once( SF_INCLUDES_PATH . '/option-extensions/loader.php' );
			require_once( SF_INCLUDES_PATH . '/sf-options.php' );
			global $sf_atelier_options, $sf_options;
			$sf_options = $sf_atelier_options;
		}
		add_action('init', 'sf_include_theme_options', 10);
	}

	
	/* THEME OPTIONS VAR RETRIEVAL
	================================================== */
	if (!function_exists('sf_get_theme_opts')) {
		function sf_get_theme_opts() {
			global $sf_atelier_options;
			return $sf_atelier_options;
		}
	}
	
	
	/* LOVE IT INCLUDE
	================================================== */
	if (!function_exists('sf_love_it_include')) {
		function sf_love_it_include() {
			global $sf_options;
			$disable_loveit = false;
			if (isset($sf_options['disable_loveit'])) {
			$disable_loveit = $sf_options['disable_loveit'];
			}

			if (!$disable_loveit) {
			include_once(SF_INCLUDES_PATH . '/plugins/love-it-pro/love-it-pro.php');
			}
		}
		add_action('init', 'sf_love_it_include', 20);
	}


	/* LOAD STYLESHEETS
	================================================== */
	if (!function_exists('sf_enqueue_styles')) {
		function sf_enqueue_styles() {

			global $sf_options, $is_IE;
			$enable_min_styles = $sf_options['enable_min_styles'];
			$enable_responsive = $sf_options['enable_responsive'];
			$enable_rtl = $sf_options['enable_rtl'];
            //$upload_dir = wp_upload_dir();

            //FONTELLO ICONS 
//            if ( get_option('sf_fontello_icon_codes') && get_option('sf_fontello_icon_codes') != '' ){
//				wp_register_style('sf-fontello',  $upload_dir['baseurl'] . '/redux/custom-icon-fonts/fontello_css/fontello-embedded.css', array(), NULL, 'all');
//				wp_enqueue_style('sf-fontello');
//		    }

		    wp_register_style('sf-style', get_stylesheet_directory_uri() . '/style.css', array(), NULL, 'all');
		    wp_register_style('bootstrap', SF_LOCAL_PATH . '/css/bootstrap.min.css', array(), NULL, 'all');
		    wp_register_style('fontawesome', SF_LOCAL_PATH .'/css/font-awesome.min.css', array(), NULL, 'all');
		    wp_register_style('sf-main', SF_LOCAL_PATH . '/css/main.css', array(), NULL, 'all');
		    wp_register_style('sf-rtl', SF_LOCAL_PATH . '/rtl.css', array(), NULL, 'all');
		    wp_register_style('sf-rtl-min', SF_LOCAL_PATH . '/rtl.min.css', array(), NULL, 'all');
		    wp_register_style('sf-woocommerce', SF_LOCAL_PATH . '/css/sf-woocommerce.css', array(), NULL, 'all');
		    wp_register_style('sf-edd', SF_LOCAL_PATH . '/css/sf-edd.css', array(), NULL, 'all');
		    wp_register_style('sf-edd', SF_LOCAL_PATH . '/css/sf-edd-min.css', array(), NULL, 'all');
		    wp_register_style('sf-responsive', SF_LOCAL_PATH . '/css/responsive.css', array(), NULL, 'all');
		    wp_register_style('sf-responsive-min', SF_LOCAL_PATH . '/css/responsive.css', array(), NULL, 'all');
		    wp_register_style('sf-combined-min', SF_LOCAL_PATH . '/css/sf-combined.min.css', array(), NULL, 'all');

			if ( $enable_min_styles && !$is_IE ) {
				wp_enqueue_style('sf-combined-min');
				
				if (sf_edd_activated()) {
					wp_enqueue_style('sf-edd-min');
				}

				if (is_rtl() || $enable_rtl || isset($_GET['RTL'])) {
			    	wp_enqueue_style('sf-rtl-min');
			    }

			    if ($enable_responsive) {
			    	wp_enqueue_style('sf-responsive-min');
			    }
				wp_enqueue_style('sf-style');
			} else {
			    wp_enqueue_style('bootstrap');
			    wp_enqueue_style('fontawesome');
			    wp_enqueue_style('sf-main');

			    if (sf_woocommerce_activated()) {
			    	wp_enqueue_style('sf-woocommerce');
			    }
			    
			    if (sf_edd_activated()) {
			    	wp_enqueue_style('sf-edd');
			    }

			    if (is_rtl() || $enable_rtl || isset($_GET['RTL'])) {
			    	wp_enqueue_style('sf-rtl');
			    }

			    if ($enable_responsive) {
			    	wp_enqueue_style('sf-responsive');
			    }

				wp_enqueue_style('sf-style');

			}
		}
		add_action('wp_enqueue_scripts', 'sf_enqueue_styles');
	}


	/* LOAD FRONTEND SCRIPTS
	================================================== */
	if (!function_exists('sf_enqueue_scripts')) {
		function sf_enqueue_scripts() {

			// Variables
			global $sf_options, $post;
		    $enable_rtl = $sf_options['enable_rtl'];
		    $enable_smoothscroll = $sf_options['enable_smoothscroll'];
		    $enable_min_scripts = $sf_options['enable_min_scripts'];
			$post_type = get_query_var('post_type');
			$product_zoom = $sf_options['enable_product_zoom'];
			$header_left_config  = $sf_options['header_left_config'];
            $header_right_config = $sf_options['header_right_config'];
			if ( isset($_GET['product_zoom']) ) {
				$product_zoom = true;
			}
			$lightbox_enabled 		  = true;
			if ( isset($sf_options['lightbox_enabled']) ) {
				$lightbox_enabled     = $sf_options['lightbox_enabled'];
			}

			// Page Content Meta
			$page_has_map = false;
			if ( $post ) {
				$page_has_map      = sf_get_post_meta( $post->ID, 'sf_page_has_map', true );
			}
			if ( is_page_template('template-directory-submit.php') || ( isset( $post ) && get_post_type( $post->ID ) == 'directory' ) ) {
				$page_has_map = true;	
			}
			if ( $header_left_config == "contact" || $header_right_config == "contact" ) {
				$page_has_map = true;
			}
			$gmaps_api_key = get_option('sf_gmaps_api_key');

		    // Register Scripts
		    wp_register_script('sf-bootstrap-js', SF_LOCAL_PATH . '/js/combine/bootstrap.min.js', 'jquery', NULL, TRUE);
		    wp_register_script('sf-isotope', SF_LOCAL_PATH . '/js/combine/jquery.isotope.min.js', 'jquery', NULL, TRUE);
		    wp_register_script('sf-imagesLoaded', SF_LOCAL_PATH . '/js/combine/imagesloaded.js', 'jquery', NULL, TRUE);
		    wp_register_script('sf-owlcarousel', SF_LOCAL_PATH . '/js/combine/owl.carousel.min.js', 'jquery', NULL, TRUE);
			wp_register_script('sf-jquery-ui', SF_LOCAL_PATH . '/js/combine/jquery-ui-1.11.4.custom.min.js', 'jquery', NULL, TRUE);
			wp_register_script('sf-ilightbox', SF_LOCAL_PATH . '/js/combine/ilightbox.min.js', 'jquery', NULL, TRUE);
		    wp_register_script('google-maps', '//maps.google.com/maps/api/js?key=' . $gmaps_api_key, 'jquery', NULL, TRUE);
		    wp_register_script('sf-elevatezoom', SF_LOCAL_PATH . '/js/combine/jquery.elevateZoom.min.js', 'jquery', NULL, TRUE);
		    wp_register_script('sf-infinite-scroll',  SF_LOCAL_PATH . '/js/combine/jquery.infinitescroll.min.js', 'jquery', NULL, TRUE);
		    wp_register_script('sf-theme-scripts', SF_LOCAL_PATH . '/js/combine/theme-scripts.js', 'jquery', NULL, TRUE);
		    wp_register_script('sf-theme-scripts-min', SF_LOCAL_PATH . '/js/sf-scripts.min.js', 'jquery', NULL, TRUE);
		    wp_register_script('sf-functions', SF_LOCAL_PATH . '/js/functions.js', 'jquery', NULL, TRUE);
		    wp_register_script('sf-functions-min', SF_LOCAL_PATH . '/js/functions.min.js', 'jquery', NULL, TRUE);
		    wp_register_script('sf-smoothscroll', SF_LOCAL_PATH . '/js/sscr.js', '', NULL, FALSE);
			wp_register_script('jquery-cookie', SF_LOCAL_PATH . '/js/jquery-cookie.js', 'jquery', NULL, TRUE);
			

			// jQuery
		    wp_enqueue_script('jquery');
			wp_enqueue_script('jquery-cookie');
			
		    if ( $enable_smoothscroll ) {
		    	wp_enqueue_script('sf-smoothscroll');
		    }

		    if ( !is_admin() ) {

		    	// Theme Scripts
		    	if ($enable_min_scripts) {
		    		wp_enqueue_script('sf-theme-scripts-min');
		    		if ( $page_has_map ) {
		    			wp_enqueue_script('google-maps');
		    		}
		    		wp_enqueue_script('sf-functions-min');
		    	} else {
		    		wp_enqueue_script('sf-bootstrap-js');
		    		wp_enqueue_script('sf-jquery-ui');

		    		wp_enqueue_script('sf-owlcarousel');
		    		wp_enqueue_script('sf-theme-scripts');
		    		if ( $lightbox_enabled ) {
		    			wp_enqueue_script('sf-ilightbox');
					}
					
		    		if ( $page_has_map ) {
		    			wp_enqueue_script('google-maps');
		    		}

		    		wp_enqueue_script('sf-isotope');
		    		wp_enqueue_script('sf-imagesLoaded');
		    		wp_enqueue_script('sf-infinite-scroll');

		    		if ( $product_zoom ) {
		    			wp_enqueue_script('sf-elevatezoom');
		    		}

		    		wp_enqueue_script('sf-functions');
		    	}

		    }
		}
		add_action('wp_enqueue_scripts', 'sf_enqueue_scripts');
	}

	function sf_custom_bwp_minify_remove() {

		global $is_IE;

		if ($is_IE) {
			return array('');
		}
	}
	add_filter('bwp_minify_allowed_styles', 'sf_custom_bwp_minify_remove');


	/* LOAD BACKEND SCRIPTS
	================================================== */
	function sf_admin_scripts() {
	    wp_register_script('admin-functions', get_template_directory_uri() . '/js/sf-admin.js', 'jquery', '1.0', TRUE);
		wp_enqueue_script('admin-functions');
        $upload_dir = wp_upload_dir();
		
		//FONTELLO ICONS 
//        if ( get_option('sf_fontello_icon_codes') && get_option('sf_fontello_icon_codes') != '' ){
//			wp_register_style('sf-fontello',  $upload_dir['baseurl'] . '/redux/custom-fonts/fontello_css/fontello-embedded.css', array(), NULL, 'all');
//			wp_enqueue_style('sf-fontello');
//		}
			
	}
	add_action('admin_enqueue_scripts', 'sf_admin_scripts');


	/* WOO CHECKOUT BUTTON
	================================================== */
	if ( ! function_exists( 'woocommerce_button_proceed_to_checkout' ) ) {
		function woocommerce_button_proceed_to_checkout() {
			$checkout_url = wc_get_checkout_url();
			?>
			<a class="sf-button standard sf-icon-reveal checkout-button accent" href="<?php echo esc_url($checkout_url); ?>">
				<i class="fa-long-arrow-right"></i>
				<span class="text"><?php _e( 'Proceed to Checkout', 'swiftframework' ); ?></span>
			</a>
			<?php
		}
	}

	/* CHECK THEME FEATURE SUPPORT
    ================================================== */
    if ( !function_exists( 'sf_theme_supports' ) ) {
        function sf_theme_supports( $feature ) {
        	$supports = get_theme_support( 'swiftframework' );
        	$supports = $supports[0];
    		if ( !isset($supports[ $feature ]) || $supports[ $feature ] == "") {
    			return false;
    		} else {
        		return isset( $supports[ $feature ] );
        	}
        }
    }

    /* SIDEBAR FILTERS
	================================================== */
	function sf_atelier_sidebar_before_title() {
		return '<div class="widget-heading title-wrap clearfix"><h3 class="spb-heading widget-title"><span>';
	}
	add_filter('sf_sidebar_before_title', 'sf_atelier_sidebar_before_title');

	function sf_atelier_sidebar_after_title() {
		return '</span></h3></div>';
	}
	add_filter('sf_sidebar_after_title', 'sf_atelier_sidebar_after_title');


	/* FOOTER FILTERS
	================================================== */
	function sf_atelier_footer_before_title() {
		return '<div class="widget-heading title-wrap clearfix"><h3 class="spb-heading widget-title"><span>';
	}
	add_filter('sf_footer_before_title', 'sf_atelier_footer_before_title');

	function sf_atelier_footer_after_title() {
		return '</span></h3></div>';
	}
	add_filter('sf_footer_after_title', 'sf_atelier_footer_after_title');
	
	
	/* EDD FILTERS
	================================================== */
	remove_filter( 'the_title', 'edd_microdata_title', 10, 2 );


    /* ADJUST WOO TERM DESCRIPTION OUTPUT
    ================================================== */
    if ( ! function_exists( 'woocommerce_taxonomy_archive_description' ) ) {
        function woocommerce_taxonomy_archive_description() {
        	
        	if ( sf_theme_supports( 'page-heading-woo-description' ) ) {
        		global $sf_options;
        		$page_title_style = $sf_options['woo_page_heading_style'];
        		if ( $page_title_style != "standard" ) {
        			return;
        		}
        	}
        	
            if ( is_tax( array( 'product_cat', 'product_tag' ) ) && get_query_var( 'paged' ) == 0 ) {
                $description = apply_filters( 'the_content', term_description() );
                if ( $description ) {
                    echo '<div class="term-description container">' . $description . '</div>';
                }
            }
        }
    }


    /* DEMO CONTENT IMPORTER
    ================================================== */
    function ocdi_import_files() {
	  return array(
		    array(
		      'import_file_name'           => 'Main Demo',
		      //'categories'                 => array( 'Category 1', 'Category 2' ),
		      'import_file_url'            => 'http://www.swiftideas.com/democontent/atelier/main/demo-content.xml',
		      'import_widget_file_url'     => 'http://www.swiftideas.com/democontent/atelier/main/widgets.wie',
		      'import_customizer_file_url' => 'http://www.swiftideas.com/democontent/atelier/main/customizer.dat',
		      'import_redux'               => array(
		        array(
		          'file_url'    => 'http://www.swiftideas.com/democontent/atelier/main/redux.json',
		          'option_name' => 'sf_atelier_options',
		        ),
		      ),
		      'import_preview_image_url'   => 'http://www.swiftideas.com/democontent/atelier/main/image.jpg',
		      'import_notice'              => '',
		      'preview_url'                => 'http://atelier.swiftideas.com',
		    ),
		    array(
		      'import_file_name'           => 'Form Demo',
		      //'categories'                 => array( 'Category 1', 'Category 2' ),
		      'import_file_url'            => 'http://www.swiftideas.com/democontent/atelier/form/demo-content.xml',
		      'import_widget_file_url'     => 'http://www.swiftideas.com/democontent/atelier/form/widgets.wie',
		      'import_customizer_file_url' => 'http://www.swiftideas.com/democontent/atelier/form/customizer.dat',
		      'import_redux'               => array(
		        array(
		          'file_url'    => 'http://www.swiftideas.com/democontent/atelier/form/redux.json',
		          'option_name' => 'sf_atelier_options',
		        ),
		      ),
		      'import_preview_image_url'   => 'http://www.swiftideas.com/democontent/atelier/form/image.jpg',
		      'import_notice'              => '',
		      'preview_url'                => 'http://atelier.swiftideas.com/form-demo',
		    ),
		    array(
		      'import_file_name'           => 'Union Demo',
		      //'categories'                 => array( 'Category 1', 'Category 2' ),
		      'import_file_url'            => 'http://www.swiftideas.com/democontent/atelier/union/demo-content.xml',
		      'import_widget_file_url'     => 'http://www.swiftideas.com/democontent/atelier/union/widgets.wie',
		      'import_customizer_file_url' => 'http://www.swiftideas.com/democontent/atelier/union/customizer.dat',
		      'import_redux'               => array(
		        array(
		          'file_url'    => 'http://www.swiftideas.com/democontent/atelier/union/redux.json',
		          'option_name' => 'sf_atelier_options',
		        ),
		      ),
		      'import_preview_image_url'   => 'http://www.swiftideas.com/democontent/atelier/union/image.jpg',
		      'import_notice'              => '',
		      'preview_url'                => 'http://atelier.swiftideas.com/union-demo',
		    ),
		    array(
		      'import_file_name'           => 'Convoy Demo',
		      //'categories'                 => array( 'Category 1', 'Category 2' ),
		      'import_file_url'            => 'http://www.swiftideas.com/democontent/atelier/convoy/demo-content.xml',
		      'import_widget_file_url'     => 'http://www.swiftideas.com/democontent/atelier/convoy/widgets.wie',
		      'import_customizer_file_url' => 'http://www.swiftideas.com/democontent/atelier/convoy/customizer.dat',
		      'import_redux'               => array(
		        array(
		          'file_url'    => 'http://www.swiftideas.com/democontent/atelier/convoy/redux.json',
		          'option_name' => 'sf_atelier_options',
		        ),
		      ),
		      'import_preview_image_url'   => 'http://www.swiftideas.com/democontent/atelier/convoy/image.jpg',
		      'import_notice'              => '',
		      'preview_url'                => 'http://atelier.swiftideas.com/convoy-demo',
		    ),
		    array(
		      'import_file_name'           => 'Tilt Demo',
		      //'categories'                 => array( 'Category 1', 'Category 2' ),
		      'import_file_url'            => 'http://www.swiftideas.com/democontent/atelier/tilt/demo-content.xml',
		      'import_widget_file_url'     => 'http://www.swiftideas.com/democontent/atelier/tilt/widgets.wie',
		      'import_customizer_file_url' => 'http://www.swiftideas.com/democontent/atelier/tilt/customizer.dat',
		      'import_redux'               => array(
		        array(
		          'file_url'    => 'http://www.swiftideas.com/democontent/atelier/tilt/redux.json',
		          'option_name' => 'sf_atelier_options',
		        ),
		      ),
		      'import_preview_image_url'   => 'http://www.swiftideas.com/democontent/atelier/tilt/image.jpg',
		      'import_notice'              => '',
		      'preview_url'                => 'http://atelier.swiftideas.com/tilt-demo',
		    ),
		    array(
		      'import_file_name'           => 'Lab Demo',
		      //'categories'                 => array( 'Category 1', 'Category 2' ),
		      'import_file_url'            => 'http://www.swiftideas.com/democontent/atelier/lab/demo-content.xml',
		      'import_widget_file_url'     => 'http://www.swiftideas.com/democontent/atelier/lab/widgets.wie',
		      'import_customizer_file_url' => 'http://www.swiftideas.com/democontent/atelier/lab/customizer.dat',
		      'import_redux'               => array(
		        array(
		          'file_url'    => 'http://www.swiftideas.com/democontent/atelier/lab/redux.json',
		          'option_name' => 'sf_atelier_options',
		        ),
		      ),
		      'import_preview_image_url'   => 'http://www.swiftideas.com/democontent/atelier/lab/image.jpg',
		      'import_notice'              => '',
		      'preview_url'                => 'http://atelier.swiftideas.com/lab-demo',
		    ),
		    array(
		      'import_file_name'           => 'Selby Demo',
		      //'categories'                 => array( 'Category 1', 'Category 2' ),
		      'import_file_url'            => 'http://www.swiftideas.com/democontent/atelier/selby/demo-content.xml',
		      'import_widget_file_url'     => 'http://www.swiftideas.com/democontent/atelier/selby/widgets.wie',
		      'import_customizer_file_url' => 'http://www.swiftideas.com/democontent/atelier/selby/customizer.dat',
		      'import_redux'               => array(
		        array(
		          'file_url'    => 'http://www.swiftideas.com/democontent/atelier/selby/redux.json',
		          'option_name' => 'sf_atelier_options',
		        ),
		      ),
		      'import_preview_image_url'   => 'http://www.swiftideas.com/democontent/atelier/selby/image.jpg',
		      'import_notice'              => '',
		      'preview_url'                => 'http://atelier.swiftideas.com/selby-demo',
		    ),
		    array(
		      'import_file_name'           => 'Emigre Demo',
		      //'categories'                 => array( 'Category 1', 'Category 2' ),
		      'import_file_url'            => 'http://www.swiftideas.com/democontent/atelier/emigre/demo-content.xml',
		      'import_widget_file_url'     => 'http://www.swiftideas.com/democontent/atelier/emigre/widgets.wie',
		      'import_customizer_file_url' => 'http://www.swiftideas.com/democontent/atelier/emigre/customizer.dat',
		      'import_redux'               => array(
		        array(
		          'file_url'    => 'http://www.swiftideas.com/democontent/atelier/emigre/redux.json',
		          'option_name' => 'sf_atelier_options',
		        ),
		      ),
		      'import_preview_image_url'   => 'http://www.swiftideas.com/democontent/atelier/emigre/image.jpg',
		      'import_notice'              => '',
		      'preview_url'                => 'http://atelier.swiftideas.com/emigre-demo',
		    ),
		    array(
		      'import_file_name'           => 'Bryant Demo',
		      //'categories'                 => array( 'Category 1', 'Category 2' ),
		      'import_file_url'            => 'http://www.swiftideas.com/democontent/atelier/bryant/demo-content.xml',
		      'import_widget_file_url'     => 'http://www.swiftideas.com/democontent/atelier/bryant/widgets.wie',
		      'import_customizer_file_url' => 'http://www.swiftideas.com/democontent/atelier/bryant/customizer.dat',
		      'import_redux'               => array(
		        array(
		          'file_url'    => 'http://www.swiftideas.com/democontent/atelier/bryant/redux.json',
		          'option_name' => 'sf_atelier_options',
		        ),
		      ),
		      'import_preview_image_url'   => 'http://www.swiftideas.com/democontent/atelier/bryant/image.jpg',
		      'import_notice'              => '',
		      'preview_url'                => 'http://atelier.swiftideas.com/bryant-demo',
		    ),
		    array(
		      'import_file_name'           => 'Arad Demo',
		      //'categories'                 => array( 'Category 1', 'Category 2' ),
		      'import_file_url'            => 'http://www.swiftideas.com/democontent/atelier/arad/demo-content.xml',
		      'import_widget_file_url'     => 'http://www.swiftideas.com/democontent/atelier/arad/widgets.wie',
		      'import_customizer_file_url' => 'http://www.swiftideas.com/democontent/atelier/arad/customizer.dat',
		      'import_redux'               => array(
		        array(
		          'file_url'    => 'http://www.swiftideas.com/democontent/atelier/arad/redux.json',
		          'option_name' => 'sf_atelier_options',
		        ),
		      ),
		      'import_preview_image_url'   => 'http://www.swiftideas.com/democontent/atelier/arad/image.jpg',
		      'import_notice'              => '',
		      'preview_url'                => 'http://atelier.swiftideas.com/arad-demo',
		    ),
		    array(
		      'import_file_name'           => 'Flock Demo',
		      //'categories'                 => array( 'Category 1', 'Category 2' ),
		      'import_file_url'            => 'http://www.swiftideas.com/democontent/atelier/flock/demo-content.xml',
		      'import_widget_file_url'     => 'http://www.swiftideas.com/democontent/atelier/flock/widgets.wie',
		      'import_customizer_file_url' => 'http://www.swiftideas.com/democontent/atelier/flock/customizer.dat',
		      'import_redux'               => array(
		        array(
		          'file_url'    => 'http://www.swiftideas.com/democontent/atelier/flock/redux.json',
		          'option_name' => 'sf_atelier_options',
		        ),
		      ),
		      'import_preview_image_url'   => 'http://www.swiftideas.com/democontent/atelier/flock/image.jpg',
		      'import_notice'              => '',
		      'preview_url'                => 'http://atelier.swiftideas.com/flock-demo',
		    ),
		    array(
		      'import_file_name'           => 'Porter Demo',
		      //'categories'                 => array( 'Category 1', 'Category 2' ),
		      'import_file_url'            => 'http://www.swiftideas.com/democontent/atelier/porter/demo-content.xml',
		      'import_widget_file_url'     => 'http://www.swiftideas.com/democontent/atelier/porter/widgets.wie',
		      'import_customizer_file_url' => 'http://www.swiftideas.com/democontent/atelier/porter/customizer.dat',
		      'import_redux'               => array(
		        array(
		          'file_url'    => 'http://www.swiftideas.com/democontent/atelier/porter/redux.json',
		          'option_name' => 'sf_atelier_options',
		        ),
		      ),
		      'import_preview_image_url'   => 'http://www.swiftideas.com/democontent/atelier/porter/image.jpg',
		      'import_notice'              => '',
		      'preview_url'                => 'http://atelier.swiftideas.com/porter-demo',
		    ),
		    array(
		      'import_file_name'           => 'Vario Demo',
		      //'categories'                 => array( 'Category 1', 'Category 2' ),
		      'import_file_url'            => 'http://www.swiftideas.com/democontent/atelier/vario/demo-content.xml',
		      'import_widget_file_url'     => 'http://www.swiftideas.com/democontent/atelier/vario/widgets.wie',
		      'import_customizer_file_url' => 'http://www.swiftideas.com/democontent/atelier/vario/customizer.dat',
		      'import_redux'               => array(
		        array(
		          'file_url'    => 'http://www.swiftideas.com/democontent/atelier/vario/redux.json',
		          'option_name' => 'sf_atelier_options',
		        ),
		      ),
		      'import_preview_image_url'   => 'http://www.swiftideas.com/democontent/atelier/vario/image.jpg',
		      'import_notice'              => '',
		      'preview_url'                => 'http://atelier.swiftideas.com/vario-demo',
		    ),
		    array(
		      'import_file_name'           => 'Rebel Demo',
		      //'categories'                 => array( 'Category 1', 'Category 2' ),
		      'import_file_url'            => 'http://www.swiftideas.com/democontent/atelier/rebel/demo-content.xml',
		      'import_widget_file_url'     => 'http://www.swiftideas.com/democontent/atelier/rebel/widgets.wie',
		      'import_customizer_file_url' => 'http://www.swiftideas.com/democontent/atelier/rebel/customizer.dat',
		      'import_redux'               => array(
		        array(
		          'file_url'    => 'http://www.swiftideas.com/democontent/atelier/rebel/redux.json',
		          'option_name' => 'sf_atelier_options',
		        ),
		      ),
		      'import_preview_image_url'   => 'http://www.swiftideas.com/democontent/atelier/rebel/image.jpg',
		      'import_notice'              => '',
		      'preview_url'                => 'http://atelier.swiftideas.com/rebel-demo',
		    ),
		    array(
		      'import_file_name'           => 'Alvar Demo',
		      //'categories'                 => array( 'Category 1', 'Category 2' ),
		      'import_file_url'            => 'http://www.swiftideas.com/democontent/atelier/alvar/demo-content.xml',
		      'import_widget_file_url'     => 'http://www.swiftideas.com/democontent/atelier/alvar/widgets.wie',
		      'import_customizer_file_url' => 'http://www.swiftideas.com/democontent/atelier/alvar/customizer.dat',
		      'import_redux'               => array(
		        array(
		          'file_url'    => 'http://www.swiftideas.com/democontent/atelier/alvar/redux.json',
		          'option_name' => 'sf_atelier_options',
		        ),
		      ),
		      'import_preview_image_url'   => 'http://www.swiftideas.com/democontent/atelier/alvar/image.jpg',
		      'import_notice'              => '',
		      'preview_url'                => 'http://atelier.swiftideas.com/alvar-demo',
		    ),
		);
	}
	add_filter( 'pt-ocdi/import_files', 'ocdi_import_files' );


	function ocdi_after_import_setup() {
		// Assign menus to their locations.
		if ( 'Arad Demo' === $selected_import['import_file_name'] || 'Alvar Demo' === $selected_import['import_file_name'] ) {
			$main_menu = get_term_by( 'name', 'Main', 'nav_menu' );

			set_theme_mod( 'nav_menu_locations', array(
					'main-menu' => $main_menu->term_id,
				)
			);
		} else if ( 'Flock Demo' === $selected_import['import_file_name'] || 'Porter Demo' === $selected_import['import_file_name'] || 'Vario Demo' === $selected_import['import_file_name'] || 'Rebel Demo' === $selected_import['import_file_name'] ) {
			$main_menu = get_term_by( 'name', 'main menu', 'nav_menu' );

			set_theme_mod( 'nav_menu_locations', array(
					'main-menu' => $main_menu->term_id,
				)
			);
		} else if ( 'Bryant Demo' !== $selected_import['import_file_name'] ) {
			$main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );

			set_theme_mod( 'nav_menu_locations', array(
					'main-menu' => $main_menu->term_id,
				)
			);
		}

		// Assign front page and posts page (blog page).
		$front_page_id = get_page_by_title( 'Home' );
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_page_id->ID );
	}
	add_action( 'pt-ocdi/after_import', 'ocdi_after_import_setup' );

	// Disable branding
	add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );