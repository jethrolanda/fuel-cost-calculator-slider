<?php 

defined('ABSPATH') || exit;
 
class WPS_Post_type
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
     * 
     * @since 1.0
     */
    public function __construct() { }

    public static function init() {
      
      // Register Movie Post Type
      add_action( 'init', array(__CLASS__, 'register_movie_post_type'), 5 );

      // Add new custom meta box
      add_action( 'add_meta_boxes', array(__CLASS__, 'add_custom_box') );

      // Save meta box data
      add_action( 'save_post', array(__CLASS__, 'save_postdata' ) );

      // Save movie poster
      add_action( 'save_post', array(__CLASS__, 'save_movie_poster' ) );

    }

    /**
     * Register new movie post type.
     * 
     * @since 1.0
     */
    public function register_movie_post_type() {

        register_post_type( 'movie',
        // CPT Options
            array(
                'labels' => array(
                    'name' => __( 'Movies', 'wp-simple-movie-library' ),
                    'singular_name' => __( 'Movie', 'wp-simple-movie-library' ),
                    'add_new_item'          => __( 'Add new movie', 'wp-simple-movie-library' ),
                ),
                'public' => true,
                'has_archive' => false,
                'rewrite' => array('slug' => 'movies'),

            )
        );

    }

    /**
     * Register meta boxes.
     * 
     * @since 1.0
     */
    public function add_custom_box() {

      add_meta_box(
        'box_id_0',
        __( 'Movie Poster', 'wp-simple-movie-library' ),
        array(__CLASS__, 'movie_poster'),
        'movie'
      );

      add_meta_box(
        'box_id_1',
        __( 'Movie Year', 'wp-simple-movie-library' ),
        array(__CLASS__, 'movie_year'),
        'movie'
      );

      add_meta_box(
        'box_id_2',
        __( 'Movie Genre', 'wp-simple-movie-library' ),
        array(__CLASS__, 'movie_genre'),
        'movie'
      );

    }
    
    /**
     * Movie poster.
     * 
     * @since 1.0
     */
    public function movie_poster( $post ) {
      wp_nonce_field('_wsml_upload_movie_poster_action', '_wsml_movie_poster_nonce');
      $value = get_post_meta($post->ID, '_wsml_movie_poster', true);
      error_log(print_r($value,true));
      $html = "<form method='post' action='' enctype='multipart/form-data'>";
      $html .= "<input type='file' id='_wsml_movie_poster' name='_wsml_movie_poster' size='25' accept='image/png, image/jpeg' value='" . $value . "'/>";
      $html .= "</form>";
      
      echo $html;
    }

    /**
     * Year Input box.
     * 
     * @since 1.0
     */
    public function movie_year( $post ) {
      $value = get_post_meta($post->ID, '_wsml_year', true);
      echo "<br/>";
      echo "<input type='text' name='year_field' id='year_field' value='" . $value . "'>";
      echo "<br/>";
    }

    /**
     * Genre Input box.
     * 
     * @since 1.0
     */
    public function movie_genre( $post ) {
      $value = get_post_meta($post->ID, '_wsml_genre', true);
      echo "<br/>";
      echo "<input type='text' name='genre_field' id='genre_field' value='" . $value . "'>";
      echo "<br/>";
    }

    /**
     * Save Post Data
     * 
     * @since 1.0
     */
    public function save_postdata( $post_id ) {
      if ( array_key_exists( 'year_field', $_POST ) ) {
        update_post_meta(
          $post_id,
          '_wsml_year',
          $_POST['year_field']
        );
      }

      if ( array_key_exists( 'genre_field', $_POST ) ) {
        update_post_meta(
          $post_id,
          '_wsml_genre',
          $_POST['genre_field']
        );
      }
      
    }

    /**
     * Save Poster Image
     * 
     * @since 1.0
     */
    public function save_movie_poster( $post_id ) {

      /* --- security verification --- */
      if(!wp_verify_nonce($_POST['_wsml_movie_poster_nonce'], '_wsml_upload_movie_poster_action')) {
        return $post_id;
      } // end if 
      
      if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
      } // end if 
        
      if('movie' == $_POST['post_type']) {
        if(!current_user_can('edit_page', $post_id)) {
          return $post_id;
        } // end if 
      } else {
          if(!current_user_can('edit_page', $post_id)) {
            return $post_id;
          } // end if 
      } // end if 
      /* - end security verification - */
      
      // Make sure the file array isn't empty 
      if(!empty($_FILES['_wsml_movie_poster']['name'])) {
       
        // Setup the array of supported file types. In this case, it's just PDF. 
        $supported_types = array('application/pdf');
        
        // Get the file type of the upload 
        $arr_file_type = wp_check_filetype(basename($_FILES['_wsml_movie_poster']['name']));
        $uploaded_type = $arr_file_type['type'];
        
        // Check if the type is supported. If not, throw an error. 
        if(in_array($uploaded_type, $supported_types)) {
          // Use the WordPress API to upload the file 
          $upload = wp_upload_bits($_FILES['_wsml_movie_poster']['name'], null, file_get_contents($_FILES['_wsml_movie_poster']['tmp_name']));
      
          if(isset($upload['error']) && $upload['error'] != 0) {
            wp_die('There was an error uploading your file. The error is: ' . $upload['error']);
          } else {
            add_post_meta($post_id, '_wsml_movie_poster', $upload);
            update_post_meta($post_id, '_wsml_movie_poster', $upload);		
          } // end if/else 
        } else {
          wp_die("The file type that you've uploaded is not a PDF.");
        } // end if/else 
        
      } // end if

    }

}

WPS_Post_Type::init();
