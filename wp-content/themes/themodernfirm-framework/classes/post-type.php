<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Base class used to generate Post Types.
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
abstract class TMF_PostType {


	static $loaded_types = array();

	public $columns	= array();

	public $taxonomy = array();

	public $linked_post_types = array();

	public $shortcode_options = array();

	/**
	 * @var  array   holds the help panels for this post type
	 */
	private $help_panels = array();


	/**
	 * @var  array   default options for all post types
	 */
	private $default_options = array(
		'slug'					=> '',
		'singular'				=> '',
		'plural'				=> '',
		'menu_name'				=> '',
		'description'			=> '',
		'hierarchical'			=> FALSE,
		'has_shortcode'			=> TRUE,
		'has_archive'			=> FALSE,
		'public'				=> TRUE,
		'show_ui'				=> TRUE,
		'show_in_nav_menus'		=> TRUE,
		'show_in_menu'			=> TRUE,
		'show_in_admin_bar'		=> TRUE,
		'menu_position'			=> 40,
		'hide_post_status'		=> FALSE,
		'bulk_actions'			=> TRUE,
		'has_seo'				=> TRUE,
		'default_columns'		=> TRUE,
		'with_front'			=> TRUE,
		'publicly_queryable'	=> TRUE,
		'show_in_rest'			=> FALSE,
		'supports'				=> array('title', 'revisions', 'editor'),
		'show_thumbnail_in_table' => TRUE,
		'menu_icon'				=> 'dashicons-admin-post'
	);


	/**
	 * Sets the options for the post type and sets the WP actions and filters
	 *
	 * @return  void
	 */
	public function __construct() {
		global $tmf_option;

		// merge options with defaults
		$this->options = wp_parse_args($this->options, $this->default_options);

		self::$loaded_types[strtolower($this->post_type)] = $this; 

		// Check if enabled.
		if (!empty($tmf_option->{'post_type_' . str_replace('-','_', strtolower($this->post_type))})):

			// Load post type labels from DB
			// set post_type labels from database
			$post_type_options = $tmf_option->post_type_options;
			if(!empty($post_type_options) && is_array($post_type_options)) {
				if($post_type_options[ TMF_Text::underscores($this->post_type) ]) {
					foreach($post_type_options[ TMF_Text::underscores($this->post_type) ] as $key => $value) {
						if(is_bool($value) || '1' == $value || '0' == $value || 'false' == $value || 'true' == $value) {
							$this->options[$key] = (bool) intval($value);
						} else if('supports' == $key) {
							if(is_array($value)) {
								$this->options[$key] = self::recursive_sanitize_text_field($value);
							} else {
								$this->options[$key] = self::recursive_sanitize_text_field( explode(',', $value) );
							}
						} else {
							$this->options[$key] = self::recursive_sanitize_text_field($value);
						}
					}
				}
			}

			// set taxonomy labels from database
			$taxonomy_options = $tmf_option->taxonomy_options;
			if(!empty($taxonomy_options) && is_array($taxonomy_options)) {
				foreach($this->taxonomy as $tax => $data) {
					if($taxonomy_options[ TMF_Text::underscores($tax) ]) {
						foreach($taxonomy_options[ TMF_Text::underscores($tax) ] as $key => $value) {
							if(is_bool($value) || '1' == $value || '0' == $value || 'false' == $value || 'true' == $value) {
								$this->taxonomy[$tax][$key] = (bool) intval($value);
							} else {
								$this->taxonomy[$tax][$key] = self::recursive_sanitize_text_field($value);
							}
						}
					}
				}
			}

			// make sure post type suports the slug then overwrite default slug if one was set in the site options
			if (isset($this->options['has_archive']) && $this->options['has_archive'] == '1'  && $tmf_option->{'post_type_' . str_replace('-','_',$this->post_type) . '_slug'})
				$this->options['slug'] = $tmf_option->{'post_type_' . str_replace('-','_',$this->post_type) . '_slug'};

			// enable gutenberg if it was enabled in the site options
			if( $tmf_option->{'post_type_' . str_replace('-','_',$this->post_type) . '_gutenberg'} )
				$this->options['show_in_rest'] = TRUE;

			add_action('init', array($this, 'register_post_type'));
			add_action('init', array($this, 'register_taxonomy')); 
			add_action('admin_head', array($this, 'add_help_tabs'));
			add_action('manage_'. $this->post_type .'_posts_custom_column', array($this, 'output_columns'), 10, 2);
			add_filter('enter_title_here', array($this, 'change_default_title'));
			add_filter('manage_edit-'. $this->post_type .'_columns', array($this, 'register_columns'));
			add_filter('manage_edit-'. $this->post_type .'_sortable_columns', array($this, 'sortable_columns'));
			add_filter('post_updated_messages', array($this, 'update_messages'));
			add_action('admin_head-edit.php', array($this, 'hide_post_status'));
			add_action('admin_head-post.php', array($this, 'hide_post_status'));
			add_action('admin_head-post-new.php', array($this, 'hide_post_status'));
			add_filter('bulk_actions-edit-' . $this->post_type, array($this, 'bulk_actions'));
		endif;
	}

