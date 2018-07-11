<?php

add_filter('vc_shortcodes_css_class', 'hermes_vc_shortcodes_custom_class', 10, 3);
function hermes_vc_shortcodes_custom_class($class_to_filter, $base_setting, $attrs) {
	if (!empty($attrs['hover_effect'])) {
		$class_to_filter .= ' ' . $attrs['hover_effect'];
	}
	return $class_to_filter;
}

add_action( 'vc_before_init', 'hermes_vc_shortcodes' );
function hermes_vc_shortcodes() {
	vc_add_param( 'vc_row', array(
		 'type' => 'checkbox',
		 'heading' => esc_html__('Full Width', 'hermes'),
		 'param_name' => 'fullwidth',
		 'value' => array(
						'Yes, please' => true
					)
	));
	vc_add_param( 'vc_single_image', array(
         'type' => 'dropdown',
         'heading' => esc_html__('Hover effect','hermes'),
         'param_name' => 'hover_effect',
         'value' => array(
         				esc_html__('None', 'hermes') => '',
         				esc_html__('Blur', 'hermes') => 'blur-ef',
         				esc_html__('Zoom', 'hermes') => 'zoom-ef',
         				esc_html__('Zoom and Blur', 'hermes') => 'zoom-ef blur-ef',
         				esc_html__('Glass Open', 'hermes') => 'glass-open-ef',
         				esc_html__('Glass Close', 'hermes') => 'glass-close-ef',
         				esc_html__('Glass Close up', 'hermes') => 'glass-close-ef up-down',
         				esc_html__('Grey overlay', 'hermes') => 'grey-overlay-ef',
         			)
    ));
	vc_add_param( 'vc_tta_tabs', array(
		'type' => 'dropdown',
		'heading' => esc_html__( 'Custom style', 'hermes' ),
		'param_name' => 'custom_style',
		'value' => array(
			esc_html__('Default', 'hermes')	=> '',
			esc_html__('Line style', 'hermes')	=> 'line-style',
			esc_html__('Border style', 'hermes')	=> 'border-style',
		),
		'group' => esc_html__( 'Hermes options', 'hermes' ),
	));
	vc_add_param( 'vc_tta_tabs', array(
		 'type' => 'textarea',
		 'heading' => esc_html__('Short Description', 'hermes'),
		 'param_name' => 'short_desc',
		 'value' => '',
		 'group' => esc_html__( 'Hermes options', 'hermes' ),
	));
	vc_add_param( 'vc_custom_heading', array(
		 'type' => 'textarea',
		 'heading' => esc_html__('Sub heading text', 'hermes'),
		 'param_name' => 'sub_heading',
		 'value' => '',
		 'group' => esc_html__( 'Hermes options', 'hermes' ),
	));
	vc_add_param( 'vc_custom_heading', array(
		 'type' => 'dropdown',
		 'heading' => esc_html__('Sub heading tag', 'hermes'),
		 'param_name' => 'sub_heading_tag',
		 'value' => array(
			'h1'=>'h1',
			'h2'=>'h2',
			'h3'=>'h3',
			'h4'=>'h4',
			'h5'=>'h5',
			'h6'=>'h6',
			'div'=>'div',
			'p'=>'p',
			'span'=>'span',
		 ),
		 'group' => esc_html__( 'Hermes options', 'hermes' ),
		 'save_always' => true,
	));
	
	//Brand logos
	vc_map( array(
		'name' => esc_html__( 'Brand Logos', 'hermes' ),
		'base' => 'ourbrands',
		'class' => '',
		'category' => esc_html__( 'Hermes Theme', 'hermes'),
		'params' => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Title', 'hermes' ),
				'param_name' => 'title',
				'value' => '',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Widget style', 'hermes' ),
				'param_name' => 'widget_style',
				'value' => array(
						esc_html__('Default', 'hermes')	=> '',
						esc_html__('Line style', 'hermes')	=> 'line-style',
						esc_html__('Border style', 'hermes')	=> 'border-style',
					),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Number of columns', 'hermes' ),
				'param_name' => 'colsnumber',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
						'6'	=> '6',
					),
				'save_always' => true,
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Auto rotate', 'hermes' ),
				'param_name' => 'autoplay',
				'value' => array(
					esc_html__( 'No', 'hermes' ) 	=> 'false',
					esc_html__( 'Yes', 'hermes' ) 	=> 'true',
				),
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Play Timeout', 'hermes' ),
				'param_name' => 'playtimeout',
				'value' => '5000',
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Rotate speed', 'hermes' ),
				'param_name' => 'speed',
				'value' => '250',
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Number of rows', 'hermes' ),
				'param_name' => 'rows',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Style', 'hermes' ),
				'param_name' => 'style',
				'value' => array(
						esc_html__( 'Grid', 'hermes' )	 	=> 'grid',
						esc_html__( 'Carousel', 'hermes' ) 	=> 'carousel',
					),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Show on effect', 'hermes' ),
				'param_name' => 'showon_effect',
				'value' => hermes_get_effect_list(),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Extra class name', 'hermes' ),
				'param_name' => 'el_class',
				'value' => '',
				'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'hermes' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count desktop small', 'hermes' ),
				'param_name' => 'desksmall',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count tablet', 'hermes' ),
				'param_name' => 'tablet_count',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count tablet small', 'hermes' ),
				'param_name' => 'tabletsmall',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count mobile', 'hermes' ),
				'param_name' => 'mobile_count',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' )
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Margin', 'hermes' ),
				'param_name' => 'margin',
				'value' => '30',
				'group' => esc_html__( 'Carousel options', 'hermes' )
			),
		)
	) );
	
	
	//Feature content widget
	vc_map( array(
		'name' => esc_html__( 'Feature content', 'hermes' ),
		'base' => 'featuredcontent',
		'class' => '',
		'category' => esc_html__( 'Hermes Theme', 'hermes'),
		'params' => array(
			array(
				'type' => 'iconpicker',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Icon', 'hermes' ),
				'param_name' => 'icon',
				'value' => '',
			),
			array(
				'type' => 'textarea_raw_html',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Feature text', 'hermes' ),
				'param_name' => 'feature_text',
				'value' => '',
			),
			array(
				'type' => 'textarea_raw_html',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Short description', 'hermes' ),
				'param_name' => 'short_desc',
				'value' => '',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Layout style', 'hermes' ),
				'param_name' => 'style',
				'value' => array(
						esc_html__('Style 1', 'hermes')	=> '',
						esc_html__('Style 2', 'hermes')	=> 'style_2',
						esc_html__('Style 3', 'hermes')	=> 'style_3',
					),
				'save_always' => true,
				'group' => esc_html__( 'List style options', 'hermes' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Show on effect', 'hermes' ),
				'param_name' => 'showon_effect',
				'value' => hermes_get_effect_list(),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Extra class name', 'hermes' ),
				'param_name' => 'el_class',
				'value' => '',
				'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'hermes' )
			)
		)
	) );
	
	//Specify Products
	vc_map( array(
		'name' => esc_html__( 'Specify Products', 'hermes' ),
		'base' => 'specifyproducts',
		'class' => '',
		'category' => esc_html__( 'Hermes Theme', 'hermes'),
		'params' => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Title', 'hermes' ),
				'param_name' => 'title',
				'value' => '',
			),
			array(
				'type' => 'textarea',
				'heading' => esc_html__('Short Description', 'hermes'),
				'param_name' => 'short_desc',
				'holder' => 'div',
				'class' => '',
				'value' => '',
				'save_always' => true,
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Widget style', 'hermes' ),
				'param_name' => 'widget_style',
				'value' => array(
						esc_html__('Default', 'hermes')	=> '',
						esc_html__('Line style', 'hermes')	=> 'line-style',
						esc_html__('Border style', 'hermes')	=> 'border-style',
					),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Type', 'hermes' ),
				'param_name' => 'type',
				'value' => array(
						esc_html__( 'Best Selling', 'hermes' )		=> 'best_selling',
						esc_html__( 'Featured Products', 'hermes' ) => 'featured_product',
						esc_html__( 'Top Rate', 'hermes' ) 			=> 'top_rate',
						esc_html__( 'Recent Products', 'hermes' ) 	=> 'recent_product',
						esc_html__( 'On Sale', 'hermes' ) 			=> 'on_sale',
						esc_html__( 'Recent Review', 'hermes' ) 	=> 'recent_review',
						esc_html__( 'Product Deals', 'hermes' )		 => 'deals'
					),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Only In Category', 'hermes' ),
				'param_name' => 'in_category',
				'value' => hermes_get_all_taxonomy_terms('product_cat', true),
				'save_always' => true,
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Number of products to show', 'hermes' ),
				'param_name' => 'number',
				'value' => '10',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Style', 'hermes' ),
				'param_name' => 'style',
				'value' => array(
						esc_html__( 'Grid', 'hermes' )	 	=> 'grid',
						esc_html__( 'List', 'hermes' ) 		=> 'list',
						esc_html__( 'Carousel', 'hermes' ) 	=> 'carousel',
					),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Show on effect', 'hermes' ),
				'param_name' => 'showon_effect',
				'value' => hermes_get_effect_list(),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Item layout', 'hermes' ),
				'param_name' => 'item_layout',
				'value' => array(
						esc_html__( 'Box', 'hermes' ) 		=> 'box',
						esc_html__( 'List', 'hermes' ) 	=> 'list',
					),
				'group' => esc_html__( 'Carousel options', 'hermes' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Auto rotate', 'hermes' ),
				'param_name' => 'autoplay',
				'value' => array(
					esc_html__( 'No', 'hermes' ) 	=> 'false',
					esc_html__( 'Yes', 'hermes' ) 	=> 'true',
				),
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Play Timeout', 'hermes' ),
				'param_name' => 'playtimeout',
				'value' => '5000',
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Rotate speed', 'hermes' ),
				'param_name' => 'speed',
				'value' => '250',
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Number of rows', 'hermes' ),
				'param_name' => 'rows',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns', 'hermes' ),
				'param_name' => 'columns',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
						'6'	=> '6',
					),
				'save_always' => true,
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Extra class name', 'hermes' ),
				'param_name' => 'el_class',
				'value' => '',
				'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'hermes' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count desktop small', 'hermes' ),
				'param_name' => 'desksmall',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count tablet', 'hermes' ),
				'param_name' => 'tablet_count',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count tablet small', 'hermes' ),
				'param_name' => 'tabletsmall',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count mobile', 'hermes' ),
				'param_name' => 'mobile_count',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4', 
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' )
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Margin', 'hermes' ),
				'param_name' => 'margin',
				'value' => '30',
				'group' => esc_html__( 'Carousel options', 'hermes' )
			),
		)
	) );
	//Products Category
	vc_map( array(
		'name' => esc_html__( 'Products Category', 'hermes' ),
		'base' => 'productscategory',
		'class' => '',
		'category' => esc_html__( 'Hermes Theme', 'hermes'),
		'params' => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Title', 'hermes' ),
				'param_name' => 'title',
				'value' => '',
			),
			array(
				'type' => 'textarea',
				'heading' => esc_html__('Short Description', 'hermes'),
				'param_name' => 'short_desc',
				'holder' => 'div',
				'class' => '',
				'value' => '',
				'save_always' => true,
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Widget style', 'hermes' ),
				'param_name' => 'widget_style',
				'value' => array(
						esc_html__('Default', 'hermes')	=> '',
						esc_html__('Line style', 'hermes')	=> 'line-style',
						esc_html__('Border style', 'hermes')	=> 'border-style',
					),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Category', 'hermes' ),
				'param_name' => 'category',
				'value' => hermes_get_all_taxonomy_terms(),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Number of products to show', 'hermes' ),
				'param_name' => 'number',
				'value' => '10',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Style', 'hermes' ),
				'param_name' => 'style',
				'value' => array(
						esc_html__( 'Grid', 'hermes' )	 	=> 'grid',
						esc_html__( 'List', 'hermes' ) 		=> 'list',
						esc_html__( 'Carousel', 'hermes' ) 	=> 'carousel',
					),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Show on effect', 'hermes' ),
				'param_name' => 'showon_effect',
				'value' => hermes_get_effect_list(),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Item layout', 'hermes' ),
				'param_name' => 'item_layout',
				'value' => array(
						esc_html__( 'Box', 'hermes' ) 		=> 'box',
						esc_html__( 'List', 'hermes' ) 	=> 'list',
					),
				'group' => esc_html__( 'Carousel options', 'hermes' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Auto rotate', 'hermes' ),
				'param_name' => 'autoplay',
				'value' => array(
					esc_html__( 'No', 'hermes' ) 	=> 'false',
					esc_html__( 'Yes', 'hermes' ) 	=> 'true',
				),
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Play Timeout', 'hermes' ),
				'param_name' => 'playtimeout',
				'value' => '5000',
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Rotate speed', 'hermes' ),
				'param_name' => 'speed',
				'value' => '250',
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Number of rows', 'hermes' ),
				'param_name' => 'rows',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns', 'hermes' ),
				'param_name' => 'columns',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
						'6'	=> '6',
					),
				'save_always' => true,
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Extra class name', 'hermes' ),
				'param_name' => 'el_class',
				'value' => '',
				'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'hermes' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count desktop small', 'hermes' ),
				'param_name' => 'desksmall',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count tablet', 'hermes' ),
				'param_name' => 'tablet_count',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count tablet small', 'hermes' ),
				'param_name' => 'tabletsmall',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count mobile', 'hermes' ),
				'param_name' => 'mobile_count',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' )
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Margin', 'hermes' ),
				'param_name' => 'margin',
				'value' => '30',
				'group' => esc_html__( 'Carousel options', 'hermes' )
			),
		)
	) );
	
	//Testimonials
	vc_map( array(
		'name' => esc_html__( 'Hermes Testimonials', 'hermes' ),
		'base' => 'testimonials',
		'class' => '',
		'category' => esc_html__( 'Hermes Theme', 'hermes'),
		'params' => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Title', 'hermes' ),
				'param_name' => 'title',
				'value' => '',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Widget style', 'hermes' ),
				'param_name' => 'widget_style',
				'value' => array(
						esc_html__('Default', 'hermes')	=> '',
						esc_html__('Line style', 'hermes')	=> 'line-style',
						esc_html__('Border style', 'hermes')	=> 'border-style',
					),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Total items to show', 'hermes' ),
				'param_name' => 'number',
				'value' => '10',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Auto rotate', 'hermes' ),
				'param_name' => 'autoplay',
				'value' => array(
					esc_html__( 'No', 'hermes' ) 	=> 'false',
					esc_html__( 'Yes', 'hermes' ) 	=> 'true',
				),
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Play Timeout', 'hermes' ),
				'param_name' => 'playtimeout',
				'value' => '5000',
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Rotate speed', 'hermes' ),
				'param_name' => 'speed',
				'value' => '250',
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Order', 'hermes' ),
				'param_name' => 'order',
				'value' => array(
					esc_html__('Random', 'hermes') => 'rand',
					esc_html__('Latest first', 'hermes') => '',
				),
				'save_always' => true,
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Show name', 'hermes' ),
				'param_name' => 'show_name',
				'value' => array(
					esc_html__('Yes', 'hermes') => 1,
					esc_html__('No', 'hermes') => 0,
				),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Show date', 'hermes' ),
				'param_name' => 'show_date',
				'value' => array(
					esc_html__('Yes', 'hermes') => 1,
					esc_html__('No', 'hermes') => 0,
				),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Excerpt length', 'hermes' ),
				'param_name' => 'excerpt_length',
				'value' => '0',
				'description' => esc_html__( 'Default 0 to display full text.', 'hermes' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Style', 'hermes' ),
				'param_name' => 'style',
				'value' => array(
						esc_html__( 'Carousel', 'hermes' ) 	=> 'carousel',
						esc_html__( 'List', 'hermes' ) 		=> 'list',
					),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Show on effect', 'hermes' ),
				'param_name' => 'showon_effect',
				'value' => hermes_get_effect_list(),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns', 'hermes' ),
				'param_name' => 'columns',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Extra class name', 'hermes' ),
				'param_name' => 'el_class',
				'value' => '',
				'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'hermes' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Number of rows', 'hermes' ),
				'param_name' => 'rows',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count desktop small', 'hermes' ),
				'param_name' => 'desksmall',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count tablet', 'hermes' ),
				'param_name' => 'tablet_count',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count tablet small', 'hermes' ),
				'param_name' => 'tabletsmall',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count mobile', 'hermes' ),
				'param_name' => 'mobile_count',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' )
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Margin', 'hermes' ),
				'param_name' => 'margin',
				'value' => '30',
				'group' => esc_html__( 'Carousel options', 'hermes' )
			),
		)
	) );
	
	//MailPoet Newsletter Form
	vc_map( array(
		'name' => esc_html__( 'Newsletter Form (MailPoet)', 'hermes' ),
		'base' => 'wysija_form',
		'class' => '',
		'category' => esc_html__( 'Hermes Theme', 'hermes'),
		'params' => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Form ID', 'hermes' ),
				'param_name' => 'id',
				'value' => esc_html__( '', 'hermes' ),
				'description' => esc_html__( 'Enter form ID here', 'hermes' ),
			)
		)
	) );
	
	//Latest posts
	vc_map( array(
		'name' => esc_html__( 'Blog posts', 'hermes' ),
		'base' => 'blogposts',
		'class' => '',
		'category' => esc_html__( 'Hermes Theme', 'hermes'),
		'params' => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Title', 'hermes' ),
				'param_name' => 'title',
				'value' => '',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Widget style', 'hermes' ),
				'param_name' => 'widget_style',
				'value' => array(
						esc_html__('Default', 'hermes')	=> '',
						esc_html__('Line style', 'hermes')	=> 'line-style',
						esc_html__('Border style', 'hermes')	=> 'border-style',
					),
			),
			array(
				'type' => 'textarea',
				'heading' => esc_html__('Short Description', 'hermes'),
				'param_name' => 'short_desc',
				'holder' => 'div',
				'class' => '',
				'value' => '',
				'save_always' => true,
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Number of post to show', 'hermes' ),
				'param_name' => 'number',
				'value' => '5',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Style', 'hermes' ),
				'param_name' => 'style',
				'value' => array(
						esc_html__( 'Carousel', 'hermes' ) 	=> 'carousel',
						esc_html__( 'List', 'hermes' ) 		=> 'list',
						esc_html__( 'Grid', 'hermes' )	 	=> 'grid',
					),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Show on effect', 'hermes' ),
				'param_name' => 'showon_effect',
				'value' => hermes_get_effect_list(),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Auto rotate', 'hermes' ),
				'param_name' => 'autoplay',
				'value' => array(
					esc_html__( 'No', 'hermes' ) 	=> 'false',
					esc_html__( 'Yes', 'hermes' ) 	=> 'true',
				),
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Play Timeout', 'hermes' ),
				'param_name' => 'playtimeout',
				'value' => '5000',
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Rotate speed', 'hermes' ),
				'param_name' => 'speed',
				'value' => '250',
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Number of rows', 'hermes' ),
				'param_name' => 'rows',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns', 'hermes' ),
				'param_name' => 'columns',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Image scale', 'hermes' ),
				'param_name' => 'image',
				'value' => array(
						esc_html__( 'Wide', 'hermes' )	=> 'wide',
						esc_html__( 'Square', 'hermes' ) => 'square',
					),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Excerpt length', 'hermes' ),
				'param_name' => 'length',
				'value' => '20',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Order by', 'hermes' ),
				'param_name' => 'orderby',
				'value' => array(
						esc_html__( 'Posted Date', 'hermes' )	=> 'date',
						esc_html__( 'Ordering', 'hermes' ) => 'menu_order',
						esc_html__( 'Random', 'hermes' ) => 'rand',
					),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Order Direction', 'hermes' ),
				'param_name' => 'order',
				'value' => array(
						esc_html__( 'Descending', 'hermes' )	=> 'DESC',
						esc_html__( 'Ascending', 'hermes' ) => 'ASC',
					),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count desktop small', 'hermes' ),
				'param_name' => 'desksmall',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count tablet', 'hermes' ),
				'param_name' => 'tablet_count',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count tablet small', 'hermes' ),
				'param_name' => 'tabletsmall',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' )
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count mobile', 'hermes' ),
				'param_name' => 'mobile_count',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel options', 'hermes' )
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Margin', 'hermes' ),
				'param_name' => 'margin',
				'value' => '30',
				'group' => esc_html__( 'Carousel options', 'hermes' )
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Extra class name', 'hermes' ),
				'param_name' => 'el_class',
				'value' => '',
				'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'hermes' )
			),
		)
	) );
	
	//Custom countdown
	vc_map( array(
		'name' => esc_html__( 'Hermes Countdown timer', 'hermes' ),
		'base' => 'hermes_countdown',
		'class' => '',
		'category' => esc_html__( 'Hermes Theme', 'hermes'),
		'params' => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Title', 'hermes' ),
				'param_name' => 'title',
				'value' => '',
			),
			array(
				'type' => 'textarea',
				'heading' => esc_html__('Short Description', 'hermes'),
				'param_name' => 'short_desc',
				'holder' => 'div',
				'class' => '',
				'value' => '',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Date time expires', 'hermes'),
				'param_name' => 'datetime',
				'holder' => 'div',
				'class' => '',
				'value' => '',
				'description' => esc_html__( 'Format must be yyyy-mm-dd HH:mm:ss', 'hermes' )
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Extra class name', 'hermes' ),
				'param_name' => 'el_class',
				'value' => '',
				'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'hermes' )
			),
		)
	) );
}
// Filter to replace default css class names for vc_row shortcode and vc_column
add_filter( 'vc_shortcodes_css_class', 'custom_css_classes_for_vc_row_and_vc_column', 10, 2 );
function custom_css_classes_for_vc_row_and_vc_column( $class_string, $tag ) {
  $class_string = preg_replace( '/vc_col-sm-(\d{1,2})/', 'col-sm-$1', $class_string ); // This will replace "vc_col-sm-%" with "my_col-sm-%"
  $class_string = str_replace('vc_column_container', 'column_container', $class_string);
  return $class_string; // Important: you should always return modified or original $class_string
}
?>