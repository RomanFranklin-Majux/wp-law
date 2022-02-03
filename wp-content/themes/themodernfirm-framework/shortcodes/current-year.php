<?php

/*********** Shortcode: current-year ************************************************************/

$TMF_Shortcodes['current-year'] = array(
	'name' => __( 'Current Year', 'tmf-shortcodes' ),
	'type' => 'single',
	'group' => 'misc',
	'atts' => array(
		'year' => array(
			'default' => '',
			'name' => __( 'Year', 'tmf-shortcodes' ),
			'desc' => __( 'Enter the year number like +1 for next and -1 for last year etc', 'tmf-shortcodes' )
		),
	),

	'content' => __( 'Current Year', 'tmf-shortcodes' ),
	'desc' => __( 'This shortcode shows Current Year', 'tmf-shortcodes' ),
);