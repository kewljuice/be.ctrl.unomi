<?php

/**
 * @file
 */

require_once 'unomi.civix.php';

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function unomi_civicrm_config(&$config) {
  _unomi_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function unomi_civicrm_xmlMenu(&$files) {
  _unomi_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function unomi_civicrm_install() {
  // Set default settings variable(s).
  $settings['unomi_url'] = 'unomi.dev';
  $settings['unomi_user'] = 'karaf';
  $settings['unomi_pass'] = 'karaf';
  $settings['site_scope'] = 'unomi-website';
  CRM_Core_BAO_Setting::setItem(json_encode($settings), 'unomi', 'unomi-settings');
  // Continue.
  _unomi_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function unomi_civicrm_postInstall() {
  _unomi_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function unomi_civicrm_uninstall() {
  // Remove setting variable(s).
  CRM_Core_BAO_Setting::setItem('', 'unomi', 'unomi-settings');
  CRM_Core_BAO_Setting::setItem('', 'unomi', 'unomi-fields');
  // Continue.
  _unomi_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function unomi_civicrm_enable() {
  _unomi_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function unomi_civicrm_disable() {
  _unomi_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function unomi_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _unomi_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function unomi_civicrm_managed(&$entities) {
  _unomi_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function unomi_civicrm_caseTypes(&$caseTypes) {
  _unomi_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function unomi_civicrm_angularModules(&$angularModules) {
  _unomi_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function unomi_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _unomi_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_entityTypes
 */
function unomi_civicrm_entityTypes(&$entityTypes) {
  _unomi_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Returns TRUE if contact type is an individual.
 */
function _unomi_civicrm_check_ind($cid) {
  $sql = "SELECT contact_type FROM civicrm_contact WHERE id = $cid";
  $dao =& CRM_Core_DAO::executeQuery($sql, []);
  while ($dao->fetch()) {
    if ($dao->contact_type == "Individual") {
      return TRUE;
    }
  }
  return FALSE;
}

/**
 * Implementation of CiviCRM tabs hook.
 */
function unomi_civicrm_tabset($tabsetName, &$tabs, $context) {
  if ($tabsetName == 'civicrm/contact/view') {
    $contactId = $context['contact_id'];
    if (_unomi_civicrm_check_ind($contactId)) {
      $url = CRM_Utils_System::url('civicrm/unomi/tab', "cid={$contactId}");
      $tabs[] = [
        'id' => 'unomi',
        'url' => $url,
        'title' => 'Unomi',
        'weight' => 400,
      ];
    }
  }
}

/**
 * Returns unomi identifier.
 */
function _unomi_get_identifier_by_id($cid) {
  $unomi_id = NULL;
  $fields = json_decode(CRM_Core_BAO_Setting::getItem('unomi', 'unomi-fields'), TRUE);
  $result = civicrm_api3('Contact', 'getSingle', [
    'sequential' => 1,
    'return' => [$fields['unomi-identifier']],
    'id' => $cid,
  ]);
  if (isset($result[$fields['unomi-identifier']])) {
    $unomi_id = $result[$fields['unomi-identifier']];
  }
  return $unomi_id;
}

/**
 * Implements hook_civicrm_merge().
 * Update unomi data to reflect identifiers when contacts are merged.
 */
function unomi_civicrm_merge($type, &$data, $new_id = NULL, $old_id = NULL, $tables = NULL) {
  if (!empty($new_id) && !empty($old_id) && $type == 'sqls') {
    $new_unomi = _unomi_get_identifier_by_id($new_id);
    $old_unomi = _unomi_get_identifier_by_id($old_id);
    if (!empty($new_unomi) && !empty($old_unomi)) {
      \Civi::log()
        ->info("unomi_civicrm_merge: " . $new_unomi . " - " . $old_unomi);
    }
  }
}

// --- Functions below this ship commented out. Uncomment as required. ---.
/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
 * function unomi_civicrm_preProcess($formName, &$form) {
 *
 * } // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
 * function unomi_civicrm_navigationMenu(&$menu) {
 * _unomi_civix_insert_navigation_menu($menu, 'Mailings', array(
 * 'label' => E::ts('New subliminal message'),
 * 'name' => 'mailing_subliminal_message',
 * 'url' => 'civicrm/mailing/subliminal',
 * 'permission' => 'access CiviMail',
 * 'operator' => 'OR',
 * 'separator' => 0,
 * ));
 * _unomi_civix_navigationMenu($menu);
 * } // */
