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
class FSCS_Data_Store
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
     * Create a new custom db table
     *
     * @since 1.0.0
     */
    public function create_custom_db_table() {
      
      global $wpdb;
      $table_name = $wpdb->prefix . 'fuel_savings_report';
	
      $charset_collate = $wpdb->get_charset_collate();

      $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        name tinytext NOT NULL,
        email VARCHAR(100) NOT NULL,
        pdf_url varchar(250) DEFAULT '' NOT NULL,
        calculator_data text NOT NULL,
        PRIMARY KEY  (id)
      ) $charset_collate;";

      require_once ABSPATH . 'wp-admin/includes/upgrade.php';
      dbDelta( $sql );

    }

    /**
     * Save data
     *
     * @since 1.0.0
     */
    public function save_entry($name, $email, $pdf_file, $slider_data) {

      global $wpdb;
      $table_name = $wpdb->prefix . 'fuel_savings_report';

      $wpdb->insert($table_name, array(
          'date' => current_datetime()->format('Y-m-d H:i:s'),
          'name' => $name,
          'email' => $email,
          'pdf_url' => $pdf_file,
          'calculator_data' => $slider_data,
        ),
        array(
          '%s',
          '%s',
          '%s',
          '%s'
        )
      );
      
    }

    /**
     * Get fuel savings data.
     * 
     * @since 1.0
     */
    public function fscs_get_fuel_savings_data() {
        
      if (!defined('DOING_AJAX') || !DOING_AJAX) {
          wp_die();
      }

      /**
       * Verify nonce
       */
      if (isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'], 'settings_nonce')) {
          wp_die();
      }  

      try{

        global $wpdb;

        $table_name = $wpdb->prefix . 'fuel_savings_report ORDER BY date DESC';
        $data = $wpdb->get_results ( "SELECT * FROM $table_name");
        $updated_data = array();

        $total = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
        $pagination = array(
          'total' => intval($total),
        );

        if($data){
          foreach($data as $d) {
            foreach(maybe_unserialize($d->calculator_data) as $k => $cd){
              $d->{$k} = $cd;
            }
            unset($d->calculator_data);
          }
          error_log(print_r($data,true));
        }
        
        wp_send_json(array(
            'status' => 'success',
            'data' => $data,
            'pagination' => $pagination
        ));

      } catch (Exception $e) {

          wp_send_json(array(
              'status' => 'error',
              'message' => $e->getMessage()
          ));

      }
      
    }

    /**
     * Delete fuel savings data item.
     * 
     * @since 1.0
     */
    public function fscs_delete_fuel_savings_data_item() {
        
      if (!defined('DOING_AJAX') || !DOING_AJAX) {
          wp_die();
      }

      /**
       * Verify nonce
       */
      if (isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'], 'settings_nonce')) {
          wp_die();
      }  

      try{

        global $wpdb;

        $id = isset($_POST['id']) ? (int) $_POST['id'] : '';
        
        if($id) {

          $table_name = $wpdb->prefix . 'fuel_savings_report';
          $result = $wpdb->delete( $table_name, array( 'id' => $id ));

          if($result) {
            wp_send_json(array(
              'status' => 'success',
              'message' => 'The item is now deleted.',
              'id' => $id
            ));
          } else {
            wp_send_json(array(
              'status' => 'error',
              'message' => 'Unable to delete.'
            ));
          }

        } else {

          wp_send_json(array(
            'status' => 'error',
            'message' => 'Invalid item id.'
          ));

        }
        
      } catch (Exception $e) {

          wp_send_json(array(
              'status' => 'error',
              'message' => $e->getMessage()
          ));

      }
      
    }

    /**
     * Execute Model.
     *
     * @since 1.0
     * @access public
     */
    public function run() { 

      // Fetch fuel savings data items via ajax 
      add_action("wp_ajax_fscs_get_fuel_savings_data", array($this, 'fscs_get_fuel_savings_data'));

      // Delete item via ajax 
      add_action("wp_ajax_fscs_delete_fuel_savings_data_item", array($this, 'fscs_delete_fuel_savings_data_item'));

    }
    
}