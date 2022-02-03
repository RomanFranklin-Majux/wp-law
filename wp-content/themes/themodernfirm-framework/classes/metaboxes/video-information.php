<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for Video Information
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_VideoInformation extends TMF_Metabox {

	protected $metabox_name		= 'video_information';
	protected $metabox_title	= 'Video Information';


	public function render() {
		?>
			<div style="padding-bottom: 5px"></div>

			<?php $this->label('Video Service') ?><br/>
			<?php $this->selectbox('video_service', array('youtube' => 'YouTube', 'vimeo' => 'Vimeo', 'other' => 'Other'), '-- Select A Service --') ?><br/><br/>

			<div class="video-url"<?php echo('other' != $this->post->_video_service || empty($this->post->_video_url) ? 'style="display: none;"' : '') ?>>
				<?php $this->label('Video URL') ?><br/>
				<?php $this->text('video_url', 'medium') ?><br/><br/>
			</div>

			<div class="video-id"<?php echo('other' === $this->post->_video_service && !empty($this->post->_video_url) ? 'style="display: none;"' : '') ?>>
				<?php $this->label('Video ID') ?><br/>
				<?php $this->text('video_id', 'medium') ?><br/><br/>
			</div>

			<?php $this->label('Video Width') ?><br/>
			<?php $this->number('video_width', 'tiny') ?><br/><br/>

			<?php $this->label('Video Height') ?><br/>
			<?php $this->number('video_height', 'tiny') ?><br/><br/>
			
			<script>
				jQuery("#tmf-video-information-video-service").on('change', function() {
					let selectedOption = jQuery(this).children('option:selected').val();

					if('other' === selectedOption) {
						jQuery('.video-url').show();
						jQuery('.video-id').hide();
					} else{
						jQuery('.video-url').hide();
						jQuery('.video-id').show();
					}
				});
			</script>
		<?php
	}

}