	/**
	 * Recursive sanitation for an array
	 * 
	 * @param $array
	 *
	 * @return mixed
	 */
	public static function recursive_sanitize_text_field($array) {
		return $array;
		if(is_array($array)) {
			foreach ( $array as $key => &$value ) {
				if ( is_array( $value ) ) {
					$value = $this->recursive_sanitize_text_field($value);
				}
				else {
					$value = sanitize_text_field( $value );
				}
			}
		} else {
			$array = sanitize_text_field( $array );
		}
	
		return $array;
	}


	/**
	 * Sets the options for the post type and sets the WP actions and filters
	 *
	 * @param	string   $taxonomy   name of taxonomy to create labels for
	 * @return  array
	 */
	public function taxonomy_labels($taxonomy) {
		return  array(
			'name'                         => ucwords($this->taxonomy[$taxonomy]['plural']),
			'singular_name'                => ucwords($this->taxonomy[$taxonomy]['singular']),
			'search_items'                 => 'Search ' . ucwords($this->taxonomy[$taxonomy]['plural']),
			'popular_items'                => 'Popular ' . ucwords($this->taxonomy[$taxonomy]['plural']),
			'all_items'                    => 'All '. ucwords($this->taxonomy[$taxonomy]['plural']),
			'parent_item'                  => 'Parent '. ucwords($this->taxonomy[$taxonomy]['singular']),
			'parent_item_colon'            => 'Parent '. ucwords($this->taxonomy[$taxonomy]['singular']) .':',
			'edit_item'                    => 'Edit ' . ucwords($this->taxonomy[$taxonomy]['singular']),
			'update_item'                  => 'Update '. ucwords($this->taxonomy[$taxonomy]['singular']),
			'add_new_item'                 => 'Add New ' . ucwords($this->taxonomy[$taxonomy]['singular']),
			'new_item_name'                => 'New '. ucwords($this->taxonomy[$taxonomy]['singular']) . ' Name',
			'separate_items_with_commas'   => 'Separate '. $this->taxonomy[$taxonomy]['plural'] .' with commas',
			'add_or_remove_items'          => 'Add or remove '. $this->taxonomy[$taxonomy]['plural'],
			'choose_from_most_used'        => 'Choose from the most used ' . $this->taxonomy[$taxonomy]['plural'],
			'not_found'                    => 'No '. $this->taxonomy[$taxonomy]['plural'] .' found.',
			'menu_name'                    => $this->taxonomy[$taxonomy]['menu_name']
		);
	}


	/**
	 * Various labels to be used for the custom post type
	 *
	 * @return  array
	 */
	public function post_type_labels() {
		return array(
			'name'               => ucwords($this->options['plural']),
			'singular_name'      => ucwords($this->options['singular']),
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add New ' . ucwords($this->options['singular']),
			'edit_item'          => 'Edit ' . ucwords($this->options['singular']),
			'new_item'           => 'New ' . ucwords($this->options['singular']),
			'all_items'          => 'All ' . ucwords($this->options['plural']),
			'view_item'          => 'View ' . ucwords($this->options['singular']),
			'search_items'       => 'Search ' . ucwords($this->options['plural']),
			'not_found'          => 'No '. $this->options['plural'] .' found',
			'not_found_in_trash' => 'No ' . $this->options['plural'] . ' found in Trash', 
			'parent_item_colon'  => '',
			'menu_name'          => $this->options['menu_name']
		);
	}


	/**
	 * Default help panels for the post editor page
	 *
	 * @return  void
	 */
	public function help_post() {
		$this->help_panels[] = array(
			'id'			=> 'help-customizing', 
			'title'			=> 'Customizing Display',
			'content'		=> '<p>The '. $this->options['singular'] .' name field is fixed in place, but you can reposition all the other boxes using drag and drop. You can also minimize or expand them by clicking the title bar of each box. Use the Screen Options tab to hide and show boxes or to choose a 1- or 2-column layout for this screen.</p>',
		);
	}


