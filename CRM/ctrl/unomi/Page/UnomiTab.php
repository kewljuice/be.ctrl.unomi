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
    $cid = NULL;
    if (isset($_REQUEST['cid'])) {
      $cid = $_REQUEST['cid'];
    }
    $this->assign('identifier', $cid);
    // @todo Print overview for identifier.
    $defaults = CRM_Core_BAO_Setting::getItem('unomi', 'unomi-settings');
    $decode = json_encode(json_decode(utf8_decode($defaults), TRUE), JSON_PRETTY_PRINT);
    $this->assign('data', $decode);
    parent::run();
  }

}
