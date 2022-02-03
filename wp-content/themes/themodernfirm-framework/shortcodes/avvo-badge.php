<?php

/*********** Shortcode: avvo-badge ************************************************************/

$TMF_Shortcodes['avvo-badge'] = array(
	'name' => __( 'Avvo Badge', 'tmf-shortcodes' ),
	'type' => 'single',
	'group' => 'misc',
	'atts' => array(
		'avvo_id' => array(
			'default' => '',
			'name' => __( 'Avvo ID', 'tmf-shortcodes' ),
			'desc' => __( '', 'tmf-shortcodes' )
		),
		'type' => array(
			'default' => 'rating',
			'name' => __( 'Badge Type', 'tmf-shortcodes' ),
			'desc' => __( '', 'tmf-shortcodes' )
		),
		'specialty' => array(
			'default' => '1',
			'name' => __( 'Specialty', 'tmf-shortcodes' ),
			'desc' => __( '', 'tmf-shortcodes' )
		),
	),
	'content' => __( 'Avvo Badge', 'tmf-shortcodes' ),
	'desc' => __( 'This shortcode shows Avvo Badge', 'tmf-shortcodes' ),
);