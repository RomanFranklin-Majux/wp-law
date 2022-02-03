<?php

/********** Shortcode: Module *************************************************************/

function tmf_shortcode_get_all_modules($args) {
		$array = array();
		$posts = get_posts($args);
		if(!empty($posts)):
			$i = 0;
			foreach ($posts as $post) {
				if($i == 0):
					$array['none'] = 'None';
					$array[$post->ID] = $post->post_title;
				else:
					$array[$post->ID] = $post->post_title;
				endif;
			}
			$i++;
		else:
			$array['none'] = 'Nothing Found';
		endif;
		return $array;
	}

$TMF_Shortcodes['module'] = array(
	'name' => __( 'Module', 'tmf-shortcodes' ),
	'type' => 'single',
	'group' => 'misc',
	'post_type'	=> 'module',
	'atts' => array(
		'id' => array(
			'default' => '',
			'type' => 'select',
            'name' => __( 'Module ID', 'tmf-shortcodes' ),
			'desc' => __('Module ID', 'tmf-shortcodes'),
			'values' => tmf_shortcode_get_all_modules(array('post_type' => 'module', 'numberposts' => '-1'))
		),
	),
	'content' => __( 'Module', 'tmf-shortcodes' ),
	'desc' => __( 'Module', 'tmf-shortcodes' ),
);