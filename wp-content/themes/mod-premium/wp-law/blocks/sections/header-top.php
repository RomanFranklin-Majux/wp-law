<?php $section = $tmf->section('header-top') ?>

	<?php $row = $tmf->row('header-top', 850) ?>

		<?php $row->cell(4) ?>
			<div class="home-mobile-nav">
            	<?php $tmf->block('sections/desktop-mobile-nav')->render() ?>
            </div>

		<?php $row->cell(18) ?>
			<div class="slogan"><?php echo $tmf->wp_option()->blogdescription ?></div>

		<?php $row->cell(5) ?>
			<div class="live-chat">
				<img onclick="window.open('https://www.apex.live/pages/chat.aspx?companykey=donaldwruck&requestedAgentId=7957&referrer='+document.referrer,'','left=1000,width=380,height=570');" onmouseover="this.src='<?php echo $tmf->theme_image('live_chat_hover_1x.png') ?>'" onmouseout="this.src='<?php echo $tmf->theme_image('live_chat_1x.png') ?>'" src="<?php echo $tmf->theme_image('live_chat_1x.png') ?>" alt="Top-Rated Midwest Personal Injury Lawyers" />
			</div>

	<?php $row->close() ?>

<?php $section->close() ?>