<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-2013 The Modern Firm, LLC
 */
class TMF_Metabox_HomeImage extends TMF_Metabox {

	protected $metabox_name		= 'home_image';
	protected $metabox_title	= 'Home Image';

	public function render() {
		?>
			<p class="description" style="margin-top: 10px">
				Image must be in the JPEG or PNG format.
			</p>
			<table class="tmf-metabox">
				<tr>
					<td>
						<div>
							<img id="home-image-preview" class="image-preview" src="<?php echo wp_get_attachment_url($this->post->_home_image) ?>" style="margin: 0 0 20px 0; max-width: 200px; <?php if (!$this->post->_home_image) echo 'display: none; '?>" />
						</div>
						<input id="tmf-metabox-home-image-image-primary" type="hidden" name="TMF[featured_images][_home_image]" value="<?php echo $this->post->_home_image ?>" />
						<input value="Upload Image" type="button" class="uploader-button button-primary" data-preview="home-image-preview" data-destination="tmf-metabox-home-image-image-primary" data-panel-title="Upload or Choose an Image" data-button-text="Select Image" data-types="jpg,jpeg,png"/>
						<input value="Remove Image" type="button" class="button uploader-remove remove" data-preview="home-image-preview" data-destination="tmf-metabox-home-image-image-primary" <?php if (!$this->post->_home_image) echo 'style="display:none"'?> />
					</td>
				</tr>
			</table>

			
		<?php
	}

}