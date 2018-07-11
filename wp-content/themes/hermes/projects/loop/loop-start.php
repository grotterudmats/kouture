<?php
/**
 * Project Loop Start
 *
 * @author 		WooThemes
 * @package 	Projects/Templates
 * @version     1.0.0
 */
?>
<?php
	global $hermes_opt;

	$col = $hermes_opt['portfolio_columns'];

	if (isset($_GET['col'])){
		$col = (int)$_GET['col'];
	}
	$col = ($col > 0) ? $col : 3;
?>
<div id="projects_list" class="auto-grid" data-col="<?php echo esc_attr($col); ?>">