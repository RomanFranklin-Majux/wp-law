<?php

/********** Shortcode: Article *************************************************************/

$TMF_Shortcodes['articles'] = array(
	'name' => __( 'Articles', 'tmf-shortcodes' ),
	'type' => 'single',
	'group' => 'content',
	'post_type'	=> 'article',
	'atts' => array(
		'taxonomy' => array(
			'default' => 'article-categories',
			'name' => __( 'Taxonomy', 'tmf-shortcodes' ),
			'desc' => __( 'Post type taxonomy', 'tmf-shortcodes' )
		),
		'terms' => array(
			'default' => '',
			'name' => __( 'Terms', 'tmf-shortcodes' ),
			'desc' => __( 'Comma separated list of terms', 'tmf-shortcodes' )
		),
		'template' => array(
			'default' => 'small', 'name' => __( 'Template', 'tmf-shortcodes' ),
			'desc' => __( '<b>Do not change this field value if you do not understand description below.</b><br/>Relative path to the template file. Default templates is placed under the plugin directory (templates folder). You can copy it under your theme directory and modify as you want. You can use following default templates that already available in the plugin directory:<br/><b%value>templates/default-loop</b> - posts loop<br/><b%value>templates/teaser-loop</b> - posts loop with thumbnail and title<br/><b%value>templates/single-post</b> - single post template<br/><b%value>templates/list-loop</b> - unordered list with posts titles', 'tmf-shortcodes' )
		),
		'include' => array(
			'default' => '',
			'name' => __( 'Include', 'tmf-shortcodes' ),
			'desc' => __( 'Enter comma separated ID\'s of the posts that you want to show', 'tmf-shortcodes' )
		),
		'field' => array(
			'default' => '',
			'name' => __( 'Field', 'tmf-shortcodes' ),
			'desc' => __( 'Return single field', 'tmf-shortcodes' )
		),
		'limit' => array(
			'type' => 'number',
			'min' => -1,
			'max' => 10000,
			'step' => 1,
			'default' => get_option( 'posts_per_page' ),
			'name' => __( 'Number of Posts', 'tmf-shortcodes' ),
			'desc' => __( 'Specify number of posts that you want to show. Enter -1 to get all posts', 'tmf-shortcodes' )
		),
		'random' => array(
			'type' => 'select',
			'values' => array(
				'0' => __( 'No', 'tmf-shortcodes' ),
				'1' => __( 'Yes', 'tmf-shortcodes' )
				),
			'name' => __( 'Random', 'tmf-shortcodes' ),
			'desc' => __( '', 'tmf-shortcodes' )
		),
		'meta_key' => array(
			'default' => '',
			'name' => __( 'Meta key', 'tmf-shortcodes' ),
			'desc' => __( 'Enter meta key name to show posts that have this key', 'tmf-shortcodes' )
		),
		'offset' => array(
			'type' => 'number',
			'min' => 0,
			'max' => 10000,
			'step' => 1, 'default' => 0,
			'name' => __( 'Offset', 'tmf-shortcodes' ),
			'desc' => __( 'Specify offset to start posts loop not from first post', 'tmf-shortcodes' )
		),
		'order' => array(
			'type' => 'select',
			'values' => array(
				'desc' => __( 'Descending', 'tmf-shortcodes' ),
				'asc' => __( 'Ascending', 'tmf-shortcodes' )
				),
			'default' => 'DESC',
			'name' => __( 'Order', 'tmf-shortcodes' ),
			'desc' => __( 'Posts order', 'tmf-shortcodes' )
		),
		'orderby' => array(
			'type' => 'select',
			'values' => array(
				'none' => __( 'None', 'tmf-shortcodes' ),
				'id' => __( 'Post ID', 'tmf-shortcodes' ),
				'author' => __( 'Post author', 'tmf-shortcodes' ),
				'title' => __( 'Post title', 'tmf-shortcodes' ),
				'name' => __( 'Post slug', 'tmf-shortcodes' ),
				'date' => __( 'Date', 'tmf-shortcodes' ), 'modified' => __( 'Last modified date', 'tmf-shortcodes' ),
				'parent' => __( 'Post parent', 'tmf-shortcodes' ),
				'rand' => __( 'Random', 'tmf-shortcodes' ), 'comment_count' => __( 'Comments number', 'tmf-shortcodes' ),
				'menu_order' => __( 'Menu order', 'tmf-shortcodes' ), 'meta_value' => __( 'Meta key values', 'tmf-shortcodes' ),
				),
			'default' => 'date',
			'name' => __( 'Order by', 'tmf-shortcodes' ),
			'desc' => __( 'Order posts by', 'tmf-shortcodes' )
		),
		'exclude' => array(
			'default' => '',
			'name' => __( 'Exclude', 'tmf-shortcodes' ),
			'desc' => __( 'Enter comma separated ID\'s of the posts that you don\'t want to show', 'tmf-shortcodes' )
		),
	),

	'content' => __( 'Articles', 'tmf-shortcodes' ),
	'desc' => __( 'Articles Post Type', 'tmf-shortcodes' ),
);