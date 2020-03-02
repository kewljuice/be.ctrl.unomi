<?php

namespace CRM\ctrl\unomi\Services;

/**
 * Class for Unomi API actions.
 */
class UnomiApi extends Unomi {

  /**
   * Get profile.
   *
   * @param string $profile_id
   *   Unomi profile identifier.
   *
   * @return string
   *   Response from get().
   */
  public function getProfile($profile_id) {
    $path = '/cxs/profiles/' . $profile_id;
    $result = $this->get($path);

    return $result;
  }

  /**
   * Get profile.
   *
   * @param string $profile_id
   *   Unomi profile identifier.
   *
   * @return string
   *   Response from get().
   */
  public function getSessions($profile_id) {
    $path = '/cxs/profiles/' . $profile_id . '/sessions';
    $result = $this->get($path);

    return $result;
  }

  /**
   * Set rule.
   *
   * @param string $json
   *   Unomi rule as json string.
   *
   * @return string
   *   Response from post().
   */
  public function setRule($json) {
    $path = '/cxs/rules/';
    $call = $this->post($path, $json);

    return $call;
  }

  /**
   * Set event.
   *
   * @param string $json
   *   Unomi event as json string.
   *
   * @return string
   *   Response from post().
   */
  public function setEvent($json) {
    $path = '/eventcollector';
    $call = $this->post($path, $json);

    return $call;
  }

  /**
   * GET call to Unomi.
   *
   * @param string $path
   *   Unomi API path.
   *
   * @return string
   *   Response from API call.
   */
  private function get($path) {
    $curl = curl_init();
    curl_setopt_array($curl, [
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_HEADER => FALSE,
      CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
      CURLOPT_URL => $this->settings['unomi_url'] . $path,
      CURLOPT_USERPWD => $this->settings['unomi_user'] . ":" . $this->settings['unomi_pass'],
      CURLOPT_FOLLOWLOCATION => 1,
    ]);
    $data = curl_exec($curl);
    curl_close($curl);

    return $data;
  }

  /**
   * POST call to Unomi.
   *
   * @param string $path
   *   Unomi API path.
   * @param string $json
   *   Unomi JSON data.
   *
   * @return string
   *   Response from API call.
   */
  private function post($path, $json) {
    $curl = curl_init();
    curl_setopt_array($curl, [
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
      CURLOPT_URL => $this->settings['unomi_url'] . $path,
      CURLOPT_USERPWD => $this->settings['unomi_user'] . ":" . $this->settings['unomi_pass'],
      CURLOPT_FOLLOWLOCATION => 1,
      CURLOPT_POST => 1,
      CURLOPT_POSTFIELDS => $json,
    ]);
    curl_exec($curl);
    $data = curl_getinfo($curl);
    curl_close($curl);

    return $data;
  }

}
