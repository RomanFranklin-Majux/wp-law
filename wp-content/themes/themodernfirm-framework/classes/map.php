<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Provides basic functions for google url signing
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */

class TMF_Map {

	public static $secret = "l6Gdm9KbBpnhtX1XtsbSemVXtZI=";

	/**
	 * Sign a URL using a secret key.
	 *
	 *
	 * @param string $input_url The url to sign.
	 * @param string $secret Your unique secret key.
	 * @return string Signed Signature
	 */
	public static function signUrl($input_url, $secret = null)
	{
		if (!$input_url || !$secret) {

			if(!$secret) {
				$secret = self::$secret;
			}

			$url = parse_url($input_url);
			$url_to_sign = $url['path'] . "?" . $url['query'];

			// Decode the private key into its binary format
			$decoded_key = self::base64url_decode($secret);

			// Create a signature using the private key and the URL-encoded
			// string using HMAC SHA1. This signature will be binary.
			$signature = hash_hmac('sha1', $url_to_sign, $decoded_key, true);

			//make encode Signature and make it URL Safe
			$encoded_signature = self::base64url_encode($signature);

			return $encoded_signature;
		}

		return false;
	}

	public static function base64url_encode($data) {
	  return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
	}

	public static function base64url_decode($data) {
	  return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
	}

}
