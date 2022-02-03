<?php

/********** Shortcode: wp-option *************************************************************/

$TMF_Shortcodes['wp-option'] = array(
	'name' => __( 'WP Option', 'tmf-shortcodes' ),
	'type' => 'single',
	'group' => 'misc',
	'atts' => array(
		'key' => array(
			'default' => '',
			'name' => __( 'Key', 'tmf-shortcodes' ),
			'desc' => __( 'Enter option name that you want to show', 'tmf-shortcodes' )
		),
	),
	'content' => __( 'WP Option', 'tmf-shortcodes' ),
	'desc' => __( 'WP Option', 'tmf-shortcodes' ),
);