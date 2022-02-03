<?php 

	if ($post->video_service == 'youtube')
		$url = '//www.youtube.com/embed/' . $post->video_id . '?rel=0';

	if ($post->video_service == 'vimeo')
		$url = '//player.vimeo.com/video/'. $post->video_id .'?title=0&amp;byline=0&amp;portrait=0&amp;autoplay=true';

	if($post->video_service == 'other')
		$url = esc_url($post->video_url);

	if (empty($post->video_width))
		$post->video_width = 600;

	if (empty($post->video_height))
		$post->video_height = 400;

	$ratio = round(100 / ($post->video_width / $post->video_height), 2, PHP_ROUND_HALF_UP);

	if($post->video_service == 'youtube'):
		$ex = explode("/", $url);
		$lastEx = end($ex);
		$thumbnail = 'https://img.youtube.com/vi/'.str_replace("?rel=0","",$lastEx).'/hqdefault.jpg';
	elseif($post->video_service == 'vimeo'):
		$response = wp_remote_get('https://vimeo.com/api/v2/video/'.$post->video_id.'.json');

		if ( is_array( $response ) ) {
		  $header = $response['headers']; // array of http header lines
		  $body = json_decode($response['body']); // use the content

		  $thumbnail = $body[0]->thumbnail_large;
		}

		//$thumbnail = 'https://i.vimeocdn.com/video/'. $post->video_id .'_640.png';
	endif;

?>

<div class="<?php echo $post->css_classes('medium') ?>">
	
	<?php if ($post->has_thumbnail_image()): ?>
		<img class="not-mobile thumbnail video-light-box" data-video-url="<?php echo $url ?>" data-video-id="" data-video-ratio="<?php echo $ratio ?>" src="<?php echo $post->thumbnail_image_url ?>" alt="<?php echo $post->thumbnail_image_alt ?>" />
	<?php else: ?>
		<img class="not-mobile thumbnail video-light-box" data-video-url="<?php echo $url ?>" data-video-id="" data-video-ratio="<?php echo $ratio ?>" src="<?php echo $thumbnail ?>" alt="<?php echo $post->thumbnail_image_alt ?>" />
	<?php endif; ?>

	<h2 class="title">
		<a href="<?php echo $post->permalink ?>">
			<?php echo $post->title ?>
		</a>
	</h2>

	<div class="excerpt">
		<?php if ($post->has_thumbnail_image()): ?>

			<img class="mobile thumbnail video-light-box" data-video-url="<?php echo $url ?>" data-video-id="" data-video-ratio="<?php echo $ratio ?>" src="<?php echo $post->thumbnail_image_url ?>" alt="<?php echo $post->thumbnail_image_alt ?>" />

		<?php else: ?>
			<img class="mobile thumbnail video-light-box" data-video-url="<?php echo $url ?>" data-video-id="" data-video-ratio="<?php echo $ratio ?>" src="<?php echo $thumbnail ?>" alt="<?php echo $post->thumbnail_image_alt ?>" />
		<?php endif; ?>

		<?php echo $post->excerpt ?>

		<?php if($tmf_option->post_type_video_read_more_links != 1): ?>
			<?php if ($post->has_permalink()): ?>	
				<a href="<?php echo $post->permalink ?>" class="read-more" title="View video information">
				Read More
				</a>
			<?php endif ?>
		<?php endif ?>
	</div>

	<div class="clear"></div>
</div>