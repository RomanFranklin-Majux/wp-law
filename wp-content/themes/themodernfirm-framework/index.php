<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * The default template for all archives.
 * 
 * @package TheModernFirmFramework
 * @category Templates
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
?>

<?php $tmf->block('top')->render() ?>

	<?php $section = $tmf->section('body') ?>

		<?php $row = $tmf->row('body', 850) ?>

			<?php $row->cell(16) ?>

				<?php $tmf->breadcrumb()->render() ?>
				<?php $tmf->request()->title() ?>
				<?php $tmf->directory()->top()->render() ?>

				<?php if ($tmf->has_posts()): ?>
					<?php $tmf->posts()->template('medium')->render(); ?>
				<?php endif; ?>

				<?php $tmf->directory()->bottom()->render() ?>
				<?php $tmf->directory()->navigation()->render() ?>

			<?php $row->cell(8) ?>
				
				<?php $sidebar = ($tmf->request()->is_directory('post')) ? 'blog-sidebar' : (($tmf->request()->is_directory('location') && $tmf->has_modules('contact-sidebar', TRUE) ) ? 'contact-sidebar' : 'page-sidebar') ?>
				<?php $tmf->module($sidebar)->render() ?>

		<?php $row->close() ?>	

	<?php $section->close() ?>

<?php $tmf->block('bottom')->render() ?>