	/**
	 * Default help panels for the post table page
	 *
	 * @return  void
	 */
	public function help_table() {		
		$this->help_panels[] = array(
			'id'			=> 'help-screen-content', 
			'title'			=> 'Screen Content',
			'content'		=> '<p>You can customize the display of this screen’s contents in a number of ways:</p><ul>
								<li>You can hide/display columns based on your needs and decide how many '. $this->options['plural'] .' to list per screen using the Screen Options tab.</li>
								<li>You can filter the list of '. $this->options['plural'] .' by status using the text links in the upper left to show All, Published, Draft, or Trashed '. $this->options['plural'] .'. The default view is to show all '. $this->options['plural'] .'.</li>
								<li>You can refine the list to show only '. $this->options['plural'] .' created in specific month by using the dropdown menus above the '. $this->options['plural'] .' list. Click the Filter button after making your selection.</li></ul>',
		);

		$this->help_panels[] = array(
			'id'			=> 'help-available-actions', 
			'title'			=> 'Available Actions',
			'content'		=> '<p>Hovering over a row in the '. $this->options['plural'] .' list will display action links that allow you to manage your '. $this->options['plural'] .'. You can perform the following actions:</p><ul>
								<li><b>Edit</b> - takes you to the editing screen for that '. $this->options['singular'] .'. You can also reach that screen by clicking on the '. $this->options['singular'] .' name.</li>
								<li><b>Quick Edit</b> - provides inline access to the metadata of your '. $this->options['plural'] .', allowing you to update '. $this->options['plural'] .' details without leaving this screen.</li>
								<li><b>Trash</b> - removes your '. $this->options['plural'] .' from this list and places it in the trash, from which you can permanently delete it.</li>
								<li><b>Preview</b> - will show you what your draft '. $this->options['singular'] .' will look like if you publish it. View will take you to your live site to view the '. $this->options['singular'] .'. Which link is available depends on your '. $this->options['plural'] .' status.</li></ul>',
		);

		$this->help_panels[] = array(
			'id'			=> 'help-bulk-actions', 
			'title'			=> 'Bulk Actions',
			'content'		=> '<p>You can also edit or move multiple '. $this->options['plural'] .' to the trash at once. Select the '. $this->options['plural'] .' you want to act on using the checkboxes, then select the action you want to take from the Bulk Actions menu and click Apply.</p><p>
									When using Bulk Edit, you can change the metadata for all selected '. $this->options['plural'] .' at once. To remove a '. $this->options['singular'] .' from the grouping, just click the x next to its name in the Bulk Edit area that appears.</p>',
		);
	}


