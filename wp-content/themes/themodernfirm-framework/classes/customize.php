<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
	class TMF_Customize {

		// Holds all of the CSS from each section
		public static $TMF_CustomizerCSS = array();
		public static $TMF_FontFamily = '';

		public function __construct() {

			// Register customize
			add_action( 'customize_register', array(&$this, 'tmf_customize_register') );

			// Output custom CSS to live site
			add_action( 'wp_head' , array( &$this , 'tmf_execute_inline_style_block' ) );
		}

		public static function tmf_customize_register( $wp_customize ) {

			/* Include customize-sections from framework */
			$files = scandir(dirname( __FILE__ ) . '/customize-sections');
			foreach($files as $file) {

				// If file does not exist at child theme's location
				if(!is_file( THEME_PATH . '/classes/customize-sections/'.$file)) {
					// Load it from framework
					if(is_file(dirname( __FILE__ ) . '/customize-sections/'.$file) && ($file != "style.php" || $file != "extend.php")){
				  		include_once (dirname( __FILE__ ) . '/customize-sections/'.$file);
					}
				}
			}

			/* Include customize-sections from child theme */

			if(is_dir( THEME_PATH . '/classes/customize-sections' )):

				$files = scandir( THEME_PATH . '/classes/customize-sections');
				foreach($files as $file) {
					if(is_file( THEME_PATH . '/classes/customize-sections/'.$file)&& ($file != "style.php" || $file != "extend.php")){
				  		include_once ( THEME_PATH . '/classes/customize-sections/'.$file);
					}
				}

			endif;
		}

		/**
	    * This will output the custom WordPress settings to the live theme's WP head.
	    * 
	    * Used by hook: 'wp_head'
	    * 
	    * @see add_action('wp_head',$func)
	    */

		public static function tmf_execute_inline_style_block() {

			if(is_file( THEME_PATH . '/classes/customize-sections/style.php')){
		  		include_once ( THEME_PATH . '/classes/customize-sections/style.php');
			}elseif(is_file(dirname( __FILE__ ) . '/customize-sections/style.php')){
				include_once (dirname( __FILE__ ) . '/customize-sections/style.php');
			}
			if(is_file( THEME_PATH . '/classes/customize-sections/extend.php')){
		  		include_once ( THEME_PATH . '/classes/customize-sections/extend.php');
			}


			$css = '';

			$inline_css = '';

			if(self::$TMF_FontFamily && get_theme_mod(self::$TMF_FontFamily)) {

				$font_name = ucwords(str_replace('-', ' ', get_theme_mod(self::$TMF_FontFamily)));
				$font_name_final = str_replace(' ', '+', $font_name);
				wp_enqueue_style(self::$TMF_FontFamily, 'http://fonts.googleapis.com/css?family='. $font_name_final .':400,400italic,600,600italic,700,700italic', NULL, NULL, 'screen');

				$inline_css = "body{ font-family: '". $font_name ."'; }";
			}


			foreach (self::$TMF_CustomizerCSS as $key => $value) {
				$type = $value['css'];
				$args = $value;

				if(array_key_exists("raw", $value)) {
					// Recursively generate css
					foreach ($value["raw"] as $index => $raw) {
						switch ( $index ) {

							case 'background' :

								$type = $index;

								// Set the background array
								$bg_args = $args['raw'][ $type ];

					
								if(	 isset( $bg_args['style'] ) && 'transparent' == $bg_args['style'] ){
										$css .= 'background-color: transparent; ';

								} else if( isset( $bg_args['style'] ) && 'opacity' == $bg_args['style'] ){
									$opacity = get_theme_mod($bg_args['opacity']) ? get_theme_mod($bg_args['opacity']) : 1;
									$css .= 'background-color: rgba(' . implode( ', ' , self::tmf_hex2rgb( get_theme_mod( $bg_args['color'] ) ) ) . ', ' . $opacity . ' ); ';
								} else if( isset( $bg_args['style'] ) && 'gradient' == $bg_args['style'] ){

									if( !isset( $bg_args['image'] ) || ( isset( $bg_args['image'] ) && '' == $bg_args['image'] ) ){

										if( isset( $bg_args['gradient-direction'] ) && '' != get_theme_mod($bg_args['gradient-direction']) ) {
											$css .= 'background: linear-gradient( ' . get_theme_mod($bg_args[ 'gradient-direction' ]) . 'deg , ' . get_theme_mod($bg_args[ 'gradient-start-color' ]) . ', ' . get_theme_mod($bg_args['gradient-end-color']) . ');';
										}elseif( get_theme_mod($bg_args[ 'gradient-start-color' ]) && get_theme_mod($bg_args[ 'gradient-end-color' ]) ){
											$css .= 'background: linear-gradient( '. get_theme_mod($bg_args[ 'gradient-start-color' ]) . ', ' . get_theme_mod($bg_args['gradient-end-color']) . ');';
										}
									}

								} else {

									if( isset( $bg_args['color'] ) && '' != get_theme_mod($bg_args['color']) ){
										$css .= 'background-color: ' . get_theme_mod($bg_args['color']) . '; ';
									}

								}

								if( isset( $bg_args['repeat'] ) && '' != get_theme_mod( $bg_args['repeat'] ) ){
									$css .= 'background-repeat: ' . get_theme_mod( $bg_args['repeat'] ) . ';';
								}

								if( isset( $bg_args['position'] ) && '' != get_theme_mod( $bg_args['position'] ) ){
									$css .= 'background-position: ' . get_theme_mod( $bg_args['position'] ) . ';';
								}

								if( isset( $bg_args['stretch'] ) && '' != get_theme_mod( $bg_args['stretch'] ) ){
									$css .= 'background-size: cover;';
								}

								if( isset( $bg_args['fixed'] ) && '' != get_theme_mod( $bg_args['fixed'] ) ){
									$css .= 'background-attachment: fixed;';
								}

								if( isset( $bg_args['image'] ) && '' != get_theme_mod( $bg_args['image'] ) ){
									$image = wp_get_attachment_image_src( get_theme_mod( $bg_args['image'] ) , 'full' );
									$css.= 'background-image: url(\'' . $image[0] .'\');';
								}

							break;

							case 'button' :

								// Set the background array
								$bg_args = $args['raw']['button'];

								if( isset( $button_args['background-color'] ) && '' != get_theme_mod( $button_args['background-color'] ) ){
									$css .= 'background-color: ' . get_theme_mod( $button_args['background-color'] ) . '; ';
								}

								if( isset( $button_args['color'] ) && '' != get_theme_mod( $button_args['color'] ) ){
									$css .= 'color: ' . get_theme_mod( $button_args['color'] ) . '; ';
								}

							break;

							case 'margin' :
							case 'padding' :

								$type = $index;

								// Set the Margin or Padding array
								$trbl_args = $args['raw'][ $type ];

								if( isset( $trbl_args['top'] ) && '' != get_theme_mod($trbl_args['top']) ){
									$css .= $type . '-top: ' . get_theme_mod($trbl_args['top']) . 'px; ';
								}

								if( isset( $trbl_args['right'] ) && '' != get_theme_mod($trbl_args['right']) ){
									$css .= $type . '-right: ' . get_theme_mod($trbl_args['right']) . 'px; ';
								}

								if( isset( $trbl_args['bottom'] ) && '' != get_theme_mod($trbl_args['bottom']) ){
									$css .= $type . '-bottom: ' . get_theme_mod($trbl_args['bottom']) . 'px; ';
								}

								if( isset( $trbl_args['left'] ) && '' != get_theme_mod($trbl_args['left']) ){
									$css .= $type . '-left: ' . get_theme_mod($trbl_args['left']) . 'px; ';
								}

							break;

							case 'border' :

								// Set the background array
								$type = $index;
								$trbl_args = $args['raw'][ $type ];

								if( isset( $trbl_args['top'] ) && '' != get_theme_mod($trbl_args['top']) ){
									$top_border_color = get_theme_mod($trbl_args['top-color']);
									$css .= $type . '-top: ' . get_theme_mod($trbl_args['top']) . 'px solid '. $top_border_color .'; ';
								}

								if( isset( $trbl_args['right'] ) && '' != get_theme_mod($trbl_args['right']) ){
									$right_border_color = get_theme_mod($trbl_args['right-color']);
									$css .= $type . '-right: ' . get_theme_mod($trbl_args['right']) . 'px solid '. $right_border_color .'; ';
								}

								if( isset( $trbl_args['bottom'] ) && '' != get_theme_mod($trbl_args['bottom']) ){
									$bottom_border_color = get_theme_mod($trbl_args['bottom-color']);
									$css .= $type . '-bottom: ' . get_theme_mod($trbl_args['bottom']) . 'px solid '. $bottom_border_color .'; ';
								}

								if( isset( $trbl_args['left'] ) && '' != get_theme_mod($trbl_args['left']) ){
									$left_border_color = get_theme_mod($trbl_args['left-color']);
									$css .= $type . '-left: ' . get_theme_mod($trbl_args['left']) . 'px solid '. $left_border_color .'; ';
								}
							break;

							case 'color' :

								if( '' != get_theme_mod($args['raw'][ 'color' ]) ) {
									$css .= 'color: ' . get_theme_mod($args['raw'][ 'color' ]) . ';';
								}
							break;

							case 'letter-spacing' :

								if( '' != get_theme_mod($args['raw'][ 'letter-spacing' ]) ) {
									$css .= 'letter-spacing: ' . get_theme_mod($args['raw'][ 'letter-spacing' ]) . 'px;';
								}
							break;

							case 'font-size' :

								if( '' != get_theme_mod($args['raw'][ 'font-size' ]) ) {
									$css .= 'font-size: ' . get_theme_mod($args['raw'][ 'font-size' ]) . 'px;';
								}
							break;

							case 'font-family' :

								if( '' != get_theme_mod($args['raw'][ 'font-family' ]) ) {
									$css .= 'font-family: "' . get_theme_mod($args['raw'][ 'font-family' ]) . '", Helvetica, sans-serif;';
								}
							break;

							case 'text-align' :

								if( '' != get_theme_mod($args['raw'][ 'text-align' ]) ) {
									$css .= 'text-align: ' . get_theme_mod($args['raw'][ 'text-align' ]) . ';';
								}
							break;

							case 'text-shadow' :

								if( '' != get_theme_mod($args['raw'][ 'text-shadow' ]) ) {
									$css .= 'text-shadow: 0px 0px 10px rgba(' . implode( ', ' , self::tmf_hex2rgb( get_theme_mod($args['raw'][ 'text-shadow' ]) ) ) . ', 0.75);';
								}
							break;

							case 'box-shadow' :
								$type = $index;

								// Set the background array
								$bg_args = $args['raw'][ $type ];

								if( '' != get_theme_mod($bg_args[ 'box-shadow' ]) ) {
									$opacity = get_theme_mod($bg_args['opacity']) ? get_theme_mod($bg_args['opacity']) : 1;
									$css .= 'box-shadow: 0px 0px 10px rgba(' . implode( ', ' , self::tmf_hex2rgb( get_theme_mod($bg_args[ 'box-shadow' ]) ) ) . ', ' . $opacity . ');';
								}
							break;

							case 'css' :
							default :
								$type = $index;

								// Set the background array
								$bg_args = $args['raw'][ $type ];

								if ( is_array( $args ) ){

									if ( isset( $type ) ) {
										if ( is_array( $bg_args ) ){
											foreach ( $bg_args as $css_atribute => $css_value ) {
												// Skip this if a css value is not sent.
												$val = get_theme_mod($css_value['option']);
												$suffix = !empty($css_value['suffix']) ? $css_value['suffix'] : '';
												if ( ! isset( $val ) || '' == $val || NULL == $val ) continue;
												$css .= "$css_atribute: ". $val . $suffix .";";
											}
										}
										else {
											$css .= $bg_args;
										}
									}
								}
								else if ( is_string( $args ) ){

									$css .= $args;
								}

							break;

						}
					}
				}

				// Bail if no css is generated
				if ( '' != trim( $css ) ) {
					// If there is a container ID specified, append it to the beginning of the declaration

					if( isset( $args['selectors'] ) ) {
			            if ( is_string( $args['selectors'] ) && '' != $args['selectors'] ) {

			            	$inline_css .= ' ' . $args['selectors'];

			            } else if( is_array( $args['selectors'] ) && !empty( $args['selectors'] ) ){
			            	
			            	$first = TRUE;
			            	
			            	foreach( $args['selectors'] as $s ) {

			            		if( !$first )
			            			$inline_css .= ', ';

			            		$inline_css .= ' ' . $s;

			            		$first = FALSE;
			            	}
			            }
					}

					// Apply inline CSS
					if( '' == trim( $inline_css ) ) {
						$inline_css .= $css;
					} else {
						$inline_css .= '{ ' . $css . '} ';
					}

					$css = '';
				}

				// Format/Clean the CSS.
				$inline_css = str_replace( "\n", '', $inline_css );
				$inline_css = str_replace( "\r", '', $inline_css );
				$inline_css = str_replace( "\t", '', $inline_css );
				// $inline_css = "\n" . $inline_css;
				//$inline_css = "\n\n" . $inline_css; // Debugging: double line breaks helps visually with debugging.
			}

			if ( isset( $inline_css ) && '' !=  $inline_css ) {
				echo '<style type="text/css" id="tmf-inline-styles-header">' . $inline_css . '</style>';
			}
		}

		/**
		 * Convert hex value to rgb array.
		 *
		 * @param	string	$hex
		 * @return	array	implode(",", $rgb); returns the rgb values separated by commas
		 */

		public static function tmf_hex2rgb($hex) {
		   $hex = str_replace("#", "", $hex);
		   if(strlen($hex) == 3) {
				$r = hexdec(substr($hex,0,1).substr($hex,0,1));
				$g = hexdec(substr($hex,1,1).substr($hex,1,1));
				$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		   } else {
				$r = hexdec(substr($hex,0,2));
				$g = hexdec(substr($hex,2,2));
				$b = hexdec(substr($hex,4,2));
		   }
		   $rgb = array($r, $g, $b);
		   return $rgb; // returns an array with the rgb values
		}

	}

?>
