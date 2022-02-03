<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for Featured Images
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_FeaturedImages extends TMF_Metabox {

	protected $metabox_name		= 'featured_images';
	protected $metabox_title	= 'Featured Images';

	public function before_save () {
		$post				= $this->post_data();
		$primary_image_id	= $post->_primary_image;
		$thumbnail_image_id = $post->_thumbnail_image;

		// If a new primary image was selected, generate correct size.
		if (!empty($primary_image_id) && $primary_image_id != $this->post->_primary_image):
			$this->create_image($primary_image_id, 'primary', $post);
		endif;

		// If a new thumbnail image was selected, generate correct size.
		if (!empty($thumbnail_image_id) && $thumbnail_image_id != $this->post->_primary_image):
			$this->create_image($thumbnail_image_id, 'thumbnail', $post);
		endif;
	}

	public function create_image ($image_id, $type = 'primary', $post) {
		global $tmf_option;

		$width	= $tmf_option->{$this->post_type . '_image_size_'. $type .'_width'} ? $tmf_option->{$this->post_type . '_image_size_'. $type .'_width'} : 500;
		$height = $tmf_option->{$this->post_type . '_image_size_'. $type .'_height'} ? $tmf_option->{$this->post_type . '_image_size_'. $type .'_height'} : 500;
		$crop	= ($tmf_option->{$this->post_type . '_image_size_'. $type .'_crop'} == 1) ? TRUE : FALSE;

		$image_path = _load_image_to_edit_path($image_id);
		$path_info  = pathinfo($image_path);
		$image		= wp_get_image_editor($image_path);
		$directory	= ($type == 'primary') ? PRIMARY_IMAGES_PATH : THUMBNAIL_IMAGES_PATH;

		if (is_wp_error($image))
			return false;

		$path_info['extension'] = strtolower($path_info['extension']);

		if ($path_info['extension'] == 'jpeg')
			$path_info['extension'] = 'jpg';


		$mime = ($path_info['extension'] == 'png') ? 'image/png' : 'image/jpeg';

		$image->resize($width, $height, $crop);
		$image->set_quality(80);
		$image->save(UPLOADS_PATH . $directory . $image_id . '-'. $this->post_id .'.' . $path_info['extension'], $mime);

		$this->update_post_data($type . '_image_type', $path_info['extension']);
	}


	public function render() {
		?>
			<p class="description" style="margin-top: 10px">
				Featured Images must be in the JPEG or PNG format.
			</p>
			<h4 class="title">Primary Image</h4>
			<table class="tmf-metabox">
				<tr>
					<td>
						<div>
							<img id="primary-preview" class="image-preview" src="<?php echo wp_get_attachment_url($this->post->_primary_image) ?>" style="margin: 0 0 20px 0; <?php if (!$this->post->_primary_image) echo 'display: none; '?>" />
						</div>
						<input id="tmf-metabox-featured-images-primary" type="hidden" name="TMF[featured_images][_primary_image]" value="<?php echo $this->post->_primary_image ?>" />
						<input value="Upload Image" type="button" class="uploader-button button-primary" data-preview="primary-preview" data-destination="tmf-metabox-featured-images-primary" data-panel-title="Upload or Choose an Image" data-button-text="Select Image" data-types="jpg,jpeg,png"/>
						<input value="Remove Image" type="button" class="button uploader-remove remove" data-preview="primary-preview" data-destination="tmf-metabox-featured-images-primary" <?php if (!$this->post->_primary_image) echo 'style="display:none"'?> />
					</td>
				</tr>
			</table>

			<h4 class="title">Thumbnail Image</h4>
			<table class="tmf-metabox">
				<tr>
					<td>
						<div>
							<img id="thumbnail-preview" class="image-preview" src="<?php echo wp_get_attachment_url($this->post->_thumbnail_image) ?>" style="margin: 0 0 20px 0; <?php if (!$this->post->_thumbnail_image) echo 'display: none; '?>" />
						</div>
						<input id="tmf-metabox-featured-images-thumbnail" type="hidden" name="TMF[featured_images][_thumbnail_image]" value="<?php echo $this->post->_thumbnail_image ?>" />
						<input value="Upload Image" type="button" class="uploader-button button-primary" data-preview="thumbnail-preview" data-destination="tmf-metabox-featured-images-thumbnail" data-panel-title="Upload or Choose an Image" data-button-text="Select Image" data-types="jpg,jpeg,png"/>
						<input value="Remove Image" type="button" class="button uploader-remove remove" data-preview="thumbnail-preview" data-destination="tmf-metabox-featured-images-thumbnail" <?php if (!$this->post->_thumbnail_image) echo 'style="display:none"'?> />
					</td>
				</tr>
			</table>
			
		<?php
	}

}
