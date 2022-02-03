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

		<img src="<?php echo $tmf->theme_image('map_1x.jpg') ?>" alt="Personal Injury Lawyers Dyer Location" />
		<a href="tel:(219) 322-1166" title="" style="position: absolute; left: 57.68%; top: 41.31%; width: 8.94%; height: 3.44%; z-index: 2;"></a>
		<!-- <img src="<?php echo $tmf->theme_image('map_1x.jpg') ?>" srcset="<?php echo $tmf->theme_image('map_1x.jpg') ?> 2x, <?php echo $tmf->theme_image('map_3x.jpg') ?> 3x" alt="Top-Rated Injury Lawyers" /> -->

	<?php $section->close() ?>

	<?php $section = $tmf->section('body') ?>

		<?php $row = $tmf->row('body', 1050) ?>

			<?php $row->cell(16) ?>
				<?php $tmf->breadcrumb(array('separator' => ' › ' ))->render() ?>
				<?php //$tmf->request()->title() ?>
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
	<div class="proven-results-mobile mobile-view no-padding-top">
		<?php $tmf->block('sections/proven-results')->render() ?>
	</div>
	<div id="reviews-slider" class="mobile-view inner">
		<h3 class="center mobile-heading">Real Client Testimonials</h3>
		<hr class="yellow"/>
		<?php get_template_part('template-parts/reviews-slider'); ?>
		<div class="reviews-btn">
			<a href="/reviews" class="btn btn-red">Read More</a>
		</div>
		
	</div>
	<div class="desktop-view">
		<?php $tmf->block('sections/int-section-3')->render() ?>
		<?php $tmf->block('sections/attorneys-section')->render() ?>
		<?php $tmf->block('sections/showcase-faq-section')->render() ?>
		<?php $tmf->block('sections/featured-and-recognized')->render() ?>
	</div>
	

<?php $tmf->block('bottom')->render() ?>