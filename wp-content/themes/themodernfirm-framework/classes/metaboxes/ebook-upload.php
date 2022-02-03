<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for Ebook Upload
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_EbookUpload extends TMF_Metabox {

	protected $metabox_name		= 'ebook_upload';
	protected $metabox_title	= 'eBook Upload';

	public function render() {
		?>

			<table class="tmf-metabox">
				<tr>
					<td>
						<div>
							<embed id="ebook-preview" class="image-preview" src="<?php echo wp_get_attachment_url($this->post->_ebook) ?>" style="margin: 0 0 20px 0; <?php if (!$this->post->_ebook) echo 'display: none; '?>" />
						</div>
						<input id="tmf-metabox-ebook-ebook" type="hidden" name="TMF[ebook_upload][_ebook]" value="<?php echo $this->post->_ebook ?>" />
						<input value="Upload eBook" type="button" class="uploader-button button-primary" data-preview="ebook-preview" data-destination="tmf-metabox-ebook-ebook" data-panel-title="Upload or Choose an eBook" data-button-text="Select eBook" data-types="pdf"/>
						<input value="Remove eBook" type="button" class="button uploader-remove remove" data-preview="ebook-preview" data-destination="tmf-metabox-ebook-ebook" <?php if (!$this->post->_ebook) echo 'style="display:none"'?> />
					</td>
				</tr>
			</table>

		<?php
	}

}
