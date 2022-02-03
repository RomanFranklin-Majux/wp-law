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

		<?php if($post->tmf->banner_image): ?>
			<?php 
			    $high_res = '';
			    $logo_path = get_attached_file($post->tmf->banner_image); 
			    $image = $tmf->image_url_from_id($post->tmf->banner_image);
			    $logo_2x = str_replace('3x', '2x', $logo_path);
			    $logo_1x = str_replace('3x', '1x', $logo_path);
			    $logo_2x_url = ( file_exists($logo_2x) ? str_replace('3x', '2x', $image) : '' );
			    $logo_1x_url = ( file_exists($logo_1x) ? str_replace('3x', '1x', $image) : '' );

			    $high_res = (!empty($logo_2x_url) ? $logo_2x_url .' 2x' : '') . (!empty($logo_2x_url && $image) ? ', ' : '' ) . (!empty($image) ? $image .' 3x' : '');
			?>
			<div class="int-billboard-desktop-view">
				<img src="<?php echo $logo_1x_url ?>" srcset="<?php echo $high_res ?>" />
			</div>
		<?php endif ?>
		
		<?php if($post->tmf->mobile_banner_image): ?>
			<?php 
			    $high_res = '';
			    $logo_path = get_attached_file($post->tmf->mobile_banner_image); 
			    $image = $tmf->image_url_from_id($post->tmf->mobile_banner_image);
			    $logo_2x = str_replace('3x', '2x', $logo_path);
			    $logo_1x = str_replace('3x', '1x', $logo_path);
			    $logo_2x_url = ( file_exists($logo_2x) ? str_replace('3x', '2x', $image) : '' );
			    $logo_1x_url = ( file_exists($logo_1x) ? str_replace('3x', '1x', $image) : '' );

			    $high_res = (!empty($logo_2x_url) ? $logo_2x_url .' 2x' : '') . (!empty($logo_2x_url && $image) ? ', ' : '' ) . (!empty($image) ? $image .' 3x' : '');
			?>
			<div class="int-billboard-mobile-view about-billboard-mobile">
				<img src="<?php echo $logo_1x_url ?>" srcset="<?php echo $high_res ?>" />
			</div>
		<?php endif ?>
		
		<?php $alternate_title = get_post_meta(get_the_ID(), '_alternate_title', true) ?>
		<?php if($alternate_title): ?>
			<div class="int-billboard-content">
		        <div class="int-billboard-content-container">
		        	<h1 id="page-title"><?php echo $alternate_title; ?></h1>
		        </div>
	    	</div>
		<?php else: ?>
			<div class="int-billboard-content bottom">
		        <div class="int-billboard-content-container">
					<?php $tmf->request()->title() ?>
		        </div>
	    	</div>
		<?php endif; ?>

	<?php $section->close() ?>

	<div class="mobile-view">
		<?php $tmf->block('sections/reviews-top-inner')->render() ?>
	</div>

	<?php $section = $tmf->section('body') ?>

		<?php $row = $tmf->row('body', 1050) ?>

			<?php $row->cell(16) ?>

				<?php if ($tmf->has_posts()): ?>
					<?php $tmf->posts()->template('large')->render(); ?>
				<?php endif; ?>

			<?php $row->cell(8) ?>
                                   
				<?php $sidebar = ($tmf->request()->is_directory('post')) ? 'blog-sidebar' : 'page-sidebar' ?>
				<?php $tmf->module($sidebar)->render() ?>

		<?php $row->close() ?>	

	<?php $section->close() ?>
	<div class="about-proven-results">
		<?php $tmf->block('sections/proven-results')->render() ?>
		<div id="reviews-slider" class="mobile-view inner">
		  <h3 class="center mobile-heading">Real Client Testimonials</h3>
		  <hr class="yellow"/>
		  <?php //echo do_shortcode('[smartslider3 slider="2"]'); ?>
		  <?php get_template_part('template-parts/reviews-slider'); ?>
	    </div>
	</div>
	
	<div class="desktop-view">
		<?php $tmf->block('sections/int-section-1')->render() ?>
		<?php $tmf->block('sections/testimonial-section')->render() ?>
		<?php $tmf->block('sections/int-section-2')->render() ?>
		<div class="get-to-know-us-sidebar-mobile-view">
			<?php $sidebar = ($tmf->request()->is_directory('post')) ? 'blog-sidebar' : 'page-sidebar' ?>
			<?php $tmf->module($sidebar)->render() ?>
		</div>
		<?php $tmf->block('sections/attorneys-section')->render() ?>
	</div>

	
	
	
	

<?php $tmf->block('bottom')->render() ?>