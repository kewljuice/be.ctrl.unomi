<?php

namespace CRM\ctrl\unomi\Services;

/**
 * Class to build Unomi Event.
 */
class UnomiEvent extends Unomi {

  /**
   * Unomi event identifier.
   *
   * @var string
   */
  protected $eventID;

  /**
   * CiviCRM contact identifier.
   *
   * @var int
   */
  protected $contactID;

  /**
   * CiviCRM custom field containing Unomi id.
   *
   * @var string
   */
  protected $customFieldID;

  /**
   * Unomi id.
   *
   * @var string
   */
  protected $unomiID;

  /**
   * Unomi Session id.
   *
   * @var string
   */
  protected $sessionID;

  /**
   * Unomi settings.
   *
   * @var array
   */
  protected $fields;

  /**
   * Constructor.
   *
   * @param int $contact_id
   *   CiviCRM contact identifier.
   *
   * @throws \CiviCRM_API3_Exception
   *   CiviCRM API3 exception.
   */
  public function __construct($contact_id) {
    parent::__construct();
    // Contact id.
    $this->contactID = $contact_id;
    // Mapping for custom field.
    $fields = json_decode(\CRM_Core_BAO_Setting::getItem('unomi', 'unomi-fields'), TRUE);
    $this->customFieldID = $fields['unomi-identifier'];
    // Unomi id & Unomi session id.
    $this->unomiID = $this->getUnomiIdentifierById($this->contactID);
    $this->sessionID = $this->getUnomiSessionById($this->unomiID);
    // Event id.
    $this->eventID = 'CiviCRMContactEvent';
    // Fields to return.
    $this->fields = $this->defaultFields();
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
   * Push JSON to Unomi.
   *
   * @return bool
   *   Returns TRUE on success.
   */
  public function push() {
    $api = new UnomiApi();
    $push = $api->setEvent($this->json());
    if (isset($push['http_code']) && $push['http_code'] == 200) {
      return TRUE;
    }
    else {
      // @todo: logs.
      return FALSE;
    }
  }

  /**
   * Create JSON.
   *
   * @return string
   *   JSON string.
   */
  protected function createJson() {
    return '';
  }

  /**
   * Return all 'Individual' fields.
   *
   * @return array
   *   Array containing all CiviCRM Individual fields.
   *
   * @throws \CiviCRM_API3_Exception
   *   CiviCRM API3 exception.
   */
  protected function defaultFields() {
    $fields = civicrm_api3('Contact', 'getfields', [
      'contact_type' => "Individual",
    ]);
    $result = array_keys($fields['values']);
    return $result;
  }

  /**
   * Returns unomi identifier.
   *
   * @param int $contact_id
   *   CiviCRM contact identifier.
   *
   * @return mixed|null
   *   Unomi identifier.
   *
   * @throws \CiviCRM_API3_Exception
   *   CiviCRM API3 exception.
   */
  protected function getUnomiIdentifierById($contact_id) {
    $unomi_id = NULL;
    $result = civicrm_api3('Contact', 'getSingle', [
      'sequential' => 1,
      'return' => [$this->customFieldID],
      'id' => $contact_id,
    ]);
    if (isset($result[$this->customFieldID])) {
      $unomi_id = $result[$this->customFieldID];
    }
    return $unomi_id;
  }

  /**
   * Returns unomi session identifier.
   *
   * @param int $unomi_id
   *   Unomi profile identifier.
   *
   * @return mixed|null
   *   Unomi session identifier.
   *
   * @throws \CiviCRM_API3_Exception
   *   CiviCRM API3 exception.
   */
  protected function getUnomiSessionById($unomi_id) {
    $api = new UnomiApi();
    $sessions = json_decode($api->getSessions($unomi_id), TRUE);
    $id = $sessions['list'][0]['itemId'];
    return $id;
  }

}
