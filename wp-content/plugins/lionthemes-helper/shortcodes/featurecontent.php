<?php
function hermes_feature_content_shortcode( $atts ) {
	
	$atts = shortcode_atts( array(
							'icon'=>'',
							'feature_text'=>'',
							'short_desc'=>'',
							'style'=>'',
							'showon_effect'=>'',
							'el_class' => '',
							), $atts, 'featuredcontent' );
	extract($atts);
	
	if(!$feature_text) return;
	
	$showon_effect = ($showon_effect) ? ' wow ' . $showon_effect : '';
	ob_start();
	echo '<div class="feature_text_widget '. $style . $showon_effect .' ' . esc_attr($el_class) .'" data-wow-delay="100ms" data-wow-duration="0.5s">';
		echo '<div class="toptext">';
			echo ($icon) ? '<span class="'. esc_attr($icon) .'"></span>':'';
			echo '<div class="feature_text">' . urldecode(base64_decode($feature_text)) . '</div>';
		echo '</div>';
		echo ($short_desc) ? '<div class="short_desc">' . urldecode(base64_decode($short_desc)) . '</div>':'';
	echo '</div>';
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}
add_shortcode( 'featuredcontent', 'hermes_feature_content_shortcode' );
?>