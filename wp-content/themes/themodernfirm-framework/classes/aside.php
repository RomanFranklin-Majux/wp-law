<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Aside {

    public function __construct() {
        add_filter('mce_css', array($this, 'tuts_mcekit_editor_style')); // Load default css in text editor
        add_filter( 'mce_buttons', array($this, 'tuts_mce_editor_buttons'), 9999 ); // Add button in second layer
        add_filter( 'tiny_mce_before_init', array($this, 'tuts_mce_before_init') ); // Register button
    }

    public function tuts_mcekit_editor_style($url) {
 
    if ( !empty($url) )
        $url .= ',';
 
        // Retrieves the plugin directory URL
        // Change the path here if using different directories
        $url .= trailingslashit( FRAMEWORK_URI ) . 'assets/css/aside.css';
 
        return $url;
    }

    public function tuts_mce_editor_buttons( $buttons ) {
        array_push( $buttons, 'styleselect' );
        return $buttons;
    }

    public function tuts_mce_before_init( $settings ) {
 
        $style_formats = array(
            array(
                'title' => 'Aside',
                'block' => 'aside',
                'wrapper' => true
            ),
            array(
                'title' => 'Left Aside',
                'block' => 'aside',
                'wrapper' => true,
                'classes'   => 'left'
            ),
            array(
                'title' => 'Right Aside',
                'block' => 'aside',
                'wrapper' => true,
                'classes'   => 'right'
            ),
            array(
                'title' => 'Call to Action',
                'block' => 'div',
                'wrapper' => true,
                'attributes' => array(
                    'id' => 'call-to-action',
                )
            )
        );
 
        $settings['style_formats'] = json_encode( $style_formats );

        return $settings;
 
    }
}

?>
