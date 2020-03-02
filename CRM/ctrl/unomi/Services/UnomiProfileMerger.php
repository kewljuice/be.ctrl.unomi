<?php

namespace CRM\ctrl\unomi\Services;

/**
 * Class to build Unomi Profile Merger.
 */
class UnomiProfileMerger extends UnomiProfile {

  /**
   * Constructor.
   *
   * @param int $contact_a
   *   CiviCRM contact A identifier.
   * @param int $contact_b
   *   CiviCRM contact B identifier.
   *
   * @throws \CiviCRM_API3_Exception
   *   CiviCRM API3 exception.
   */
  public function __construct($contact_a, $contact_b) {
    parent::__construct();
    $a = $this->getUnomiIdentifierById($contact_a);
    $b = $this->getUnomiIdentifierById($contact_b);
    if (!empty($a) && !empty($b)) {
      \Civi::log()
        ->info("unomi_civicrm_merge cids: " . $contact_a . " - " . $contact_b);
      // @todo: Create API call to execute merge!?
    }
  }

}
