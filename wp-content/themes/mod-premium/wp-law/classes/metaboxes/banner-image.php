<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for Banner Image
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_BannerImage extends TMF_Metabox {

	protected $metabox_name		= 'banner_image';
	protected $metabox_title	= 'Banner Image';

	public function render() {
		?>
			<p class="description" style="margin-top: 10px">
				Banner Images must be in the JPEG format.
			</p>
			<h4 class="title">Desktop Banner Image</h4>
			<table class="tmf-metabox">
				<tr>
					<td>
						<div>
							<img id="banner-preview" class="image-preview" src="<?php echo wp_get_attachment_url($this->post->_banner_image) ?>" style="margin: 0 0 20px 0; max-width: 200px; <?php if (!$this->post->_banner_image) echo 'display: none; '?>" />
						</div>
						<input id="tmf-metabox-banner-image-primary" type="hidden" name="TMF[featured_images][_banner_image]" value="<?php echo $this->post->_banner_image ?>" />
						<input value="Upload Image" type="button" class="uploader-button button-primary" data-preview="banner-preview" data-destination="tmf-metabox-banner-image-primary" data-panel-title="Upload or Choose an Image" data-button-text="Select Image" data-types="jpg,jpeg"/>
						<input value="Remove Image" type="button" class="button uploader-remove remove" data-preview="banner-preview" data-destination="tmf-metabox-banner-image-primary" <?php if (!$this->post->_banner_image) echo 'style="display:none"'?> />
					</td>
				</tr>
			</table>

			<h4 class="title">Mobile Banner Image</h4>
			<table class="tmf-metabox">
				<tr>
					<td>
						<div>
							<img id="mobile-banner-preview" class="image-preview" src="<?php echo wp_get_attachment_url($this->post->_mobile_banner_image) ?>" style="margin: 0 0 20px 0; max-width: 200px; <?php if (!$this->post->_mobile_banner_image) echo 'display: none; '?>" />
						</div>
						<input id="tmf-metabox-mobile-banner-image-primary" type="hidden" name="TMF[featured_images][_mobile_banner_image]" value="<?php echo $this->post->_mobile_banner_image ?>" />
						<input value="Upload Image" type="button" class="uploader-button button-primary" data-preview="mobile-banner-preview" data-destination="tmf-metabox-mobile-banner-image-primary" data-panel-title="Upload or Choose an Image" data-button-text="Select Image" data-types="jpg,jpeg"/>
						<input value="Remove Image" type="button" class="button uploader-remove remove" data-preview="mobile-banner-preview" data-destination="tmf-metabox-mobile-banner-image-primary" <?php if (!$this->post->_mobile_banner_image) echo 'style="display:none"'?> />
					</td>
				</tr>
			</table>

			
		<?php
	}

}
