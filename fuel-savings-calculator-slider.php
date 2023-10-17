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
  
  if($post && has_shortcode($post->post_content, 'fuel_savings_calculator_slider')) {

    plugin_scripts();
    
  }
  
}

function load_oxygen_scripts() {

  global $post;

  if($post && $post->ID){
    $shortcodes = get_post_meta( $post->ID, "ct_builder_shortcodes", true );
    if(strpos($shortcodes, '[fuel_savings_calculator_slider]') !== false) {
      plugin_scripts();
    }
  }

}

function plugin_scripts(){
  
  wp_enqueue_style('range-slider-style-custom', plugins_url() . '/fuel-savings-calculator-slider/css/style.min.css');
  wp_enqueue_style('range-slider-style', plugins_url() . '/fuel-savings-calculator-slider/css/rangeslider.min.css');

  wp_enqueue_script('range-slider-script', plugins_url() . '/fuel-savings-calculator-slider/js/rangeslider.min.js', array('jquery'), '1.0.0', false);
  wp_enqueue_script('range-slider-setup-script', plugins_url() . '/fuel-savings-calculator-slider/js/slider-options.js', array('jquery'), '1.0.0', false);

}

// For regular post content
add_action('wp_enqueue_scripts', 'load_front_end_styles_and_scripts' );
add_action('admin_enqueue_scripts', 'load_front_end_styles_and_scripts' );

// For compatibility with oxygen plugin
add_action('oxygen_enqueue_iframe_scripts', 'plugin_scripts' );
add_action('oxygen_enqueue_ui_scripts', 'plugin_scripts' );

add_action('oxygen_enqueue_frontend_scripts', 'load_oxygen_scripts' );
add_action('wp_print_footer_scripts', function() { ?>
  <script>
      (function($) {
        var viewport = $("#ct-artificial-viewport");

        $('body').on('DOMSubtreeModified', function(){
          
          var weeks = 52;
          var months = 12;
          var rate_per_minute = 0;
          var minutes_in_an_hour = 60;

          var calculateSavedFuel = function() {

            // Update Estimated Savings
            var a = parseInt($("#estimated-gallons-per-fill-input").val());
            var b = parseInt($("#number-of-units-input").val());
            var c = parseInt($("#number-of-operators-input").val());
            var d = parseInt($("#hourly-rate-input").val());
            var e = parseInt($("#round-trip-per-fueling-input").val());
            var f = parseInt($("#frequency-of-fueling-input").val());

            rate_per_minute = d / 60;
            // Estimated Gallons Consumed per Month
            var estimated_gallons_consumed_per_month = a * b * f * weeks / months;
            estimated_gallons_consumed_per_month = Math.round(estimated_gallons_consumed_per_month);

            // Man Hours Allocated to Fueling per Week
            var man_hours_allocated_to_fueling_per_week = e * c * b * f / minutes_in_an_hour;
            man_hours_allocated_to_fueling_per_week = Math.round(man_hours_allocated_to_fueling_per_week);

            // Lost Assets and Labor Hours
            var lost_assets_and_labor_hours = estimated_gallons_consumed_per_month + man_hours_allocated_to_fueling_per_week;
            if(lost_assets_and_labor_hours > 0) {
              lost_assets_and_labor_hours = Math.round(lost_assets_and_labor_hours);
              $("#lost-assets-and-labor-hours").text(lost_assets_and_labor_hours.toLocaleString());
            }

            // Estimated Cost of Self Fueling / Labor Savings Per Week
            var labor_savings_per_week = rate_per_minute * e * c * b * f;
            labor_savings_per_week = Math.round(labor_savings_per_week);
            $("#labor-savings-per-week").text("$"+labor_savings_per_week.toLocaleString());

            // Every Gallon You Pump Costs You An Additional
            var additional_costs = rate_per_minute * e * c * b * f;
            if(additional_costs > 0 && estimated_gallons_consumed_per_month > 0) {
              additional_costs = additional_costs / estimated_gallons_consumed_per_month;
              $("#every-gallon-you-pump-costs-an-additional").text("$"+additional_costs.toLocaleString('en-US', {maximumFractionDigits:2}));
            }

            // Estimated Savings Annually
            var estimated_savings_annually = rate_per_minute * e * c * b * f * weeks;
            estimated_savings_annually = Math.round(estimated_savings_annually);
            $("#estimated-savings-annually").text("$"+estimated_savings_annually.toLocaleString('en-US', {maximumFractionDigits:2}));

          }
          
          const myInterval = setInterval(function(){
            setup();
          }, 1000);

          const setup = function () {
            var fuel_savings_wrapper = viewport.contents().find('body').find('.fuel-savings-calculator-wrapper');
            
            if(fuel_savings_wrapper.length !== 0){
              clearInterval(myInterval);
              
              fuel_savings_wrapper.find('input[type="range"]').rangeslider({

                // Feature detection the default is `true`.
                // Set this to `false` if you want to use
                // the polyfill also in Browsers which support
                // the native <input type="range"> element.
                polyfill: false,

                // Default CSS classes
                // rangeClass: 'rangeslider',
                // disabledClass: 'rangeslider--disabled',
                // horizontalClass: 'rangeslider--horizontal',
                // verticalClass: 'rangeslider--vertical',
                // fillClass: 'rangeslider__fill',
                // handleClass: 'rangeslider__handle',

                // Callback function
                onInit: function() { calculateSavedFuel(); },

                // Callback function
                onSlide: function(position, value) {

                  // Change input values
                  var id = this.$element.attr('id');
                  if(id){
                    $('#'+id+'-input').val(value);
                  }

                  calculateSavedFuel();

                },

                // Callback function
                onSlideEnd: function(position, value) {}

              });

              fuel_savings_wrapper.find('input[type="text"]').on('keyup', function(){
                var id = $(this).attr("id");
                var value = parseInt(this.value);

                if(value === undefined) return;

                switch(id) {
                  case "estimated-gallons-per-fill-input":
                    $('#estimated-gallons-per-fill').val(value).change();
                    break;

                  case "number-of-units-input":
                    $('#number-of-units').val(value).change();
                    break;

                  case "number-of-operators-input":
                    $('#number-of-operators').val(value).change();
                    break;

                  case "hourly-rate-input":
                    $('#hourly-rate').val(value).change();
                    break;

                  case "round-trip-per-fueling-input":
                    $('#round-trip-per-fueling').val(value).change();
                    break;
                    
                  case "frequency-of-fueling-input":
                    $('#frequency-of-fueling').val(value).change();
                    break;
                }

              });
            }
          }
        });
        
      })(jQuery);
  </script>
  <?php
},99999);