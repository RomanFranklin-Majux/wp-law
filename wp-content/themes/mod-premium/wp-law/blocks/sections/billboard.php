<?php $section = $tmf->section('billboard') ?>

	<div class="desktop-view">
	    <img src="<?php echo $tmf->theme_image('home_billboard_1x.jpg') ?>" srcset="<?php echo $tmf->theme_image('home_billboard_2x.jpg') ?> 2x, <?php echo $tmf->theme_image('home_billboard_3x.jpg') ?> 3x" alt="Indiana Personal Injury Attorneys" />
		<div class="billboard-content">
        <div class="billboard-content-container">
        	<?php $tmf->module('billboard')->render() ?>
        </div>
    </div>
	</div>

	<div class="mobile-view">
	    <img src="<?php echo $tmf->theme_image('home_mobile_billboard.jpg') ?>" alt="Indiana Personal Injury Attorneys" />
		<div class="billboard-content">
        <div class="billboard-content-container">
        	<h1>Injured? Help is Minutes Away.</h1>
        </div>
    </div>
	</div>

    

<?php $section->close() ?>	