<?php $section = $tmf->section('showcase-faq-section') ?>

	<?php $row = $tmf->row('showcase-faq-section', 1050) ?>

		<?php $row->cell(24) ?>
		
			<?php global $post; ?>
            <?php $args = array('posts_per_page' => 5, 'post_type' => 'showcase-faq', 'orderby' => 'menu_order', 'order' => 'ASC'); ?>
            <?php $myposts = get_posts($args); ?>
            <!-- Desktop View Start-->
            <div class="showcase-faq-desktop-view">
	            <div id="show-case-faqs-tab">
	                <ul class="resp-tabs-list hor_1">
			            <?php foreach ($myposts as $post) : setup_postdata($post); ?>
				            <?php $question = get_post_meta($post->ID, '_question', true); ?>
					        <li><?php echo $question ?></li>
			            <?php endforeach; ?>
				    </ul>

				    <div class="resp-tabs-container hor_1">
			            <?php foreach ($myposts as $post) : setup_postdata($post); ?>
				            <?php $answer = get_post_meta($post->ID, '_answer', true); ?>
				            <?php $shocase_faq_bt_text = get_post_meta($post->ID, '_shocase_faq_bt_text', true); ?>
				            <?php $shocase_faq_bt_link = get_post_meta($post->ID, '_shocase_faq_bt_link', true); ?>
				            <?php $primary_img = wp_get_attachment_url($post->_primary_image); ?>
				            <?php $video_service = get_post_meta($post->ID, '_video_service', true); ?>
				            <?php $video_id = get_post_meta($post->ID, '_video_id', true);?>
				            <?php $video_width = get_post_meta($post->ID, '_video_width', true); ?>
				            <?php $video_width = get_post_meta($post->ID, '_video_width', true); ?>
				            <?php $video_height = get_post_meta($post->ID, '_video_height', true); ?>
							<?php 
								if ($video_service == 'youtube')
									$url = '//www.youtube.com/embed/' . $video_id . '?rel=0';
								
								if ($video_service == 'vimeo')
									$url = '//player.vimeo.com/video/'. $video_id .'?title=0&amp;byline=0&amp;portrait=0&amp;autoplay=true';

								if (empty($video_width))
									$video_width = 600;

								if (empty($video_height))
									$video_height = 400;

								$ratio = round(100 / ($video_width / $video_height), 2, PHP_ROUND_HALF_UP);

								if($video_service == 'youtube'):
									$ex = explode("/", $url);
									$lastEx = end($ex);
									$thumbnail = 'https://img.youtube.com/vi/'.str_replace("?rel=0","",$lastEx).'/hqdefault.jpg';
								elseif($post->video_service == 'vimeo'):
									$response = wp_remote_get('https://vimeo.com/api/v2/video/'.$video_id.'.json');

									if ( is_array( $response ) ) {
									  $header = $response['headers']; // array of http header lines
									  $body = json_decode($response['body']); // use the content

									  $thumbnail = $body[0]->thumbnail_large;
									}

									//$thumbnail = 'https://i.vimeocdn.com/video/'. $post->video_id .'_640.png';
								endif;
							?>
					        <div class="editor-content">

					        	<div class="tab-content-cell-1">
					        		<?php echo $answer ?>
					        	</div>

								<?php if ($primary_img) : ?>
						        	<div class="tab-content-cell-2">
						                <div class="showcase-faq-video-image">
											<img src="<?php echo $primary_img ?>" />
											
											<div class="play-button">
												<img class="video-light-box" data-video-url="<?php echo $url ?>" data-video-id="" data-video-ratio="<?php echo $ratio ?>" src="<?php echo $tmf->theme_image('btn_play.png') ?>" alt="Injury Lawyers Near Me"/>
											</div>
										</div>
						        	</div>
								<?php endif; ?>

								<?php if ($shocase_faq_bt_text) : ?>
									<div class="showcase-faq-button">
										<a class="tmf-button" href="<?php echo $shocase_faq_bt_link; ?>"><?php echo $shocase_faq_bt_text; ?></a>
									</div>
					            <?php endif; ?>

					        </div>
			            <?php endforeach; ?>
		            </div>
	            </div>
            </div>
			<!-- Desktop View End-->

			<!-- Mobile View Start-->
            <div class="showcase-faq-mobile-view">
	            <div class="showcase-faq-section-accordion">
		            <?php foreach ($myposts as $post) : setup_postdata($post); ?>
			            <?php $question = get_post_meta($post->ID, '_question', true); ?>
			            <?php $answer = get_post_meta($post->ID, '_answer', true);?>
			            <?php $shocase_faq_bt_text = get_post_meta($post->ID, '_shocase_faq_bt_text', true); ?>
			            <?php $shocase_faq_bt_link = get_post_meta($post->ID, '_shocase_faq_bt_link', true); ?>
			            <?php $primary_img = wp_get_attachment_url($post->_primary_image); ?>
			            <?php $video_service = get_post_meta($post->ID, '_video_service', true); ?>
			            <?php $video_id = get_post_meta($post->ID, '_video_id', true);?>
			            <?php $video_width = get_post_meta($post->ID, '_video_width', true); ?>
			            <?php $video_width = get_post_meta($post->ID, '_video_width', true); ?>
			            <?php $video_height = get_post_meta($post->ID, '_video_height', true); ?>
						<?php 
							if ($video_service == 'youtube')
								$url = '//www.youtube.com/embed/' . $video_id . '?rel=0';
							
							if ($video_service == 'vimeo')
								$url = '//player.vimeo.com/video/'. $video_id .'?title=0&amp;byline=0&amp;portrait=0&amp;autoplay=true';

							if (empty($video_width))
								$video_width = 600;

							if (empty($video_height))
								$video_height = 400;

							$ratio = round(100 / ($video_width / $video_height), 2, PHP_ROUND_HALF_UP);

							if($video_service == 'youtube'):
								$ex = explode("/", $url);
								$lastEx = end($ex);
								$thumbnail = 'https://img.youtube.com/vi/'.str_replace("?rel=0","",$lastEx).'/hqdefault.jpg';
							elseif($post->video_service == 'vimeo'):
								$response = wp_remote_get('https://vimeo.com/api/v2/video/'.$video_id.'.json');

								if ( is_array( $response ) ) {
								  $header = $response['headers']; // array of http header lines
								  $body = json_decode($response['body']); // use the content

								  $thumbnail = $body[0]->thumbnail_large;
								}

								//$thumbnail = 'https://i.vimeocdn.com/video/'. $post->video_id .'_640.png';
							endif;
						?>
			            <div class="accordion_in">
		            		<div class="acc_head">
								<div class="title">
									<?php echo $question ?>
								</div>
							</div>

							<div class="acc_content">
								<div class="editor-content">
									<?php echo $answer ?>
								</div>

								<?php if ($primary_img) : ?>
					                <div class="showcase-faq-video-image">
										<img src="<?php echo $primary_img ?>" />
										
										<div class="play-button">
											<img class="video-light-box" data-video-url="<?php echo $url ?>" data-video-id="" data-video-ratio="<?php echo $ratio ?>" src="<?php echo $tmf->theme_image('btn_play.png') ?>" alt="Injury Attorneys in my Area"/>
										</div>
									</div>
								<?php endif; ?>

								<?php if ($shocase_faq_bt_text) : ?>
									<div class="showcase-faq-button">
										<a class="tmf-button" href="<?php echo $shocase_faq_bt_link; ?>"><?php echo $shocase_faq_bt_text; ?></a>
									</div>
					            <?php endif; ?>
					            
							</div>
						</div>
		            <?php endforeach; ?>
	            </div>
            </div>
            <!-- Mobile View End-->

	<?php $row->close() ?>

<?php $section->close() ?>