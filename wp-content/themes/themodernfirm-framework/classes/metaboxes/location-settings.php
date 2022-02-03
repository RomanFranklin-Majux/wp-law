<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for location RSVP options
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_LocationSettings extends TMF_Metabox {

	protected $metabox_name		= 'location-settings';
	protected $metabox_title	= 'Location Settings';

	public function render() {
		global $wp_option;
		?>
			<div style="padding-bottom: 5px"></div>
			<?php $this->checkbox('show_title', TRUE) ?>
			<?php $this->label('Display Title On Location Page', 'show_title') ?><br/><br/>

			<?php $this->label('Alternate Title') ?><br/>
			<?php $this->text('alternate_title', 'medium') ?>

		<?php
	}

}
