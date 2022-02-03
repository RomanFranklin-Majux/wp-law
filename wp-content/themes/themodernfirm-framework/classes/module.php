<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Module {


	private $module_area_name;


	private $module_area_type;


	private $show_missing_warnings;


	private $module_id;


	private static $registered_multi_module_areas = array(
		'page-sidebar'	=> 'Page Sidebar',
		'home-sidebar'	=> 'Home Sidebar',
		'blog-sidebar'	=> 'Blog Sidebar',
		'contact-sidebar'	=> 'Contact Sidebar'
	);


	private static $registered_single_module_areas = array(
		'header'		=> 'Header',
		'billboard'		=> 'Billboard',
		'footer-1'		=> 'Footer 1',
		'footer-2'		=> 'Footer 2',
		'footer-3'		=> 'Footer 3',
		'copyright'		=> 'Copyright'
	);


	public static function get_registered_areas ($single = TRUE) {
		if ($single == TRUE)
			return self::$registered_single_module_areas;
		else
			return self::$registered_multi_module_areas;
	}


	public static function register_area ($slug, $title = NULL, $single = TRUE) {
		if (is_array($slug)):
			if ($single == TRUE)
				self::$registered_single_module_areas = array_merge(self::$registered_module_area, $area);
			else
				self::$registered_multi_module_areas = array_merge(self::$registered_module_area, $area);
		else:
			if ($single == TRUE)
				self::$registered_single_module_areas[$slug] = $title;
			else
				self::$registered_multi_module_areas[$slug] = $title;
		endif;
	}


	public static function unregister_area ($slug, $single = TRUE) {
		if ($single == TRUE)
			unset(self::$registered_single_module_areas[$slug]);
		else
			unset(self::$registered_multi_module_areas[$slug]);
	} 


	public function __construct ($module_area = NULL, $single = TRUE) {

		if (is_numeric($module_area)):
			$this->module_id = $module_area;
			$this->module_area_type = 'id';
		else:
			$this->module_area_name = $module_area;
		endif;


		// only display missing warnings if its a single area or if its a multi area in a dev environment
		$this->show_missing_warnings = ($single == TRUE || ($single == FALSE && TMF_ENVIRONMENT == 'development')) ? TRUE : FALSE;
	}


	public function single () {
		$this->module_area_type = 'single';

		return $this;
	}


	public function multi () {
		$this->module_area_type = 'multi';

		return $this;
	}


	public function id ($id) {
		$this->module_area_type = 'id';
		$this->module_id = $id;
		return $this;
	}


	public static function factory ($module_area = NULL, $single = TRUE) {
		return new TMF_Module($module_area, $single);
	}


	public function render () {
		// If the requested area has not been registered, throw warning

		if (empty($this->module_id)):
			if (!empty($this->module_area_type)):
				$prop_name = 'registered_'. $this->module_area_type .'_module_areas';
				$registered_areas = self::$$prop_name;

				if (empty($registered_areas[$this->module_area_name])):
					$this->area_not_registered();
					return;
				endif;
			else:
				if (!empty(self::$registered_single_module_areas[$this->module_area_name])):
					$this->module_area_type = 'single';
				elseif (!empty(self::$registered_multi_module_areas[$this->module_area_name])):
					$this->module_area_type = 'multi';
				endif;

				if (empty($this->module_area_type)):
					$this->area_not_registered();
					return;
				endif;
			endif;
		endif;
		// Call the corresponding renderer for the requested area
		$this->{$this->module_area_type . '_render'}();
	}


	private function filter_modules ($modules) {
		if (is_array($modules) && !empty($modules)):
			foreach ($modules as $key => $module):
				$mode = $module->tmf->display_rules_mode;

				// hide mode
				if ($mode == 'hide' && $this->has_rule_match($module) == TRUE):
					unset($modules[$key]);

				// show mode
				elseif ($mode == 'show' && $this->has_rule_match($module) == FALSE):
					unset($modules[$key]);

				endif;

			endforeach;
		endif;

		return $modules;
	}


	private function has_rule_match ($module) {
		global $wp;
		$current_url = $wp->request;
		$rules	= $module->tmf->display_rules;

		if (!empty($rules)):
			foreach ($rules as $rule):
				$rule = strtolower(trim($rule, '/'));
				$decendant = TMF_Text::ends_with($rule, '{descendants}');

				if (!empty($rule)):

					// if rule is homepage
					if ($current_url == '' && $rule == '{home}')
						return TRUE;

					// if rule is a decendant
					if ($decendant == TRUE):
						$rule = str_replace('/{descendants}', '', $rule);

						if (TMF_Text::starts_with($current_url, $rule) && $current_url != $rule):
							return TRUE;
						endif;

					// needs to be an exact match
					else:
						if ($current_url == $rule):
							return TRUE;
						endif;
					endif;

				endif;

			endforeach;
		endif;

		return FALSE;
	}


	private function id_render () {
		$modules = get_posts(array('post_type' => 'module', 'numberposts' => 1, 'p' => $this->module_id, 'suppress_filters' => FALSE));

		if (empty($modules) && $this->show_missing_warnings):
			$this->module_not_found();
			return;
		endif;

		$modules = $this->filter_modules($modules);

		if (!empty($modules)):

			echo '<div class="tmf-module-area tmf-single-module-area tmf-module-area-'. $this->module_area_name .'">';

			$this->builder($modules[0]);

			echo '</div>';

		endif;
	}	

	private function single_render () {
		$modules = get_posts(array('post_type' => 'module', 'numberposts' => 1, 'meta_key' => '_module_area', 'meta_value' => $this->module_area_name, 'suppress_filters' => FALSE));

		if (empty($modules) && $this->show_missing_warnings):
			$this->module_not_found();
			return;
		endif;

		$modules = $this->filter_modules($modules);

		if (!empty($modules)):

			echo '<div class="tmf-module-area tmf-single-module-area tmf-module-area-'. $this->module_area_name .'">';

			$this->builder($modules[0]);

			echo '</div>';

		endif;
	}	


	private function multi_render () {
		global $tmf_option;

		if ($area_modules = $tmf_option->{'module_area_' . str_replace('-', '_', $this->module_area_name)}):
			
			$area_modules = implode(',', $area_modules);

			$modules = get_posts(array('post_type' => 'module', 'suppress_filters' => FALSE, 'numberposts' => -1, 'orderby' => 'post__in', 'post__in' => explode(',', $area_modules)));

			if (empty($modules) && $this->show_missing_warnings):
				$this->module_not_found();
				return;
			endif;

			$modules = $this->filter_modules($modules);

			if (!empty($modules)):

				echo '<div class="tmf-module-area tmf-multi-module-area tmf-module-area-'. $this->module_area_name .'">';

				foreach ($modules as $module):
					$this->builder($module);
				endforeach;

				echo '</div>';

			endif;

		endif;
	}

	private function builder ($module) {
		?>
			<div class="<?php self::generate_module_css_classes($module) ?>">
				<?php if (isset($module->_show_module_title) && $module->_show_module_title == 'true'): ?>
					<h3 class="tmf-module-title">
						<?php if (isset($module->_title_link)): ?>
							<a href="<?php echo $module->_title_link ?>" />
						<?php endif ?>

							<?php echo (isset($module->_alternate_title)) ? $module->_alternate_title : $module->post_title ?>

						<?php if (isset($module->_title_link)): ?>
							</a>
						<?php endif ?>
					</h3>
				<?php endif ?>
				<div class="tmf-module-content editor-content">
					<?php echo $module->tmf->content ?>
				</div>
			</div>
		<?php
	}

	private function module_not_found () {
		?>
			<div class="missing-module tmf-warning">
				No modules are set for the '<?php echo $this->module_area_name ?>' area.
			</div>
		<?php
	}

	private function area_not_registered () {
		?>
			<div class="missing-module-area tmf-warning">
				No module areas have been registered with the id of '<?php echo $this->module_area_name ?>'.
			</div>
		<?php
	}	


	public static function has_modules ($module, $multi_module = FALSE) {
		global $tmf_option;

		if($multi_module):
			if ($area_modules = $tmf_option->{'module_area_' . str_replace('-', '_', $module)}):
				
				$area_modules = implode(',', $area_modules);

				$modules = get_posts(array('post_type' => 'module', 'suppress_filters' => FALSE, 'numberposts' => -1, 'orderby' => 'post__in', 'post__in' => explode(',', $area_modules)));

				if (!empty($modules)):
					return true;
				endif;

			endif;
		else:
			$modules = get_posts(array('post_type' => 'module', 'numberposts' => 1, 'meta_key' => '_module_area', 'meta_value' => $module, 'suppress_filters' => FALSE));

			if (!empty($modules)):
				return true;
			endif;
		endif;

		return false;
	}

	public static function generate_module_css_classes ($module) {
		$classes = array('tmf-module');
		$classes[] = 'tmf-module-' . $module->ID;

		// add title to css classes
		if (isset($module->_alternate_title))
			$classes[] = 'tmf-module-' . str_replace(' ', '-', trim(strtolower($module->_alternate_title)));
		else
			$classes[] = 'tmf-module-' . str_replace(' ', '-', trim(strtolower($module->post_title)));

		if (isset($module->_css_classes)) 
			$classes[] = $module->_css_classes;


		echo implode(' ', $classes);
	}
}