	/**
	 * Various messages to be used for this custom post type
	 *
	 * @param	array   $messages   messages used for WP custom post types
	 * @return  array
	 */
	public function update_messages($messages) {
	  global $post, $post_ID;

		$messages[$this->post_type] = array(
			0 => '', // Unused.
			1 => sprintf(ucwords($this->options['singular']). ' updated. <a href="%s">View '. $this->options['singular'] .'</a>', esc_url(get_permalink($post_ID))),
			2 => 'Custom field updated.',
			3 => 'Custom field deleted.',
			4 => ucwords($this->options['singular']) . ' updated.',
			5 => isset($_GET['revision']) ? sprintf(ucwords($this->options['singular']) .' restored to revision from %s', wp_post_revision_title((int) $_GET['revision'], FALSE )) : FALSE,
			6 => sprintf(ucwords($this->options['singular']) . ' published. <a href="%s">View '. $this->options['singular'] .'</a>', esc_url(get_permalink($post_ID))),
			7 => ucwords($this->options['singular']) . ' saved.',
			8 => sprintf(ucwords($this->options['singular']) .' submitted. <a target="_blank" href="%s">Preview '. $this->options['singular'] .'</a>', esc_url( add_query_arg( 'preview', 'TRUE', get_permalink($post_ID) ) ) ),
			9 => sprintf(ucwords($this->options['singular']). ' scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview '. $this->options['singular'] .'</a>', date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
			10 => sprintf(ucwords($this->options['singular']). ' draft updated. <a target="_blank" href="%s">Preview '. $this->options['singular'] .'</a>', esc_url( add_query_arg( 'preview', 'TRUE', get_permalink($post_ID) ) ) ),
		);

	  return $messages;
	}


	/**
	 * Adds the help panels to the correct WP screens.
	 *
	 * @return  void
	 */
	public function add_help_tabs() {
		$screen = get_current_screen();

		if ($screen->base == 'edit' && $screen->post_type == $this->post_type)
			$this->help_table();

		elseif ($screen->base == 'post' && $screen->post_type == $this->post_type)
			$this->help_post();

		foreach ($this->help_panels as $help_panel):
			$screen->add_help_tab($help_panel);
		endforeach;

	}


	/**
	 * Hides the post status dropdown from edit pages.
	 *
	 * @return  void
	 */
	public function hide_post_status() {
		global $post;

		if ($this->options['hide_post_status'] && isset($post->post_type) && $post->post_type == $this->post_type)
			echo '<style type="text/css">#misc-publishing-actions .misc-pub-section:first-child, .misc-pub-section.curtime, .inline-edit-status { display:none !important }</style>';

	}


	/**
	 * Hides or shows the bulk actions for this post type
	 *
	 * @param	array   $actions   bulk actions for this post type
	 * @return  void
	 */
	public function bulk_actions($actions) {
		return $this->options['bulk_actions'] ? $actions : array();
	}


	/**
	 * Registers all the metaboxes that are associated with 
	 * this custom post type.
	 *
	 * @return  void
	 */
	public function register_metaboxes() {
		global $tmf_option;
		if ($this->metaboxes):
			foreach($this->metaboxes as $key => $metabox):

				if (isset($metabox['dependent'])):
					if (empty($tmf_option->{'post_type_' . $metabox['dependent']})):
						continue;
					endif;
				endif;

				$class_name = FRAMEWORK_PREFIX . '_Metabox_' . str_replace(' ','', ucwords(str_replace('-',' ', $key)));

				TMF_Class::factory('metaboxes/' . $key)->load();

				$context	= isset($metabox['context']) ? $metabox['context'] : NULL;
				$priority	= isset($metabox['priority']) ? $metabox['priority'] : NULL;

				new $class_name($this->post_type, $context, $priority);

			endforeach;
		endif;

		if ($this->linked_post_types):
			foreach($this->linked_post_types as $key => $metabox):
				if (!empty($tmf_option->{'post_type_' . str_replace('-','_', strtolower($key))})):
					$class_name = FRAMEWORK_PREFIX . '_Metabox_LinkedPost';

					TMF_Class::factory('metaboxes/linked-post')->load();

					new $class_name($this->post_type, 'side', NULL, $key, $metabox);
				endif;
			endforeach;
		endif;
	}


	/**
	 * Registers all the taxonomys that are associated with 
	 * this custom post type.
	 *
	 * @return  void
	 */
	public function register_taxonomy() {
		if ($this->taxonomy):
			foreach($this->taxonomy as $key => $taxonomy):

				$args = array(
					'hierarchical'		=> $taxonomy['hierarchical'],
					'labels'			=> $this->taxonomy_labels($key),
					'label'				=> $taxonomy['label'],
					'query_var'			=> TRUE,
					'show_in_nav_menus' => (isset($taxonomy['show_in_nav_menus'])) ? $taxonomy['show_in_nav_menus'] : TRUE,
					'rewrite'			=> array('slug' => $taxonomy['slug'])
				);

				register_taxonomy($key, $this->post_type, $args);

			endforeach;
		endif;
	}


	/**
	 * Registers this custom post type with WP
	 *
	 * @return  void
	 */
	public function register_post_type() {
		$args = array(
			'labels'				=> $this->post_type_labels(),
			'description'			=> $this->options['description'],
			'public'				=> $this->options['public'],
			'menu_position'			=> $this->options['menu_position'],
			'supports'				=> $this->options['supports'],
			'has_archive'			=> $this->options['has_archive'],
			'show_ui'				=> $this->options['show_ui'],
			'show_in_nav_menus'		=> $this->options['show_in_nav_menus'],
			'show_in_menu'			=> $this->options['show_in_menu'],
			'show_in_admin_bar'		=> $this->options['show_in_admin_bar'],
			'show_in_rest'			=> $this->options['show_in_rest'],
			'publicly_queryable'	=> $this->options['publicly_queryable'],
			'hierarchical'			=> $this->options['hierarchical'],
			'menu_icon'				=> $this->options['menu_icon'],
			'query_var'				=> TRUE,
			'rewrite'				=> array(
											'slug'			=> $this->options['slug'],
											'with_front'	=> $this->options['with_front']
										)
		);		
		register_post_type($this->post_type, $args);	

		$this->register_metaboxes();
		$this->register_shortcode();
		$this->register_admin_panels();
	}


	public function register_admin_panels () {
		if (isset($this->admin_panels) && is_array($this->admin_panels)):
			foreach ($this->admin_panels as $admin_panel):
				$class_name = FRAMEWORK_PREFIX . '_AdminPanel_' . str_replace(' ','', ucwords(str_replace('-',' ', $admin_panel)));

				TMF_Class::factory('admin-panels/' . $admin_panel)->load();

				new $class_name();;
			endforeach;
		endif;
	}


	public function register_shortcode () {
		if ($this->options['has_shortcode'] == TRUE):
			new TMF_PostTypeShortcode(str_replace(' ', '-', $this->options['plural']), $this->post_type, $this->shortcode_options);;
		endif;
	}


	/**
	 * Changes the default title placeholder on post edit pages
	 *
	 * @param	string   $title   the placeholder title
	 * @return  void
	 */
	public function change_default_title($title){
		$screen = get_current_screen();

		if ($this->post_type == $screen->post_type)
			$title = 'Enter ' . $this->options['singular'] . ' name here';

		return $title;
	}


	/**
	 * Registers the columns for this custom post type.
	 *
	 * @param	array   $columns   the default columns
	 * @return  array
	 */
	public function register_columns($columns) {

		if ($this->options['show_thumbnail_in_table'] == TRUE):
			$default_columns = array(
				'cb'		=> '<input type="checkbox" />',
				'id'		=> 'ID',
				'thumbnail' => '',
				'title'		=> 'Title'
			);
		else:
			$default_columns = array(
				'cb'		=> '<input type="checkbox" />',
				'id'		=> 'ID',
				'title'		=> 'Title'
			);
		endif;

		$seo_columns = array(
							'wpseo-score'		=> 'SEO',
							'wpseo-title'		=> 'SEO Title',
							'wpseo-metadesc'	=> 'Meta Desc',
							'wpseo-focuskw'		=> 'Focus KW'
						);

		if ($this->options['default_columns'] && $this->options['has_seo'])
			return array_merge($default_columns, $this->columns, $seo_columns);

		if ($this->options['default_columns'])
			return array_merge($default_columns, $this->columns);

		return $this->columns;
	}


	/**
	 * Registers the sortable columns for this custom post type.
	 *
	 * @param	array   $columns   the default columns
	 * @return  array
	 */
	public function sortable_columns($columns) {

		if (!empty($this->sortable_columns) && is_array($this->sortable_columns)):
			foreach ($this->sortable_columns as $column):
				$columns[$column] = $column;
			endforeach;
		endif;
		return $columns;
	}


	/**
	 * Checks for functions to output the content of 
	 * custom post type columns.
	 * 
	 * 	eg. If a column was named 'start_date', this would expect
	 * 	a function named 'column_start_date' in the child class
	 * 	which extended this class.
	 *
	 * @return  void
	 */
	public function output_columns($column_name, $id) {
		$function = 'column_' . $column_name;

		if (method_exists($this, $function))
			echo $this->$function($id);	
	} 


	public function column_id ($id) {
		return $id;
	}


	public function column_thumbnail ($id) {
		global $post;

		if ($post->_thumbnail_image):
			return wp_get_attachment_image($post->_thumbnail_image, 'full');
		elseif ($post->_primary_image):
			return wp_get_attachment_image($post->_primary_image, 'full');
		endif;
	}


	public function column_linked_user () {
		global $post;

		if (isset($post->_linked_user)):
			$user = get_userdata($post->_linked_user);

			return '<a href="/wp-admin/user-edit.php?user_id='. $user->ID .'&action=edit">'. $user->display_name .'</a>';
		endif;
	}


	/**
	 * Checks if the current admin edit.php page is for 
	 * this objects post type
	 *
	 * @return  boolean
	 */
	public function is_current_edit_page() {
		return (isset($_GET['post_type']) && $_GET['post_type'] == $this->post_type);
	}


	public function no_posts_message () {
		return $this->options['no_posts'];
	}

	public static function get_post_type_object ($post_type) {
		return get_post_type_object($post_type);
	}

}
