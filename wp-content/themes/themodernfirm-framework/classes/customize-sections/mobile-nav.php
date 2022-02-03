<?php

/* Just use the $wp_customize object and create a section or use a built-in
   section. */

$general_settings = new TMF_AdminPanel_GeneralSettings;

function tmf_generic_filter($input) {
    return wp_kses_post(force_balance_tags($input));
}

$wp_customize->add_panel( 'tmf_mobile_nav', array(
    'title' => 'Mobile Nav',
    'description' => 'Mobile Nav Settings',
    'priority' => 15,
) );

$wp_customize->add_section(
    'tmf_mobile_nav_general',
    array(
        'title'       => __('General', 'themodernfirm-framework'),
        'priority'    => 30,
        'panel'       => 'tmf_mobile_nav'
    )
);

$wp_customize->add_section(
    'tmf_mobile_menu_bar',
    array(
        'title'       => __('Menu Bar', 'themodernfirm-framework'),
        'priority'    => 30,
        'panel'       => 'tmf_mobile_nav'
    )
);

$wp_customize->add_section(
    'tmf_mobile_nav_menu_submenu',
    array(
        'title'       => __('Menu & Submenu Items', 'themodernfirm-framework'),
        'priority'    => 30,
        'panel'       => 'tmf_mobile_nav'
    )
);

$wp_customize->add_section(
    'tmf_mobile_color',
    array(
        'title'       => __('Background Colors', 'themodernfirm-framework'),
        'priority'    => 30,
        'panel'       => 'tmf_mobile_nav'
    )
);

//  =============================
//  = Menu Button Settings      =
//  =============================

$wp_customize->add_setting( 'tmf_mobile_nav_general_use_menu', array(
    'default'    => '',
    'type'       => 'theme_mod',
    'capability' => 'edit_theme_options'
) );

$wp_customize->add_control( 'tmf_mobile_nav_general_use_menu', array(
    'label'      => __( 'Use Mobile Menu', 'themodernfirm-framework' ),
    'section'    => 'tmf_mobile_nav_general',
    'settings'   => 'tmf_mobile_nav_general_use_menu',
    'type'       => 'checkbox',
    'std'        => '1'
) );

$wp_customize->add_setting('tmf_mobile_nav_general_break_point', array(
    'capability'        => 'edit_theme_options',
    'type'              => 'theme_mod',

));

$wp_customize->add_control('tmf_mobile_nav_general_break_point', array(
    'settings' => 'tmf_mobile_nav_general_break_point',
    'label'    => __('Show Mobile Menu Below'),
    'section'  => 'tmf_mobile_nav_general',
    'type'     => 'number',
));

$wp_customize->add_setting('tmf_mobile_nav_general_menu_location', array(
    'capability'        => 'edit_theme_options',
    'type'              => 'theme_mod',

));

$wp_customize->add_control('tmf_mobile_nav_general_menu_location', array(
    'settings' => 'tmf_mobile_nav_general_menu_location',
    'label'    => __('Menu Toggle Style'),
    'section'  => 'tmf_mobile_nav_general',
    'type'     => 'select',
    'choices'  => array('' => '-- Please Select --', 'left' => 'Left Menu', 'right' => 'Right Menu', 'fade-in' => 'Fade In', 'slide-down' => 'Slide Down')
));

$wp_customize->add_setting('tmf_mobile_nav_general_submenu_icon', array(
    'capability'        => 'edit_theme_options',
    'type'              => 'theme_mod',

));

$wp_customize->add_control('tmf_mobile_nav_general_submenu_icon', array(
    'settings' => 'tmf_mobile_nav_general_submenu_icon',
    'label'    => __('Children Toggle Icon'),
    'section'  => 'tmf_mobile_nav_general',
    'type'     => 'select',
    'choices'  => array('' => '-- Please Select --', 'angle' => 'Angle Sign', 'plus-minus' => 'Plus/Minus Sign')
));


$wp_customize->add_setting('tmf_mobile_nav_general_logo_image', array(
    'capability'        => 'edit_theme_options',
    'type'              => 'theme_mod',

));

