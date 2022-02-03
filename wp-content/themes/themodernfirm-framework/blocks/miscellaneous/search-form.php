<form method="get" class="search-form" action="<?php echo get_home_url() ?>/">
	<div>
		<input type="text" size="30" name="s" class="search-box" value="<?php echo $placeholder ?>" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;"/>
		<input type="submit" class="search-submit tmf-button small" value="Search" />
			
		<?php if (!empty($post_type)): ?>
			<input type="hidden" name="post_type" value="<?php echo $post_type ?>" />
		<?php endif ?>
					
	</div>
</form>