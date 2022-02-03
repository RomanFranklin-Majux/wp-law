<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for Testimonial Settings
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_TestimonialSettings extends TMF_Metabox {

	protected $metabox_name		= 'testimonial-settings';
	protected $metabox_title	= 'Testimonial Settings';

	public function render() {
		global $wp_option;
		?>
			<div style="padding-bottom: 5px"></div>
			<?php $this->checkbox('show_title', TRUE) ?>
			<?php $this->label('Display Title On Testimonial Page', 'show_title') ?><br/><br/>

			<?php $this->label('Alternate Title') ?><br/>
			<?php $this->text('alternate_title', 'medium') ?>

		<?php
	}

}
