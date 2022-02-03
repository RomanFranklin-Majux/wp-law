<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * The default template for all archives.
 * 
 * @package TheModernFirmFramework
 * @category Templates
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-2013 The Modern Firm, LLC
 */
?>

<?php $tmf->block('top')->render() ?>

	<?php $section = $tmf->section('int-billboard') ?>
		<div class="int-billboard-desktop-view">
			<img src="<?php echo $tmf->theme_image('billboard_practice_areas_1x.jpg') ?>" srcset="<?php echo $tmf->theme_image('billboard_practice_areas_2x.jpg') ?> 2x, <?php echo $tmf->theme_image('billboard_practice_areas_3x.jpg') ?> 3x" alt="Injury Law Firm Near Me" />
		</div>

		<div class="int-billboard-mobile-view">
			<img src="<?php echo $tmf->theme_image('mobile_int_practice_areas_1x.jpg') ?>" srcset="<?php echo $tmf->theme_image('mobile_int_practice_areas_2x.jpg') ?> 2x, <?php echo $tmf->theme_image('mobile_int_practice_areas_3x.jpg') ?> 3x" alt="Catastrophic Injury Lawyers Near Me" />
		</div>

		<?php $alternate_title = get_post_meta(get_the_ID(), '_alternate_title', true) ?>
		<?php if($alternate_title): ?>
			<div class="int-billboard-content">
		        <div class="int-billboard-content-container">
		        	<h1 id="page-title"><?php echo $alternate_title; ?></h1>
		        </div>
	    	</div>
		<?php else: ?>
			<div class="int-billboard-content">
		        <div class="int-billboard-content-container">
					<?php $tmf->request()->title() ?>
		        </div>
	    	</div>
		<?php endif; ?>

	<?php $section->close() ?>

	<?php $section = $tmf->section('body') ?>

		<?php $row = $tmf->row('body', 1050) ?>

			<?php $row->cell(24) ?>
				<?php $tmf->breadcrumb(array('separator' => ' › ' ))->render() ?>
				<?php //$tmf->request()->title() ?>
                <?php $tmf->directory()->top()->render() ?>

				<?php if ($tmf->has_posts()): ?>
					<?php $tmf->posts()->template('medium')->render(); ?>
				<?php endif; ?>

				<?php $tmf->directory()->bottom()->render() ?>
				<?php $tmf->directory()->navigation()->render() ?>

		<?php $row->close() ?>	

	<?php $section->close() ?>

	<?php $tmf->block('sections/attorneys-section')->render() ?>
	<?php $tmf->block('sections/showcase-faq-section')->render() ?>
	<?php $tmf->block('sections/featured-and-recognized')->render() ?>

<?php $tmf->block('bottom')->render() ?>