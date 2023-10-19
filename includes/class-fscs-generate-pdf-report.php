<?php
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
class FSCS_Generate_PDF_Report
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
    public static function instance() {
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
    public function fscs_generate_pdf() {
      
      // Get html data
      // ob_start();
      // include_once FSCS_TEMPLATES_ROOT_DIR. 'pdf-template.html';
      // $data = ob_get_clean();
      
      $dompdf = new Dompdf();
      $html = file_get_contents(FSCS_TEMPLATES_ROOT_DIR. 'pdf-template.html');
      $dompdf->loadHtml($html);
      
      // (Optional) Setup the paper size and orientation
      $dompdf->setPaper('Tabloid', 'portrait');

      // Render the HTML as PDF
      $dompdf->render();

      $output = $dompdf->output();
      file_put_contents(FSCS_PLUGIN_DIR.'/Brochure.pdf', $output);

      wp_send_json(array('status' => 'success'));
    }

    /**
     * Execute Model.
     *
     * @since 1.0
     * @access public
     */
    public function run() { 

      add_action('wp_ajax_fscs_generate_pdf', array($this, 'fscs_generate_pdf'));
      add_action('wp_ajax_nopriv_fscs_generate_pdf', array($this, 'fscs_generate_pdf'));

    }
    
}