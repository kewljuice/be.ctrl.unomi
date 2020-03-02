<?php

use CRM\ctrl\unomi\Services\UnomiEventDefault;

/**
 * Unomi.CreateEvent API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/api-architecture/
 */
function _civicrm_api3_unomi_CreateEvent_spec(&$spec) {
  $spec['contact_id']['api.required'] = 1;
  $spec['fields']['description'] = 'Comma separated list of contact fields.';
}

/**
 * Unomi.CreateEvent API
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
function civicrm_api3_unomi_CreateEvent($params) {
  if (array_key_exists('contact_id', $params)) {
    // Submit event for CiviCRM contact identifier.
    // @todo: implement fields variable.
    $event = new UnomiEventDefault($params['contact_id']);
    $result = $event->push();
    if ($result) {
      $returnValues = ['id' => 'CreateRule', 'message' => 'Succes'];
      return civicrm_api3_create_success($returnValues, $params, 'Unomi', 'CreateRule');
    }
    else {
      $returnValues = ['id' => 'CreateRule', 'message' => 'Failed'];
      return civicrm_api3_create_error($returnValues, $params, 'Unomi', 'CreateRule');
    }
  }
  else {
    throw new API_Exception('Error', 'contact_id_incorrect');
  }
}
