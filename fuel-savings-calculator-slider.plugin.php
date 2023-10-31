<?php
if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly

require_once FSCS_INCLUDES_ROOT_DIR . 'class-fscs-scripts.php';
require_once FSCS_INCLUDES_ROOT_DIR . 'class-fscs-slider-shortcode.php';
require_once FSCS_INCLUDES_ROOT_DIR . 'class-fscs-pdf-report-shortcode.php';
require_once FSCS_INCLUDES_ROOT_DIR . 'class-fscs-generate-pdf-report.php';
require_once FSCS_INCLUDES_ROOT_DIR . 'class-fscs-settings.php';
require_once FSCS_INCLUDES_ROOT_DIR . 'class-fscs-data-store.php';
require_once FSCS_INCLUDES_ROOT_DIR . 'class-fscs-email.php';
require_once FSCS_INCLUDES_ROOT_DIR . 'class-fscs-recaptcha.php';


class Fuel_Savings_Calculator_Slider {

    /*
    |------------------------------------------------------------------------------------------------------------------
    | Class Members
    |------------------------------------------------------------------------------------------------------------------
     */
    private static $_instance;

    public $_fscs_scripts;
    public $_fscs_slider_shortcode;
    public $_fscs_pdf_report_shortcode;
    public $_fscs_generate_pdf_report;
    public $_fscs_settings;
    public $_fscs_data_store;
    public $_fscs_email;
    public $_fscs_recaptcha;

    const VERSION = '1.0';

    /*
    |------------------------------------------------------------------------------------------------------------------
    | Mesc Functions
    |------------------------------------------------------------------------------------------------------------------
     */

    /**
     * Class constructor.
     *
     * @since 1.0.0
     */
    public function __construct() {

      $this->_fscs_scripts = FSCS_Scripts::instance();
      $this->_fscs_slider_shortcode = FSCS_Slider_Shortcode::instance();
      $this->_fscs_pdf_report_shortcode = FSCS_PDF_Report_Shortcode::instance();
      $this->_fscs_generate_pdf_report = FSCS_Generate_PDF_Report::instance();
      $this->_fscs_settings = FSCS_Settings::instance();
      $this->_fscs_data_store = FSCS_Data_Store::instance();
      $this->_fscs_email = FSCS_Email::instance();
      $this->_fscs_recaptcha = FSCS_Recaptcha::instance();

    }

    /**
     * Singleton Pattern.
     *
     * @since 1.0.0
     *
     * @return Fuel_Savings_Calculator_Slider
     */
    public static function instance() {

      if (!self::$_instance instanceof self) {
          self::$_instance = new self;
      }

      return self::$_instance;
    }

    /**
     * Trigger on activation
     *
     * @since 1.0.0
     */
    public function activate() {
      
      if(get_option('fscs_email_subject') == "") {
        update_option('fscs_email_subject', FSCS_EMAIL_SUBJECT);
      }
      
      if(get_option('fscs_email_body') == "") {
        update_option('fscs_email_body', FSCS_EMAIL_BODY);
      }

      // Create custom table
      $this->_fscs_data_store->create_custom_db_table();

    }

    /**
     * Trigger on deactivation
     *
     * @since 1.0.0
     */
    public function deactivate() {

    }

    /**
     * Triggers the execution codes of the plugin models.
     *
     * @since 1.0
     * @access public
     */
    public function run() {
      
      // Register Activation Hook
      register_activation_hook(FSCS_PLUGIN_DIR . 'fuel-savings-calculator-slider.php', array($this, 'activate'));

      // Register Deactivation Hook
      register_deactivation_hook(FSCS_PLUGIN_DIR . 'fuel-savings-calculator-slider.php', array($this, 'deactivate'));

      // Run all the class hooks
      $this->_fscs_scripts->run();
      $this->_fscs_slider_shortcode->run();
      $this->_fscs_pdf_report_shortcode->run();
      $this->_fscs_generate_pdf_report->run();
      $this->_fscs_settings->run();
      $this->_fscs_data_store->run();
      $this->_fscs_email->run();
      $this->_fscs_recaptcha->run();

    }

}
