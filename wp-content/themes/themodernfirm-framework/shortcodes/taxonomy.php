<?php

/********** Shortcode: taxonomies *************************************************************/

$TMF_Shortcodes['taxonomies'] = array(
    'name' => __( 'Taxonomy', 'tmf-shortcodes' ),
	'type' => 'single',
	'group' => 'tmf',
	'atts' => array(
		'post_type' => array(
			'default' => '',
            'name' => __( 'Post Type', 'tmf-shortcodes' ),
			'desc' => __('Post Type', 'tmf-shortcodes'),
		),
		'taxonomy' => array(
            'name' => __( 'Taxonomy', 'tmf-shortcodes' ),
			'desc' => __('Taxonomy', 'tmf-shortcodes'),
		),
		'include' => array(
            'name' => __( 'Include', 'tmf-shortcodes' ),
			'desc' => __('Taxonomy ID\'s to include', 'tmf-shortcodes'),
		),
		'exclude' => array(
            'name' => __( 'Exclude', 'tmf-shortcodes' ),
			'desc' => __('Taxonomy ID\'s to exclude', 'tmf-shortcodes'),
		),
		'show_count' => array(
			'type' => 'select',
			'values' => array(
				'false' => __( 'No', 'tmf-shortcodes' ),
				'true' => __( 'Yes', 'tmf-shortcodes' )
				),
			'name' => __( 'Show Post Count', 'tmf-shortcodes' ),
			'desc' => __( '', 'tmf-shortcodes' )
		),
		'before' => array(
			'type' => 'select',
			'values' => array(
				'false' => __( 'Show After Taxonomy Name', 'tmf-shortcodes' ),
				'true' => __( 'Show Before Taxonomy Name', 'tmf-shortcodes' )
				),
			'name' => __( 'Post Count Position', 'tmf-shortcodes' ),
			'desc' => __( '', 'tmf-shortcodes' )
		),

	),
    'content' => __( 'Taxonomy', 'tmf-shortcodes' ),
	'desc' => __('Taxonomy', 'tmf-shortcodes' )
);