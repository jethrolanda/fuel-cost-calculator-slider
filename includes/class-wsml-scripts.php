<?php

/**
 * Scripts class
 *
 * @since   1.0
 */

defined('ABSPATH') || exit;

class WSML_Scripts
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
        add_action('admin_enqueue_scripts', array($this, 'load_back_end_styles_and_scripts'), 10, 1);
        add_action('wp_enqueue_scripts', array($this, 'load_front_end_styles_and_scripts'), 11);
        
    }

    /**
     * All backend scripts
     *
     * @since 1.0
     * @access public
     */
    public function load_back_end_styles_and_scripts()
    { 

        wp_enqueue_style('spoiler-plugin-style', WSML_PLUGIN_URL . '/css/style.css');
        
    }

    /**
     * All frontend scripts
     *
     * @since 1.0
     * @access public
     */
    public function load_front_end_styles_and_scripts()
    {
        
    }

}

new WSML_Scripts();
