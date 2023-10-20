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
      
      error_log(print_r($_POST,true));
      // Get html data
      // ob_start();
      // include_once FSCS_TEMPLATES_ROOT_DIR. 'pdf-template.html';
      // $data = ob_get_clean();
      $dompdf = new Dompdf();
      // $dompdf->set_option('isRemoteEnabled', true);
      // $dompdf->set_option('isHtml5ParserEnabled', true);
      
      // $html = file_get_contents(FSCS_TEMPLATES_ROOT_DIR. 'pdf-template.html');
      $dompdf->loadHtml($this->pdf_template());
      
      // (Optional) Setup the paper size and orientation
      $dompdf->setPaper('Tabloid', 'portrait');

      // Render the HTML as PDF
      $dompdf->render();

      $output = $dompdf->output();
      file_put_contents(FSCS_PLUGIN_DIR.'/pdf-report.pdf', $output);
      
      // Send email
      $this->send_email();

      wp_send_json(array('status' => 'success'));
    }

    /**
     * PDF template
     * 
     * @since 1.0
     */
    private function pdf_template() {

      $cover_image = file_get_contents(FSCS_IMAGES_ROOT_DIR.'FL-HORIZONTAL-W-SLOGAN.png');
      $cover_image = 'data:image/png;base64,{{'. base64_encode($cover_image) .'}}';

      $icon_image = file_get_contents(FSCS_IMAGES_ROOT_DIR.'FL-logoSquare-ICON.jpg');
      $icon_image = 'data:image/png;base64,{{'. base64_encode($icon_image) .'}}';

      ob_start(); ?>
      <!DOCTYPE html>
      <html lang="en">
        <head>
        <style type="text/css">
          body{
            font-family: sans-serif;
            color: #707070;
          }
          .first-column{
            width: 45%;
          }
          .first-column p{
            font-size: 24px;
            line-height: 1.5em;
            padding-right: 50px;
            width: 88%;
          }
          .second-column{
            width: 55%;
          }
          .second-column div.wrap{
            float: left;
            white-space: unset;
          }
          
          h1, h2, h3{
            margin: 0px;
          }
          table{
            border-collapse: collapse;
            white-space: normal;
            line-height: normal;
            
          }
          tr, td{
            padding: 0px;
            margin: 0px;
            
          }
        </style>
        </head>
        <body>
          <table cellspacing="0" style="border-collapse: collapse;">
            <tr>
              <td colspan="2" style="text-align: center;">
                <img src="<?php echo $cover_image;?>" alt="Fuel Logic" style="width: 380px;">
                <h2 style="font-family: sans-serif; font-weight: lighter; font-size: 26px; margin: 0px; margin-bottom: 40px;">Fuel Logic - Powering Efficiency, One Gallon at a Time.</h2>
              </td>
            </tr>
            <tr>
              <td class="first-column">
                <div style="float: left;">
                  <h1 style="margin-top: 20px; font-size: 38px;">The <span style="color: #a2cc3a;">True Cost</span> Of Fuel.</h1>
                  <p>With Fuel Logic, fueling is simplified. Fleet managers, on average, save $21, 840 annually. Why? It's not just about pump prices; it's about time, labor, and productivity.</p>
                  <h2>Bulk Fuel Delivery:</h2>
                  <p style="margin-top: 6px;">Get competitive pricing, predictable schedules, and deliveries tailored to your needs. No more guessing, no more wasted hours.</p>
                  <h2>Direct to Equipement Fueling:</h2>
                  <p style="margin-top: 6px;">Fuel comes straight to your equipment. Save on wear, tear, and downtime.</p>
                  <h2>Fuel Management with Precision:</h2>
                  <p style="margin-top: 6px;">From wholesale rates and detailed consumption tracking to emergency support, we've got you covered. Fuel logic isn't just a supplier; we're your strategic partner.</p>
                  <p>In every industry, from construction to event management, reliable fueling is crucial. Fuel Logic ensures you're always powered up, optimizing your operations and budget.</p>
                </div>
                <div style="clear: both;"></div>
              </td>
              <td class="second-column">
                <div class="wrap">
                  <div style="display: inline-block; background: #f7fce8; padding: 30px 20px 30px 40px; padding-bottom: 50px; margin: 0px;">
                    <h1 style="color: #434343; font-size: 36px; margin-bottom: 30px;">So, how much did that gallon of fuel really cost?</h1>
                    
                    <ul style="list-style-type: none; font-size: 22px; margin: 0px; padding: 0px; margin-bottom: 30px; font-size: 20px; color: #7e7e7e;">
                      <li><b style="font-size: 22px;">Your Average Fueling Data</b></li>
                      <li>Number of Operators? <?php echo $_POST['calculator_data']['number_of_operators'];?></li>
                      <li>Number of Units in Fleet? <?php echo $_POST['calculator_data']['number_of_units_in_fleet'];?></li>
                      <li>Frequency of Fueling (Days/Wk)? <?php echo $_POST['calculator_data']['frequency_of_fueling'];?></li>
                      <li>Round-Trip per Fueling (Minutes)? <?php echo $_POST['calculator_data']['round_trip_per_fueling'];?></li>
                      <li>Estimated Gallons per Fill? <?php echo $_POST['calculator_data']['estimated_gallons_per_fill'];?></li>
                      <li>Average hourly rate? <?php echo $_POST['calculator_data']['average_hourly_rate'];?></li>
                    </ul>
            
                    <div style="border-top: 1px solid black;"></div>
            
                    <h2 style="margin-top: 35px; color: #5a5a5a;">Every gallon you pump cost an additional: <span style="color: #a2cc3a;"><?php echo $_POST['calculator_data']['every_gallon_you_pump_cost_an'];?></span></h2>
                    <ul style="margin: 35px 0px; padding: 0px; font-family: serif; color: #000000; list-style:none; background: #f4fde7; font-size: 22px!important; line-height: 24px;">	
                      <li style="border-bottom: 1px dotted #9cc83a; padding: 5px; background: #f7fcf0;">Estimated Gallons Consumed per Week: <span style="color: #73a03b; font-weight: 900; "><span class="lfb_richVariable" data-varitemid="449" data-action="price"><?php echo $_POST['calculator_data']['estimated_gallons_consumed_per_week'];?></span></span></li>
                      <li style="border-bottom: 1px dotted #9cc83a; padding: 5px; background: #eef7d9;">Man Hours Allocated to Fueling per Week: <span style="color: #73a03b; font-weight: 900; "><span class="lfb_richVariable" data-varitemid="450" data-action="price"><?php echo $_POST['calculator_data']['man_hours_allocated_to_fueling_per_week'];?></span></span></li>
                      <li style="border-bottom: 1px dotted #9cc83a; padding: 5px; background: #f7fcf0;">Lost Asset Production Hours per Week: <span style="color: #73a03b; font-weight: 900;"><span class="lfb_richVariable" data-varitemid="451" data-action="price"><?php echo $_POST['calculator_data']['lost_asset_production_hours_per_week'];?></span></span></li>
                      <li style="border-bottom: 1px dotted #9cc83a; padding: 5px; background: #d9d9d9;">Estimated Cost of Self Fueling per Week: <span style="color: black; font-weight: 900; "><span class="lfb_richVariable" data-varitemid="452" data-action="price"><?php echo $_POST['calculator_data']['estimated_cost_of_self_fueling_per_week'];?></span></span></li>
                    </ul>
            
                    <h2 style="margin-top: 20px;">With Fuel Logic Your Estimated Yearly Fuel Savings: <span style="color: #a2cc3a;"><?php echo $_POST['calculator_data']['yearly_fuel_savings'];?></span></h2>
                  </div>
                  <div style="position: relative; margin-top: 40px;">
                    <img src="<?php echo $icon_image;?>" alt="Fuel Logic" style="width: 100px; float: left;"><h1 style="position: absolute; top: 10px; left: 120px; width: 100px; color: #a2cc3a; width: 450px;">Unlock Your Fueling Potential with Fuel Logic</h1>
                  </div>
                  <div style="clear: both;"></div>
                  
                </div>
                
                <div style="clear: both;"></div>
                <div style="display: inline-block;">
                    <p style="color: #000000; font-size: 24px; font-style: italic; width: 450px; padding: 10px;">Ready to optimize your fueling strategy and boost your bottom line?<br/><span style="font-style: normal;">CALL TO ACTION SECTION</span></p>
                  </div>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <div style="margin-top: 30px; border-top: 1px solid black;"></div>
                <h2 style="padding: 20px 0px">
                  www.fuellogic.net. |. sales@fuellogic.net. | 866-934-6062
                </h4>
              </td>
            </tr>
          </table>
        </body>
      </html>
      <?php

      return ob_get_clean();

    }

    /**
     * Send email
     * 
     * @since 1.0
     */
    private function send_email() {


      $subject = "Your Fuel Savings Report from Fuel Logic";

      $body = "Dear ". $_POST['name'] .",

      Thank you for using the Fuel Logic Savings Calculator. We understand that optimizing your fueling strategy is crucial for your operations, and we're here to help you uncover potential savings and efficiencies.

      Attached to this email, you'll find a detailed report outlining the savings and benefits you could achieve by partnering with Fuel Logic. This report provides a comprehensive breakdown based on the data you provided, showcasing how our services can transform your fueling process.

      Key highlights from your report:

      ⦁ Potential Annual Savings: On average, our clients save $21,840 annually.

      ⦁ Efficiency Boost: Reduce downtime, streamline refueling, and ensure your fleet is always ready.

      ⦁ Transparent Pricing: Experience the benefits of clear, upfront pricing with no hidden fees.

      At Fuel Logic, we pride ourselves on offering tailored solutions that cater to your unique needs. Whether you're looking to buy fuel in bulk, require direct-to-equipment fueling, or need a comprehensive fuel management program, we've got you covered.

      If you have any questions or would like to discuss the report in more detail, our team of fuel experts is here to assist. Feel free to reply to this email, call us at 866-311-3571, or book a virtual consultation.

      Thank you for considering Fuel Logic. We look forward to the opportunity to help you optimize your fueling strategy and boost your bottom line.

      Warm regards,

      [Name]

      [Position]

      Fuel Logic";

      // wp_mail( $to, $subject, $message, $headers, $attachments );
      $test = wp_mail( $_POST['email'], $subject, $body, array(), array(FSCS_PLUGIN_DIR.'/pdf-report.pdf') );

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