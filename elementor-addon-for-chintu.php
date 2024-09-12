<?php
/**
 * Plugin Name: Elementor Addon for Chintu
 * Description: Simple widgets for Chintu.
 * Version:     1.0.0
 * Author:      Ahmed Imran
 * Author URI:  https://webappick.com/
 * Text Domain: Chintu
 *
 * Requires Plugins: elementor
 * Elementor tested up to: 3.24.0
 * Elementor Pro tested up to: 3.24.0
 */

function register_chintu_widget( $widgets_manager ) {

    require_once __DIR__ . '/widgets/elementor-category-list-widget.php';
    require_once __DIR__ . '/widgets/category-carousel-widget.php';
    require_once __DIR__ . '/widgets/elementor-banner-slider-widget.php';

    $widgets_manager->register( new \Elementor_Category_List_Widget() );
    $widgets_manager->register( new \Elementor_Category_Carousel_Widget() );
    $widgets_manager->register( new \Elementor_Banner_Slider_Widget() );

}
add_action( 'elementor/widgets/register', 'register_chintu_widget' );
function enqueue_category_post_widget_scripts() {
    wp_register_script( 'swiper-js', 'https://unpkg.com/swiper/swiper-bundle.min.js', [], '6.0', true );
    wp_register_style( 'swiper-css', 'https://unpkg.com/swiper/swiper-bundle.min.css', [], '6.0' );

    // Enqueue custom styles for the widget
    wp_enqueue_style( 'category-post-widget-style', plugins_url( '/assets/css/style.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'enqueue_category_post_widget_scripts' );