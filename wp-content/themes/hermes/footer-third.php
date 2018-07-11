<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package LionThemes
 * @subpackage Hermes_Themes
 * @since Hermes Themes 1.6
 */
?>
<?php 
$hermes_opt = get_option( 'hermes_opt' );
$ft_col_class = '';
?>
	<div class="footer layout2">
		
		<?php if(isset($hermes_opt) || is_active_sidebar('footer_4columns')) { ?>
		<div class="footer-top">
			<div class="container">
				<div class="container-inner">
					<div class="row">
						<?php if(!empty($hermes_opt['about_us2'])) { ?>
							<div class="col-md-3 col-sm-6">
								<div class="widget widget_contact_us">
								
								<?php echo wp_kses($hermes_opt['about_us2'], array(
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
									'h3' => array(
										'class' => array(),
									),
									'ul' => array('class' => array()),
									'li' => array('class' => array()),
									'i' => array(
										'class' => array()
									),
									'br' => array(),
									'em' => array(),
									'strong' => array(),
									'p' => array(),
									)); ?>
								</div>
							</div>
						<?php } elseif(is_active_sidebar('footer_4columns')){ ?>
							<?php dynamic_sidebar('footer_4columns'); ?>
						<?php } ?>
						<?php
						if( !empty($hermes_opt['footer_menu1']) && !empty($hermes_opt['about_us2'])) {
							$menu1_object = wp_get_nav_menu_object( $hermes_opt['footer_menu1'] );
							$menu1_args = array(
								'menu_class'      => 'nav_menu',
								'menu'         => $hermes_opt['footer_menu1'],
							);
							if (is_object($menu1_object)) {
							?>
							<div class="col-sm-6  col-md-3">
								<div class="widget widget_menu">
									<h3 class="widget-title"><?php echo esc_html($menu1_object->name); ?></h3>
									<?php wp_nav_menu( $menu1_args ); ?>
								</div>
							</div>
						<?php }
						}
						if( !empty($hermes_opt['footer_menu2']) && !empty($hermes_opt['about_us2'])) {
							$menu2_object = wp_get_nav_menu_object( $hermes_opt['footer_menu2'] );
							$menu2_args = array(
								'menu_class'      => 'nav_menu',
								'menu'         => $hermes_opt['footer_menu2'],
							);
							if (is_object($menu2_object)) {
							?>
							<div class="col-sm-6  col-md-3">
								<div class="widget widget_menu">
									<h3 class="widget-title"><?php echo esc_html($menu2_object->name); ?></h3>
									<?php wp_nav_menu( $menu2_args ); ?>
								</div>
							</div>
						<?php }
						}
						if( !empty($hermes_opt['footer_menu3']) && !empty($hermes_opt['about_us2'])) {
							$menu3_object = wp_get_nav_menu_object( $hermes_opt['footer_menu3'] );
							$menu3_args = array(
								'menu_class'      => 'nav_menu',
								'menu'         => $hermes_opt['footer_menu3'],
							);
							if (is_object($menu3_object)) {
							?>
							<div class="col-sm-6  col-md-3">
								<div class="widget widget_menu">
									<h3 class="widget-title"><?php echo esc_html($menu3_object->name); ?></h3>
									<?php wp_nav_menu( $menu3_args ); ?>
								</div>
							</div>
							<?php } ?>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<div class="col-sm-6">

						<div class="widget-copyright">
							<?php 
							if( !empty($hermes_opt['copyright']) || is_active_sidebar('footer_copyright') ) {
								if( !empty($hermes_opt['copyright'])) {
									echo wp_kses($hermes_opt['copyright'], array(
										'a' => array(
											'href' => array(),
											'title' => array()
										),
										'br' => array(),
										'em' => array(),
										'strong' => array(),
									));
								} else {
									dynamic_sidebar('footer_copyright');
								}
							} else {
								echo 'Copyright © '.date('Y').' <a href="'.esc_url( home_url( '/' ) ).'">'.get_bloginfo('name').'</a>. All Rights Reserved';
							}
							?>
						</div>
					</div>
					
					<?php if(!empty($hermes_opt['payment_icons']) ) { ?>
					<div class="col-sm-6">
						<div class="widget-payment text-right">
							<?php echo wp_kses($hermes_opt['payment_icons'], array(
								'a' => array(
									'href' => array(),
									'title' => array()
								),
								'img' => array(
									'src' => array(),
									'alt' => array()
								),
							)); ?>
						</div>
					</div>
					<?php }elseif(is_active_sidebar('footer_payment')) { ?>
						<div class="col-sm-6 text-right	">
							<?php dynamic_sidebar('footer_payment'); ?>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>