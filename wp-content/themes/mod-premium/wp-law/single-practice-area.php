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
				<img src="<?php echo $tmf->theme_image('billboard_auto_accidents_1x.jpg') ?>" srcset="<?php echo $tmf->theme_image('billboard_auto_accidents_2x.jpg') ?> 2x, <?php echo $tmf->theme_image('billboard_auto_accidents_3x.jpg') ?> 3x" alt="Injury and Accident Lawyers Near Me" />
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
			<div class="int-billboard-mobile-view">
				<img src="<?php echo $tmf->theme_image('mobile_int_auto_accidents_1x.jpg') ?>" srcset="<?php echo $tmf->theme_image('mobile_int_auto_accidents_2x.jpg') ?> 2x, <?php echo $tmf->theme_image('mobile_int_auto_accidents_3x.jpg') ?> 3x" alt="Injury Law Firm Near Me" />
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

	<?php $tmf->posts()->template('large')->render() ?>

<?php $tmf->block('bottom')->render() ?>