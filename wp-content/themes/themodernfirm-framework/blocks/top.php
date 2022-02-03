<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * This is the top block for every front-end page. 
 * 
 * @package TheModernFirmFramework
 * @category Blocks
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
?>

<!DOCTYPE html>
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="no-js no-touch ie8"> <![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html <?php language_attributes() ?> class="no-js no-touch"><!--<![endif]-->

	<head>
		<meta name="themodernfirm-framework-version" content="<?php echo FRAMEWORK_VERSION ?>" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta charset="<?php bloginfo('charset'); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no" />
		<link rel="profile" href="http://gmpg.org/xfn/11" />	
		<?php $tmf->request()->title(TRUE) ?>
		<?php $tmf->head() ?>
	</head>

	<body <?php $tmf->body_css() ?>>
	<?php do_action('body_start') ?>
	
	<?php $tmf->block('miscellaneous/print-header')->render() ?>
	<?php $tmf->block('sections/secondary-nav')->render() ?>
	<?php $tmf->block('sections/header')->render() ?>
	<?php $tmf->block('sections/primary-nav')->render() ?>
	<?php $tmf->block('sections/mobile-nav')->render() ?>
