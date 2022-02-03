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
		$thumbnail = 'https://img.youtube.com/vi/'.str_replace("?rel=0","",$lastEx).'/0.jpg';
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

<div class="<?php echo $post->css_classes('large') ?>">
	
	<?php if ($post->has_title()): ?>
		<h1 id="page-title">
			<?php echo $post->title ?>
		</h1>
	<?php endif ?>

	<div class="content-container">
		<?php if ($post->has_primary_image()): ?>
			<img class="primary video-light-box" data-video-url="<?php echo $url ?>" data-video-id="" data-video-ratio="<?php echo $ratio ?>" src="<?php echo $post->primary_image_url ?>" alt="<?php echo $post->primary_image_alt ?>" />
		<?php else: ?>
			<img class="primary video-light-box" data-video-url="<?php echo $url ?>" data-video-id="" data-video-ratio="<?php echo $ratio ?>" src="<?php echo $thumbnail ?>" alt="<?php echo $post->primary_image_alt ?>" />
		<?php endif; ?>

		<div class="clear"></div>

		<div id="page-content" class="editor-content">
			<?php echo $post->content ?>
		</div>

	</div>

</div>