<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-2013 The Modern Firm, LLC
 */
class TMF_Metabox_AttorneySignature extends TMF_Metabox {

	protected $metabox_name		= 'attorney_sign';
	protected $metabox_title	= 'Attorney Signature';

	public function render() {
		?>
			<p class="description" style="margin-top: 10px">
				Image must be in the JPEG or PNG format.
			</p>
			<table class="tmf-metabox">
				<tr>
					<td>
						<div>
							<img id="attorney-sign-preview" class="image-preview" src="<?php echo wp_get_attachment_url($this->post->_attorney_sign) ?>" style="margin: 0 0 20px 0; max-width: 200px; <?php if (!$this->post->_attorney_sign) echo 'display: none; '?>" />
						</div>
						<input id="tmf-metabox-attorney-sign-primary" type="hidden" name="TMF[featured_images][_attorney_sign]" value="<?php echo $this->post->_attorney_sign ?>" />
						<input value="Upload Image" type="button" class="uploader-button button-primary" data-preview="attorney-sign-preview" data-destination="tmf-metabox-attorney-sign-primary" data-panel-title="Upload or Choose an Image" data-button-text="Select Image" data-types="jpg,jpeg,png"/>
						<input value="Remove Image" type="button" class="button uploader-remove remove" data-preview="attorney-sign-preview" data-destination="tmf-metabox-attorney-sign-primary" <?php if (!$this->post->_attorney_sign) echo 'style="display:none"'?> />
					</td>
				</tr>
			</table>

			
		<?php
	}

}