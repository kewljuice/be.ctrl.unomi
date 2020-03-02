<?php

namespace CRM\ctrl\unomi\Services;

/**
 * Class to build Unomi Rule.
 */
class UnomiRule extends Unomi {

  /**
   * Unomi rule identifier.
   *
   * @var string
   */
  protected $ruleID;

  /**
   * Unomi event identifier.
   *
   * @var string
   */
  protected $eventID;

  /**
   * Unomi settings.
   *
   * @var array
   */
  protected $fields;

  /**
   * Constructor.
   */
  public function __construct() {
    parent::__construct();
    $this->ruleID = 'CiviCRMContact';
    $this->eventID = 'CiviCRMContactEvent';
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
    $push = $api->setRule($this->json());
    if (isset($push['http_code']) && $push['http_code'] == 204) {
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

}
