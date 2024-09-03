<?php

namespace FSCS\Plugin;

/**
 * Plugins custom settings page that adheres to wp standard
 * see: https://developer.wordpress.org/plugins/settings/custom-settings-page/
 *
 * @since   1.0
 */

defined('ABSPATH') || exit;

require_once __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;

/**
 * WP Settings Class.
 */
class Generate_PDF_Report
{

  /**
   * The single instance of the class.
   *
   * @since 1.0
   */
  protected static $_instance = null;

  /**
   * Class constructor.
   *
   * @since 1.0.0
   */
  public function __construct()
  {
    add_action('wp_ajax_fscs_generate_pdf', array($this, 'fscs_generate_pdf'));
    add_action('wp_ajax_nopriv_fscs_generate_pdf', array($this, 'fscs_generate_pdf'));
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
   * Main Instance.
   * 
   * @since 1.0
   */
  public function fscs_generate_pdf()
  {

    if (apply_filters('fscs_bypass_generate_pdf_security', false) === false) {
      if (!defined('DOING_AJAX') || !DOING_AJAX) {
        wp_die();
      }

      /**
       * Verify nonce
       */
      if (isset($_POST['_wpnonce']) && !wp_verify_nonce($_POST['_wpnonce'], 'submit_pdf_report')) {
        wp_die();
      }
    }

    $dompdf = new Dompdf();

    // $html = file_get_contents(FSCS_TEMPLATES_ROOT_DIR. 'pdf-template.html');
    $dompdf->loadHtml($this->pdf_template());

    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('Tabloid', 'portrait');

    // Render the HTML as PDF
    $dompdf->render();

    $output = $dompdf->output();

    // Store to wp uploads folder
    $upload_dir = wp_upload_dir();
    $base_dir = $upload_dir['basedir'] . '/fuel-savings-calculator-slider/';

    // Creates the dir
    if (!is_dir($base_dir)) {
      wp_mkdir_p($base_dir);
    }

    $customer_name = isset($_POST['customer_name']) ? $_POST['customer_name'] : '';
    $customer_email = isset($_POST['customer_email']) ? $_POST['customer_email'] : '';
    $salesperson_name = isset($_POST['salesperson_name']) ? $_POST['salesperson_name'] : '';
    $salesperson_email = isset($_POST['salesperson_email']) ? $_POST['salesperson_email'] : '';

    $current_datetime = current_datetime()->format('Y-m-d--H-i-s');
    $file_name = 'fuel-savings-report--' . $current_datetime . '--' . str_replace(' ', '-', strtolower($customer_name)) . '.pdf';

    // Save file to wp-uploads/fuel-savings-calculator-slider
    file_put_contents($base_dir . $file_name, $output);

    global $fscs;

    // PDF location
    $pdf_file = $upload_dir['baseurl'] . '/fuel-savings-calculator-slider/' . $file_name;

    // Used for email attachment
    $_POST['pdf_file'] = $base_dir . $file_name;

    // Slider data
    $slider_data = isset($_POST['calculator_data']) ? maybe_serialize($_POST['calculator_data']) : '';

    // Save new entry to db
    // Dont save when using send test email feature
    if (apply_filters('fscs_send_test_email', false) === false) {
      $fscs->data_store->save_entry($customer_name, $customer_email, $salesperson_name, $salesperson_email, $pdf_file, $slider_data);
    }

    // Validate recaptcha
    if (apply_filters('fscs_bypass_recaptcha_security', false) || $fscs->recaptcha->validate_recaptcha()) {

      // Send email
      $fscs->email->send_email();
      wp_send_json(array('status' => 'success'));
    } else {

      wp_send_json(array('error' => 'Recaptcha is invalid.'));
    }
  }

  /**
   * PDF template
   * 
   * @since 1.0
   */
  private function pdf_template()
  {

    ob_start();

    require_once(FSCS_TEMPLATES_ROOT_DIR . '/pdf-template.php');

    return ob_get_clean();
  }
}
