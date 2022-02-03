<?php

//  =============================
//  = Render Stylings           =
//  =============================

TMF_Customize::$TMF_CustomizerCSS[] = array(
    'selectors' => array( '#mobile-nav'),
    'raw' => array(
        'background' => array(
            'style' => 'opacity',
            'color' => 'tmf_menubar_background_color',
            'opacity' => 'tmf_menubar_opacity'
        ),
        'css' => array(
            'height' => array(
                'option' => 'tmf_menubar_height',
                'suffix' => 'px'
            )
        )
    ),
    
);

TMF_Customize::$TMF_CustomizerCSS[] = array(
    'selectors' => array( '#mobile-nav .hamburger, #mobile-nav .hamburger:before, #mobile-nav .hamburger:after'),
    'raw' => array(
        'background' => array(
            'color' => 'tmf_mobile_nav_menu_button_color'
        )
    ),
);

TMF_Customize::$TMF_CustomizerCSS[] = array(
    'selectors' => array( '.hamburger:hover, .hamburger:hover:before, .hamburger:hover:after'),
    'raw' => array(
        'background' => array(
            'color' => 'tmf_mobile_nav_menu_button_hover_color'
        )
    ),
);

TMF_Customize::$TMF_CustomizerCSS[] = array(
    'selectors' => array( '#mobile-nav .mobile-menu'),
    'raw' => array(
        'background' => array(
            'color' => 'tmf_mobile_background_color'
        )
    ),
);

TMF_Customize::$TMF_CustomizerCSS[] = array(
    'selectors' => array( '.menu-bar-container'),
    'raw' => array(
        'text-align' => 'tmf_mobile_nav_menu_button_position',
        'margin' => array(
            'top' => 'tmf_mobile_nav_menu_button_top_distance',
            'left' => 'tmf_mobile_nav_menu_button_side_distance',
            'right' => 'tmf_mobile_nav_menu_button_side_distance'
        )
    )
);

TMF_Customize::$TMF_CustomizerCSS[] = array(
    'selectors' => array( '.menu-bar-container .menu-label'),
    'raw' => array(
        'color' => 'tmf_mobile_nav_menu_button_label_color',
        'font-size' => 'tmf_mobile_nav_menu_button_label_font_size',
        'letter-spacing' => 'tmf_mobile_nav_menu_button_label_letter_spacing'
    )
);

TMF_Customize::$TMF_CustomizerCSS[] = array(
    'selectors' => array( '.menu-bar-container .menu-label:hover'),
    'raw' => array(
        'color' => 'tmf_mobile_nav_menu_button_label_hover_color'
    )
);

TMF_Customize::$TMF_CustomizerCSS[] = array(
    'selectors' => array( '#mobile-nav .menu .menu-item.display'),
    'raw' => array(
        'background' => array(
            'color' => 'tmf_mobile_submenu_background_color'
        )
    ),
);

TMF_Customize::$TMF_CustomizerCSS[] = array(
    'selectors' => array( '#mobile-nav .mob-expand-submenu:before'),
    'raw' => array(
        'color' => 'tmf_mobile_submenu_icon_color'
    ),
);

TMF_Customize::$TMF_CustomizerCSS[] = array(
    'selectors' => array( '#mobile-nav .menu .menu-item.display > .mob-expand-submenu:before'),
    'raw' => array(
        'color' => 'tmf_mobile_submenu_icon_color_active'
    ),
);


TMF_Customize::$TMF_CustomizerCSS[] = array(
    'selectors' => array( '#mobile-nav .menu > .menu-item > a'),
    'raw' => array(
        'color' => 'tmf_mobile_nav_menu_color',
        'font-size' => 'tmf_mobile_nav_menu_font_size',
        'letter-spacing' => 'tmf_mobile_nav_menu_letter_spacing',
        'margin' => array(
            'top' => 'tmf_mobile_nav_menu_vertical_spacing'
        )
    ),
);

TMF_Customize::$TMF_CustomizerCSS[] = array(
    'selectors' => array( '#mobile-nav .mobile-menu .current-menu-item > a'),
    'raw' => array(
        'color' => 'tmf_mobile_nav_menu_current_color'
    ),
);

TMF_Customize::$TMF_CustomizerCSS[] = array(
    'selectors' => array( '#mobile-nav .menu > .menu-item > a:hover'),
    'raw' => array(
        'color' => 'tmf_mobile_nav_menu_hover_color'
    ),
);

TMF_Customize::$TMF_CustomizerCSS[] = array(
    'selectors' => array( '#mobile-nav .menu .menu-item.display .sub-menu a'),
    'raw' => array(
        'color' => 'tmf_mobile_nav_submenu_color',
        'font-size' => 'tmf_mobile_nav_submenu_font_size',
        'letter-spacing' => 'tmf_mobile_nav_submenu_letter_spacing',
        'margin' => array(
            'top' => 'tmf_mobile_nav_submenu_vertical_spacing'
        )
    ),
);

TMF_Customize::$TMF_CustomizerCSS[] = array(
    'selectors' => array( '#mobile-nav .menu .menu-item.display .sub-menu .current-menu-item a'),
    'raw' => array(
        'color' => 'tmf_mobile_nav_submenu_current_color'
    ),
);

TMF_Customize::$TMF_CustomizerCSS[] = array(
    'selectors' => array( '#mobile-nav .menu .menu-item.display .sub-menu a:hover'),
    'raw' => array(
        'color' => 'tmf_mobile_nav_submenu_hover_color'
    ),
);