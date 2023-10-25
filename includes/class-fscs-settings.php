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
class FSCS_Settings
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
     * Add custom wp admin menu.
     * 
     * @since 1.0
     */
    public function custom_menu() {
        add_menu_page(
            'Fuel Savings',
            'Fuel Savings',
            'edit_posts',
            'fuel_savings_settings',
            array($this, 'fuel_savings_settings_page'),
            'dashicons-media-spreadsheet'
        );
    }
    
    /**
     * Display content to the new added custom wp admin menu.
     * 
     * @since 1.0
     */
    public function fuel_savings_settings_page() {
      ?>
        <div class="wrap">
            <div id="fuel-savings-settings">
                <h2>Loading...</h2>
            </div>
        </div><?php
    }
    
    /**
     * Fetch settings.
     * 
     * @since 1.0
     */
    public function fscs_settings_get_recaptcha_data() {
        
        if (!defined('DOING_AJAX') || !DOING_AJAX) {
            wp_die();
        }
        
        /**
         * Verify nonce
         */
        if (isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'], 'settings_nonce')) {
            wp_die();
        }
        
        $site_key = get_option('fscs_site_key', '');
        $secret_key = get_option('fscs_secret_key', '');
        
        wp_send_json(array(
            'status' => 'success',
            'site_key' => $site_key,
            'secret_key' => $secret_key
        ));
        
    }

    /**
     * Save settings.
     * 
     * @since 1.0
     */
    public function fscs_settings_save_recaptcha_data() {
        
        if (!defined('DOING_AJAX') || !DOING_AJAX) {
            wp_die();
        }

        /**
         * Verify nonce
         */
        if (isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'], 'settings_nonce')) {
            wp_die();
        }  

        $site_key = isset($_POST['site_key']) ? sanitize_text_field($_POST['site_key']) : '';
        $secret_key = isset($_POST['secret_key']) ? sanitize_text_field($_POST['secret_key']) : '';

        update_option('fscs_site_key', $site_key);
        update_option('fscs_secret_key', $secret_key);
        
        wp_send_json(array(
            'status' => 'success',
            'site_key' => $site_key,
            'secret_key' => $secret_key
        ));
        
    }

    /**
     * Execute Model.
     *
     * @since 1.0
     * @access public
     */
    public function run() { 

        // Add new menu
        add_action('admin_menu', array($this, 'custom_menu'), 10);
        
        // Fetch setting via ajax 
        add_action("wp_ajax_fscs_settings_get_recaptcha_data", array($this, 'fscs_settings_get_recaptcha_data'));

        // Save setting via ajax 
        add_action("wp_ajax_fscs_settings_save_recaptcha_data", array($this, 'fscs_settings_save_recaptcha_data'));

    }

}