<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for Modern Slider General Settings
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_ModernSliderGeneralSettings extends TMF_Metabox {

	protected $metabox_name		= 'modern_slider_general_settings';
	protected $metabox_title	= 'General Settings';

	public function before_save() {
		$post_data = $this->post_data(TRUE);

		update_post_meta($this->post_id, '_modern_slider_general_settings', $post_data);
	}

	public function render() {
		global $post;

		$meta_box = get_post_meta($post->ID, '_modern_slider_general_settings', true);
		?>
			<?php $this->label('Assign Slider to Area') ?>
			<?php $this->combobox('slider_area', TMF_ModernSlider::get_registered_areas(), '-- Select Area --') ?><br/><br/>

			<div style="padding-bottom: 5px"></div>
			<?php $this->checkbox('random', FALSE) ?>
			<?php $this->label('Show Random image', 'random') ?><br/>
			<em>Check this if you want to show random image on page load instead of slider</em>

			<div class="modernslider-field">
				<?php $this->label('Slideshow Speed', 'speed') ?><br/>
				<?php $this->number('slide_speed', NULL, $meta_box->_slide_speed, 1, 1, TRUE) ?><br/>
				<em>Sets the amount of time between each slideshow interval, in milliseconds.</em>
			</div>

			<div class="modernslider-field">
				<?php $this->label('Animation Speed', 'speed') ?><br/>
				<?php $this->number('animation_speed', NULL, $meta_box->_animation_speed, 1, 1, TRUE) ?><br/>
				<em>Sets the duration in which animations will happen, in milliseconds.</em>
			</div>

			<div style="padding-bottom: 15px"></div>
			<div class="modernslider-field">
				<?php $this->label('Slide Type') ?>
				<?php $this->combobox('animation', array('slide' => 'Slide', 'fade' => 'Fade'), '-- Select Slide Type --', $meta_box->_animation, NULL, TRUE) ?>
			</div>
			<div class="modernslider-field">

				<?php $this->label('Slide Direction') ?>
				<?php $this->combobox('direction', array('horizontal' => 'Horizontal', 'vertical' => 'Vertical'), '-- Select Slide Type --', $meta_box->_direction, NULL, TRUE) ?>
			</div>
			<div class="modernslider-field">

				<?php
					// add if checked
					if ($meta_box->_show_arrows == "true"):
						$arrows = 'checked="checked"';
					endif;
				?>

				<?php $this->label('Show Next/Prev Arrows', 'random') ?>
				<input type="checkbox" value="true" name="TMF_x[modern_slider_general_settings][_show_arrows]" <?php echo $arrows ?> />
				<label class="force_inline">Enable</label><br/>
				<em>Check this if you want to show next/previous nagivation arrows</em>

			</div>
			<div class="modernslider-field">

				<?php
					// add if checked
					if ($meta_box->_show_paging == "true"):
						$paging = 'checked="checked"';
					endif;
				?>

				<?php $this->label('Show Paging', 'random') ?>
				<input type="checkbox" value="true" name="TMF_x[modern_slider_general_settings][_show_paging]" <?php echo $paging ?> />
				<label class="force_inline">Enable</label><br/>
				<em>Create navigation for paging control of each slide</em>

			</div>
		<?php
	}

}
