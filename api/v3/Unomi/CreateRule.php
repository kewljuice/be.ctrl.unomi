<?php

use CRM\ctrl\unomi\Services\UnomiRuleDefault;

/**
 * Unomi.CreateRule API
 *
 * @param array $params
 *
 * @return array
 *   API result descriptor
 *
 * @throws API_Exception
 * @throws \CiviCRM_API3_Exception
 * @see civicrm_api3_create_success
 *
 */
function civicrm_api3_unomi_CreateRule($params) {
  // Submit default rule for CiviCRM individuals.
  $rule = new UnomiRuleDefault();
  $result = $rule->push();
  if ($result) {
    $returnValues = ['id' => 'CreateRule', 'message' => 'Succes'];
    return civicrm_api3_create_success($returnValues, $params, 'Unomi', 'CreateRule');
  }
  else {
    throw new API_Exception('Error', 'Unomi CreateRule failed');
  }
}
