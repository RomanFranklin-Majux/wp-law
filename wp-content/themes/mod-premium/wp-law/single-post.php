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
		<?php else: ?>
			<div class="int-billboard-desktop-view">
				<img src="<?php echo $tmf->theme_image('billboard_blog_1x.jpg') ?>" srcset="<?php echo $tmf->theme_image('billboard_blog_2x.jpg') ?> 2x, <?php echo $tmf->theme_image('billboard_blog_3x.jpg') ?> 3x" alt="Indiana Personal Injury Attorneys Blog" />
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
			<div class="int-billboard-mobile-view">
				<img src="<?php echo $logo_1x_url ?>" srcset="<?php echo $high_res ?>" />
			</div>
		<?php else: ?>
			<div class="int-billboard-mobile-view single-post">
				<img src="<?php echo $tmf->theme_image('mobile_int_blog_1x.jpg') ?>" srcset="<?php echo $tmf->theme_image('mobile_int_blog_2x.jpg') ?> 2x, <?php echo $tmf->theme_image('mobile_int_blog_3x.jpg') ?> 3x" alt="Indiana Personal Injury Lawyer Blog" />
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
      <div class="int-billboard-content">
            <div class="int-billboard-content-container">
          <?php $tmf->request()->title() ?>
            </div>
        </div>
    <?php endif; ?>

	<?php $section->close() ?>
	<div class="body-padding-top">
		<?php $section = $tmf->section('body') ?>

		<?php $row = $tmf->row('body', 1050) ?>

			<div class="mobile-view">
			<div class="home-contact-info-wrapper">
				<div class="home-contact-info-container single-post">
					<h3>HELP IS MINUTES AWAY</h3>
					<div class="icons-rating-wrapper">
						<div class="icons">
							<img src="/wp-content/uploads/2021/11/path-facebook-1@1x.png" alt="Indiana Legal Info"/>
							<img src="/wp-content/uploads/2021/11/path-google-1@1x.png" alt="Personal Injury Lawyer Blog"/>
							<img src="/wp-content/uploads/2021/11/image-22-1@1x.png" alt="Law Firm Blog"/>
							<img src="/wp-content/uploads/2021/11/image-24-1@1x.png" alt="Personal Injury Blog"/>
						</div>
						<div class="star-rating-wrapper">
							<div class="star-rating">
								<p class="rating">5.0</p>
								<div class="stars">
								  <img src="/wp-content/uploads/2021/11/path-star-25@1x.png" alt="Indiana Law Firm Blog"/>
								  <img src="/wp-content/uploads/2021/11/path-star-25@1x.png" alt="Indiana Law Firm"/>
								  <img src="/wp-content/uploads/2021/11/path-star-25@1x.png" alt="Lawyers in Indiana"/>
								  <img src="/wp-content/uploads/2021/11/path-star-25@1x.png" alt="Attorneys in Indiana"/>
								  <img src="/wp-content/uploads/2021/11/path-star-25@1x.png" alt="Law Blog"/>
								</div>
							</div>
							<p class="center">Out of 477 Reviews</p>
						</div>
					</div>
				</div>
			</div>
		</div>

			<?php $row->cell(16) ?>

				<?php if ($tmf->has_posts()): ?>        
					<?php $tmf->breadcrumb(array('separator' => ' › ' ))->render() ?>
					<?php $tmf->posts()->template('large')->render() ?>
				<?php endif; ?>

			<?php $row->cell(8) ?>

				<?php if(is_singular('post')) : ?>
					<?php $tmf->module('blog-sidebar')->render() ?>
				<?php else : ?>
					<?php $tmf->module('page-sidebar')->render() ?>
				<?php endif; ?>

			<?php $row->close() ?>	

		<?php $section->close() ?>
	</div>
	
	<div class="desktop-view">
		<?php $tmf->block('sections/int-section-3')->render() ?>
		<?php $tmf->block('sections/attorneys-section')->render() ?>
	</div>
	<div class="mobile-view">
		<?php $tmf->block('sections/featured-and-recognized')->render() ?>
		<div class="mobile-view proven-results-single-post">
			<h3 class="mobile-heading">Proven Results</h3>
			<hr class="yellow"/>
			<?php get_template_part('template-parts/results-slider'); ?>
			<div class="proven-results-bottom-text">
				***Every case is unique and your results will differ. Contact us for a free case review of your circumstance.					
			</div>
		</div>
		<div id="reviews-slider" class="mobile-view inner">
			<h3 class="center mobile-heading">Real Client Testimonials</h3>
			<hr class="yellow"/>
		  <?php get_template_part('template-parts/reviews-slider'); ?>
		</div>
	</div>
	
	
	

<?php $tmf->block('bottom')->render() ?>