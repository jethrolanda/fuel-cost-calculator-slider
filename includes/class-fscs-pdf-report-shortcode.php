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
class FSCS_PDF_Report_Shortcode
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
     * PDF report content
     *
     * @since 1.0
     * @access public
     */
    public function fuel_savings_pdf_report_shortcode() { 

      ob_start();
      require_once(FSCS_TEMPLATES_ROOT_DIR . '/pdf-report.php');
      //assign the file output to $content variable and clean buffer
      $content = ob_get_clean();
      return $content;

    }

    /**
     * Execute Model.
     *
     * @since 1.0
     * @access public
     */
    public function run() { 

      // PDF Report Shortcode
      add_shortcode('fuel_savings_pdf_report', array($this, 'fuel_savings_pdf_report_shortcode'));

    }
    
}