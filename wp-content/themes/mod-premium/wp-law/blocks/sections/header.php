<?php $section = $tmf->section('header') ?>

	<?php $row = $tmf->row('header') ?>

		<?php $row->cell(10) ?>
            <div class="desktop-view">
				<?php //$tmf->logo() ?>
			</div>

            <div class="mobile-view">
				<a href="<?php echo SITE_URL ?>">
					<img id="site-logo" class="logo" src="<?php echo $tmf->theme_image('mobile_logo.png') ?>" alt="<?php echo $tmf->wp_option()->blogname ?>"/>
				</a>
			</div>

		<?php $row->cell(14) ?>
			<div class="desktop-view">
	            <?php //$tmf->module('header')->render() ?>
	        </div>

			<?php //$tmf->block('sections/mobile-nav')->render() ?>

	<?php $row->close() ?>

<!--     <div class="mobile-view">
		<div class="header-btns">
			<a href="tel:+12193221166" class="btn call-btn">CALL (219) 322-1166</a>
			<a href="sms:+12193221166"class="btn text-btn">TEXT US</a>
		</div>
		<div class="header-slogan">
			GET A FREE CASE EVALUATION NOW
		</div>
	</div> -->

<meta name="google-site-verification" content="2XCYL3gluo6V_NVw81JMiTAniVPf-bxW_dodKorCb_s" />


<?php $section->close() ?>