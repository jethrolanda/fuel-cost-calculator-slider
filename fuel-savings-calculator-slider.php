<?php
/**
 * Plugin Name: Fuel Savings Calculator Slider
 * Description: Calculate yearly saved fuel
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

require_once 'fuel-savings-calculator-slider.plugin.php';
$fscs = Fuel_Savings_Calculator_Slider::instance();
$GLOBALS['fscs'] = $fscs;

$fscs->run();