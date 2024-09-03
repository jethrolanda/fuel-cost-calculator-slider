<?php
if (!defined('ABSPATH')) {
  exit;
}
// Exit if accessed directly

require_once 'autoloader.php';


class Fuel_Savings_Calculator_Slider
{

  /*
    |------------------------------------------------------------------------------------------------------------------
    | Class Members
    |------------------------------------------------------------------------------------------------------------------
     */
  private static $_instance;

  public $scripts;
  public $slider_shortcode;
  public $pdf_report_shortcode;
  public $generate_pdf_report;
  public $settings;
  public $data_store;
  public $email;
  public $recaptcha;
  public $hubspot_users;

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
  public function __construct()
  {

    $this->scripts = FSCS\Plugin\Scripts::instance();
    $this->slider_shortcode = FSCS\Plugin\Slider_Shortcode::instance();
    $this->pdf_report_shortcode = FSCS\Plugin\PDF_Report_Shortcode::instance();
    $this->generate_pdf_report = FSCS\Plugin\Generate_PDF_Report::instance();
    $this->settings = FSCS\Plugin\Settings::instance();
    $this->data_store = FSCS\Plugin\Data_Store::instance();
    $this->email = FSCS\Plugin\Email::instance();
    $this->recaptcha = FSCS\Plugin\Recaptcha::instance();
    $this->hubspot_users = FSCS\Plugin\Hubspot_Users::instance();

    // Register Activation Hook
    register_activation_hook(FSCS_PLUGIN_DIR . 'fuel-savings-calculator-slider.php', array($this, 'activate'));

    // Register Deactivation Hook
    register_deactivation_hook(FSCS_PLUGIN_DIR . 'fuel-savings-calculator-slider.php', array($this, 'deactivate'));
  }

  /**
   * Singleton Pattern.
   *
   * @since 1.0.0
   *
   * @return Fuel_Savings_Calculator_Slider
   */
  public static function instance()
  {

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
  public function activate()
  {

    if (get_option('fscs_email_subject') == "") {
      update_option('fscs_email_subject', FSCS_EMAIL_SUBJECT);
    }

    if (get_option('fscs_email_body') == "") {
      update_option('fscs_email_body', FSCS_EMAIL_BODY);
    }

    // Create custom table
    $this->data_store->create_custom_db_table();
  }

  /**
   * Trigger on deactivation
   *
   * @since 1.0.0
   */
  public function deactivate()
  {
  }
}
