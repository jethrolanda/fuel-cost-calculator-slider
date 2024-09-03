<?php

namespace FSCS\Plugin;

/**
 * Plugins custom settings page that adheres to wp standard
 * see: https://developer.wordpress.org/plugins/settings/custom-settings-page/
 *
 * @since   1.0
 */

defined('ABSPATH') || exit;

/**
 * WP Settings Class.
 */
class Email
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
   * Send email
   * 
   * @since 1.0
   */
  public function send_email()
  {

    $subject = get_option('fscs_email_subject');
    $subject = empty($subject) ? FSCS_EMAIL_SUBJECT : $subject;

    $body = get_option('fscs_email_body');
    $body = empty($body) ? FSCS_EMAIL_BODY : $body;

    $customer_name = isset($_POST['customer_name']) ? sanitize_text_field($_POST['customer_name']) : '';
    $customer_email = isset($_POST['customer_email']) ? sanitize_text_field($_POST['customer_email']) : '';
    $yearly_fuel_savings = isset($_POST['calculator_data']) && isset($_POST['calculator_data']['yearly_fuel_savings']) ? sanitize_text_field($_POST['calculator_data']['yearly_fuel_savings']) : '';

    // Email Tags
    $body = str_replace('{customer_name}', $customer_name, $body);
    $body = str_replace('{customer_email}', $customer_email, $body);
    $body = str_replace('{estimated_yearly_savings}', $yearly_fuel_savings, $body);

    $body = wp_unslash($body);
    $headers[] = 'Content-Type: text/html; charset=UTF-8';

    // From name and from email
    $salesperson_name = isset($_POST['salesperson_name']) ? sanitize_text_field($_POST['salesperson_name']) : '';
    $salesperson_email = isset($_POST['salesperson_email']) ? sanitize_text_field($_POST['salesperson_email']) : '';

    if (!empty($salesperson_name) && !empty($salesperson_email)) {
      $body = str_replace('{salesperson_name}', $salesperson_name, $body);
      $body = str_replace('{salesperson_position}', 'Salesperson', $body);
      $headers[] = 'From: ' . $salesperson_name . ' <' . $salesperson_email . '>';
      $headers[] = 'Cc: ' . $salesperson_email;
    } else {
      $body = str_replace('{salesperson_name}', 'Jordan Turner', $body);
      $body = str_replace('{salesperson_position}', 'Fuel Delivery Expert', $body);
      $headers[] = 'From: Fuel Logic <sales@fuellogic.net>';
    }


    // CC
    $cc_emails = get_option('fscs_email_cc');
    if (!empty($cc_emails)) {
      foreach ($cc_emails as $e) {
        $headers[] = 'Cc: ' . $e['cc'];
      }
    }

    // BCC
    $bcc_emails = get_option('fscs_email_bcc');
    if (!empty($bcc_emails)) {
      foreach ($bcc_emails as $e) {
        $headers[] = 'Bcc: ' . $e['bcc'];
      }
    }

    // pdf file
    $pdf_file = isset($_POST['pdf_file']) ? $_POST['pdf_file'] : '';

    // wp_mail( $to, $subject, $message, $headers, $attachments );
    wp_mail($customer_email, $subject, $body, $headers, array($pdf_file));
  }
}
