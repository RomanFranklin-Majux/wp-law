<?php

/*********** Shortcode: vimeo ************************************************************/

$TMF_Shortcodes['vimeo'] = array(
	'name' => __( 'Vimeo', 'tmf-shortcodes' ),
	'type' => 'single',
	'group' => 'misc',
	'atts' => array(
		'id' => array(
			'default' => '',
			'name' => __( 'Video ID', 'tmf-shortcodes' ),
			'desc' => __( 'Vimeo Video ID', 'tmf-shortcodes' )
		),
		'width' => array(
			'default' => '300',
			'name' => __( 'Video Width', 'tmf-shortcodes' ),
			'desc' => __( 'Width of Video', 'tmf-shortcodes' )
		),
		'height' => array(
			'default' => '200',
			'name' => __( 'Video Height', 'tmf-shortcodes' ),
			'desc' => __( 'Height of Video', 'tmf-shortcodes' )
		),
		'placeholder_src' => array(
			'default' => '',
			'name' => __( 'Video Thumbnail URL', 'tmf-shortcodes' ),
			'desc' => __( 'Thumbnail URL of Video', 'tmf-shortcodes' )
		),
		'ui_color' => array(
			'type' => 'color',
			'default' => '#ffffff',
			'values' => array( ),
			'name' => __( 'Video Background Color', 'tmf-shortcodes' ),
			'desc' => __( 'Background Color of Video', 'tmf-shortcodes' )
		),
	),
	'content' => __( 'Vimeo', 'tmf-shortcodes' ),
	'desc' => __( 'This shortcode shows vimeo embed', 'tmf-shortcodes' ),
);