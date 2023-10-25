<?php
/**
 * Plugin Name: Fuel Savings Calculator Slider
 * Description: Calculate saved fuel annually.
 * Version: 1.0
 * Author: Jethro Landa
 * Author URI: https://jethrolanda.com/
 * Text Domain: fuel-savings-calculator-slider
 * Domain Path: /languages/
 * Requires at least: 5.7
 * Requires PHP: 7.2
 */

defined('ABSPATH') || exit; 

// Path Constants ======================================================================================================

define( 'FSCS_MAIN_PLUGIN_FILE_PATH', WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . 'fuel-savings-calculator-slider' . DIRECTORY_SEPARATOR . 'fuel-savings-calculator-slider.bootstrap.php' );
define( 'FSCS_PLUGIN_BASE_NAME', 	    plugin_basename( FSCS_MAIN_PLUGIN_FILE_PATH ) );
define( 'FSCS_PLUGIN_BASE_PATH',	    basename( dirname( __FILE__ ) ) . '/' );
define( 'FSCS_PLUGIN_URL',            plugins_url() . '/fuel-savings-calculator-slider/' );
define( 'FSCS_PLUGIN_DIR',            plugin_dir_path( __FILE__ ) );
define( 'FSCS_CSS_ROOT_URL',          FSCS_PLUGIN_URL . 'css/' );
define( 'FSCS_CSS_ROOT_DIR',          FSCS_PLUGIN_DIR . 'css/' );
define( 'FSCS_IMAGES_ROOT_URL',       FSCS_PLUGIN_URL . 'images/' );
define( 'FSCS_IMAGES_ROOT_DIR',       FSCS_PLUGIN_DIR . 'images/' );
define( 'FSCS_INCLUDES_ROOT_URL',     FSCS_PLUGIN_URL . 'includes/' );
define( 'FSCS_INCLUDES_ROOT_DIR',     FSCS_PLUGIN_DIR . 'includes/' );
define( 'FSCS_JS_ROOT_URL',           FSCS_PLUGIN_URL . 'js/' );
define( 'FSCS_JS_ROOT_DIR',           FSCS_PLUGIN_DIR . 'js/' );
define( 'FSCS_TEMPLATES_ROOT_URL',    FSCS_PLUGIN_URL . 'templates/' );
define( 'FSCS_TEMPLATES_ROOT_DIR',    FSCS_PLUGIN_DIR . 'templates/' );
define( 'FSCS_VIEWS_ROOT_URL',        FSCS_PLUGIN_URL . 'views/' );
define( 'FSCS_VIEWS_ROOT_DIR',        FSCS_PLUGIN_DIR . 'views/' );
define( 'FSCS_LANGUAGES_ROOT_URL',    FSCS_PLUGIN_URL . 'languages/' );
define( 'FSCS_LANGUAGES_ROOT_DIR',    FSCS_PLUGIN_DIR . 'languages/' );

// Email Defaut Values
$body = "<p>Dear {customer_name},<p>";

$body .= "<p>Thank you for using the Fuel Logic Savings Calculator. We understand that optimizing your fueling strategy is crucial for your operations, and we're here to help you uncover potential savings and efficiencies.</p>";

$body .= "<p>Attached to this email, you'll find a detailed report outlining the savings and benefits you could achieve by partnering with Fuel Logic. This report provides a comprehensive breakdown based on the data you provided, showcasing how our services can transform your fueling process.</p>";

$body .= "<p>Key highlights from your report:</p>";

$body .= "<ul>";
$body .= "<li>Potential Annual Savings: On average, our clients save $21,840 annually.</li>";
$body .= "<li>Efficiency Boost: Reduce downtime, streamline refueling, and ensure your fleet is always ready.</li>";
$body .= "<li>Transparent Pricing: Experience the benefits of clear, upfront pricing with no hidden fees.</li>";
$body .= "</ul>";

$body .= "<p>At Fuel Logic, we pride ourselves on offering tailored solutions that cater to your unique needs. Whether you're looking to buy fuel in bulk, require direct-to-equipment fueling, or need a comprehensive fuel management program, we've got you covered.</p>";

$body .= "<p>If you have any questions or would like to discuss the report in more detail, our team of fuel experts is here to assist. Feel free to reply to this email, call us at 866-311-3571, or book a virtual consultation.</p>";

$body .= "<p>Thank you for considering Fuel Logic. We look forward to the opportunity to help you optimize your fueling strategy and boost your bottom line.</p>";

$body .= "<p>Warm regards,</p>";

$body .= "<p>[Name]<br/>";
$body .= "[Position]<br/>";
$body .= "Fuel Logic</p>";

define( 'FSCS_EMAIL_SUBJECT', "Your Fuel Savings Report from Fuel Logic" );
define( 'FSCS_EMAIL_BODY', $body );

// Run
require_once 'fuel-savings-calculator-slider.plugin.php';
$fscs = Fuel_Savings_Calculator_Slider::instance();
$GLOBALS['fscs'] = $fscs;

$fscs->run();