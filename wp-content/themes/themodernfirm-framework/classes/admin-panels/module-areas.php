<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_AdminPanel_ModuleAreas extends TMF_AdminPanel {

	protected $name				= 'Module Areas';
	protected $menu_title		= 'Module Areas';
	protected $parent_slug		= 'edit.php?post_type=module';

	public function before_save () {
		$data = $this->post_data(TRUE);

		foreach ($data as $key => $area):
			unset($data->{$key}[0]);

			TMF_Option::factory()->set($key, $data->{$key});
		endforeach;

	}

	public function get_modules () {
		$posts = get_posts(array('post_type' => 'module', 'numberposts' => -1, 'orderby' => 'ID', 'order' => ''));
		$return = array();

		foreach ($posts as $post):
			$return[$post->ID] = TMF_Text::limit_chars($post->post_title, 30);
		endforeach;

		return $return;
	}

	public function render() {
		global $tmf_option;
	?>
		<?php foreach (TMF_Module::get_registered_areas(FALSE) as $slug => $title): ?>
			<input type="hidden" name="TMF_x[module_areas][tmf_module_area_<?php echo TMF_Text::underscores($slug) ?>][]" value=""/>

			<br/>
			<h3 class="title" style="margin-bottom: 0;"><?php echo $title ?></h3>
			<table class="form-table indent">
				<tr>
					<td>

						<select class="combobox-tags">
							<option value="">-- Select Module --</option>
							<?php
								foreach($this->get_modules() as $id => $module):
									echo '<option value="'. $id .'">'. $id . ' -- ' .$module .'</option>';
								endforeach;
							?>
						</select>
						<div class="tags-container tags-box" data-object-name="TMF_x[module_areas][tmf_module_area_<?php echo TMF_Text::underscores($slug) ?>]">
							<?php
								$count = 1;
								$get_options = $tmf_option->{'module_area_' . TMF_Text::underscores($slug)};

								if (isset($get_options) && is_array($get_options)):
								foreach ($get_options as $module_for_area): ?>
								<div class="attorney tag" data-object-id="<?php echo $module_for_area ?>">
									<input type="hidden" name="TMF_x[module_areas][tmf_module_area_<?php echo TMF_Text::underscores($slug) ?>][<?php echo $count ?>]" value="<?php echo $module_for_area ?>"/>
									<span class="name"><a href="/wp-admin/post.php?post=<?php echo $module_for_area ?>&action=edit" target="_blank"><?php echo $module_for_area ?> – <?php echo get_the_title($module_for_area) ?></a></span>
									<span class="delete">X</span>
								</div>
							<?php $count++; endforeach; endif; ?>
						</div>
					</td>
				</tr>
			</table>
		<?php endforeach ?>
	<?php
	}

}
