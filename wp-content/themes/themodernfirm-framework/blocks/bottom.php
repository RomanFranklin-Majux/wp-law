<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * This block contains the closing tags for the 'page/top' block.
 * 
 * @package TheModernFirmFramework
 * @category Blocks
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
?>
	
		<?php $tmf->block('sections/footer')->render() ?>
		<?php $tmf->block('sections/copyright')->render() ?>
		<?php $tmf->block('miscellaneous/print-footer')->render() ?>

		<?php $tmf->footer() ?>
	</body>
</html>
