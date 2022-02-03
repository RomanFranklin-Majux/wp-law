<?php 

/**
 * Add stylesheet to the page
 */
function wplaw_enqueue_styles() {

  // Swiper CSS
  wp_enqueue_style( 'swiper-css', 'https://unpkg.com/swiper@7/swiper-bundle.min.css' );

  // Style
  wp_enqueue_style( 'swiper-styles', get_stylesheet_directory_uri() . '/assets/css/slides.css', array(), '1.0.08');



  /* JS
  ---------------------------- */

  // Swiper JS
  wp_register_script( 'swiper-js', 'https://unpkg.com/swiper@7/swiper-bundle.min.js' );

  // Swiper Inits
  wp_register_script('swiper-inits', get_stylesheet_directory_uri() . '/assets/js/swipers.js', array(), '1.0.06', true);
  
  wp_enqueue_script('swiper-js');
  wp_enqueue_script('swiper-inits');

}
add_action( 'wp_enqueue_scripts', 'wplaw_enqueue_styles', 20 );




function wplaw_results_shortcode() { 
	ob_start();
	get_template_part('template-parts/results-slider');
    
	return ob_get_clean();
} 

add_shortcode('results_slider', 'wplaw_results_shortcode'); 
 ?>