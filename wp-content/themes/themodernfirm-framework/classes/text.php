<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Provides an object to generate page breadcrumbs.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Prsent The Modern Firm, LLC
 */
class TMF_Text {


	/**
	 * Shortens a string to a limited number of words.
	 *
	 * @param   string   $str   string to be shortened
	 * @param	integer	$limit   number of words to limit
	 * @param   string   $end_char   append this to the end of new string
	 * @return  string
	 */
	public static function limit_words($str, $limit = 100, $end_char = '…'){
		$limit = (int) $limit;

		if (trim($str) === '')
			return $str;

		if ($limit <= 0)
			return $end_char;

		preg_match('/^\s*+(?:\S++\s*+){1,'.$limit.'}/u', $str, $matches);

		// Only attach the end character if the matched string is shorter
		// than the starting string.
		return rtrim($matches[0]).((strlen($matches[0]) === strlen($str)) ? '' : $end_char);
	}


	/**
	 * Shortens a string to a limted number of characters
	 * 
	 * @param   string   $str   string to be shortened
	 * @param	integer	$limit   number of words to limit
	 * @param   string   $end_char   append this to the end of new string
	 * @param   boolean  $preserve_words   shorten to the nearest word
	 * @return  string
	 */
	public static function limit_chars($str, $limit = 100, $end_char = '…', $preserve_words = FALSE){
		$limit = (int) $limit;

		if (trim($str) === '' OR strlen($str) <= $limit)
			return $str;

		if ($limit <= 0)
			return $end_char;

		if ($preserve_words === FALSE)
			return rtrim(substr($str, 0, $limit)).$end_char;

		// Don't preserve words. The limit is considered the top limit.
		// No strings with a length longer than $limit should be returned.
		if ( ! preg_match('/^.{0,'.$limit.'}\s/us', $str, $matches))
			return $end_char;

		return rtrim($matches[0]).((strlen($matches[0]) === strlen($str)) ? '' : $end_char);
	}

	public static function starts_with($haystack, $needle) {
		return $needle === "" || strpos($haystack, $needle) === 0;
	}

	public static function ends_with ($haystack, $needle) {
		$strlen = strlen($haystack);
		$needlelen = strlen($needle);
		if ($needlelen > $strlen) return false;
		return substr_compare($haystack, $needle, -$needlelen) === 0;
	}


	public static function random_string ($length = 10) {
		return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
	}


	public static function slug_to_name ($string) {
		return ucwords(str_replace(array('-', '_'), ' ', trim($string)));
	}

	public static function pretty ($string) {
		return ucwords(str_replace(array('-', '_'), ' ', trim($string)));
	}


	public static function underscores ($string, $lowercase = TRUE) {
		$string = str_replace(array('-', ' '), '_', trim($string));

		if ($lowercase)
			$string = strtolower($string);
		
		return $string;
	}


	public static function dashes ($string, $lowercase = TRUE) {
		$string = str_replace(array('_', ' '), '-', trim($string));

		if ($lowercase)
			$string = strtolower($string);
		
		return $string;
	}

	public static function plural ($singular, $plural, $number) {
		if ($number > 1)
			return $plural;
		else
			return $singular;
	}


}
