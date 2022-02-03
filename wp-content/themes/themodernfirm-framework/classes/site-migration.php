<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Migrates a site to a new url or host.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_SiteMigration {

	private $new_url;
	private $current_url;

	public function __construct($url_from, $url_to) {

		if (!empty($url_from) && !empty($url_to)):
			$this->new_url = $this->format_url($url_to);
			$this->current_url = $url_from;
			$this->update_urls();
		endif;
	}

	private function update_urls () {
		global $wpdb;

		$wpdb->query("UPDATE $wpdb->posts SET post_content = REPLACE(post_content, '$this->current_url', '$this->new_url')");
		$wpdb->query("UPDATE $wpdb->posts SET guid = REPLACE(guid, '$this->current_url', '$this->new_url')");
		$wpdb->query("UPDATE $wpdb->posts SET post_excerpt = REPLACE(post_excerpt, '$this->current_url', '$this->new_url')");
	}

	private function format_url ($url) {
		// remove extra whitespace
		$url = trim($url);

		// strip possible http or https
		$url = preg_replace("(^https?://)", "", $url);

		// strip possible www
		$url = preg_replace("(^www.)", "", $url);

		// remove trailing slash
		$url = rtrim($url, '/');

		// change to lowercase
		$url = strtolower($url);

		return 'http://www.' . $url . '/';
	}

}
