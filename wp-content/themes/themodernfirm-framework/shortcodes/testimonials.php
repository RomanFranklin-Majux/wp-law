<?php

/********** Shortcode: Testimonial *************************************************************/

$TMF_Shortcodes['testimonials'] = array(
	'name' => __( 'Testimonials', 'tmf-shortcodes' ),
	'type' => 'single',
	'group' => 'content',
	'testimonial_type'	=> 'testimonial',
	'post_type' => 'testimonial',
	'atts' => array(
		'taxonomy' => array(
			'default' => 'testimonial-categories',
			'name' => __( 'Taxonomy', 'tmf-shortcodes' ),
			'desc' => __( 'Post type taxonomy', 'tmf-shortcodes' )
		),
		'terms' => array(
			'default' => '',
			'name' => __( 'Terms', 'tmf-shortcodes' ),
			'desc' => __( 'Comma separated list of terms', 'tmf-shortcodes' )
		),
		'template' => array(
			'default' => '',
			'name' => __( 'Template', 'tmf-shortcodes' ),
			'desc' => __( '<b>Do not change this field value if you do not understand description below.</b><br/>Default templates is placed under the framework/blocks/post-types/testimonial/ directory (templates folder). You can copy it under your theme directory and modify as you want. You can use following default templates that already available in the framework directory:<br/><b%value>medium</b> - posts loop<br/><b%value>small</b> - posts loop with thumbnail and title<br/><b%value>large</b> - single post template', 'tmf-shortcodes' )
		),
		'include' => array(
			'default' => '',
			'name' => __( 'Include', 'tmf-shortcodes' ),
			'desc' => __( 'Enter comma separated ID\'s of the posts that you want to show', 'tmf-shortcodes' )
		),
		'field' => array(
			'default' => '',
			'name' => __( 'Field', 'tmf-shortcodes' ),
			'desc' => __( 'Return single field', 'tmf-shortcodes' )
		),
		'limit' => array(
			'type' => 'number',
			'min' => -1,
			'max' => 10000,
			'step' => 1,
			'default' => '',
			'name' => __( 'Number of Testimonials', 'tmf-shortcodes' ),
			'desc' => __( 'Specify number of testimonials that you want to show. Enter -1 to get all testimonials', 'tmf-shortcodes' )
		),
		'random' => array(
			'type' => 'select',
			'values' => array(
				'' => __( 'Select', 'tmf-shortcodes' ),
				'false' => __( 'No', 'tmf-shortcodes' ),
				'true' => __( 'Yes', 'tmf-shortcodes' )
				),
			'default' => '',
			'name' => __( 'Random', 'tmf-shortcodes' ),
			'desc' => __( '', 'tmf-shortcodes' )
		),
		'meta_key' => array(
			'default' => '',
			'name' => __( 'Meta key', 'tmf-shortcodes' ),
			'desc' => __( 'Enter meta key name to show testimonials that have this key', 'tmf-shortcodes' )
		),
		'offset' => array(
			'type' => 'number',
			'min' => 0,
			'max' => 10000,
			'step' => 1, 
			'default' => '',
			'name' => __( 'Offset', 'tmf-shortcodes' ),
			'desc' => __( 'Specify offset to start testimonials loop not from first testimonial', 'tmf-shortcodes' )
		),
		'order' => array(
			'type' => 'select',
			'values' => array(
				'' => __( 'Select', 'tmf-shortcodes' ),
				'desc' => __( 'Descending', 'tmf-shortcodes' ),
				'asc' => __( 'Ascending', 'tmf-shortcodes' )
				),
			'default' => '',
			'name' => __( 'Order', 'tmf-shortcodes' ),
			'desc' => __( 'Posts order', 'tmf-shortcodes' )
		),
		'orderby' => array(
			'type' => 'select',
			'values' => array(
				'' => __( 'Select', 'tmf-shortcodes' ),
				'id' => __( 'Post ID', 'tmf-shortcodes' ),
				'author' => __( 'Post author', 'tmf-shortcodes' ),
				'title' => __( 'Post title', 'tmf-shortcodes' ),
				'name' => __( 'Post slug', 'tmf-shortcodes' ),
				'date' => __( 'Date', 'tmf-shortcodes' ), 'modified' => __( 'Last modified date', 'tmf-shortcodes' ),
				'parent' => __( 'Post parent', 'tmf-shortcodes' ),
				'rand' => __( 'Random', 'tmf-shortcodes' ), 'comment_count' => __( 'Comments number', 'tmf-shortcodes' ),
				'menu_order' => __( 'Menu order', 'tmf-shortcodes' ), 'meta_value' => __( 'Meta key values', 'tmf-shortcodes' ),
				),
			'default' => '',
			'name' => __( 'Order by', 'tmf-shortcodes' ),
			'desc' => __( 'Order testimonials by', 'tmf-shortcodes' )
		),
		'exclude' => array(
			'default' => '',
			'name' => __( 'Exclude', 'tmf-shortcodes' ),
			'desc' => __( 'Enter comma separated ID\'s of the testimonials that you don\'t want to show', 'tmf-shortcodes' )
		),
	),

	'content' => __( 'Testimonials', 'tmf-shortcodes' ),
	'desc' => __( 'Testimonials Post Type', 'tmf-shortcodes' ),
);