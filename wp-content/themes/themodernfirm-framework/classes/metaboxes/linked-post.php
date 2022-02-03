<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for Linked Post
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_LinkedPost extends TMF_Metabox {

	protected $metabox_name;
	protected $metbox_name_short;
	protected $metabox_title;
	protected $linked_post;
	protected $linked_title;

	public function __construct ($post_type, $context = NULL , $priority = NULL, $linked_post, $title) {

		$this->metabox_name = TMF_Text::underscores($post_type) . '_linked_post_' . TMF_Text::underscores($linked_post);
		$this->metabox_name_short = 'linked_post_' . TMF_Text::underscores($linked_post);

		$this->metabox_title = $title;
		$this->linked_post = $linked_post;
		$this->linked_title = $title;

		parent::__construct($post_type, $context, $priority);

	}

	public function before_save (){
		global $wp_option;
		$data = $this->post_data(TRUE);

		// We need to grab the old data
		$old_data = get_post_meta($this->post_id, '_' . $this->metabox_name_short, TRUE);


		// If data was provided for this linked post
		if (isset($data->items) && is_array($data->items)):
			foreach ($data->items as $key => $post):

				$found = FALSE;
				$cross_post_meta_array = array();

				// get posts metadata to update it's meta in addition to the current post 
				$cross_post_meta = get_post_meta($post, '_linked_post_' . TMF_Text::underscores($this->post_type), TRUE);

				if (is_array($cross_post_meta)):
					foreach ($cross_post_meta as $cross_key => $linked):
						if ($linked == $this->post_id)
							$found = TRUE;
					endforeach;
				else:
					$found = FALSE;
				endif;

				// If the cross post doesn't already have this in its array, add it to the end.
				if (!$found):
					if(is_array($cross_post_meta)) {
						$cross_post_meta_array = $cross_post_meta;
					} else {
						$cross_post_meta_array[] = $cross_post_meta;
					}
					$cross_post_meta_array[] = (string) $this->post_id;
					update_post_meta($post, '_linked_post_' . TMF_Text::underscores($this->post_type), $cross_post_meta_array);
				endif;
			endforeach;

			// save array
			update_post_meta($this->post_id, '_' . $this->metabox_name_short, $data->items);
		
		// No data was provided so we clear it.
		else:
			$data->items = array();
			delete_post_meta($this->post_id, '_' . $this->metabox_name_short);
		endif;

		// old data was found.
		if (is_array($old_data)):
			$deleted = array_diff($old_data, $data->items);
		endif;


		if (is_array($deleted)):
			foreach ($deleted as $deleted_post):
				$remove_from = get_post_meta($deleted_post, '_linked_post_' . TMF_Text::underscores($this->post_type), TRUE);
				$new_data = array();
				foreach ($remove_from as $add):
					if ((int)$add !== (int)$this->post_id):
						$new_data[] = $add;
					endif;
				endforeach;

				if (empty($new_data)):
						delete_post_meta($deleted_post, '_linked_post_' . TMF_Text::underscores($this->post_type));
				else:
					update_post_meta($deleted_post, '_linked_post_' . TMF_Text::underscores($this->post_type), $new_data);
				endif;

			endforeach;
		endif;
	}

	public function get_posts () {
		$posts = get_posts(array('post_type' => $this->linked_post, 'numberposts' => -1));
		$return = array();	

		foreach ($posts as $post):
			$return[$post->ID] = TMF_Text::limit_chars($post->post_title, 30);
		endforeach;

		return $return;

	}

	public function render () {
		?>
			<select class="combobox-tags">
				<option value="">-- Select <?php echo $this->linked_title ?> --</option>
				<?php 
					foreach($this->get_posts() as $id => $post):
						echo '<option value="'. $id .'">'. $post .'</option>';
					endforeach;
				?>
			</select>

			<div class="tags-container" data-object-name="TMF_x[<?php echo $this->metabox_name ?>][items]">
				<?php if (is_array($linked = get_post_meta($this->post->ID, '_' . $this->metabox_name_short, TRUE))):
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
