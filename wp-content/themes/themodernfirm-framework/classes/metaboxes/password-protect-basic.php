<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for Password Protect Basic
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_PasswordProtectBasic extends TMF_Metabox {

	protected $metabox_name		= 'password_protect_basic';
	protected $metabox_title	= 'Password Protect';

	public function render() {
		?>
			<div style="padding-bottom: 5px"></div>
			<?php $this->checkbox('password_protected', FALSE) ?>
			<?php $this->label('Password Protect Page', 'password_protected') ?><br/><br/>

			<?php $this->label('Password') ?><br/>
			<?php $this->text('password', 'medium') ?><br/><br/>
		<?php
	}

}
