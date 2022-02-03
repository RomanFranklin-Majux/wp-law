<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for Resume
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_Resume extends TMF_Metabox {

	protected $metabox_name		= 'resume';
	protected $metabox_title	= 'Resume';

	public function render() {
		?>

			<table class="tmf-metabox">
				<tr>
					<td>
						<div>
							<embed id="resume-preview" class="image-preview" src="<?php echo wp_get_attachment_url($this->post->_resume) ?>" style="margin: 0 0 20px 0; <?php if (!$this->post->_resume) echo 'display: none; '?>" />
						</div>
						<input id="tmf-metabox-resume-resume" type="hidden" name="TMF[resume][_resume]" value="<?php echo $this->post->_resume ?>" />
						<input value="Upload Resume" type="button" class="uploader-button button-primary" data-preview="resume-preview" data-destination="tmf-metabox-resume-resume" data-panel-title="Upload or Choose an Resume" data-button-text="Select Resume" data-types="pdf"/>
						<input value="Remove Resume" type="button" class="button uploader-remove remove" data-preview="resume-preview" data-destination="tmf-metabox-resume-resume" <?php if (!$this->post->_resume) echo 'style="display:none"'?> />
					</td>
				</tr>
			</table>

		<?php
	}

}
