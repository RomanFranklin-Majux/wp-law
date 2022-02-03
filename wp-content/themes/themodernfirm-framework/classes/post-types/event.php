<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Custom post type to events.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_PostType_Event extends TMF_PostType{


	protected $post_type = 'event';

	protected $is_past_archive = FALSE;
  

	public $options	= array(
		'slug'					=> 'events',
		'singular'				=> 'event',
		'plural'				=> 'events',
		'menu_name'				=> 'Events',
		'description'			=> 'Create and manage events.',
		'no_posts'				=> 'There are currently no upcoming events.',
		'hide_post_status'		=> TRUE,
		'bulk_actions'			=> TRUE,
		'has_archive'			=> TRUE,
		'show_in_nav_menus'		=> FALSE,
		'menu_icon'				=> 'dashicons-calendar'
	);


	public $columns = array(
		'location'		=> 'Location',
		'start_date'	=> 'Start Date',
		'end_date'		=> 'End Date'
	);


	public $sortable_columns = array(
		'start_date', 
		'end_date'
	);


	public $metaboxes = array(
		'excerpt'			=> array('priority' => 'high', 'context' => 'normal'),
		'event-location'	=> array('priority' => 'high', 'context' => 'normal'),
		'event-settings'	=> array('context' => 'side'),
		'rsvp-settings'		=> array('context' => 'side'),
		'featured-images'	=> array('context' => 'side')
	);


	public $taxonomy = array(
		'event-categories'	=> array(
			'slug'				=> 'event-category',
			'label'				=> 'Event Categories',
			'singular'			=> 'event category',
			'plural'			=> 'event categories',
			'menu_name'			=> 'Event Categories',
			'hierarchical'		=> TRUE
		),
		'event-tags' => array(
			'slug'					=> 'event-tags',
			'label'					=> 'Event Tags',
			'singular'				=> 'event tags',
			'plural'				=> 'event tags',
			'menu_name'				=> 'Tags',
			'show_in_nav_menus' 	=> FALSE,
			'hierarchical'			=> FALSE
		)

	);

	public $admin_panels = array(
		'event-archive-settings',
		'event-settings'
	);


	public $shortcode_options = array(
		'orderby'				=> 'meta_value_num',
		'meta_key'				=> '_start_date',
		'post_status'			=> array('upcoming-event','past-event'),
		'meta_query'			=> array(
			array(
				'key'		=> '_start_date'
			),
			array(
				'key'		=> '_end_date',
				'value'		=> '',
				'compare'	=> '>'
			)
		)
	);

	public function __construct(){
		parent::__construct();
		add_action('init', array($this, 'post_status'));
		add_action('admin_menu', array($this, 'adjust_menu'), 10);
		add_action('save_post', array($this, 'save'), 100);
		add_action('tmf_update_events', array($this, 'update_events'));
		add_action('wp', array($this, 'schedule_cron'));
		add_action('pre_get_posts', array($this, 'column_orderby'));
		add_action('pre_get_posts', array($this, 'modify_loop'));
		add_action('init', array($this, 'add_past_events_rewrite_rule')); 
		add_filter('display_post_states', array($this, 'custom_post_state'));
		add_filter('parent_file', array($this, 'parent_file'), 9999);
		add_filter('views_edit-event', array($this, 'views'));
		add_filter('gettext', array($this, 'change_publish_button_text'), 10, 2);
	}

	public function no_posts_message () {
		if ($this->is_past_archive):
			return 'There are no past events.';
		endif;

		return $this->options['no_posts'];
	}


	public function add_past_events_rewrite_rule () {
		add_rewrite_rule(  
		    '^'. $this->options['slug'] .'/past/page/([0-9]+)?',  
		    'index.php?post_type=event&category_name=past&paged=$matches[1]',  
		    'top'
		);  
		
		add_rewrite_rule(  
		    '^'. $this->options['slug'] .'/past',  
		    'index.php?post_type=event&category_name=past',  
		    'top'  
		);
	}

	public function modify_loop ($query) {
		if (!is_admin() && $query->is_post_type_archive('event')):

			// past event
			if ($query->get('category_name') == 'past'):
				//print_r($query);die;

				$this->is_past_archive = TRUE;

				$query->query_vars['category_name'] = NULL;
				$query->is_category = NULL;
				$query->set('meta_key', '_end_date');
				$query->set('orderby', 'meta_value_num');
				$query->set('order', 'DESC');
				$query->set('meta_query', array(
								array(
									'key'		=> '_end_date',
									'value'		=> time(),
									'compare'	=> '<'
								)
							));

			// current event
			else:

				$query->set('meta_key', '_start_date');
				$query->set('orderby', 'meta_value_num');
				$query->set('order', 'ASC');
				$query->set('meta_query', array(
								array(
									'key'		=> '_start_date'
								),
								array(
									'key'		=> '_end_date',
									'value'		=> time(),
									'compare'	=> '>'
								)
							));
			endif;
		endif;
	}

	public function views($views) {

		if (isset($views['all'])):
			$all = $views['all'];
			unset($views['all']);
			$views['all'] = $all;
		endif;

		if (isset($views['trash'])):
			$trash = $views['trash'];
			unset($views['trash']);
			$views['trash'] = $trash;
		endif;

		if (isset($views['draft'])):
			$draft = $views['draft'];
			unset($views['draft']);
			$views['draft'] = $draft;
		endif;

		return $views;
	}

	public function parent_file($parent_file) {
		global $submenu_file, $self, $typenow;

		if ($this->is_current_edit_page()):

			if (isset($_GET['post_status']))
				$submenu_file = "edit.php?post_type=". $this->post_type ."&post_status=" . strtolower($_GET['post_status']);

			$self = "edit.php?post_type=". $this->post_type;
			$typenow = NULL;
			return "edit.php?post_type=" . $this->post_type;
		endif;

		return $parent_file;
	}


	public function custom_post_state($states) {
		global $post;

		if (isset($_GET['post_status']) || (isset($_GET['post_type']) && $_GET['post_type'] != $this->post_type))
			return $states;

		if ($post->post_status == 'upcoming-event')
			$states[] = 'Upcoming';

		if ($post->post_status == 'past-event')
			$states[] = 'Past';

		return $states;
	}


	public function column_orderby($query) {  
		if(!is_admin())  
			return;  

		$orderby = $query->get('orderby');  

		if ($orderby == 'start_date'):
			$query->set('meta_key','_start_date');
			$query->set('orderby','meta_value_num');
		elseif ($orderby == 'end_date'):
			$query->set('meta_key','_end_date');
			$query->set('orderby','meta_value_num');
		endif; 

	} 


	public function update_events() {
		global $wpdb;
		$wpdb->query("UPDATE $wpdb->posts posts LEFT JOIN $wpdb->postmeta meta ON posts.id = meta.post_id SET post_status = 'past-event' WHERE meta_key = '_end_date' AND post_status = 'upcoming-event' AND meta_value < " . time());
	}


	public function schedule_cron() {
		if (!wp_next_scheduled('tmf_update_events'))
			wp_schedule_event(time(), 'hourly', 'tmf_update_events');
	}


	public function save($post_id) {
		global $wpdb;

		// if post being saved matches this post type
		if ($this->post_type == get_post_type($post_id) && !in_array(get_post_status($post_id), array('trash', 'draft', 'auto-draft', 'inherit'))):
			$post				= get_post($post_id);

			// if event hasn't happened yet
			if ($post->_end_date > time()):
				$status = 'upcoming-event';

			// event has passed
			else:
				$status = 'past-event';
			endif;

			// update post status
			$wpdb->query("UPDATE $wpdb->posts SET post_status = '$status' WHERE ID = $post_id");
		endif;
	}


	public function adjust_menu() {
		global $submenu;

		remove_submenu_page('edit.php?post_type=event', 'edit.php?post_type=event');
		remove_submenu_page('edit.php?post_type=event', 'post-new.php?post_type=event');
		remove_submenu_page('edit.php?post_type=event', 'edit-tags.php?taxonomy=event-tags&amp;post_type=event');
		remove_submenu_page('edit.php?post_type=event', 'edit-tags.php?taxonomy=event-categories&amp;post_type=event');

		add_submenu_page('edit.php?post_type=event', 'Upcoming Events', 'Upcoming Events', 'edit_posts', 'edit.php?post_type=event&post_status=upcoming-event');
		add_submenu_page('edit.php?post_type=event', 'Past Events', 'Past Events', 'edit_posts', 'edit.php?post_type=event&post_status=past-event');
		add_submenu_page('edit.php?post_type=event', 'Add New', 'Add New', 'publish_posts', 'post-new.php?post_type=event');
		add_submenu_page('edit.php?post_type=event', 'Categories', 'Categories', 'publish_posts', 'edit-tags.php?taxonomy=event-categories&post_type=event');
		add_submenu_page('edit.php?post_type=event', 'Tags', 'Tags', 'publish_posts', 'edit-tags.php?taxonomy=event-tags&post_type=event');
	}


	public function post_status() {
		register_post_status('upcoming-event', array(
			'label'                     => 'Upcoming Event',
			'public'                    => TRUE,
			'exclude_from_search'       => FALSE,
			'show_in_admin_all_list'    => TRUE,
			'show_in_admin_status_list' => TRUE,
			'label_count'               => _n_noop('Upcoming Events <span class="count">(%s)</span>', 'Upcoming Events <span class="count">(%s)</span>')
		));

		register_post_status('past-event', array(
			'label'                     => 'Past Event',
			'public'                    => TRUE,
			'exclude_from_search'       => FALSE,
			'show_in_admin_all_list'    => TRUE,
			'show_in_admin_status_list' => TRUE,
			'label_count'               => _n_noop('Past Events <span class="count">(%s)</span>', 'Past Events <span class="count">(%s)</span>')
		));
	}

	public function help_post() {
		parent::help_post();

		$this->help_panels[] = array(
			'id'			=> 'help-title-editor', 
			'title'		=> 'Event Editor',
			'content'	=> '<p><b>Event name</b> - Enter a name for your event. After you enter a name, you’ll see the permalink below, which you can edit.</p>'
		);
	}


	public function help_table() {
		$this->help_panels[] = array(
			'id'			=> 'help-overview', 
			'title'		=> 'Overview',
			'content'	=> '<p>Events are a way to display upcoming events on your site.</p>',
		);

		parent::help_table();
	}


	public function column_location($id) {
		$post = get_post($id);
		$data = '';

		if ($post->_location_name)
			$data .= $post->_location_name . '<br/>';

		if ($post->_location_address_1)
			$data .= $post->_location_address_1;

		if ($post->_location_address_2)
			$data .= ', ' . $post->_location_address_2;

		if ($post->_location_city)
			$data .= '<br/>' . $post->_location_city . ', ';

		if ($post->_location_state)
			$data .= $post->_location_state . ' ';

		if ($post->_location_zipcode)
			$data .= $post->_location_zipcode;
		return $data;

	}


	public function column_start_date($id) {
		global $post;

		if ($post->_start_date):
			$data = date('F jS, Y', $post->_start_date) . '<br/>';
			$data .= date('g:ia', $post->_start_date);
			return $data;
		endif;
	}


	public function column_end_date($id) {
		global $post;

		if ($post->_end_date):
			$data = date('F jS, Y', $post->_end_date) . '<br/>';
			$data .= date('g:ia', $post->_end_date);
			return $data;
		endif;
	}

	public function change_publish_button_text( $translation, $text ) {
		if ( 'event' == get_post_type() && in_array(get_post_status(), array('upcoming-event', 'past-event')))
			if ( $text == 'Publish' )
				return 'Update';
	
		return $translation;
	}

}
