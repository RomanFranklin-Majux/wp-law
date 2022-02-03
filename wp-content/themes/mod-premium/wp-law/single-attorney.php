<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * The default template for all single post types.
 * 
 * @package TheModernFirmFramework
 * @category Templates
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-2013 The Modern Firm, LLC
 */
?>

<?php $tmf->block('top')->render() ?>

	<?php $tmf->posts()->template('large')->render() ?>

<?php $tmf->block('bottom')->render() ?>