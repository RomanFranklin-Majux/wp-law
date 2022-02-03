<?php

/*********** Shortcode: date ************************************************************/

$TMF_Shortcodes['date'] = array(
	'name' => __( 'Date', 'tmf-shortcodes' ),
	'type' => 'single',
	'group' => 'misc',
	'atts' => array(
		'time' => array(
			'default' => 'now',
			'name' => __( 'Time', 'tmf-shortcodes' ),
			'desc' => __( 'Enter date or day like now, +10 day, -10 day, +1 year, -1 year etc', 'tmf-shortcodes' )
		),
		'format' => array(
			'default' => 'M dS, Y',
			'name' => __( 'Format', 'tmf-shortcodes' ),
			'desc' => __( 'Enter the display format like m-d-Y or M d, Y etc.<br/>M dS, Y - '. date("M dS, Y") . '<br/>Y-m-d - '. date("Y-m-d") . '<br/>m/d/Y - '. date("m/d/Y") . '<br/>d/m/Y - '. date("d/m/Y"), 'tmf-shortcodes' )
		),
	),

	'content' => __( 'Date', 'tmf-shortcodes' ),
	'desc' => __( 'This shortcode shows Date', 'tmf-shortcodes' ),
);