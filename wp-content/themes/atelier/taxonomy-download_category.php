<?php get_header(); ?>

<div class="container">

	<?php 
	if ( is_tax( 'download_category' ) && class_exists( 'ATCF_Campaigns' ) ) {
    	sf_base_layout('campaigns');	
    } else if ( is_tax( 'download_category' ) && sf_edd_activated() ) {
        sf_base_layout('edd-archive');      
    }
	?>
	
</div>

<?php get_footer(); ?>