<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for title settings.
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_TitleSettings extends TMF_Metabox {

	protected $metabox_name		= 'title_settings';
	protected $metabox_title	= 'Title Settings';


	public function render() {
		?>
			<div style="padding-bottom: 5px"></div>
			<?php $this->checkbox('show_title', TRUE) ?>
			<?php $this->label('Display Title On Page', 'show_title') ?><br/><br/>

			<?php $this->label('Alternate Title') ?><br/>
			<?php $this->text('alternate_title', 'medium') ?><br/><br/>
		<?php
	}

}
