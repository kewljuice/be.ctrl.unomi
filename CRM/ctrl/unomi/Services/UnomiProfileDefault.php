<?php

namespace CRM\ctrl\unomi\Services;

/**
 * Class to build Unomi Default Profile.
 */
class UnomiProfileDefault extends UnomiProfile {

  /**
   * CiviCRM contact identifier.
   *
   * @var int
   */
  protected $contactID;

  /**
   * Unomi id.
   *
   * @var string
   */
  protected $unomiID;

  /**
   * Constructor.
   *
   * @param int $contact_id
   *   Integer with CiviCRM contact identifier.
   */
  public function __construct($contact_id) {
    parent::__construct();
    // Contact id.
    $this->contactID = $contact_id;
    // Unomi id.
    $this->unomiID = $this->getUnomiIdentifierById($this->contactID);
  }

  /**
   * Output JSON.
   *
   * @return string
   *   JSON string.
   */
  public function json() {
    return $this->createJson();
  }

  /**
   * Output Unomi identifier.
   *
   * @return string
   *   JSON string.
   */
  public function id() {
    return $this->unomiID;
  }

  /**
   * Create JSON.
   *
   * @return string
   *   JSON string.
   */
  protected function createJson() {
    // Print overview for Unomi identifier.
    $unomi = new UnomiApi();

    $result = json_encode(json_decode(utf8_decode($unomi->getProfile($this->unomiID)), TRUE), JSON_PRETTY_PRINT);
    return $result;
  }

}
