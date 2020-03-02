<?php

use CRM\ctrl\unomi\Services\UnomiApi;
use CRM\ctrl\unomi\Services\UnomiEventDefault;
use CRM\ctrl\unomi\Services\UnomiRuleDefault;
use CRM_ctrl_unomi_ExtensionUtil as E;

/**
 *
 */
class CRM_ctrl_unomi_Page_UnomiTab extends CRM_Core_Page {

  /**
   * {@inheritdoc}
   */
  public function run() {
    // Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml.
    CRM_Utils_System::setTitle(E::ts('Unomi'));
    // Print identifier.
    $id = NULL;
    if (isset($_REQUEST['cid'])) {
      $cid = $_REQUEST['cid'];
      $id = _unomi_get_identifier_by_id($cid);
      // Print overview for identifier.
      $unomi = new UnomiApi();
      $data['profile'] = json_encode(json_decode(utf8_decode($unomi->getProfile($id)), TRUE), JSON_PRETTY_PRINT);
    }
    else {
      // Print unomi settings as fallback.
      $defaults = CRM_Core_BAO_Setting::getItem('unomi', 'unomi-settings');
      $data['settings'] = json_encode(json_decode(utf8_decode($defaults), TRUE), JSON_PRETTY_PRINT);
      // Update profile in unomi when contact_id is given.
      if (isset($_REQUEST['contact_id'])) {
        // Submit rule.
        $rule = new UnomiRuleDefault();
        $data['rule'] = $rule->json();
        /* $rule->push(); */
        // Submit event.
        $event = new UnomiEventDefault($_REQUEST['contact_id']);
        $data['event'] = $event->json();
        /* $event->push(); */
      }
    }
    $this->assign('identifier', $id);
    $this->assign('data', $data);
    parent::run();
  }

}
