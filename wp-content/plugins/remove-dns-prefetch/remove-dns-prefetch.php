<?php /** 
* Plugin Name: Remove DNS Prefetch
* Description: This plugin will automagically remove the DNS prefetch from your website's header.
* Author: Worcester Web Studio
* Author URI: https://www.worcesterwebstudio.com/
* Version: 1.1.2 */ 

remove_action( 'wp_head', 'wp_resource_hints', 2 );

?>