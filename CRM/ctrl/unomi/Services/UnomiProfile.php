<?php

namespace CRM\ctrl\unomi\Services;

/**
 * Class to build Unomi Profile.
 */
class UnomiProfile extends Unomi {

  /**
   * CiviCRM custom field containing Unomi id.
   *
   * @var string
   */
  protected $customFieldID;

  /**
   * Constructor.
   */
  public function __construct() {
    parent::__construct();
    // Mapping for custom field.
    $fields = json_decode(\CRM_Core_BAO_Setting::getItem('unomi', 'unomi-fields'), TRUE);
    $this->customFieldID = $fields['unomi-identifier'];
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
