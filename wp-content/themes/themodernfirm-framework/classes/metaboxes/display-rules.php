<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for Display Rules
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_DisplayRules extends TMF_Metabox {

	protected $metabox_name		= 'display_rules';
	protected $metabox_title	= 'Display Rules';

	public function before_save () {

		// convert linebreaked rules to an array before saving
		$rules = explode("\r\n", str_replace(' ', '', $this->post_data(TRUE)->_display_rules));

		// save rules array
		update_post_meta($this->post_id, '_display_rules', $rules);
	}

	public function all_pages () {
		global $wpdb, $wp_option;
		$list = array();
		$front_page_id = $wp_option->page_on_front;

		$post_types = get_post_types(array('public' => TRUE, '_builtin' => FALSE), 'object'); 
		$posts		= $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_status IN ('upcoming-event', 'publish') AND post_type NOT IN ('nav_menu_item', 'module') ORDER BY post_type,post_title ASC");

		$list['{home}'] = 'Home Page';

		foreach ($post_types as $type):
			$path = '/' . $type->rewrite['slug'] . '/';
			$list[$path] = 'Archive -- ' . TMF_Text::limit_chars($type->labels->name, 30);
		endforeach;

		foreach ($posts as $post):

			if ($post->ID !== $front_page_id):
				$path = '/' .str_replace($wp_option->siteurl . '/','', get_permalink($post));
				$list[$path] = TMF_Text::pretty($post->post_type) . ' -- ' . TMF_Text::limit_chars($post->post_title, 30);
			endif;

		endforeach;

		return $list;
	}

	public function render () {
		?>
			<div id="add-new-rule">
				<h4 class="title">Add New Rule</h4>
				<select id="rule-page" class="combobox">
					<option>-- Select A Page --</option>
					<?php foreach ($this->all_pages() as $uri => $post): ?>
						<option value="<?php echo $uri ?>"><?php echo $post ?></option>
					<?php endforeach ?>
				</select><br/><br/>
				<input type="radio" id="rules-this-page-only" class="ruletype" name="ruletype" checked="checked" value="1"/>&nbsp;&nbsp;<label for="rules-this-page-only">This page only</label><br/>
				<input type="radio" id="rules-childern" class="ruletype" name="ruletype" value="2"/>&nbsp;&nbsp;<label for="rules-childern">Decendants only</label><br/>
				<input type="radio" id="rules-this-and-children" class="ruletype" name="ruletype" value="3" />&nbsp;&nbsp;<label for="rules-this-and-children">This page including all decendants</label>
				<br/><br/>
				<input id="add-rule" value="Add Rule" type="button" class="green-button button-primary"/>

			</div>

			<div id="rules-container">
				<h4 class="title">Current Rules</h4>
				<textarea id="tmf-display-rules-display-rules" name="TMF_x[display_rules][_display_rules]" class="medium"><?php
					if (is_array($rules = get_post_meta($this->post->ID, '_display_rules', TRUE))):
						$count = 0;
						foreach ($rules as $rule):
							if (!$count)
								echo "\r\n";
							echo $rule;
						endforeach;
					endif;
				?></textarea>
				<input type="radio" id="rule-radio-hide" name="TMF[display_rules][_display_rules_mode]" <?php if ($this->post->_display_rules_mode !== 'show') echo 'checked="checked"'; ?> value="hide" /> <label for="rule-radio-hide">Hide</label>&nbsp;&nbsp;
				<input type="radio" id="rule-radio-show" name="TMF[display_rules][_display_rules_mode]" <?php if ($this->post->_display_rules_mode == 'show') echo 'checked="checked"'; ?> value="show" /> <label for="rule-radio-show">Show</label>&nbsp;&nbsp;
				<span style="vertical-align: middle"> module on matching rule</span><br/><br/>
				<p class="description">
					Use line breaks to separate rules. Only use relative URI paths. <br/>
					Use {HOME} to target the home page. Use {DESCENDANTS} to target all decendants. 
				</p>
			</div>

			<script>
				jQuery(document).ready(function($) {
					$('#add-rule').on('click', function(){
						var page = $('#rule-page').val(),
							first_page = page;
							rule_type = $("input:radio[name='ruletype']:checked").val(),
							current_rules = $('#tmf-display-rules-display-rules').val();

						if (page != '-- Select A Page --') {
								
							if (page == '{HOME}')
								rule_type = '1';	

							if (current_rules !== '')
								var first_page = '\r\n' + page;

							switch (rule_type) {

								case '1':
									$('#tmf-display-rules-display-rules').val(current_rules + first_page);
									break;
								case '2':
									$('#tmf-display-rules-display-rules').val(current_rules + first_page + '{DESCENDANTS}');
									break;
								case '3':
									$('#tmf-display-rules-display-rules').val(current_rules + first_page + "\r\n" + page + '{DESCENDANTS}');
									break;

							}
							$('#add-new-rule input.ui-combobox-input, #rule-page').val("-- Select A Page --");

						}
					});
				});
			</script>

		<?php
	}

}
