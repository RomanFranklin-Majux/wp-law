<?php

/*********** Shortcode: stars ************************************************************/

$TMF_Shortcodes['stars'] = array(
	'name' => __( 'Stars', 'tmf-shortcodes' ),
	'type' => 'single',
	'group' => 'misc',
	'atts' => array(
		'limit' => array(
			'default' => '',
			'name' => __( 'Limit', 'tmf-shortcodes' ),
			'desc' => __( 'Number of stars to show', 'tmf-shortcodes' )
		),
	),
	'content' => __( 'Stars', 'tmf-shortcodes' ),
	'desc' => __( 'This shortcode shows Stars', 'tmf-shortcodes' ),
);