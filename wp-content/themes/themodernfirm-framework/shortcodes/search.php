<?php

/********** Shortcode: search *************************************************************/

$TMF_Shortcodes['search'] = array(
	'name' => __( 'Search', 'tmf-shortcodes' ),
	'type' => 'single',
	'group' => 'misc',
	'atts' => array(
		'placeholder' => array(
			'default' => '',
                        'name' => __( 'Placeholder', 'tmf-shortcodes' ),
			'desc' => __('Placeholder', 'tmf-shortcodes')
		),
	),
	'content' => __( 'Search', 'tmf-shortcodes' ),
	'desc' => __( 'This shortcode shows Search', 'tmf-shortcodes' ),
);