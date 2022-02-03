<div class="tag-cloud">
	<?php if($tags) {
			foreach ($tags as $tag) {
				echo $tag;
			}
		} else { 
			echo "There are currently no tags.";
		} ?>
</div>