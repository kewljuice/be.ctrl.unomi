<?php

use CRM\ctrl\unomi\Services\UnomiEventDefault;
use CRM\ctrl\unomi\Services\UnomiProfileDefault;
use CRM\ctrl\unomi\Services\UnomiRuleDefault;
use CRM_ctrl_unomi_ExtensionUtil as E;

/**
 * Custom contact tab to display Unomi specific information.
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
      // Print overview for identifier.
      $profile = new UnomiProfileDefault($_REQUEST['cid']);
      $id = $profile->id();
      $data['profile'] = $profile->json();
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
