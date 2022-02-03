<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for names
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-2020 The Modern Firm, LLC
 */
class TMF_Metabox_ShowcaseFaq extends TMF_Metabox {

	protected $metabox_name		= 'question';
	protected $metabox_title	= 'Question And Answer';

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
						<?php wp_editor(htmlspecialchars_decode($this->post->_answer), 'tmf-metabox-question-answer', array('textarea_name' => 'TMF[question][_answer]', 'textarea_rows' => 10)); ?>            
					</td>
				</tr>
				<tr>
					<td style="vertical-align: top;"><?php $this->label('Button Text') ?></td>
					<td><?php $this->text('shocase_faq_bt_text', 'large') ?></td>
				</tr>
				<tr>
					<td style="vertical-align: top;"><?php $this->label('Button Link') ?></td>
					<td><?php $this->text('shocase_faq_bt_link', 'large') ?></td>
				</tr>
			</table>
		<?php
	}

}