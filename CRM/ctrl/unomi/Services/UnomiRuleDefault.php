<?php

namespace CRM\ctrl\unomi\Services;

/**
 * Class to build Unomi Default Rule.
 */
class UnomiRuleDefault extends UnomiRule {

  /**
   * Constructor.
   *
   * @param array $fields
   *   Array containing all CiviCRM Individual fields.
   * @param string $rule_id
   *   String with Unomi rule identifier.
   * @param string $event_id
   *   String with Unomi event identifier.
   */
  public function __construct(array $fields = [], $rule_id = NULL, $event_id = NULL) {
    parent::__construct();
    if (isset($rule_id) && !is_null($rule_id)) {
      $this->ruleID = $rule_id;
    }
    if (isset($event_id) && !is_null($event_id)) {
      $this->eventID = $event_id;
    }
    if (isset($fields) && !empty($fields)) {
      $this->fields = $fields;
    }
  }

  /**
   * Create JSON.
   *
   * @return string
   *   JSON string.
   */
  protected function createJson() {
    $output['itemId'] = $this->ruleID;
    $output['itemType'] = "rule";
    $output['version'] = 1;
    $output['linkedItems'] = NULL;
    $output['raiseEventOnlyOnceForProfile'] = FALSE;
    $output['raiseEventOnlyOnceForSession'] = FALSE;
    $output['priority'] = 0;
    // Metadata.
    $output['metadata'] = [
      'id' => $this->ruleID,
      'name' => $this->ruleID,
      'description' => "The Unomi rule for " . $this->ruleID,
      'scope' => $this->settings['site_scope'],
      'tags' => [],
      'systemTags' => ['event', 'eventCondition'],
      'enabled' => TRUE,
      'missingPlugins' => FALSE,
      'hidden' => FALSE,
      'readOnly' => FALSE,
    ];
    // Condition.
    $output['condition'] = [
      'type' => "eventTypeCondition",
      'parameterValues' => ['eventTypeId' => $this->eventID],
    ];
    // Actions.
    foreach ($this->fields as $field) {
      $properties = [
        'setPropertyName' => "properties(civicrm_$field)",
        'setPropertyValue' => "eventProperty::properties(civicrm_$field)",
        'setPropertyStrategy' => "alwaysSet",
      ];
      $output['actions'][] = [
        'type' => 'setPropertyAction',
        'parameterValues' => $properties,
      ];
    }

    $output = json_encode($output, JSON_PRETTY_PRINT);
    return $output;
  }

}
