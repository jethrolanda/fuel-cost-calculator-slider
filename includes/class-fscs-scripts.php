<?php

namespace FSCS\Plugin;

/**
 * Scripts class
 *
 * @since   1.0
 */

defined('ABSPATH') || exit;

class Scripts
{

    /**
     * The single instance of the class.
     *
     * @since 1.0
     */
    protected static $_instance = null;

    private $hours_in_seconds = '';
    /**
     * Class constructor.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->hours_in_seconds = time() - strtotime("today");

        // Load Backend CSS and JS
        add_action('admin_enqueue_scripts', array($this, 'load_front_end_styles_and_scripts'));

        // Load Frontend CSS and JS
        add_action('wp_enqueue_scripts', array($this, 'load_front_end_styles_and_scripts'));

        // For compatibility with oxygen plugin
        add_action('oxygen_enqueue_iframe_scripts', array($this, 'plugin_scripts'));
        add_action('oxygen_enqueue_ui_scripts', array($this, 'plugin_scripts'));
        add_action('oxygen_enqueue_frontend_scripts', array($this, 'load_oxygen_scripts'));
        add_action('wp_print_footer_scripts', array($this, 'oxygen_builder_editor_slider'), 99999);
    }

    /**
     * Main Instance.
     *
     * @since 1.0
     */
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }


    /**
     * Only load scripts on page that is being used
     *
     * @since 1.0
     */
    public function load_front_end_styles_and_scripts()
    {

        global $post, $fscs;

        // Range Slider Styles
        wp_register_style('range-slider-style-custom',  FSCS_CSS_ROOT_URL . 'style.min.css', array(), $this->hours_in_seconds);
        wp_register_style('range-slider-style', FSCS_CSS_ROOT_URL . 'rangeslider.min.css', array(), $this->hours_in_seconds);

        // Range Slider Scripts
        wp_register_script('range-slider-script', FSCS_JS_ROOT_URL . 'rangeslider.min.js', array('jquery'), $this->hours_in_seconds, false);
        wp_register_script('range-slider-setup-script', FSCS_JS_ROOT_URL . 'slider-options.js', array('jquery'), $this->hours_in_seconds, false);

        // PDF REPORT
        wp_register_script('pdf-report-script', FSCS_JS_ROOT_URL . 'pdf-report.js', array('jquery'), $this->hours_in_seconds, false);
        wp_localize_script(
            'pdf-report-script',
            'options',
            array(
                'ajax' => admin_url('admin-ajax.php')
            )
        );

        // JQUERY MODAL
        wp_register_script('pdf-report-modal-script', FSCS_JS_ROOT_URL . 'jquery-modal/jquery.modal.min.js', array('jquery'), $this->hours_in_seconds, false);
        wp_register_style('pdf-report-modal-style', FSCS_JS_ROOT_URL . 'jquery-modal/jquery.modal.min.css', array(), $this->hours_in_seconds);

        // Toastr
        wp_register_script('pdf-report-toastr-script', FSCS_JS_ROOT_URL . 'toastr/toastr.min.js', array('jquery'), $this->hours_in_seconds, false);
        wp_register_style('pdf-report-toastr-style', FSCS_JS_ROOT_URL . 'toastr/toastr.min.css', array(), $this->hours_in_seconds);

        // Google Recaptcha
        wp_register_script('pdf-report-google-recaptcha-script', 'https://www.google.com/recaptcha/api.js', array('jquery'), $this->hours_in_seconds, false);

        if ($post && has_shortcode($post->post_content, 'fuel_savings_calculator_slider')) {

            $this->plugin_scripts();
        }

        // Backend Settings Page React App
        if (isset($_GET['page']) && $_GET['page'] == 'fuel_savings_settings') {
            wp_enqueue_style('fuel-savings-setting-style', FSCS_JS_ROOT_URL . 'settings/build/index.css', array(), $this->hours_in_seconds);
            wp_enqueue_script('fuel-savings-setting-script', FSCS_JS_ROOT_URL . 'settings/build/index.js', array('wp-element', 'wp-i18n'),  $this->hours_in_seconds, true);
            wp_localize_script('fuel-savings-setting-script', 'fscs_settings', array(
                'rest_url'   => esc_url_raw(get_rest_url()),
                'nonce' => wp_create_nonce('wp_rest'),
                'ajax_url' => admin_url('admin-ajax.php'),
                'settings_nonce' => wp_create_nonce('settings_nonce'),
            ));
        }
    }

    /**
     * Load scripts
     *
     * @since 1.0
     */
    public function plugin_scripts()
    {

        wp_enqueue_style('range-slider-style-custom');
        wp_enqueue_style('range-slider-style');

        wp_enqueue_script('range-slider-script');
        wp_enqueue_script('range-slider-setup-script');

        // PDF REPORT
        wp_enqueue_script('pdf-report-script');

        // JQUERY MODAL
        wp_enqueue_script('pdf-report-modal-script');
        wp_enqueue_style('pdf-report-modal-style');

        // Toastr
        wp_enqueue_script('pdf-report-toastr-script');
        wp_enqueue_style('pdf-report-toastr-style');

        // Google Recaptcha
        wp_enqueue_script('pdf-report-google-recaptcha-script');
    }

    /**
     * Load scripts
     *
     * @since 1.0
     */
    public function load_oxygen_scripts()
    {

        global $post;

        if ($post && $post->ID) {
            $shortcodes = get_post_meta($post->ID, "_ct_builder_shortcodes", true);
            if (strpos($shortcodes, '[fuel_savings_calculator_slider]') !== false) {
                $this->plugin_scripts();
            }
        }
    }

    /**
     * Display properly the slider when using the oxygen builder
     *
     * @since 1.0
     */
    public function oxygen_builder_editor_slider()
    { ?>

        <script>
            (function($) {
                var viewport = $("#ct-artificial-viewport");

                $('body').on('DOMSubtreeModified', function() {

                    var weeks = 52;
                    var months = 12;
                    var rate_per_minute = 0;
                    var minutes_in_an_hour = 60;

                    var calculateSavedFuel = function() {

                        var fuel_savings_wrapper = viewport.contents().find('body').find('.fuel-savings-calculator-wrapper');

                        // Update Estimated Savings
                        var a = parseInt(fuel_savings_wrapper.find("#estimated-gallons-per-fill-input").val());
                        var b = parseInt(fuel_savings_wrapper.find("#number-of-units-input").val());
                        var c = parseInt(fuel_savings_wrapper.find("#number-of-operators-input").val());
                        var d = parseInt(fuel_savings_wrapper.find("#hourly-rate-input").val());
                        var e = parseInt(fuel_savings_wrapper.find("#round-trip-per-fueling-input").val());
                        var f = parseInt(fuel_savings_wrapper.find("#frequency-of-fueling-input").val());

                        rate_per_minute = d / 60;
                        // Estimated Gallons Consumed per Month
                        var estimated_gallons_consumed_per_month = a * b * f * weeks / months;
                        estimated_gallons_consumed_per_month = Math.round(estimated_gallons_consumed_per_month);

                        // Man Hours Allocated to Fueling per Week
                        var man_hours_allocated_to_fueling_per_week = e * c * b * f / minutes_in_an_hour;
                        man_hours_allocated_to_fueling_per_week = Math.round(man_hours_allocated_to_fueling_per_week);

                        // Lost Assets and Labor Hours
                        var lost_assets_and_labor_hours = estimated_gallons_consumed_per_month + man_hours_allocated_to_fueling_per_week;
                        if (lost_assets_and_labor_hours > 0) {
                            lost_assets_and_labor_hours = Math.round(lost_assets_and_labor_hours);
                            fuel_savings_wrapper.find("#lost-assets-and-labor-hours").text(lost_assets_and_labor_hours.toLocaleString());
                        }

                        // Estimated Cost of Self Fueling / Labor Savings Per Week
                        var labor_savings_per_week = rate_per_minute * e * c * b * f;
                        labor_savings_per_week = Math.round(labor_savings_per_week);
                        fuel_savings_wrapper.find("#labor-savings-per-week").text("$" + labor_savings_per_week.toLocaleString());

                        // Every Gallon You Pump Costs You An Additional
                        var additional_costs = rate_per_minute * e * c * b * f;
                        if (additional_costs > 0 && estimated_gallons_consumed_per_month > 0) {
                            additional_costs = additional_costs / estimated_gallons_consumed_per_month;
                            fuel_savings_wrapper.find("#every-gallon-you-pump-costs-an-additional").text("$" + additional_costs.toLocaleString('en-US', {
                                maximumFractionDigits: 2
                            }));
                        }

                        // Estimated Savings Annually
                        var estimated_savings_annually = rate_per_minute * e * c * b * f * weeks;
                        estimated_savings_annually = Math.round(estimated_savings_annually);
                        fuel_savings_wrapper.find("#estimated-savings-annually").text("$" + estimated_savings_annually.toLocaleString('en-US', {
                            maximumFractionDigits: 2
                        }));

                    }

                    const myInterval = setInterval(function() {
                        setup();
                    }, 1000);

                    const setup = function() {
                        var fuel_savings_wrapper = viewport.contents().find('body').find('.fuel-savings-calculator-wrapper');

                        if (fuel_savings_wrapper.length !== 0) {
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
                                onInit: function() {
                                    calculateSavedFuel();
                                },

                                // Callback function
                                onSlide: function(position, value) {

                                    // Change input values
                                    var id = this.$element.attr('id');
                                    if (id) {
                                        $('#' + id + '-input').val(value);
                                    }

                                    calculateSavedFuel();

                                },

                                // Callback function
                                onSlideEnd: function(position, value) {}

                            });

                            fuel_savings_wrapper.find('input[type="text"]').on('keyup', function() {
                                var id = $(this).attr("id");
                                var value = parseInt(this.value);

                                if (value === undefined) return;

                                switch (id) {
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

    }
}
