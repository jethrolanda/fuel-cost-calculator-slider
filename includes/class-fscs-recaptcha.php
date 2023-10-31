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
class FSCS_Recaptcha
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
     * Validate google recaptcha
     * 
     * @since 1.0
     */
    public function validate_recaptcha() {

      // Google reCAPTCHA API keys settings 
      $secretKey  = get_option('fscs_secret_key'); 

      // Validate reCAPTCHA checkbox 
      if(isset($_POST['g_recaptcha_response']) && !empty($_POST['g_recaptcha_response'])) { 

        // Verify the reCAPTCHA API response 
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST['g_recaptcha_response']); 
             
          // Decode JSON data of API response 
          $responseData = json_decode($verifyResponse); 
           
          // If the reCAPTCHA API response is valid 
          return $responseData->success;

      }

      return false;

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