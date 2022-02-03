<?php

/********** Shortcode: author *************************************************************/

$TMF_Shortcodes['author'] = array(
	'name' => __( 'Author', 'tmf-shortcodes' ),
	'type' => 'single',
	'group' => 'misc',
        'atts' => array(
		'template' => array(
			'default' => '',
                        'name' => __( 'Template', 'tmf-shortcodes' ),
			'desc' => __( 'Template', 'tmf-shortcodes' )
		),
	),
	'content' => __( 'Author', 'tmf-shortcodes' ),
	'desc' => __( 'This shortcode shows Author', 'tmf-shortcodes' ),
);