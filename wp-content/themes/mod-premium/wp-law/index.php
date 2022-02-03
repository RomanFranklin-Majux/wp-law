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

<?php $tmf->block('top')->render(); ?>

	<?php $section = $tmf->section('int-billboard') ?>

		<?php if(is_home() || is_category() || is_tag() || is_date() || is_search()) : ?>
			<div class="int-billboard-desktop-view">
				<img src="<?php echo $tmf->theme_image('billboard_blog_1x.jpg') ?>" srcset="<?php echo $tmf->theme_image('billboard_blog_2x.jpg') ?> 2x, <?php echo $tmf->theme_image('billboard_blog_3x.jpg') ?> 3x" alt="Injury Attorneys Near Me" />
			</div>
			<div class="int-billboard-mobile-view archive">
				    <img src="<?php echo $tmf->theme_image('mobile_int_blog_1x.jpg') ?>" srcset="<?php echo $tmf->theme_image('mobile_int_blog_2x.jpg') ?> 2x, <?php echo $tmf->theme_image('mobile_int_blog_3x.jpg') ?> 3x" alt="Best Accident Lawyers" />
			</div>
		<?php else: ?>
			<div class="int-billboard-desktop-view">
				<img src="<?php echo $tmf->theme_image('billboard_help_without_leaving_1x.jpg') ?>" srcset="<?php echo $tmf->theme_image('billboard_help_without_leaving_2x.jpg') ?> 2x, <?php echo $tmf->theme_image('billboard_help_without_leaving_3x.jpg') ?> 3x" alt="Injury and Accident Lawyers Near Me" />
			</div>
			<div class="int-billboard-mobile-view archive">
				<img src="<?php echo $tmf->theme_image('mobile_int_help_without_leaving_1x.jpg') ?>" srcset="<?php echo $tmf->theme_image('mobile_int_help_without_leaving_2x.jpg') ?> 2x, <?php echo $tmf->theme_image('mobile_int_help_without_leaving_3x.jpg') ?> 3x" alt="Accident Attorneys Near Me" />

			</div>
		<?php endif; ?>

		<?php $alternate_title = get_post_meta(get_the_ID(), '_alternate_title', true) ?>
		<?php if($alternate_title): ?>
			<div class="int-billboard-content">
		        <div class="int-billboard-content-container">
		        	<h1 id="page-title"><?php echo $alternate_title; ?></h1>
		        </div>
	    	</div>
		<?php else: ?>
			<div class="int-billboard-content archive">
		        <div class="int-billboard-content-container">
					<?php $tmf->request()->title() ?>
		        </div>
	    	</div>
		<?php endif; ?>

	<?php $section->close() ?>

	<div class="body-padding-top">
		<?php $section = $tmf->section('body') ?>
		<div class="mobile-view">
			<div class="home-contact-info-wrapper">
				<div class="home-contact-info-container blog">
					<h3>HELP IS MINUTES AWAY</h3>
					<div class="icons-rating-wrapper">
						<div class="icons">
							<img src="/wp-content/uploads/2021/11/path-facebook-1@1x.png" alt="Best Lawyer fo Injury"/>
							<img src="/wp-content/uploads/2021/11/path-google-1@1x.png" alt="Accident Lawyer Near Me"/>
							<img src="/wp-content/uploads/2021/11/image-22-1@1x.png" alt="Best Accident and Injury Lawyers"/>
							<img src="/wp-content/uploads/2021/11/image-24-1@1x.png" alt="Top-rated Accident and Injury Lawyers"/>
						</div>
						<div class="star-rating-wrapper">
							<div class="star-rating">
								<p class="rating">5.0</p>
								<div class="stars">
								  <img src="/wp-content/uploads/2021/11/path-star-25@1x.png" alt="Lawyer for Catastrophic Injury"/>
								  <img src="/wp-content/uploads/2021/11/path-star-25@1x.png" alt="Best Catastrophic Injury Lawyer"/>
								  <img src="/wp-content/uploads/2021/11/path-star-25@1x.png" alt="Top Rated Injury Firm"/>
								  <img src="/wp-content/uploads/2021/11/path-star-25@1x.png" alt="Best Injury Attorney"/>
								  <img src="/wp-content/uploads/2021/11/path-star-25@1x.png" alt="Best Injury Lawyer"/>
								</div>
							</div>
							<p class="center">Out of 477 Reviews</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<?php $row = $tmf->row('body', 1050) ?>
			<?php $row->cell(16) ?>
				<?php $tmf->breadcrumb(array('separator' => ' › ' ))->render() ?>
				<?php //$tmf->request()->title() ?>
                <?php $tmf->directory()->top()->render() ?>

	

				<?php if(is_home() || is_category() || is_tag() || is_date() || is_search()) : ?>
					<?php if ($tmf->has_posts()): ?>
						<div class="blog-medium-desktop-view">
							<?php $tmf->posts()->template('medium')->render(); ?>
						</div>

						<div class="blog-medium-mobile-view">
							<?php $tmf->posts()->template('medium-mobile')->render(); ?>
						</div>
					<?php endif; ?>
				<?php else : ?>
					<?php if ($tmf->has_posts()): ?>
						<?php $tmf->posts()->template('medium')->render(); ?>
					<?php endif; ?>
				<?php endif; ?>

				<?php $tmf->directory()->bottom()->render() ?>
				<?php $tmf->directory()->navigation()->render() ?>

			<?php $row->cell(8) ?>

				<?php if(is_home() || is_category() || is_tag() || is_date() || is_search()) : ?>
					<div class="blog-sidebar-desktop">
						<?php $tmf->module('blog-sidebar')->render() ?>
					</div>
					<div class="blog-sidebar-mobile">
						<?php $tmf->module('blog-sidebar-mobile')->render() ?>
					</div>
				<?php elseif(is_post_type_archive('location')) : ?>
					<?php $tmf->module('contact-sidebar')->render() ?>
				<?php else : ?>
					<?php $tmf->module('page-sidebar')->render() ?>
				<?php endif; ?>

			<?php $row->close() ?>	

		<?php $section->close() ?>
	</div>
	

	<?php if(is_home() || is_category() || is_tag() || is_date() || is_search()) : ?>
		<div class="desktop-view">
			<?php $tmf->block('sections/attorneys-section')->render() ?>
			<?php $tmf->block('sections/int-section-3')->render() ?>
		</div>
		<div class="mobile-view">
			<?php $tmf->block('sections/featured-and-recognized')->render() ?>
			<div class="proven-results-mobile no-padding-top">
				<?php $tmf->block('sections/proven-results')->render() ?>
			</div>
			<div id="reviews-slider" class="mobile-view inner">
			  <h3 class="center mobile-heading">Real Client Testimonials</h3>
			  <hr class="yellow"/>
			  <?php get_template_part('template-parts/reviews-slider'); ?>
			</div>
		</div>
		
	<?php else : ?>
		<div class="desktop-view">
			<?php $tmf->block('sections/int-section-3')->render() ?>
		</div>
		<div class="mobile-view zero-fee">
			<div class="proven-results-bottom-text results">
					***Every case is unique and your results will differ. Contact us for a free case review of your circumstance.					
			</div>
			<div class="center">
				<img src="/wp-content/uploads/2020/10/logo_zero_fee_promise_1x.png" alt="Attorney Team Near Me"/>
				<p>
					We make every client a written guarantee:<br>you will recover money or our work is free.
				</p>
			</div>
		</div>
		<div class="mobile-view">
			<div class="free-case-evaluation inner">
				<h3 class="mobile-heading">
				Get a Free Case Evaluation
				</h3>
				<hr class="yellow"/>
				<?php echo do_shortcode( '[gravityform id="3" title="false" description="false" ajax="true"]' ); ?>
			</div>
			<div id="reviews-slider" class="mobile-view inner">
				<h3 class="center">Real Client Testimonials</h3>
				<hr class="yellow"/>
				<?php get_template_part('template-parts/reviews-slider'); ?>
			</div>
		</div>
		<div class="desktop-view">
			<?php $tmf->block('sections/attorneys-section')->render() ?>
		</div>
		
	<?php endif; ?>

<?php $tmf->block('bottom')->render() ?>