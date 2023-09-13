<?php
/**
 * Plugin Name: Fuel Cost Calculator Slider
 * Description: Calculate saved fuel
 * Version: 1.0
 * Author: Jethro Landa
 * Author URI: https://jethrolanda.com/
 * Text Domain: fuel-cost-calculator-slider
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
add_shortcode('fuel_cost_calculator_slider', 'calculator_slider_shortcode');


// Load scripts
function load_front_end_styles_and_scripts()
{
  global $post;
  
  if(has_shortcode($post->post_content, 'fuel_cost_calculator_slider')){
    wp_enqueue_style('range-slider-style-custom', plugins_url() . '/fuel-cost-calculator-slider/css/style.css');
    wp_enqueue_style('range-slider-style', 'https://cdnjs.cloudflare.com/ajax/libs/rangeslider.js/2.3.3/rangeslider.min.css');

    wp_enqueue_script('range-slider-script', 'https://cdnjs.cloudflare.com/ajax/libs/rangeslider.js/2.3.3/rangeslider.min.js', array(), '1.0.0', true);
    wp_enqueue_script('range-slider-setup-script', plugins_url() . '/fuel-cost-calculator-slider/js/slider-options.js', array(), '1.0.0', true);
    
  }
  
  
}

add_action('wp_enqueue_scripts', 'load_front_end_styles_and_scripts' );
