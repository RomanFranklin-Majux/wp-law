<div class="<?php echo $post->css_classes('related') ?> accordion_in">

	<div class="acc_head">
		<div class="acc_icon_expand"></div>
		<div class="title">
		    <a href="<?php echo $post->permalink ?>" title="Read more about <?php echo TMF_Text::limit_chars($post->title, 25) ?>">
			    <?php echo $post->question ?>
			</a>
		</div>
	</div>

	<div class="acc_content">
		<div class="editor-content">
			<?php echo $post->answer ?>
		</div>
	</div>

</div>