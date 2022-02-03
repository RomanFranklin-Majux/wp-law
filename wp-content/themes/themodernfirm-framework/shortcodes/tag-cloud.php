<?php

/********** Shortcode: tag-cloud *************************************************************/

$TMF_Shortcodes['tag-cloud'] = array(
	'name' => __( 'Tag Cloud', 'tmf-shortcodes' ),
	'type' => 'single',
	'group' => 'tags',
	'atts' => array(
		'taxonomy' => array(
                    'name' => __( 'Taxonomy', 'tmf-shortcodes' ),
                    'desc' => __('Taxonomy', 'tmf-shortcodes'),
		),
	),
	'content' => __( 'Tag Cloud', 'tmf-shortcodes' ),
	'desc' => __( 'This shortcode shows tag cloud', 'tmf-shortcodes' ),
);