<?php $section = $tmf->section('int-billboard') ?>

	<?php if(is_post_type_archive('attorney')) : ?>
		<img src="<?php echo $tmf->theme_image('billboard_get_to_know_us_1x.jpg') ?>" srcset="<?php echo $tmf->theme_image('billboard_get_to_know_us_2x.jpg') ?> 2x, <?php echo $tmf->theme_image('billboard_get_to_know_us_3x.jpg') ?> 3x" alt="Indiana Personal Injury Lawyers" />
	<?php endif; ?>

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