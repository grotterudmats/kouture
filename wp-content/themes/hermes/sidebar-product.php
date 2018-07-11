<?php if (is_active_sidebar('product')) { ?> 
	<div class="col-xs-12 col-md-3 sidebar-product" id="secondary">
		<?php do_action('before_sidebar'); ?> 
		<?php dynamic_sidebar('product'); ?>
	</div>
<?php } ?> 