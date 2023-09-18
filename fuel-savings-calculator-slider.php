<?php
/**
 * Plugin Name: Fuel Savings Calculator Slider
 * Description: Calculate saved fuel
 * Version: 1.0
 * Author: Jethro Landa
 * Author URI: https://jethrolanda.com/
 * Text Domain: fuel-savings-calculator-slider
 * Domain Path: /languages/
 * Requires at least: 5.7
 * Requires PHP: 7.2
 */

defined('ABSPATH') || exit;

// function that runs when shortcode is called
function calculator_slider_shortcode() { 
  
  ob_start();
  require_once('templates/slider-view.php');
  //assign the file output to $content variable and clean buffer
  $content = ob_get_clean();
  return $content;
}

// register shortcode
add_shortcode('fuel_savings_calculator_slider', 'calculator_slider_shortcode');


// Load frontend and backend scripts
function load_front_end_styles_and_scripts()
{
  global $post;
  $ct_builder = isset($_GET['ct_builder']) && $_GET['ct_builder'] === "true" ? true : false;

  if(has_shortcode($post->post_content, 'fuel_savings_calculator_slider') || $ct_builder) {
    wp_enqueue_style('range-slider-style-custom', plugins_url() . '/fuel-savings-calculator-slider/css/style.css');
    wp_enqueue_style('range-slider-style', 'https://cdnjs.cloudflare.com/ajax/libs/rangeslider.js/2.3.3/rangeslider.min.css');

    wp_enqueue_script('range-slider-script', 'https://cdnjs.cloudflare.com/ajax/libs/rangeslider.js/2.3.3/rangeslider.min.js', array(), '1.0.0', true);
    wp_enqueue_script('range-slider-setup-script', plugins_url() . '/fuel-savings-calculator-slider/js/slider-options.js', array(), '1.0.0', true);
    
    // Tooltip
    wp_enqueue_style('range-slider-style-tippy-css-animation', 'https://unpkg.com/tippy.js@6/animations/scale.css');
    
    wp_enqueue_script('range-slider-tooltip-popper', 'https://unpkg.com/@popperjs/core@2', array(), '1.0.0', true);
    wp_enqueue_script('range-slider-tooltip-tippy', 'https://unpkg.com/tippy.js@6', array(), '1.0.0', true);
    
  }
  
  
}

add_action('wp_enqueue_scripts', 'load_front_end_styles_and_scripts' );
add_action('admin_enqueue_scripts', 'load_front_end_styles_and_scripts' );