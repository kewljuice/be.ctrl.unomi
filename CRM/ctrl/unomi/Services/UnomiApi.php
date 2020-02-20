<?php

namespace CRM\ctrl\unomi\Services;

/**
 * Class for Unomi API actions.
 */
class UnomiApi {

  /**
   * @var array
   * Stores settings.
   */
  private $settings;

  /**
   * @var string
   * Stores API url.
   */
  private $url;

  /**
   * @var string
   * Stores API username.
   */
  private $user;

  /**
   * @var string
   * Stores API url.
   */
  private $pass;

  /**
   * Constructor.
   */
  public function __construct() {
    // Set settings from parameters.
    $settings = \CRM_Core_BAO_Setting::getItem('unomi', 'unomi-settings');
    $this->settings = json_decode($settings, TRUE);
    // Set parameters.
    $this->url = $this->settings['unomi_url'];
    $this->user = $this->settings['unomi_user'];
    $this->pass = $this->settings['unomi_pass'];
  }

  /**
   * Fetch profile.
   *
   * @return string
   */
  public function fetchProfile($id) {
    $profile = [];
    $path = $this->url . '/cxs/profiles/' . $id;
    // Send the request & save response to $data.
    $curl = curl_init();
    // Set some cURL options.
    curl_setopt_array($curl, [
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_HEADER => FALSE,
      CURLOPT_HTTPHEADER => ['Content-Type:application/json'],
      CURLOPT_URL => $path,
      CURLOPT_USERPWD => $this->user . ":" . $this->pass,
      CURLOPT_FOLLOWLOCATION => 1,
    ]);
    // Send the request & save response to $data.
    $profile = curl_exec($curl);
    // Close request to clear up resources.
    curl_close($curl);
    // Pass results.
    return $profile;
  }

}
