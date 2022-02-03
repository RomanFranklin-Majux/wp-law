<div class="rss-feed">
	<?php if (!empty($feed)): ?>

		<?php foreach($feed as $item): ?>
			<div class="feed-post">
				<div class="title">
					<a href="<?php echo esc_url($item->get_permalink()) ?>">
						<?php echo esc_html($item->get_title()) ?>
					</a>
				</div>
				<div class="date">
					<?php echo $item->get_date('F jS, Y') ?>
				</div>
				<p class="excerpt">
					<?php echo TMF_Text::limit_chars(strip_tags($item->get_description(), $char_limit)) ?>
					<a href="<?php echo esc_url($item->get_permalink()) ?>" class="read-more" target="_blank">Read More</a>
				</p>
			</div>
		<?php endforeach ?>

	<?php else: ?>
		<p>There are no items at this time.</p>
	<?php endif ?>
</div>