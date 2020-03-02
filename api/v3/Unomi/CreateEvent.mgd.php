<?php
// This file declares a managed database record of type "Job".
// The record will be automatically inserted, updated, or deleted from the
// database as appropriate. For more details, see "hook_civicrm_managed" at:
// https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
return [
  0 =>
    [
      'name' => 'Cron:Unomi.CreateEvent',
      'entity' => 'Job',
      'params' =>
        [
          'version' => 3,
          'name' => 'Call Unomi.CreateEvent API',
          'description' => 'Call Unomi.CreateEvent API',
          'run_frequency' => 'Hourly',
          'api_entity' => 'Unomi',
          'api_action' => 'CreateEvent',
          'parameters' => '',
        ],
    ],
];
