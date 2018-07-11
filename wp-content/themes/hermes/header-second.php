<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package LionThemes
 * @subpackage Hermes_Themes
 * @since Hermes Themes 1.6
 */
 
$hermes_opt = get_option( 'hermes_opt' );
$logo = ( !empty($hermes_opt['logo_main']['url']) ) ? $hermes_opt['logo_main']['url'] : '';
if(get_post_meta( get_the_ID(), 'hermes_logo_page', true )){
	$logo = get_post_meta( get_the_ID(), 'hermes_logo_page', true );
}
?>
	<div class="header-container layout3">
		<?php if(!empty($hermes_opt['enable_topbar'])){ ?>
		<div class="top-bar">
			<div class="container">
				<div class="row">
					<div class="col-sm-6 nav-top-bar">
						<?php if (is_active_sidebar('top_header')) { ?> 
							<div class="widgets-top">
							<?php dynamic_sidebar('top_header'); ?> 
							</div>
						<?php } ?>
					</div>
					<div class="col-sm-6 social-bar">
						<div class="login-page pull-right">
							<?php if(is_user_logged_in()){ ?>
								<a class="acc-btn" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php esc_html_e('My account','hermes'); ?>"><?php esc_html_e('My account','hermes'); ?></a>
							<?php }else{ ?>
								<a class="acc-btn" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php esc_html_e('Login or Register','hermes'); ?>"><?php esc_html_e('Login or Register','hermes'); ?></a>
							<?php } ?>
						</div>
						<?php
							if(isset($hermes_opt['social_icons'])) {
								echo '<ul class="social-icons pull-right">';
								foreach($hermes_opt['social_icons'] as $key=>$value ) {
									if($value!=''){
										if($key=='vimeo'){
											echo '<li><a class="'.esc_attr($key).' social-icon" href="'.esc_url($value).'" title="'.ucwords(esc_attr($key)).'" target="_blank"><i class="fa fa-vimeo-square"></i></a></li>';
										} else {
											echo '<li><a class="'.esc_attr($key).' social-icon" href="'.esc_url($value).'" title="'.ucwords(esc_attr($key)).'" target="_blank"><i class="fa fa-'.esc_attr($key).'"></i></a></li>';
										}
									}
								}
								echo '</ul>';
							}
						?>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
		<div class="header">
			<div class="container">
				<div class="row">
					<div class="col-md-3 col-sm-6 col-xs-6 col-logo">
						<?php if( $logo ){ ?>
							<div class="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" /></a></div>
						<?php
						} else { ?>
							<h1 class="logo text-center"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<?php
						} ?>
					</div>
					<div class="col-md-9 col-sm-6 col-xs-6 col-menu">
						<div class="nav-menus pull-left">
							<div class="nav-desktop visible-lg visible-md">
								<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'primary-menu-container', 'menu_class' => 'nav-menu' ) ); ?>
							</div>
							
							<div class="nav-mobile visible-xs visible-sm">
								<div class="mobile-menu-overlay"></div>
								<div class="toggle-menu"><i class="fa fa-bars"></i></div>
								<div class="mobile-navigation">
									<?php wp_nav_menu( array( 'theme_location' => 'mobilemenu', 'container_class' => 'mobile-menu-container', 'menu_class' => 'nav-menu mobile-menu' ) ); ?>
								</div>
							</div>
						</div>
						<?php if(class_exists('WC_Widget_Cart') && !empty($hermes_opt['show_topcart'])) { ?>
							<div class="shoping_cart pull-right">
							<?php the_widget('WC_Widget_Cart'); ?>
							</div>
						<?php } ?>
						<?php if(class_exists('WC_Widget_Product_Search') && !empty($hermes_opt['show_topsearch'])) { ?>
						<div class="top-search pull-right">
							<?php the_widget('WC_Widget_Product_Search', array('title' => '')); ?>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>