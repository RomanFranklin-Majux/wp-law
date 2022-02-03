<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Provides date helpers
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Time {


	/**
	 * @var  array   an array of hours in a day
	 */
	static $hours = array(
		'1' => '1',
		'2' => '2',
		'3' => '3',
		'4' => '4',
		'5' => '5',
		'6' => '6',
		'7' => '7',
		'8' => '8',
		'9' => '9',
		'10' => '10',
		'11' => '11',
		'12' => '12'
	);


	/**
	 * @var  array   an array of minutes in an hour
	 */
	static $minutes = array(
		'00' => '00',
		'01' => '01',
		'02' => '02',
		'03' => '03',
		'04' => '04',
		'05' => '05',
		'06' => '06',
		'07' => '07',
		'08' => '08',
		'09' => '09',
		'10' => '10',
		'11' => '11',
		'12' => '12',
		'13' => '13',
		'14' => '14',
		'15' => '15',
		'16' => '16',
		'17' => '17',
		'18' => '18',
		'19' => '19',
		'20' => '20',
		'21' => '21',
		'22' => '22',
		'23' => '23',
		'24' => '24',
		'25' => '25',
		'26' => '26',
		'27' => '27',
		'28' => '28',
		'29' => '29',
		'30' => '30',
		'31' => '31',
		'32' => '32',
		'33' => '33',
		'34' => '34',
		'35' => '35',
		'36' => '36',
		'37' => '37',
		'38' => '38',
		'39' => '39',
		'40' => '40',
		'41' => '41',
		'42' => '42',
		'43' => '43',
		'44' => '44',
		'45' => '45',
		'46' => '46',
		'47' => '47',
		'48' => '48',
		'49' => '49',
		'50' => '50',
		'51' => '51',
		'52' => '52',
		'53' => '53',
		'54' => '54',
		'55' => '55',
		'56' => '56',
		'57' => '57',
		'58' => '58',
		'59' => '59'
	);


	/**
	 * @var  array   array of AM and PM
	 */
	static $ampm = array(
		'AM' =>	'AM', 
		'PM' => 'PM'
	);


	/**
	 * @var  array   an array of American Timezones
	 */
	static $timezones = array(
		'America/New_York'			=> 'Eastern Time',
		'America/Chicago' 		 	=> 'Central Time',
		'America/Denver'			=> 'Mountain Time',
		'America/Phoenix' 			=> 'Mountain Time (no DST)',
		'America/Los_Angeles'		=> 'Pacific Time',
		'America/Anchorage'			=> 'Alaska Time',
		'America/Adak'				=> 'Hawaii-Aleutian',
		'Pacific/Honolulu'			=> 'Hawaii-Aleutian (no DST)',
	);


	public static function now ($format = 'l, F j g:ia') {
		return date($format, current_time('timestamp', 0));
	}


}
