<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a print settings menu in the admin backend
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_AdminPanel_PrintSettings extends TMF_AdminPanel {

	protected $name				= 'Print Settings';
	protected $menu_title		= 'Print';
	protected $parent_slug		= 'tmf-general-settings';


	public function render() {
		global $tmf_option;
	?>
		<br/>
		<table class="form-table">

			<tr valign="top">
				<th scope="row">
					Print Logo
				</th>
				<td>
					<div>
						<img id="print-logo-preview" src="<?php echo wp_get_attachment_url($tmf_option->print_logo) ?>" style="margin: 0 0 20px 0; <?php if (!$tmf_option->print_logo) echo 'display: none; '?>" />
					</div>
					<input id="tmf-print-settings-print-logo" type="hidden" name="TMF[print_settings][tmf_print_logo]" value="<?php echo $tmf_option->print_logo ?>" />
					<input value="Upload Print Logo" type="button" class="uploader-button button-primary" data-preview="print-logo-preview" data-destination="tmf-print-settings-print-logo" data-panel-title="Upload or Choose a Logo" data-types="png,jpg,jpeg" data-button-text="Select Logo"/ >
					<input value="Remove Logo" type="button" class="button uploader-remove remove" data-preview="print-logo-preview" data-destination="tmf-print-settings-print-logo" <?php if (!$tmf_option->print_logo) echo 'style="display:none"'?> />
					<p class="description">The logo that will appear on all printed pages.</p>
				</td>
			</tr>

			<tr>
				<th>Print Header</th>
				<td>
					<?php wp_editor(stripslashes($tmf_option->print_header), 'tmf-print-settings-options-print-header', array('textarea_name' => 'TMF[print_settings][tmf_print_header]', 'textarea_rows' => 10)); ?>
					<p class="description">The content that will appear at the top of all printed pages.</p>
				</td>
			</tr>

			<tr>
				<th>Print Footer</th>
				<td>
					<?php wp_editor(stripslashes($tmf_option->print_footer), 'tmf-print-settings-options-print-footer', array('textarea_name' => 'TMF[print_settings][tmf_print_footer]', 'textarea_rows' => 10)); ?>
					<p class="description">The content that will appear at the bottom of all printed pages.</p>
				</td>
			</tr>
		</table>
	<?php
	}

}
