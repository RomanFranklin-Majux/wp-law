<?php

/********** Shortcode: rss *************************************************************/

$TMF_Shortcodes['rss'] = array(
	'name' => __( 'RSS', 'tmf-shortcodes' ),
	'type' => 'single',
	'group' => 'misc',
	'atts' => array(
		'url' => array(
			'default' => '',
                        'name' => __( 'Url', 'tmf-shortcodes' ),
			'desc' => __('Url', 'tmf-shortcodes')
		),
		'limit' => array(
			'default' => '3',
                        'name' => __( 'Limit', 'tmf-shortcodes' ),
			'desc' => __('Limit', 'tmf-shortcodes')
		),
		'char_limit' => array(
			'default' => '250',
                        'name' => __( 'Char Limit', 'tmf-shortcodes' ),
			'desc' => __('Char Limit', 'tmf-shortcodes')
		),
	),
	'content' => __( 'Rss', 'tmf-shortcodes' ),
	'desc' => __( 'Rss', 'tmf-shortcodes' ),
);