<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for Modern Slider
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_ModernSlides extends TMF_Metabox {

	protected $metabox_name		= 'modern_slides';
	protected $metabox_title	= 'Slides';

	public function render() {
		global $post;
		?>
		<div class="tmf-slide-actions">
			<button type="button" id="tmf-add-slide" class="tmf-add-slide">Add Slide</button>
			<button type="button" id="tmf-multiple-slides" class="tmf-multiple-slides">Add Images as Slides</button>
			<!--<button type="button" id="tmf-sort" class="tmf-sort">Sort</button>-->
		</div>
		<div id="tmf-sortables" class="tmf-sortables active" data-post-id="<?php echo $post->ID; ?>">
		<?php
			if( $slides = get_post_meta($post->ID, '_modernslider_metas', true) ):
				foreach ($slides as $i => $slide) {
					$image_url = TMF_ModernSlider::get_slide_img_thumb($slide['id']);

		            $box_title = 'Slide '.($i+1);
		            if( '' != trim($slide['title']) and 'image' == $slide['type'] ){
		                $box_title = $box_title. ' - '.$slide['title'];
		            }
		            if( '1' == $slide['hidden'] ){
		                $box_title = $box_title. ' - '.'[Hidden]';
		            }
		            
		            $vars = array();
		            $vars['i'] = $i;
		            $vars['slider'] = $slider;
		            $vars['slide'] = $slide;
		            $vars['image_url'] = $image_url;
		            $vars['full_image_url'] = wp_get_attachment_url($slide['id']);
		            $vars['box_title'] = $box_title;

					TMF_ModernSlider::edit_template($slide, $i, $vars);
				}
			endif;
		?>
		</div>
		<?php
	}

}
