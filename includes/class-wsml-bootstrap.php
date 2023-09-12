<?php
/**
 * Main plugin bootstrap class
 * 
 * @since   1.0
 */

defined('ABSPATH') || exit;

/**
 * Main Class.
 */
final class WSML_Bootstrap
{

    /**
     * Version.
     */
    public $version = '1.0';

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
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->define_constants();
        $this->includes();
        $this->init_hooks();
    }

    /**
     * Define all constains here
     *
     * @since 1.0
     * @access public
     */
    private function define_constants()
    {

        $this->define('WSML_VERSION', $this->version);
        $this->define('WSML_ABSPATH', dirname(WSML_PLUGIN_FILE) . '/');
        $this->define('WSML_PLUGIN_BASENAME', plugin_basename(WSML_PLUGIN_FILE));
        $this->define('WSML_PLUGIN_URL', plugins_url() . '/wp-simple-movie-library/' );
        $this->define('WSML_CSS_URL', WSML_PLUGIN_URL . 'css/' );
        $this->define('WSML_NOTICE_MIN_PHP_VERSION', '7.2');
        $this->define('WSML_NOTICE_MIN_WP_VERSION', '5.2');

    }

    /**
     * Define constant if not already set.
     *
     * @param string      $name  Constant name.
     * @param string|bool $value Constant value.
     */
    private function define($name, $value)
    {
        if (!defined($name)) {
            define($name, $value);
        }
    }

    /**
     * Include all plugin class
     *
     * @since 1.0
     * @access public
     */
    public function includes()
    {

        include_once WSML_ABSPATH . 'includes/class-wsml-scripts.php';
        include_once WSML_ABSPATH . 'includes/class-wsml-post-type.php';
        // include_once WSML_ABSPATH . 'includes/class-wps-settings.php';
        // include_once WSML_ABSPATH . 'includes/class-wps-shortcode.php';

        // Custom Block
        // include_once WSML_ABSPATH . 'js/blocks/wp-spoiler-block/wp-spoiler-block.php';

    }

    /**
     * Initialize hooks
     *
     * @since 1.0
     * @access public
     */
    private function init_hooks()
    {

        // Load Plugin Text Domain
        add_action('plugins_loaded', array($this, 'load_plugin_text_domain'));

        // Activate / Deactivate plugin
        register_activation_hook(WSML_PLUGIN_FILE, array($this, 'activated_plugin'));
        register_deactivation_hook(WSML_PLUGIN_FILE, array($this, 'deactivated_plugin'));

    }

    /**
     * Load plugin text domain.
     *
     * @since 1.0
     * @access public
     */
    public function load_plugin_text_domain()
    {

        load_plugin_textdomain('wp-simple-movie-library', false, WSML_ABSPATH . 'languages/');

    }

    /**
     * Ran when any plugin is activated.
     *
     * @since 1.0
     * @param string $filename The filename of the activated plugin.
     */
    public function activated_plugin($filename)
    {

    }

    /**
     * Ran when any plugin is deactivated.
     *
     * @since 1.0
     * @param string $filename The filename of the deactivated plugin.
     */
    public function deactivated_plugin($filename)
    {

    }
}
