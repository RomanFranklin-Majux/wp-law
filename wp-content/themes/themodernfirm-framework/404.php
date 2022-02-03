<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * The default template for all 404 errors.
 * 
 * @package TheModernFirmFramework
 * @category Templates
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
?>

<?php $tmf->block('top')->render() ?>

	<?php $section = $tmf->section('body') ?>

		<?php $row = $tmf->row('body') ?>

			<?php $row->cell(24) ?>
			
				<div id="page-title-wrapper">
					<h1 id="page-title">
						404 - Not Found
					</h1>
				</div>

				<div id="page-content">
					<h2>Sorry. We could not find the page you requested.</h2>
					<p>This page may no longer exist — Please double check the URL for any mistakes.</p>
				</div>

		<?php $row->close() ?>	

	<?php $section->close() ?>

<?php $tmf->block('bottom')->render() ?>
