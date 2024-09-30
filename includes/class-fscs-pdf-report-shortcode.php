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
class PDF_Report_Shortcode
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
    // PDF Report Shortcode
    add_shortcode('fuel_savings_pdf_report', array($this, 'fuel_savings_pdf_report_shortcode'));

    // PDF Report Shortcode for Salesperson
    add_shortcode('fuel_savings_pdf_report_for_salesperson', array($this, 'fuel_savings_sales_pdf_report_shortcode'));
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
   * PDF report content
   *
   * @since 1.0
   * @access public
   */
  public function fuel_savings_pdf_report_shortcode($atts = array())
  {
    $atts = shortcode_atts(array(
      'title' => '📄EMAIL ME THE REPORT',
    ), $atts);

    extract($atts);

    if (empty($title)) {
      $title = '📄EMAIL ME THE REPORT';
    }

    ob_start();

    echo '<div class="fuel-savings-pdf-report-wrapper">';
    echo '<p><a class="pdf-report-btn">' . $title . '</a></p>';
    require_once(FSCS_TEMPLATES_ROOT_DIR . '/pdf-report-modal-form.php');
    echo '</div>';

    //assign the file output to $content variable and clean buffer
    $content = ob_get_clean();
    return $content;
  }

  /**
   * Salesperson PDF report content
   *
   * @since 1.0
   * @access public
   */
  public function fuel_savings_sales_pdf_report_shortcode($atts = array())
  {

    $atts = shortcode_atts(array(
      'title' => '📄EMAIL REPORT TO CUSTOMER',
    ), $atts);

    extract($atts);

    if (empty($title)) {
      $title = '📄EMAIL REPORT TO CUSTOMER';
    }

    ob_start();

    echo '<div class="fuel-savings-pdf-report-wrapper">';
    echo '<p><a class="pdf-report-salesperson-btn">' . $title . '</a></p>';
    require_once(FSCS_TEMPLATES_ROOT_DIR . '/pdf-report-salesperson-modal-form.php');
    echo '</div>';

    //assign the file output to $content variable and clean buffer
    $content = ob_get_clean();
    return $content;
  }
}
