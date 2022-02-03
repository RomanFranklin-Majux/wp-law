<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for quotes
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_QuoteInformation extends TMF_Metabox {

	protected $metabox_name		= 'quote_information';
	protected $metabox_title	= 'Quote Information';

	public function render() {

		?>
			<table class="tmf-metabox">
				<tr>
					<td><?php $this->label('Quote Author') ?></td>
					<td><?php $this->text('quote_author', 'medium') ?></td>
				</tr>
				<tr>
					<td style="vertical-align:top;"><?php $this->label('Quote Text') ?></td>
					<td><?php $this->textarea('quote_text', 'large') ?></td>
				</tr>
			</table>
		<?php
	}

}
