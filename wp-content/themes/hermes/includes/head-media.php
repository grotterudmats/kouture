<?php
/**
* Theme stylesheet & javascript registration
*
* @package LionThemes
* @subpackage Hermes_theme
* @since Hermes Themes 1.6
*/

function hermes_build_background($background) {
	if (!is_array($background)) return 'none';
	if (isset($background['media'])) unset($background['media']);
	if (!empty($background['background-image'])) $background['background-image'] = 'url("'. $background['background-image'] .'")';
	if (empty($background['background-color'])) $background['background-color'] = 'transparent';
	$bg = $background['background-color'];
	if (!empty($background['background-image'])) {
		$bg .= ' ' . $background['background-image'];
		$bg .= (!empty($background['background-position'])) ? ' ' . $background['background-position'] : '';
		$bg .= (!empty($background['background-size'])) ? ' / ' . $background['background-size'] : '';
		$bg .= (!empty($background['background-repeat'])) ? ' ' . $background['background-repeat'] : '';
		$bg .= (!empty($background['background-attachment'])) ? ' ' . $background['background-attachment'] : '';
	}
	return $bg;
}
function hermes_get_skin_option($options, $skin, $key, $subkey, $default, $replaced = '') {
	$skins = array(
		2 => array(
			'primary_color' => '#808f66',
			'header_background' => array(
				'background-image' => '../images/bkg_footer.jpg',
			),
			'header_color' => '#FFF',
			'topbar_hvcolor' => '#808f66',
			'sub_menu_color' => '#cfcfcf',
			'sub_menu_bg' => '#2c2c2c',
		),
		3 => array(
			'primary_color' => '#6dc5ee',
			'sticky_header_bg' => array('rgba' => 'rgba(255,255,255,0.9)'),
			'header_bg_color' => array('rgba' => 'rgba(255,255,255, 1)'),
			'header_color' => '#555',
			'topbar_color' => '#888',
			'topbar_hvcolor' => '#333',
			'topbar_border_color' => '#DDDDDD',
			'menu_color' => '#555',
			'sub_menu_color' => '#cfcfcf',
			'sub_menu_bg' => '#2c2c2c',
			'footer_bg' => array(
				'background-color' => '#ffffff'
			),
			'footer_border' => array('rgba' => 'rgba(238, 238, 238, 1)'),
			'footer_heading_color' => '#333333',
			'footer_color' => '#888888',
		),
		4 => array(
			'primary_color' => '#12a170',
			'header_bg_color' => array('rgba' => 'rgba(51,51,51, 1)'),
			'topbar_background' => array('rgba' => 'rgba(38,38,38, 1)'),
			'header_color' => '#ddd',
			'topbar_color' => '#ddd',
			'topbar_hvcolor' => '#12a170',
			'menu_color' => '#ddd',
			'sub_menu_color' => '#cfcfcf',
			'sub_menu_bg' => '#2c2c2c',
			'footer_bg' => array(
				'background-color' => '#222222'
			),
			'footer_border' => array('rgba' => 'rgba(68, 68, 68, 1)'),
			'copyright_bg' => '#181818'
		),
		5 => array(
			'primary_color' => '#FC7001',
			'sticky_header_bg' => array('rgba' => 'rgba(255,255,255,0.9)'),
			'header_bg_color' => array('rgba' => 'rgba(255,255,255, 1)'),
			'topbar_background' => array('rgba' => 'rgba(38,38,38, 1)'),
			'topbar_color' => '#eee',
			'topbar_hvcolor' => '#FC7001',
			'menu_color' => '#333',
			'sub_menu_color' => '#cfcfcf',
			'sub_menu_bg' => '#2c2c2c',
			'footer_bg' => array(
				'background-color' => '#222222'
			),
			'footer_border' => array('rgba' => 'rgba(57, 57, 57, 1)'),
			'copyright_bg' => '#181818'
		),
	);
	if ($replaced && !empty($options['use_design_font'])) return $replaced;
	if ($skin) {
		if ($subkey && $key && !empty($skins[$skin][$key][$subkey])) {
			return $skins[$skin][$key][$subkey];
		}
		if ($key && !empty($skins[$skin][$key])) {
			return $skins[$skin][$key];
		}
	} else {
		if ($subkey && $key) return (!empty($options[$key][$subkey])) ? $options[$key][$subkey] : $default;
		if ($key) return (!empty($options[$key])) ? $options[$key] : $default;
	}
	return $default;
}
//Hermes theme style and script 
function hermes_register_script()
{
	global $hermes_opt, $woocommerce;
	$default_font = "'Arial', Helvetica, sans-serif";
	$skin = (isset($_GET['skin'])) ? $_GET['skin'] : 0;
	$params = array(
		'heading_font'=> hermes_get_skin_option($hermes_opt, $skin, 'headingfont', 'font-family', $default_font, 'texgyreadventorbold'),
		'heading_color'=> hermes_get_skin_option($hermes_opt, $skin, 'headingfont', 'color', '#181818'),
		'heading_font_weight'=> hermes_get_skin_option($hermes_opt, $skin, 'headingfont', 'font-weight', 700, 'normal'),
		'menu_font'=> hermes_get_skin_option($hermes_opt, $skin, 'menufont', 'font-family', $default_font, 'texgyreadventorbold'),
		'menu_font_size'=> hermes_get_skin_option($hermes_opt, $skin, 'menufont', 'font-size', '14px'),
		'menu_font_weight'=> hermes_get_skin_option($hermes_opt, $skin, 'menufont', 'font-weight', '400'),
		'menu_color'=> hermes_get_skin_option($hermes_opt, $skin, 'menu_color', '', '#FFF'),
		'sub_menu_bg'=> hermes_get_skin_option($hermes_opt, $skin, 'sub_menu_bg', '', '#ffffff'),
		'sub_menu_color'=> hermes_get_skin_option($hermes_opt, $skin, 'sub_menu_color', '', '#333333'),
		'body_font'=> hermes_get_skin_option($hermes_opt, $skin, 'bodyfont', 'font-family', $default_font, 'texgyreadventorregular'),
		'text_color'=> hermes_get_skin_option($hermes_opt, $skin, 'bodyfont', 'color', '#333333'),
		'primary_color' => hermes_get_skin_option($hermes_opt, $skin, 'primary_color', '', '#ba933e'),
		'header_bg' => hermes_build_background(hermes_get_skin_option($hermes_opt, $skin, 'header_background', '', array())),
		'header_bg_color' => hermes_get_skin_option($hermes_opt, $skin, 'header_bg_color', 'rgba', 'rgba(36,36,36,0.86)'),
		'header_color' => hermes_get_skin_option($hermes_opt, $skin, 'header_color', '', '#bbbbbb'),
		'topbar_bg' => hermes_get_skin_option($hermes_opt, $skin, 'topbar_background', 'rgba', 'transparent'),
		'topbar_color' => hermes_get_skin_option($hermes_opt, $skin, 'topbar_color', '', '#aaaaaa'),
		'topbar_hvcolor' => hermes_get_skin_option($hermes_opt, $skin, 'topbar_hvcolor', '', '#ba933e'),
		'topbar_border_color' => hermes_get_skin_option($hermes_opt, $skin, 'topbar_border_color', '', '#444'),
		'sale_color' => hermes_get_skin_option($hermes_opt, $skin, 'sale_color', '', '#f49835'),
		'saletext_color' => hermes_get_skin_option($hermes_opt, $skin, 'saletext_color', '', '#FFFFFF'),
		'rate_color' => hermes_get_skin_option($hermes_opt, $skin, 'rate_color', '', '#f49835'),
		'button_bg' => hermes_get_skin_option($hermes_opt, $skin, 'button_bg', '', '#2f2f2f'),
		'button_color' => hermes_get_skin_option($hermes_opt, $skin, 'button_color', '', '#ffffff'),
		'page_width' => hermes_get_skin_option($hermes_opt, $skin, 'box_layout_width', '', '1200px'),
		'body_bg_color' => hermes_get_skin_option($hermes_opt, $skin, 'background_opt', 'background-color', '#FFFFFF'),
		'popup_bg' => hermes_build_background($hermes_opt['background_popup']),
		'sticky_header_bg' => hermes_get_skin_option($hermes_opt, $skin, 'sticky_header_bg', 'rgba', 'rgba(36,36,36,0.86)'),
		'footer_color' => hermes_get_skin_option($hermes_opt, $skin, 'footer_color', '', '#bbbbbb'),
		'footer_heading_color' => hermes_get_skin_option($hermes_opt, $skin, 'footer_heading_color', '', '#dddddd'),
		'footer_border' => hermes_get_skin_option($hermes_opt, $skin, 'footer_border', 'rgba', 'rgba(255,255,255,0.15)'),
		'footer_bg' => hermes_build_background(hermes_get_skin_option($hermes_opt, $skin, 'footer_bg', '', array('background-image' => '../images/bkg_footer.jpg'))),
		'footer_top_border' => hermes_build_background(hermes_get_skin_option($hermes_opt, $skin, 'footer_top_border', '', array('background-image' => '../images/boder_product_group.jpg', 'background-repeat' => 'repeat-x'))),
		'copyright_bg' => hermes_get_skin_option($hermes_opt, $skin, 'copyright_bg', '', 'transparent'),
	);
	// if (isset($_GET['debug'])) print_r($params);
	if( function_exists('compileLess') ){
		if(isset($_GET['skin']) && !empty($skins[intval($_GET['skin'])])){
			compileLess('theme.less', 'theme_skin_' . intval($_GET['skin']) . '.css', $params);
		}else{
			compileLess('theme.less', 'theme.css', $params);
		}
	}
	wp_enqueue_style( 'design-font', get_template_directory_uri() . '/css/font-texgyreadventor.css' );
	wp_enqueue_style( 'base-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/css/bootstrap.min.css' );
	wp_enqueue_style( 'bootstrap-theme-css', get_template_directory_uri() . '/css/bootstrap-theme.min.css' );
	wp_enqueue_style( 'awesome-css', get_template_directory_uri() . '/css/font-awesome.min.css' );
	wp_enqueue_style( 'owl-css', get_template_directory_uri() . '/owl-carousel/owl.carousel.css' );
	wp_enqueue_style( 'owl-theme', get_template_directory_uri() . '/owl-carousel/owl.theme.css' );
	wp_enqueue_style( 'owl-transitions', get_template_directory_uri() . '/owl-carousel/owl.transitions.css' );
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.css' );
	wp_enqueue_style( 'fancybox', get_template_directory_uri() . '/fancybox/jquery.fancybox.css' );
	if ( is_singular() ) wp_enqueue_script( "comment-reply" );
	if(isset($_GET['skin']) && !empty($skins[$_GET['skin']])){
		if(file_exists( get_template_directory() . '/css/theme_skin_' . intval($_GET['skin']) . '.css' )){
			wp_enqueue_style( 'theme-options', get_template_directory_uri() . '/css/theme_skin_' . intval($_GET['skin']) . '.css', array(), filemtime( get_template_directory() . '/css/theme_skin_' . intval($_GET['skin']) . '.css' ) );
		}
	}else{
		if(file_exists( get_template_directory() . '/css/theme.css' )){
			wp_enqueue_style( 'theme-options', get_template_directory_uri() . '/css/theme.css', array(), filemtime( get_template_directory() . '/css/theme.css' ) );
		}
	}
	// add custom style sheet
	if ( isset($hermes_opt['custom_css']) && $hermes_opt['custom_css']!='') {
		wp_add_inline_style( 'theme-options', $hermes_opt['custom_css'] );
	}
	
	// add add-to-cart-variation js to all other pages without detail. it help quickview work with variable products
	if( class_exists('WooCommerce') && !is_product() ) {
		wp_enqueue_script( 'wc-add-to-cart-variation', $woocommerce->plugin_url() . '/assets/js/frontend/add-to-cart-variation.js', array('jquery'), '', true );
    }
    wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '', true );
    wp_enqueue_script( 'owl-wow-js', get_template_directory_uri() . '/js/jquery.wow.min.js', array('jquery'), '', true );
    wp_enqueue_script( 'owl-modernizr-js', get_template_directory_uri() . '/js/modernizr.custom.js', array('jquery'), '', true );
    wp_enqueue_script( 'owl-carousel-js', get_template_directory_uri() . '/owl-carousel/owl.carousel.js', array('jquery'), '', true );
    wp_enqueue_script( 'auto-grid', get_template_directory_uri() . '/js/autoGrid.min.js', array('jquery'), '', true );
    wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/fancybox/jquery.fancybox.pack.js', array('jquery'), '', true );
    if (!empty($hermes_opt['lazy_load'])) {
		wp_enqueue_script( 'lazy', get_template_directory_uri() . '/js/jquery.lazy.min.js', array('jquery'), '', true );
	}
    wp_enqueue_script( 'temp-js', get_template_directory_uri() . '/js/custom.js', array('jquery'), '', true );
	// add ajaxurl
	$ajaxurl = 'var ajaxurl = "'. esc_js(admin_url('admin-ajax.php')) .'";';
	wp_add_inline_script( 'temp-js', $ajaxurl, 'before' );
	
	// add newletter popup js
	if(isset($hermes_opt['enable_popup']) && $hermes_opt['enable_popup']){
		if (is_front_page() && (!empty($hermes_opt['popup_onload_form']) || !empty($hermes_opt['popup_onload_content']))) {
			$newletter_js = 'jQuery(document).ready(function($){
								if($(\'#popup_onload\').length){
									$(\'#popup_onload\').fadeIn(400);
								}
								$(\'#popup_onload .close-popup, #popup_onload .overlay-bg-popup\').click(function(){
									var not_again = $(this).closest(\'#popup_onload\').find(\'.not-again input[type="checkbox"]\').prop(\'checked\');
									if(not_again){
										var datetime = new Date();
										var exdays = '. ((!empty($hermes_opt['popup_onload_expires'])) ? intval($hermes_opt['popup_onload_expires']) : 7) . ';
										datetime.setTime(datetime.getTime() + (exdays*24*60*60*1000));
										document.cookie = \'no_again=1; expires=\' + datetime.toUTCString();
									}
									$(this).closest(\'#popup_onload\').fadeOut(400);
								});
							});';
			wp_add_inline_script( 'temp-js', $newletter_js );
		}
	}
	
	
	// add remove top cart item
	$remove_cartitem_js = 'jQuery(document).on(\'click\', \'.mini_cart_item .remove\', function(e){
							var product_id = jQuery(this).data("product_id");
							var item_li = jQuery(this).closest(\'li\');
							var a_href = jQuery(this).attr(\'href\');
							jQuery.ajax({
								type: \'POST\',
								dataType: \'json\',
								url: ajaxurl,
								data: \'action=hermes_product_remove&\' + (a_href.split(\'?\')[1] || \'\'), 
								success: function(data){
									if(typeof(data) != \'object\'){
										alert(\'' . esc_html__('Could not remove cart item.', 'hermes') . '\');
										return;
									}
									jQuery(\'.topcart .cart-toggler .qty\').html(data.qty);
									jQuery(\'.topcart .cart-toggler .subtotal\').html(data.subtotal);
									jQuery(\'.topcart_content\').css(\'height\', \'auto\');
									if(data.qtycount > 0){
										jQuery(\'.topcart_content .total .amount\').html(data.subtotal);
									}else{
										jQuery(\'.topcart_content .cart_list\').html(\'<li class="empty">' .  esc_html__('No products in the cart.', 'hermes') .'</li>\');
										jQuery(\'.topcart_content .total\').remove();
										jQuery(\'.topcart_content .buttons\').remove();
									}
									item_li.remove();
								}
							});
							e.preventDefault();
							return false;
						});';
	wp_add_inline_script( 'temp-js', $remove_cartitem_js );
	
	//ajax search autocomplete products
	if(!empty($hermes_opt['enable_ajaxsearch'])){
		$enable_ajaxsearch_js = '
			var in_request = null;
			jQuery(document).on("keyup focus", ".woocommerce-product-search .search-field", function(e){
				var keyword = jQuery(this).val();
				var _me_result = jQuery(this).siblings(".hermes-autocomplete-search-results");
				var _me_loading = jQuery(this).siblings(".hermes-autocomplete-search-loading");
				_me_result.hide();
				_me_loading.show();
				if (in_request !== null){
					in_request.abort();
				}
				in_request = jQuery.ajax({
					type: "POST",
					dataType: "text",
					url: ajaxurl,
					data: "action=hermes_autocomplete_search&keyword=" + keyword, 
					success: function(data){
						_me_result.html(data).delay(500).show();
						_me_loading.hide();
						in_request = null;
					}
				});
				e.preventDefault();
				return false;
			});
		';
		wp_add_inline_script( 'temp-js', $enable_ajaxsearch_js );
	}
	
	
	//sticky header
	if(isset($hermes_opt['sticky_header']) && $hermes_opt['sticky_header']){
		$sticky_header_js = '
			jQuery(document).ready(function($){
				$(window).scroll(function() {
					var start = $(".header-container > .top-bar").outerHeight() + 10;
					' . ((is_admin_bar_showing()) ? '$(".header-container > .header").addClass("has_admin");':'') . '
					if ($(this).scrollTop() > start){  
						$(".header-container > .header").addClass("sticky");
					}
					else{
						$(".header-container > .header").removeClass("sticky");
					}
				});
			});';
		wp_add_inline_script( 'temp-js', $sticky_header_js );
	}
}
add_action( 'wp_enqueue_scripts', 'hermes_register_script' );

// bootstrap for back-end page
add_action( 'admin_enqueue_scripts', 'hermes_admin_custom' );
function hermes_admin_custom() {
	wp_enqueue_style( 'hermes-admin-custom', get_template_directory_uri() . '/css/admin.css', array(), '1.0.0');
}

//Hermes theme gennerate title
function hermes_wp_title( $title, $sep ) {
	global $paged, $page;
	if ( is_feed() ) return $title;
	
	$title .= get_bloginfo( 'name', 'display' );
	
	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";
	
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( esc_html__( 'Page %s', 'hermes' ), max( $paged, $page ) );
	
	return $title;
}

add_filter( 'wp_title', 'hermes_wp_title', 10, 2 );

// add favicon to header
add_action( 'wp_head', 'hermes_wp_custom_head', 100);
function hermes_wp_custom_head(){
	global $hermes_opt;
	if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {
		if(isset($hermes_opt['opt-favicon']) && $hermes_opt['opt-favicon']!="") { 
			if(is_ssl()){
				$hermes_opt['opt-favicon'] = str_replace('http:', 'https:', $hermes_opt['opt-favicon']);
			}
		?>
			<link rel="icon" type="image/png" href="<?php echo esc_url($hermes_opt['opt-favicon']['url']);?>" />
		<?php }
	}
}

// body class for wow scroll script
add_filter('body_class', 'hermes_effect_scroll');

function hermes_effect_scroll($classes){
	$classes[] = 'hermes-animate-scroll';
	if (!empty($hermes_opt['lazy_load'])) {
		$classes[] = 'hermes-lazy-load';
	}
	return $classes;
}
?>