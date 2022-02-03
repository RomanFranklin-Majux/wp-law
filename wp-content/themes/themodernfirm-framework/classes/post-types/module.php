<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Custom post type for modules.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_PostType_Module extends TMF_PostType{


	protected $post_type = 'module';
  
  
	public $options	= array(
		'slug'						=> 'modules',
		'singular'					=> 'module',
		'plural'					=> 'modules',
		'menu_name'					=> 'Modules',
		'description'				=> 'Create and manage modules.',
		'hide_post_status'			=> TRUE,
		'bulk_actions'				=> TRUE,
		'has_archive'				=> FALSE,
		'public'					=> FALSE,
		'show_in_nav_menus'			=> FALSE,
		'publicly_queryable'		=> FALSE,
		'has_seo'					=> FALSE,
		'show_thumbnail_in_table'	=> FALSE,
		'has_shortcode'				=> FALSE,
		'menu_icon'					=> 'dashicons-screenoptions'
	);

	public $columns = array(
		'static_area'		=> 'Static Area',
		'multi_areas'		=> 'Multi Areas',
		'display_rules'		=> 'Display Rules'
	);


	public $metaboxes = array(
		'display-rules'		=> array('priority' => 'high'),
		'module-settings'	=> array('context' => 'side')
	);


	public $admin_panels = array(
		'module-areas'
	);

	public function column_static_area ($query) {  
		global $post;

		$areas = TMF_Module::get_registered_areas('single');

		if (!empty($areas[$post->tmf->module_area]))
			return $areas[$post->tmf->module_area];
	} 

	public function column_multi_areas ($query) {
		global $tmf, $post;
		$build = array();

		foreach (TMF_Module::get_registered_areas(FALSE) as $slug => $title):
			$get_options = $tmf->option()->{'module_area_' . TMF_Text::underscores($slug)};

			if (!empty($get_options)):
				foreach ($get_options as $module_for_area):
					if ($module_for_area == $post->ID)
						$build[] = $title;
				endforeach;
			endif;
		endforeach;

		return implode(', ', $build);
	}

	public function column_display_rules ($query) {  
		global $post;

		if (!empty($post->tmf->display_rules[0]))
			return '<div class="dashicons dashicons-yes" style="color: green; font-size: 30px"></div>';
		else
			return '<div class="dashicons dashicons-minus" style="color: #ccc; font-size: 24px"></div>';

	} 

}
