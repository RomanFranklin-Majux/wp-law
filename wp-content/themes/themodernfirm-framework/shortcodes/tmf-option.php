<?php

/********** Shortcode: tmf-option *************************************************************/

$TMF_Shortcodes['tmf-option'] = array(
	'name' => __( 'TMF Option', 'tmf-shortcodes' ),
	'type' => 'single',
	'group' => 'misc',
	'atts' => array(
		'key' => array(
			'default' => '',
			'name' => __( 'Key', 'tmf-shortcodes' ),
			'desc' => __( 'Enter option name that you want to show', 'tmf-shortcodes' )
		),
	),
	'content' => __( 'TMF Option', 'tmf-shortcodes' ),
	'desc' => __( 'Framework Options', 'tmf-shortcodes' ),
);