<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for names
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_FullName extends TMF_Metabox {

	protected $metabox_name		= 'full_name';
	protected $metabox_title	= 'Full Name';

	public function render() {

		$locked = ($this->post->_display_name) ? ' locked' : '';
		?>
			<table class="tmf-metabox">
				<tr>
					<td><?php $this->label('Prefix') ?></td>
					<td><?php $this->text('prefix', 'tiny name-field') ?></td>
				</tr>
				<tr>
					<td><?php $this->label('First Name') ?></td>
					<td><?php $this->text('first_name', 'small name-field') ?></td>
				</tr>
				<tr>
					<td><?php $this->label('Middle Name') ?></td>
					<td><?php $this->text('middle_name', 'small name-field') ?></td>
				</tr>
				<tr>
					<td><?php $this->label('Last Name') ?></td>
					<td><?php $this->text('last_name', 'small name-field') ?></td>
				</tr>
				<tr>
					<td><?php $this->label('Suffix') ?></td>
					<td><?php $this->text('suffix', 'tiny name-field') ?></td>
				</tr>
				<tr>
					<td><?php $this->label('Display Name') ?></td>
					<td><?php $this->text('display_name', 'medium' . $locked) ?></td>
				</tr>
			</table>

			<script>
				jQuery(document).ready(function($) {

					$('#tmf-full-name-display-name').keyup(function(){
						$('#tmf-full-name-display-name').addClass('locked');
					});

					$('.name-field').keyup(function(){
						var prefix  = $('#tmf-full-name-prefix').val();
						var first   = ' ' + $('#tmf-full-name-first-name').val();
						var middle  = ' ' + $('#tmf-full-name-middle-name').val();
						var last    = ' ' + $('#tmf-full-name-last-name').val();
						var suffix  = ' ' + $('#tmf-full-name-suffix').val();
						var full    = prefix + first + middle + last + suffix

						if (!$('#tmf-full-name-display-name').hasClass('locked'))
							$('#tmf-full-name-display-name').val($.trim(full.replace(/ +(?= )/g, '')));
					});
				});
			</script>

		<?php
	}

}