$wp_customize->add_control( new WP_Customize_Media_Control($wp_customize, 'tmf_mobile_nav_general_logo_image', array(
    'label'    => __('Mobile Menu Logo', 'themodernfirm-framework'),
    'section'  => 'tmf_mobile_nav_general',
    'settings' => 'tmf_mobile_nav_general_logo_image',
    'description' => __('This will add logo in the mobile menu', 'themodernfirm-framework')
)));

/* menu button color */
$wp_customize->add_setting( 'tmf_mobile_nav_menu_button_color', array( 'sanitize_callback' => 'sanitize_hex_color' ));
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tmf_mobile_nav_menu_button_color',array(
    'label' => 'Menu Button', 'settings' => 'tmf_mobile_nav_menu_button_color', 'section' => 'tmf_mobile_nav_general' )
));

/* menu button color hover */
$wp_customize->add_setting( 'tmf_mobile_nav_menu_button_hover_color', array( 'sanitize_callback' => 'sanitize_hex_color' ));
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tmf_mobile_nav_menu_button_hover_color',array(
    'label' => 'Menu Button Hover', 'settings' => 'tmf_mobile_nav_menu_button_hover_color', 'section' => 'tmf_mobile_nav_general' )
));

/* menu button position */
$wp_customize->add_setting('tmf_mobile_nav_menu_button_position',array(
    'default' => 'left',
));
$wp_customize->add_control('tmf_mobile_nav_menu_button_position',array(
    'type' => 'select',
    'label' => 'Menu button position',
    'section' => 'tmf_mobile_nav_general',
    'choices' => array(
        'left' => 'Left',
        'center' => 'Center',
        'right' => 'Right',
    ),
));
        
/* menu button top distance */
$wp_customize->add_setting('tmf_mobile_nav_menu_button_top_distance',array('default' => '','sanitize_callback' => 'tmf_generic_filter',));

$wp_customize->add_control('tmf_mobile_nav_menu_button_top_distance',array('type' => 'text','label' => 'Top distance (in pixels)','description' => 'Example: 25. If empty, defaults to 10','section' => 'tmf_mobile_nav_general',));

/* menu button left/right distance */
$wp_customize->add_setting('tmf_mobile_nav_menu_button_side_distance',array('default' => '','sanitize_callback' => 'tmf_generic_filter',));

$wp_customize->add_control('tmf_mobile_nav_menu_button_side_distance',array('type' => 'text','label' => 'Left/right distance (in pixels)','description' => 'Example: 35. If empty, defaults to 15','section' => 'tmf_mobile_nav_general',));

/* inline label */
// NOTE: NEED TO CODE THIS...
/*
$wp_customize->add_setting( 'tmf_mobile_nav_menu_button_inline_label', array(
    'default'    => '',
    'type'       => 'theme_mod',
    'capability' => 'edit_theme_options'
) );

$wp_customize->add_control( 'tmf_mobile_nav_menu_button_inline_label', array(
    'label'      => __( 'Make Label Inline', 'themodernfirm-framework' ),
    'section'    => 'tmf_mobile_nav_general',
    'settings'   => 'tmf_mobile_nav_menu_button_inline_label',
    'type'       => 'checkbox',
    'std'        => '1',
    'description'   => 'Make label show next to hamburger icon.'
) );*/

/* menu button label */
$wp_customize->add_setting('tmf_mobile_nav_menu_button_label',array('default' => '','sanitize_callback' => 'tmf_generic_filter',));

$wp_customize->add_control('tmf_mobile_nav_menu_button_label',array('type' => 'text','label' => 'Label','description' => 'If empty, no label will be shown','section' => 'tmf_mobile_nav_general',));

/* menu button label horizontal position */
// NOTE: MIGHT BE REMOVED IN FUTURE
/*
$wp_customize->add_setting('tmf_mobile_nav_menu_button_label_horizontal_position',array('default' => '','sanitize_callback' => 'tmf_generic_filter',));

$wp_customize->add_control('tmf_mobile_nav_menu_button_label_horizontal_position',array('type' => 'text','label' => 'Label horizontal position (in pixels)','description' => 'Label position is relative to the menu button. Negative values accepted. If empty, defaults to 40 (if empty when menu button is hidden, defaults to 0)','section' => 'tmf_mobile_nav_general',));*/

