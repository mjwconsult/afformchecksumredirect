<?php

use CRM_Afformchecksumredirect_ExtensionUtil as E;

return [
  [
    'name' => 'afformchecksumredirect_settings',
    'entity' => 'Navigation',
    'cleanup' => 'always',
    'update' => 'unmodified',
    'params' => [
      'version' => 4,
      'values' => [
        'label' => E::ts('FormBuilder Checksum Redirect Settings'),
        'name' => 'afformchecksumredirect_settings',
        'url' => 'civicrm/admin/setting/afformchecksumredirect',
        'permission' => 'administer FormBuilder Checksum Redirect',
        'permission_operator' => 'OR',
        'parent_id.name' => 'Customize Data and Screens',
        'is_active' => TRUE,
        'has_separator' => 0,
        'weight' => 90,
      ],
      'match' => ['name'],
    ],
  ],
];
