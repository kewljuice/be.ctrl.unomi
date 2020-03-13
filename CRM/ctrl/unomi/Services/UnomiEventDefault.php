<?php

namespace CRM\ctrl\unomi\Services;

/**
 * Class to build Unomi Default Event.
 */
class UnomiEventDefault extends UnomiEvent {

  /**
   * Constructor.
   *
   * @param int $contact_id
   *   Integer with CiviCRM contact identifier.
   * @param string $event_id
   *   String with Unomi event identifier.
   * @param array $fields
   *   Array containing all CiviCRM Individual fields.
   *
   * @throws \CiviCRM_API3_Exception
   *   CiviCRM API3 exception.
   */
  public function __construct($contact_id, $event_id = NULL, array $fields = []) {
    parent::__construct($contact_id);
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
   *
   * @throws \CiviCRM_API3_Exception
   *   CiviCRM API3 exception.
   */
  protected function createJson() {
    // Session.
    $output['sessionId'] = $this->sessionID;
    // Events.
    $output['events'][] = [
      'eventType' => $this->eventID,
      'scope' => $this->settings['site_scope'],
      'source' => [
        'itemType' => "site",
        'scope' => $this->settings['site_scope'],
        'itemId' => "site",
      ],
      'target' => [
        'itemType' => "form",
        'scope' => $this->settings['site_scope'],
        'itemId' => $this->eventID,
      ],
      'properties' => $this->fetchFieldValues($this->contactID, $this->fields),
    ];

    $output = json_encode($output, JSON_PRETTY_PRINT);
    return $output;
  }

  /**
   * Return field values for contact ID.
   *
   * @param int $contact_id
   *   Integer with CiviCRM contact identifier.
   * @param array $fields
   *   Array containing all CiviCRM Individual fields.
   *
   * @return array
   *   Field values for contact.
   *
   * @throws \CiviCRM_API3_Exception
   *   CiviCRM API3 exception.
   */
  private function fetchFieldValues($contact_id, array $fields) {
    $results = [];
    $contact = civicrm_api3('Contact', 'getsingle', [
      'return' => $fields,
      'id' => $contact_id,
    ]);
    if (!isset($contact['is_error'])) {
      $profile = new UnomiProfileDefault($contact_id);
      $json = json_decode($profile->json(), TRUE);
      $properties = $json['properties'];
      foreach ($fields as $field) {
        if (isset($contact[$field])) {
          if (!empty($contact[$field]) or array_key_exists('civicrm_' . $field, $properties)) {
            $results['civicrm_' . $field] = $contact[$field];
          }
        }
      }
    }

    return $results;
  }

}