/* menu button label vertical position */
// NOTE: MIGHT BE REMOVED IN FUTURE
/*
$wp_customize->add_setting('tmf_mobile_nav_menu_button_label_vertical_position',array('default' => '','sanitize_callback' => 'tmf_generic_filter',));

$wp_customize->add_control('tmf_mobile_nav_menu_button_label_vertical_position',array('type' => 'text','label' => 'Label vertical position (in pixels)','description' => 'Label position is relative to the menu button. Negative values accepted. If empty, defaults to 6 (if empty when menu button is hidden, defaults to 0)','section' => 'tmf_mobile_nav_general',));*/

/* menu button label color */
$wp_customize->add_setting( 'tmf_mobile_nav_menu_button_label_color', array( 'sanitize_callback' => 'sanitize_hex_color' ));

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tmf_mobile_nav_menu_button_label_color',array(
    'label' => 'Label', 'settings' => 'tmf_mobile_nav_menu_button_label_color', 'section' => 'tmf_mobile_nav_general' )
));

/* menu button label hover color */
$wp_customize->add_setting( 'tmf_mobile_nav_menu_button_label_hover_color', array( 'sanitize_callback' => 'sanitize_hex_color' ));
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tmf_mobile_nav_menu_button_label_hover_color',array(
    'label' => 'Label Hover', 'settings' => 'tmf_mobile_nav_menu_button_label_hover_color', 'section' => 'tmf_mobile_nav_general' )
));

/* menu button label font size */
$wp_customize->add_setting('tmf_mobile_nav_menu_button_label_font_size',array('default' => '','sanitize_callback' => 'tmf_generic_filter',));

$wp_customize->add_control('tmf_mobile_nav_menu_button_label_font_size',array('type' => 'text','label' => 'Label font size (in pixels)','description' => 'If empty, defaults to 11','section' => 'tmf_mobile_nav_general',));

/* menu button label letter spacing */
$wp_customize->add_setting('tmf_mobile_nav_menu_button_label_letter_spacing',array('default' => '','sanitize_callback' => 'tmf_generic_filter',));

$wp_customize->add_control('tmf_mobile_nav_menu_button_label_letter_spacing',array('type' => 'text','label' => 'Label letter spacing (in pixels)','description' => 'If empty, defaults to 0','section' => 'tmf_mobile_nav_general',));

//  =============================
//  = Menubar items             =
//  =============================

/* show menubar */
// NOTE: This will be added later on
/*
$wp_customize->add_setting('tmf_show_menubar',array('sanitize_callback' => 'sanitize_taptap_show_header',));
//function sanitize_taptap_show_header( $input ) { if ( $input == 1 ) { return 1; } else { return ''; } }
$wp_customize->add_control('tmf_show_menubar',array('type' => 'checkbox','label' => 'Show menubar','description' => 'Display background behind menu buttons and logo', 'section' => 'tmf_mobile_menu_bar',));*/

/* menubar height */
$wp_customize->add_setting('tmf_menubar_height',array('default' => '','sanitize_callback' => 'tmf_generic_filter',));
$wp_customize->add_control('tmf_menubar_height',array('type' => 'text','label' => 'Menu Bar height (in pixels)','description' => 'If empty, defaults to 65','section' => 'tmf_mobile_menu_bar',));

/* menubar opacity */
$wp_customize->add_setting('tmf_menubar_opacity',array('default' => '','sanitize_callback' => 'tmf_generic_filter',));
$wp_customize->add_control('tmf_menubar_opacity',array('type' => 'text','label' => 'Menu Bar opacity','description' => 'From 0-1 (example: 0.5) If empty, defaults to 1','section' => 'tmf_mobile_menu_bar',));

/* menubar background color */
$wp_customize->add_setting( 'tmf_menubar_background_color', array( 'sanitize_callback' => 'sanitize_hex_color' ));
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'taptap_header_background_color',array(
    'label' => 'Menu Bar Background', 'settings' => 'tmf_menubar_background_color', 'section' => 'tmf_mobile_menu_bar' )
));

//  =============================
//  = Menu & Submenu Items      =
//  =============================

$wp_customize->add_setting( 'tmf_mobile_nav_general_open_submenu', array(
    'default'    => '',
    'type'       => 'theme_mod',
    'capability' => 'edit_theme_options'
) );

