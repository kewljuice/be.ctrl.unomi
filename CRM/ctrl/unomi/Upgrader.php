<?php

require_once 'CRM/Core/BAO/CustomField.php';

/**
 * Collection of upgrade steps.
 */
class CRM_ctrl_unomi_Upgrader extends CRM_ctrl_unomi_Upgrader_Base {

  // By convention, functions that look like "function upgrade_NNNN()" are
  // upgrade tasks. They are executed in order (like Drupal's hook_update_N).

  /**
   * Run an XML script when the module is installed.
   */
  public function install() {
    // Install custom fields
    $res = CRM_Core_Resources::singleton();
    $files = glob($res->getPath('be.ctrl.unomi') . '/xml/*-install.xml');
    if (is_array($files)) {
      foreach ($files as $file) {
        $this->executeCustomDataFileByAbsPath($file);
      }
    }
    // Set initial custom_field variable(s).
    $fields['unomi-identifier'] = 'custom_' . CRM_Core_BAO_CustomField::getCustomFieldID('Unomi_Identifier', 'Unomi_Group');
    CRM_Core_BAO_Setting::setItem(json_encode($fields), 'unomi', 'unomi-fields');
  }

}
