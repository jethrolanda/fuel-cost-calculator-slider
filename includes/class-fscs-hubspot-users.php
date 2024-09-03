<?php

namespace FSCS\Plugin;

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
class Hubspot_Users
{

  /**
   * The single instance of the class.
   *
   * @since 1.0
   */
  protected static $_instance = null;

  private $api_key = '';

  /**
   * Class constructor.
   *
   * @since 1.0.0
   */
  public function __construct() {}

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

  public function get_all_users()
  {

    try {
      $curl = curl_init();

      // SALES TEAM ID = 9465032
      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.hubapi.com/settings/v3/users/",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
          "accept: application/json",
          "authorization: Bearer " . $this->api_key
        ),
      ));

      $response = curl_exec($curl);
      $response = json_decode($response);


      $filtered = array_filter($response->results, function ($obj) {
        return isset($obj->primaryTeamId) && $obj->primaryTeamId == 9465032 ? true : false;
      });
      // error_log(print_r($filtered, true));

      return $filtered;
    } catch (\Exception $e) {
      error_log(print_r($e, true));
    }
  }

  public function get_all_teams()
  {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.hubapi.com/settings/v3/users/teams",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "accept: application/json",
        "authorization: Bearer " . $this->api_key
      ),
    ));

    $response = curl_exec($curl);
    error_log(print_r($response, true));
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      echo $response;
    }
  }
}
