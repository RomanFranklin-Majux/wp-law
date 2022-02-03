<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for Excerpt
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_Excerpt extends TMF_Metabox {

	protected $metabox_name		= 'excerpt';
	protected $metabox_title	= 'Excerpt';

	public function before_save() {
		global $wpdb;

		$extra = $this->post_data(TRUE);
		$excerpt = addslashes($extra->_excerpt);
		$wpdb->query("UPDATE $wpdb->posts SET post_excerpt = '$excerpt' WHERE ID = $this->post_id LIMIT 1");

	}

	public function render() {
		global $tmf_option;
		?>
			<table class="tmf-metabox">
				<tr valign="top">
					<td>
						<?php $this->textarea('excerpt', 'full medium', $this->post->post_excerpt, TRUE) ?>
						<?php if (!empty($tmf_option->{str_replace('-', '_', $this->post->post_type) . '_excerpt_length'})): ?>
							<div class="character-counter">
								<span class="max-length">Max Length: <?php echo $tmf_option->{str_replace('-', '_', $this->post->post_type) . '_excerpt_length'} ?></span>

								<div class="counter">
									Character Count: 
									<span class="count"><?php echo strlen($this->post->post_excerpt) ?></span>
								</div>
							</div>
							<script>
								jQuery(document).ready(function($) {
									check_excerpt_length();

									$('#tmf-excerpt-excerpt').keyup(function(){
										check_excerpt_length();
									});

									function check_excerpt_length() {
										var max_length		= <?php echo $tmf_option->{$this->post->post_type . '_excerpt_length'} ?>;
										var excerpt_length	= $('#tmf-excerpt-excerpt').val().length;
										$('#tmf-excerpt .character-counter .count').html(excerpt_length);

										if (excerpt_length > max_length){
											$('#tmf-excerpt .max-length').css({'background-color': '#c33428', 'color': '#FFF'});
										} else {
											$('#tmf-excerpt .max-length').css({'background-color': '#eaeaea', 'color': '#000'});
										}
									}
								});
							</script>
						<?php endif ?>
					</td>
				</tr>
			</table>
			
		<?php
	}

}
