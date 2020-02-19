<?php

use CRM_ctrl_unomi_ExtensionUtil as E;

class CRM_ctrl_unomi_Page_UnomiTab extends CRM_Core_Page {

  /**
   * {@inheritdoc}
   */
  public function run() {
    // Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(E::ts('Unomi'));
    // Print identifier.
    $id = NULL;
    if (isset($_REQUEST['cid'])) {
      $cid = $_REQUEST['cid'];
      $fields = json_decode(CRM_Core_BAO_Setting::getItem('unomi', 'unomi-fields'), TRUE);
      $result = civicrm_api3('Contact', 'getSingle', [
        'sequential' => 1,
        'return' => [$fields['unomi-identifier']],
        'id' => $cid,
      ]);
      $id = $result[$fields['unomi-identifier']];
    }
    $this->assign('identifier', $id);
    // @todo Print overview for identifier.
    $defaults = CRM_Core_BAO_Setting::getItem('unomi', 'unomi-settings');
    $decode = json_encode(json_decode(utf8_decode($defaults), TRUE), JSON_PRETTY_PRINT);
    $this->assign('data', $decode);
    parent::run();
  }

}
