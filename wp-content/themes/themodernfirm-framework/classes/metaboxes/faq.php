<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for FAQ
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_Faq extends TMF_Metabox {

	protected $metabox_name		= 'faq';
	protected $metabox_title	= 'Frequently Asked Question';

	public function render() {

		?>
			<table class="tmf-metabox">
				<tr>
					<td style="vertical-align: top;"><?php $this->label('Question') ?></td>
					<td><?php $this->textarea('question', 'small') ?></td>
				</tr>
				<tr>
					<td style="vertical-align: top;"><?php $this->label('Answer') ?></td>
					<td>
						<?php wp_editor(htmlspecialchars_decode($this->post->_answer), 'tmf-metabox-faq-answer', array('textarea_name' => 'TMF[faq][_answer]', 'textarea_rows' => 10)); ?>            
					</td>
				</tr>
			</table>
		<?php
	}

}
