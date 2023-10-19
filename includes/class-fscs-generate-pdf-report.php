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
      $dompdf->set_option('isRemoteEnabled', TRUE);
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

    private function pdf_template() { 

      $cover_image = file_get_contents(FSCS_IMAGES_ROOT_DIR.'cover.png');
      $cover_image_base64 = 'data:image/png;base64,'.base64_encode($cover_image);
// error_log(print_r($cover_image,true));
      $icon_image = file_get_contents(FSCS_IMAGES_ROOT_DIR.'icon.png');
      $icon_image_base64 = 'data:image/png;base64,'.base64_encode($icon_image);
      // error_log(print_r($icon_image_base64,true));
      ob_start(); ?>
      <!DOCTYPE html>
      <html lang="en">
        <head>
          <style type="text/css">
            .two-column{
              display: table;
            }
            .two-column div{
              width: 50%;
              float: left;
            }
          </style>
        </head>
        <body>
          <div class="heading">
            <img src="<?php echo __DIR__.'/../images/FL-HORIZONTAL-W-SLOGAN.png';?>" alt="Fuel Logic">
            Fuel Logic - Powering Efficiency, One Gallon at a Time.
          </div>
          <div class="two-column">
            <div>
              <h1>The True Cost Of Fuel</h1>
              <p>With Fuel Logic, fueling is simplified. Fleet managers, on average, save $21, 840 annually. Why? It's not just about pump prices; it's about time, labor, and productivity.</p>
              <h3>Bulk Fuel Delivery:</h3>
              <p>Get competitive pricing, predictable schedules, and deliveries tailored to your needs. No more guessing, no more wasted hours.</p>
              <h3>Direct to Equipement Fueling:</h3>
              <p>Fuel comes straight to your equipment. Save on wear, tear, and downtime.</p>
              <h3>Fuel Management with Precision:</h3>
              <p>From wholesale rates and detailed consumption tracking to emergency support, we've got you covered. Fuel logic isn't just a supplier; we're your strategic partner.</p>
              <p>In every industry, from construction to event management, reliable fueling is crucial. Fuel Logic ensures you're always powered up, optimizing your operations and budget.</p>
            </div>
            <div>
              <h1>So, how much did that gallon of fuel really cost?</h1>
              
              <ul>
                <li><b>Your Average Fueling Data</b></li>
                <li>Number of Operators? 33</li>
                <li>Number of Units in Fleet? 5</li>
                <li>Frequency of Fueling (Days/Wk)? 3</li>
                <li>Round-Trip per Fueling (Minutes)? 33</li>
                <li>Estimated Gallons per Fill? 33</li>
                <li>Number of Operators? 2</li>
                <li>Average hourly rate? 22</li>
              </ul>
      
              <hr/>
      
              <h2>Every gallon you pump cost an additional: $0.67</h2>
              <ul style="list-style:none; padding: 10px; border: 1px dotted #c4ec87; background: #f4fde7; font-size: 19px!important; line-height: 24px;">	<li style="border-bottom: 1px dotted #9cc83a; padding: 5px; background: #f7fcf0;">Estimated Gallons Consumed per Week: <span style="color: #73a03b; font-weight: 900; "><span class="lfb_richVariable" data-varitemid="449" data-action="price">660.00</span></span></li><li style="border-bottom: 1px dotted #9cc83a; padding: 5px; background: #eef7d9;">Man Hours Allocated to Fueling per Week: <span style="color: #73a03b; font-weight: 900; "><span class="lfb_richVariable" data-varitemid="450" data-action="price">20.00</span></span></li><li style="border-bottom: 1px dotted #9cc83a; padding: 5px; background: #f7fcf0;">Lost Asset Production Hours per Week: <span style="color: #73a03b; font-weight: 900;"><span class="lfb_richVariable" data-varitemid="451" data-action="price">10.00</span></span></li><li style="border-bottom: 1px dotted #9cc83a; padding: 5px; background: #d9d9d9;">Estimated Cost of Self Fueling per Week: <span style="color: black; font-weight: 900; ">$<span class="lfb_richVariable" data-varitemid="452" data-action="price">440.00</span></span></li><li style="color: white; font-size: 16px; border: 1px dotted #a2d1e5; border-top: 3px solid #626465; padding: 8px; background:#363636;">Total Estimated Fuel Savings Annually: <span style="color:#84b43b; font-weight: 900; border-bottom: 4px solid #84b43b; padding-bottom: 3px; ">$<span class="lfb_richVariable" data-varitemid="453" data-action="price">22,880.00</span></span></li>	</ul>
      
              <h2>With Fuel Logic Your Estimated Yearly Fuel Savings: $22,880.00</h2>
              <img src="<?php echo __DIR__.'/../images/FL-REVERSE.png';?>" alt="Fuel Logic" style="width: 100px;">Unlock Your Fueling Potential with Fuel Logic
            </div>
          </div>
          <div class="footer">www.fuellogic.net. |. sales@fuellogic.net. | 866-934-6062</div>
          
        </body>
      </html>
      <?php

      return ob_get_clean();

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