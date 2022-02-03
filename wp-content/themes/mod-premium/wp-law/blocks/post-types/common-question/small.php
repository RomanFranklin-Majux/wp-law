<div class="<?php echo $post->css_classes('small') ?> accordion_in">

	<div class="acc_head">
		<div class="acc_icon_expand"></div>
		<div class="title">
		    <?php echo $post->title ?>
		</div>
	</div>

	<div class="acc_content">
		<div class="editor-content">
			<?php echo $post->content ?>
		</div>
	</div>

</div>