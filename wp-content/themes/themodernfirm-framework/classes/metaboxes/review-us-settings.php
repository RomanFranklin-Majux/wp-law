<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for Review Us Settings
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_ReviewUsSettings extends TMF_Metabox {

	protected $metabox_name		= 'review_us_settings';
	protected $metabox_title	= 'Review Us Settings';


	public function before_save () {
		global $wpdb;
		$reivew_us_link_icon = $this->post_data()->_reivew_us_link_icon;
	}

	public function render() {
		$link_types = array(
			'avvo'			=>	"Avvo",
			'yelp'			=>	"Yelp",
			'facebook'		=>	"Facebook",
			'linkedin'		=>	"Linked In"
			);
		?>
			<div style="padding-bottom: 5px"></div>
			<?php $this->checkbox('show_review_us_title', TRUE) ?>
			<?php $this->label('Display Title', 'show_review_us_title') ?><br/><br/>

			<?php $this->label('Alternate Title') ?><br/>
			<?php $this->text('alternate_title', 'medium') ?><br/><br/>

			<?php $this->label('Link Icon') ?><br/>
			<?php $this->combobox('reivew_us_link_icon', $link_types, '-- Select a Link Type --') ?><br/>
		<?php
	}

}
