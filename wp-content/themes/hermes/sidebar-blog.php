<?php if (is_active_sidebar('blog')) { ?> 
				<div class="col-md-3" id="secondary" class="sidebar-blog">
					<?php do_action('before_sidebar'); ?> 
					<?php dynamic_sidebar('blog'); ?> 
				</div>
<?php } ?> 