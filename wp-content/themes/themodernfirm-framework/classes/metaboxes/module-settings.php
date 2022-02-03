<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for Module Settings
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_ModuleSettings extends TMF_Metabox {

	protected $metabox_name		= 'module_settings';
	protected $metabox_title	= 'Module Settings';


	public function before_save () {
		global $wpdb;
		$module_area = $this->post_data()->_module_area;

		// Remove any other module that might be linked to the same area
		if (!empty($module_area)):
			$wpdb->query("DELETE FROM $wpdb->postmeta WHERE meta_key ='_module_area' AND meta_value ='$module_area' AND post_id != $this->post_id");
		endif;
	}

	public function render() {
		?>
			<div style="padding-bottom: 5px"></div>
			<?php $this->checkbox('show_module_title', TRUE) ?>
			<?php $this->label('Display Title Above Module', 'show_module_title') ?><br/><br/>

			<?php $this->label('Alternate Title') ?><br/>
			<?php $this->text('alternate_title', 'medium') ?><br/><br/>

			<?php $this->label('Title Link') ?><br/>
			<?php $this->text('title_link', 'medium') ?><br/><br/>
			
			<?php $this->label('Assign To Static Area') ?><br/>
			<?php $this->combobox('module_area', TMF_Module::get_registered_areas('single'), '-- Select a Static Module Area --') ?><br/>
			<br/>

			<?php $this->label('Custom CSS Classes') ?><br/>
			<?php $this->textarea('css_classes', 'small') ?>
		<?php
	}

}