$wp_customize->add_control( 'tmf_mobile_nav_general_open_submenu', array(
    'label'      => __( 'Alternate submenu activation', 'themodernfirm-framework' ),
    'section'    => 'tmf_mobile_nav_menu_submenu',
    'settings'   => 'tmf_mobile_nav_general_open_submenu',
    'type'       => 'checkbox',
    'std'        => '1',
    'description'   => 'Make entire top-level menu item open the submenu. If unchecked, only the icon next to menu item opens submenu'
) );


$wp_customize->add_setting('tmf_mobile_nav_menu_font_size', array(
    'default' => '',
    'sanitize_callback' => 'absint'
));

$wp_customize->add_control('tmf_mobile_nav_menu_font_size', array(
    'type' => 'text',
    'label' => 'Menu item font size (in pixels)',
    'description' => 'If empty, defaults to 14',
    'section' => 'tmf_mobile_nav_menu_submenu',
));

$wp_customize->add_setting('tmf_mobile_nav_submenu_font_size', array(
    'default' => '',
    'sanitize_callback' => 'absint'
));

$wp_customize->add_control('tmf_mobile_nav_submenu_font_size', array(
    'type' => 'text',
    'label' => 'Submenu item font size (in pixels)',
    'description' => 'If empty, defaults to 14',
    'section' => 'tmf_mobile_nav_menu_submenu',
));

 /* menu item vertical spacing */
$wp_customize->add_setting('tmf_mobile_nav_menu_vertical_spacing', array(
    'default' => '',
    'sanitize_callback' => 'absint'
));

$wp_customize->add_control('tmf_mobile_nav_menu_vertical_spacing', array(
    'type' => 'text',
    'label' => 'Menu items vertical spacing (in pixels)',
    'description' => 'Enter custom value to increase spacing between between menu items.',
    'section' => 'tmf_mobile_nav_menu_submenu'
));

 /* submenu item vertical spacing */
$wp_customize->add_setting('tmf_mobile_nav_submenu_vertical_spacing', array(
    'default' => '',
    'sanitize_callback' => 'absint'
));

$wp_customize->add_control('tmf_mobile_nav_submenu_vertical_spacing', array(
    'type' => 'text',
    'label' => 'Submenu items vertical spacing (in pixels)',
    'description' => 'Enter custom value to increase spacing between between submenu items.',
    'section' => 'tmf_mobile_nav_menu_submenu'
));

/* menu item letter spacing */
$wp_customize->add_setting('tmf_mobile_nav_menu_letter_spacing', array(
    'default' => '',
    'sanitize_callback' => 'absint'
));

$wp_customize->add_control('tmf_mobile_nav_menu_letter_spacing', array(
    'type' => 'text',
    'label' => 'Menu items letter spacing (in pixels)',
    'description' => 'If empty, defaults to 0',
    'section' => 'tmf_mobile_nav_menu_submenu'
));

/* submenu item letter spacing */
$wp_customize->add_setting('tmf_mobile_nav_submenu_letter_spacing', array(
    'default' => '',
    'sanitize_callback' => 'absint'
));

$wp_customize->add_control('tmf_mobile_nav_submenu_letter_spacing', array(
    'type' => 'text',
    'label' => 'Submenu items letter spacing (in pixels)',
    'description' => 'If empty, defaults to 0',
    'section' => 'tmf_mobile_nav_menu_submenu'
));

/* menu item color */
$wp_customize->add_setting( 'tmf_mobile_nav_menu_color', array( 'sanitize_callback' => 'sanitize_hex_color' ));

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tmf_mobile_nav_menu_color',array(
    'label' => 'Menu item', 'settings' => 'tmf_mobile_nav_menu_color', 'section' => 'tmf_mobile_nav_menu_submenu' )
));

/* menu item color (current) */
$wp_customize->add_setting( 'tmf_mobile_nav_menu_current_color', array( 'sanitize_callback' => 'sanitize_hex_color' ));

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tmf_mobile_nav_menu_current_color',array(
    'label' => 'Menu item (current)', 'settings' => 'tmf_mobile_nav_menu_current_color', 'section' => 'tmf_mobile_nav_menu_submenu' )
));

