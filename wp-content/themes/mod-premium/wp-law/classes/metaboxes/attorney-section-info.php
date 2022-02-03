<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for names
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-2020 The Modern Firm, LLC
 */
class TMF_Metabox_AttorneySectionInfo extends TMF_Metabox {

	protected $metabox_name		= 'attorney_section_info';
	protected $metabox_title	= 'Attorney Section Info';

	public function render() {

		?>
			<table class="tmf-metabox">
				<tr>
					<td style="vertical-align: top;"><?php $this->label('Meet Title') ?></td>
					<td><?php $this->text('meet_title', 'large') ?></td>
				</tr>
				<tr>
					<td style="vertical-align: top;"><?php $this->label('Top Rated Title') ?></td>
					<td><?php $this->text('top_rated_title', 'large') ?></td>
				</tr>
				<tr>
					<td style="vertical-align: top;"><?php $this->label('Sub Title') ?></td>
					<td><?php $this->text('sub_title', 'large') ?></td>
				</tr>
				<tr>
					<td style="vertical-align: top;"><?php $this->label('Home Content') ?></td>
					<td>
						<?php wp_editor(htmlspecialchars_decode($this->post->_home_content), 'tmf-metabox-home-content', array('textarea_name' => 'TMF[attorney_section_info][_home_content]', 'textarea_rows' => 10)); ?>            
					</td>
				</tr>
				<tr>
					<td style="vertical-align: top;"><?php $this->label('Attorney Top Content') ?></td>
					<td>
						<?php wp_editor(htmlspecialchars_decode($this->post->_attorney_top_content), 'tmf-metabox-attorney-top-content', array('textarea_name' => 'TMF[attorney_section_info][_attorney_top_content]', 'textarea_rows' => 10)); ?>            
					</td>
				</tr>
				<tr>
					<td style="vertical-align: top;"><?php $this->label('Did You Know Title') ?></td>
					<td><?php $this->text('did_you_know_title', 'large') ?></td>
				</tr>
				<tr>
					<td style="vertical-align: top;"><?php $this->label('Did You Know Content') ?></td>
					<td>
						<?php wp_editor(htmlspecialchars_decode($this->post->_did_you_know_content), 'tmf-metabox-did-you-know-content', array('textarea_name' => 'TMF[attorney_section_info][_did_you_know_content]', 'textarea_rows' => 10)); ?>            
					</td>
				</tr>
				<tr>
					<td style="vertical-align: top;"><?php $this->label('Bar and Admissions Title') ?></td>
					<td><?php $this->text('bar_admission_title', 'large') ?></td>
				</tr>
				<tr>
					<td style="vertical-align: top;"><?php $this->label('Bar and Admissions Content') ?></td>
					<td>
						<?php wp_editor(htmlspecialchars_decode($this->post->_bar_admission_content), 'tmf-metabox-bar-admission-content', array('textarea_name' => 'TMF[attorney_section_info][_bar_admission_content]', 'textarea_rows' => 10)); ?>            
					</td>
				</tr>
			</table>
		<?php
	}

}