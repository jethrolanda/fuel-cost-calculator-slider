<?php
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
class FSCS_Email
{

    /**
     * The single instance of the class.
     *
     * @since 1.0
     */
    protected static $_instance = null;

    /**
     * Main Instance.
     * 
     * @since 1.0
     */
    public static function instance(){
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
    public function send_email() {

      $subject = get_option('fscs_email_subject');
      $subject = empty($subject) ? FSCS_EMAIL_SUBJECT : $subject;

      $body = get_option('fscs_email_body');
      $body = empty($body) ? FSCS_EMAIL_BODY : $body;

      $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
      $email = isset($_POST['email']) ? sanitize_text_field($_POST['email']) : '';
      $yearly_fuel_savings = isset($_POST['calculator_data']) && isset($_POST['calculator_data']['yearly_fuel_savings']) ? sanitize_text_field($_POST['calculator_data']['yearly_fuel_savings']) : '';

      // Email Tags
      $body = str_replace('{customer_name}', $name, $body);
      $body = str_replace('{estimated_yearly_savings}', $yearly_fuel_savings, $body);

      $body = wp_unslash($body);
      $headers[] = 'Content-Type: text/html; charset=UTF-8';

      $emails = get_option('fscs_email_cc');
      if(!empty($emails)) {
        foreach($emails as $e) {
          $headers[] = 'Cc: ' . $e['cc'];
        }
      }

      // pdf file
      $pdf_file = isset($_POST['pdf_file']) ? $_POST['pdf_file'] : '';

      // wp_mail( $to, $subject, $message, $headers, $attachments );
      wp_mail( $email, $subject, $body, $headers, array($pdf_file) );

    }

    /**
     * Execute Model.
     *
     * @since 1.0
     * @access public
     */
    public function run() { 

    }
    
}