<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for Superlawyer
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_SuperlawyEr extends TMF_Metabox {

	protected $metabox_name		= 'superlawyer';
	protected $metabox_title	= 'Badge Codes';

	public function render() {

		?>
			<?php wp_editor($this->post->superlawyer, 'tmf-metabox-superlawyer', array('textarea_name' => 'TMF[superlawyer][superlawyer]', 'textarea_rows' => 5, 'tinymce' => false, 'wpautop' => false)); ?>            
		<?php
	}

}
