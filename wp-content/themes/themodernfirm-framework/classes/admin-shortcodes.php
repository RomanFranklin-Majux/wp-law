<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Various functions to modify the Wordpress admin panel
 * Note: This file is only for backward compatibility in shortcodes
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
 class TMF_Admin_Shortcodes {

	public static function get_post_type($args) {
		$array = array();
		$posts = get_posts($args);

		if(!empty($posts)):
			$i = 0;
			foreach ($posts as $post) {
				if($i == 0):
					$array['none'] = 'None';
					$array[$post->ID] = $post->post_title;
				else:
					$array[$post->ID] = $post->post_title;
				endif;
			}
			$i++;
		else:
			$array['none'] = 'Nothing Found';
		endif;
		return $array;
	}

	public static function get_youtube_video_info($video_id) {
		$googleApiUrl = 'https://www.googleapis.com/youtube/v3/videos?id=' . $video_id . '&key='. YT_API_KEY .'&part=snippet';

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($ch);

		curl_close($ch);

		return $response;
	}

}
