<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for Modern Slider Shortcode
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_ModernSliderShortcode extends TMF_Metabox {

	protected $metabox_name		= 'modern_slider_shortcode';
	protected $metabox_title	= 'Shortcode';

	public function render() {
		global $post;
		?>
		<div class="modernslider-field last">
			<label for="modernslider_get_shortcode">Your Shortcode: </label>
			<input readonly="true" id="modernslider_get_shortcode" type="text" class="widefat" name="" value="[modernslider id=&quot;<?php echo $post->ID ?>&quot;]">
			<span class="note">Copy and paste this shortcode into your Post, Page or Custom Post editor.</span>
			<div class="clear"></div>
		</div>
		<?php
	}

}
