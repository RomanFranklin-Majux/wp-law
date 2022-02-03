<?php

/*********** Shortcode: youtube ************************************************************/

$TMF_Shortcodes['youtube'] = array(
	'name' => __( 'YouTube', 'tmf-shortcodes' ),
	'type' => 'single',
	'group' => 'misc',
	'atts' => array(
		'id' => array(
			'default' => '',
			'name' => __( 'Video ID', 'tmf-shortcodes' ),
			'desc' => __( 'YouTube Video ID', 'tmf-shortcodes' )
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
		'title'          => array(
			'name'    => __( 'Title', 'shortcodes-ultimate' ),
			'desc'    => __( 'A brief description of the embedded content (used by screenreaders)', 'shortcodes-ultimate' ),
			'default' => '',
		),
		'description'    => array(
			'name'    => __( 'Description', 'shortcodes-ultimate' ),
			'type'    => 'textarea',
			'desc'    => __( 'A brief description of the embedded content (used by video object schema)', 'shortcodes-ultimate' ),
			'default' => '',
		),
	),
	'content' => __( 'YouTube', 'tmf-shortcodes' ),
	'desc' => __( 'This shortcode shows YouTube embed', 'tmf-shortcodes' ),
);