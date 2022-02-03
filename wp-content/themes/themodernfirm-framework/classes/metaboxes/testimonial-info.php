<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for testimonial author info
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_TestimonialInfo extends TMF_Metabox {

	protected $metabox_name		= 'testimonial_info';
	protected $metabox_title	= 'Author Information';

	public function render() {
		?>
			<table class="tmf-metabox">
				<tbody>
					<tr>
						<td><?php $this->label('Author Name') ?></td>
						<td><?php $this->text('author_name', 'medium') ?></td>
					</tr>
					<tr>
						<td><?php $this->label('Description 1') ?></td>
						<td><?php $this->text('description_1', 'medium') ?></td>
					</tr>
					<tr>
						<td><?php $this->label('Description 2') ?></td>
						<td><?php $this->text('description_2', 'medium') ?></td>
					</tr>
				</tbody>
			</table>
		<?php
	}

}
