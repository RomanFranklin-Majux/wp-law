<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for contributors to a post
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_Contributors extends TMF_Metabox {

	protected $metabox_name		= 'contributors';
	protected $metabox_title	= 'Contributors';

	public function before_save (){
		global $wp_option;
		$data = $this->post_data(TRUE);

		if (isset($data->items) && is_array($data->items)):	
			update_post_meta($this->post_id, '_contributors' , $data->items);
		else:
			delete_post_meta($this->post_id, '_contributors');
		endif;

		
	}

	public function get_people () {
		$posts = get_posts(array('post_type' => array('attorney', 'staff'), 'numberposts' => -1));
		$return = array();	

		foreach ($posts as $post):
			$return[$post->ID] = TMF_Text::limit_chars($post->post_title, 30);
		endforeach;

		return $return;

	}

	public function render () {
		?>
			<select class="combobox-tags">
				<option value="">-- Select Contributor --</option>
				<?php 
					foreach($this->get_people() as $id => $post):
						echo '<option value="'. $id .'">'. $post .'</option>';
					endforeach;
				?>
			</select>

			<div class="tags-container" data-object-name="TMF_x[<?php echo $this->metabox_name ?>][items]">
				<?php if (is_array($linked = get_post_meta($this->post->ID, '_contributors', TRUE))):
						$count = 1; 
						foreach($linked as $post):?>
						<div class="tag" data-object-id="<?php echo $post ?>">
							<input type="hidden" name="TMF_x[<?php echo $this->metabox_name ?>][items][<?php echo $count ?>]" value="<?php echo $post ?>"/>
							<span class="name"><?php echo get_the_title($post) ?></span>
							<span class="delete">X</span>
						</div>
				<?php $count++ ?>
				<?php endforeach; 
					endif;
				?>
			</div>
		<?php
	}

}
