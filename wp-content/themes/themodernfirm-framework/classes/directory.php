<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Directory {

	private $action;

	private $content_position;


	public static function factory() {
		return new TMF_Directory();
	}

	public function title () {
		global $tmf;

		$post_type			= $tmf->request()->post_type();
		$field				= TMF_Text::underscores($post_type) . '_archive_title';
		$post_type_title	= $tmf->option()->{$field};
		$post_type_name		= TMF_PostType::get_post_type_object($post_type)->labels->name;
		
		return (empty($post_type_title)) ? $post_type_name : $post_type_title;
	}

	public function navigation () {
		$this->action = 'navigation';
		return $this;
	}


	public function top () {
		$this->action = 'content';
		$this->content_position = 'top';
		return $this;
	}


	public function bottom () {
		$this->action = 'content';
		$this->content_position = 'bottom';
		return $this;
	}


	public function render () {

		switch ($this->action):
			case 'content':
				$this->render_content();
				break;

			case 'navigation':
				$this->render_navigation();
				break;
		endswitch;
	}

	private function render_navigation () {
		global $wp_query, $tmf;
		$request = $tmf->request();

		if ($request->max_number_of_pages() > 1): ?>
			<div class="page-navigation">

				<span class="container">
					<?php 
						$current = $request->paged() > 1 ? $request->paged() : 1;

						/*echo paginate_links(array(
							'base' => @add_query_arg('paged','%#%'), 
							'format' => '',
							'prev_text'	=> '« Prev',
							'end_size'	=> 0,
							'mid_size' => 1,
							'next_text' => 'Next »',
							'current' => $current,
							'total' => $request->max_number_of_pages()
						));*/ ?>
                        <?php previous_posts_link(); ?>
                        <?php next_posts_link(); ?>

					
				</span>
				<!-- <a class="last tmf-button" href="<?php echo @add_query_arg('paged', $wp_query->max_num_pages) ?>">Last »</a> -->
			</div>
			
		<?php endif;
	}


	private function render_content () {
		global $tmf;
		$request = $tmf->request();

		if (empty($this->content_position))
			throw new TMF_Exception("You must specify a 'top' or 'bottom' page position for directory content.");

		$post_type	= TMF_Text::underscores($request->post_type());
		$content	= $tmf->option()->{$post_type . '_archive_' . $this->content_position};

		if ($request->is_directory() && !$request->is_taxonomy() && !empty($content)):
			$content = TMF_Shortcode::render($content);
			$content = TMF_Shortcode::cleanup_content($content);
			echo '<div class="tmf-archive-'. $this->content_position .' editor-content">' . $content .'</div>';
		endif;
	}


}