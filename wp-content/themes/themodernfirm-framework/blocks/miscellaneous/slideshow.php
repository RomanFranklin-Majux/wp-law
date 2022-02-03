<?php if ($random == FALSE): ?>
	<div id="<?php echo $id ?>" class="tmf-flex-slideshow <?php echo $class ?>">
		<?php foreach ($images as $image): ?>
			<img src="<?php echo $image ?>" />
		<?php endforeach ?>
			<img src="<?php echo end($images) ?>" class="spacer" />
	</div>

	<script>
		jQuery(function(){
			setInterval(function(){
				jQuery('#<?php echo $id ?> > img:nth-last-child(2)').fadeOut(<?php echo $fade_duration ?>, function(){
					jQuery(this).insertBefore('#<?php echo $id ?> > img:first').show();
				});
			}, <?php echo $speed ?>);
		});
	</script>
<?php else: ?>
	<img src="<?php echo $images[array_rand($images)] ?>" id="<?php echo $id ?>" class="tmf-static-slide <?php echo $class ?>" />
<?php endif ?>