<?php
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || 
    $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    
	$url = (isset($url)) ? urlencode($url) : urlencode($protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
?>

<div class="social-buttons">
	
	<?php if(($tmf->option()->facebook_button_pages && isset($page)) || ($tmf->option()->facebook_button_posts && isset($post))): ?>
		<div class="facebook-like">
			<iframe src="//www.facebook.com/plugins/like.php?href=<?php echo $url ?>&amp;send=false&amp;layout=button_count&amp;width=285&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:107px; height:21px;" allowTransparency="true"></iframe>
		</div>
	<?php endif; ?>
	
	<?php if(($tmf->option()->facebook_share_button_pages && isset($page)) || ($tmf->option()->facebook_share_button_posts && isset($post))): ?>
		<div class="facebook-share">
			<iframe src="https://www.facebook.com/plugins/share_button.php?href=<?php echo $url ?>&layout=button_count&size=small&width=96&height=20&appId" width="96" height="20" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
		</div>
	<?php endif; ?>

	<?php if(($tmf->option()->twitter_button_pages && isset($page)) || ($tmf->option()->twitter_button_posts && isset($post))): ?>
		<div class="twitter-tweet">
			<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo urldecode($url) ?>" style="width: 40px;">Tweet</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		</div>
	<?php endif; ?>

	<?php if(($tmf->option()->pinterest_button_pages && isset($page)) || ($tmf->option()->pinterest_button_posts && isset($post))): ?>
		<div class="pinterest-pin">
			<a href="//www.pinterest.com/pin/create/button/" data-pin-do="buttonBookmark" >
				<img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_20.png" />
			</a>
			<!-- Please call pinit.js only once per page -->
			<script type="text/javascript" async src="//assets.pinterest.com/js/pinit.js"></script>
		</div>
	<?php endif; ?>

	<?php if(($tmf->option()->linkedin_button_pages && isset($page)) || ($tmf->option()->linkedin_button_posts && isset($post))): ?>
		<div class="linkedin-share">
			<script src="//platform.linkedin.com/in.js" type="text/javascript">
			 lang: en_US
			</script>
			<script type="IN/Share" data-counter="right" data-url="<?php echo urldecode($url) ?>"></script>
		</div>
	<?php endif; ?>

</div>