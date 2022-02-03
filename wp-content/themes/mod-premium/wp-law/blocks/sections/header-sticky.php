<?php $section = $tmf->section('header-sticky'); ?>
	
	<!-- Desktop Version Start-->
	<?php $row = $tmf->row('header-sticky') ?>

		<?php $row->cell(10) ?>
			<?php $tmf->module('header-sticky-1')->render() ?>

		<?php $row->cell(8) ?>
			<?php $tmf->module('header-sticky-2')->render() ?>

		<?php $row->cell(3) ?>

		<?php $row->cell(3) ?>
			<div class="live-chat">
				<img onclick="window.open('https://www.apex.live/pages/chat.aspx?companykey=donaldwruck&requestedAgentId=7957&referrer='+document.referrer,'','left=1000,width=380,height=570');" onmouseover="this.src='<?php echo $tmf->theme_image('live_chat_hover_1x.png') ?>'" onmouseout="this.src='<?php echo $tmf->theme_image('live_chat_1x.png') ?>'" src="<?php echo $tmf->theme_image('live_chat_1x.png') ?>" alt="Best Lawyers for Injuries" />
			</div>

	<?php $row->close() ?>
	<!-- Desktop Version End-->

	<!-- Mobile Version Start-->
	<?php $row = $tmf->row('header-sticky-mobile') ?>

		<?php $row->cell(10) ?>
			<div class="mobile-view">
				<a href="<?php echo SITE_URL ?>">
					<img id="site-logo" class="logo" src="<?php echo $tmf->theme_image('mobile_logo.png') ?>" alt="<?php echo $tmf->wp_option()->blogname ?>"/>
				</a>
			</div>
		<?php $row->cell(14) ?>
			<?php $tmf->block('sections/mobile-nav')->render() ?>
	<?php $row->close() ?>
			<div class="mobile-view">
				<div class="header-btns">
					<a href="tel:+12193221166" class="btn call-btn">CALL (219) 322-1166</a>
					<a href="sms:+12193221166"class="btn text-btn">TEXT US</a>
				</div>
				<div class="header-slogan">
					GET A FREE CASE EVALUATION NOW
				</div>
			</div>


	<!-- Mobile Version End-->

<?php $section->close() ?>