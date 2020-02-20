<?php

use CRM\ctrl\unomi\Services\UnomiApi;
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
      $decode = json_encode(json_decode(utf8_decode($unomi->fetchProfile($id)), TRUE), JSON_PRETTY_PRINT);
    }
    else {
      // Print unomi settings as fallback.
      $defaults = CRM_Core_BAO_Setting::getItem('unomi', 'unomi-settings');
      $decode = json_encode(json_decode(utf8_decode($defaults), TRUE), JSON_PRETTY_PRINT);
    }
    $this->assign('identifier', $id);
    $this->assign('data', $decode);
    parent::run();
  }

}