/* menu item color hover */
$wp_customize->add_setting( 'tmf_mobile_nav_menu_hover_color', array( 'sanitize_callback' => 'sanitize_hex_color' ));

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tmf_mobile_nav_menu_hover_color',array(
    'label' => 'Menu item hover', 'settings' => 'tmf_mobile_nav_menu_hover_color', 'section' => 'tmf_mobile_nav_menu_submenu' )
));

/* submenu item color hover */
$wp_customize->add_setting( 'tmf_mobile_nav_submenu_color', array( 'sanitize_callback' => 'sanitize_hex_color' ));

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tmf_mobile_nav_submenu_color',array(
    'label' => 'Submenu item', 'settings' => 'tmf_mobile_nav_submenu_color', 'section' => 'tmf_mobile_nav_menu_submenu' )
));

/* submenu item color (current) */
$wp_customize->add_setting( 'tmf_mobile_nav_submenu_current_color', array( 'sanitize_callback' => 'sanitize_hex_color' ));

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tmf_mobile_nav_submenu_current_color',array(
    'label' => 'Submenu item (current)', 'settings' => 'tmf_mobile_nav_submenu_current_color', 'section' => 'tmf_mobile_nav_menu_submenu' )
));

/* submenu item color hover */
$wp_customize->add_setting( 'tmf_mobile_nav_submenu_hover_color', array( 'sanitize_callback' => 'sanitize_hex_color' ));

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tmf_mobile_nav_submenu_hover_color',array(
    'label' => 'Submenu item hover', 'settings' => 'tmf_mobile_nav_submenu_hover_color', 'section' => 'tmf_mobile_nav_menu_submenu' )
));


//  =============================
//  = Background Settings       =
//  =============================

$wp_customize->add_setting('tmf_mobile_background_color', array(
    'default'           => '',
    'sanitize_callback' => 'sanitize_hex_color',
    'capability'        => 'edit_theme_options',
    'type'              => 'theme_mod',

));

$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'tmf_mobile_background_color', array(
    'label'    => __('Opened Menu Background Color', 'themodernfirm-framework'),
    'description' => __('Adds plain background color to menu', 'themodernfirm-framework'),
    'section'  => 'tmf_mobile_color',
    'settings' => 'tmf_mobile_background_color',
)));


$wp_customize->add_setting('tmf_mobile_submenu_background_color', array(
    'default'           => '',
    'sanitize_callback' => 'sanitize_hex_color',
    'capability'        => 'edit_theme_options',
    'type'              => 'theme_mod',

));

$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'tmf_mobile_submenu_background_color', array(
    'label'    => __('Sub Menu Background Color', 'themodernfirm-framework'),
    'description' => __('Adds plain background color to sub-menu', 'themodernfirm-framework'),
    'section'  => 'tmf_mobile_color',
    'settings' => 'tmf_mobile_submenu_background_color',
)));


$wp_customize->add_setting('tmf_mobile_submenu_icon_color', array(
    'default'           => '',
    'sanitize_callback' => 'sanitize_hex_color',
    'capability'        => 'edit_theme_options',
    'type'              => 'theme_mod',

));

$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'tmf_mobile_submenu_icon_color', array(
    'label'    => __('Sub Menu Icon Color', 'themodernfirm-framework'),
    'description' => __('Adds plain color to sub-menu icon', 'themodernfirm-framework'),
    'section'  => 'tmf_mobile_color',
    'settings' => 'tmf_mobile_submenu_icon_color',
)));

$wp_customize->add_setting('tmf_mobile_submenu_icon_active_color', array(
    'default'           => '',
    'sanitize_callback' => 'sanitize_hex_color',
    'capability'        => 'edit_theme_options',
    'type'              => 'theme_mod',

));

$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'tmf_mobile_submenu_icon_active_color', array(
    'label'    => __('Sub Menu Active Icon Color', 'themodernfirm-framework'),
    'description' => __('Adds plain color to sub-menu icon when sub-menu is open', 'themodernfirm-framework'),
    'section'  => 'tmf_mobile_color',
    'settings' => 'tmf_mobile_submenu_icon_active_color',
)));

//  =============================
//  = Background Settings End    =
//  =============================

?>